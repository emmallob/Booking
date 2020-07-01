<?php
// ensure this file is being included by a parent file
if( !defined( 'SITE_URL' ) ) die( 'Restricted access' );

class Apis {

	public function __construct() {
		global $learner;

		$this->db = $learner;
	}

	public function genVerify($username, $accessToken) {
		return $this->verifyToken($username, $accessToken);
	}

	public function validateApiKey($userName = null, $apiAccessKey = null) {

		/** get the user full request headers **/
		$headers = apache_request_headers();
		$authHeader = null;
		
		// get teh redirect http authorization headers
		if(isset($_SERVER['REDIRECT_HTTP_AUTHORIZATION']) && $_SERVER['REDIRECT_HTTP_AUTHORIZATION'] != "") {
            $authHeader = $_SERVER['REDIRECT_HTTP_AUTHORIZATION'];
        }

		/** authenticate the headers that have been parsed **/
		if((isset($headers["Authorization"]) && ($headers["Authorization"] == $authHeader))) {
			
			/** Set the Authorization Code **/
			$accessToken = xss_clean($headers['Authorization']);

			/** Split the Authorization Code **/
			$authorizationToken = base64_decode(str_ireplace("Bearer", "", $accessToken));

			$splitAuthInfo = explode(":", $authorizationToken);
			$userName = xss_clean(
				substr( $authorizationToken, 0, strpos($authorizationToken, ":") )
			);

			/** check if the authorization token was parsed **/
			if(!isset($splitAuthInfo[1])) {
			 	/** Inform the user that a wrong request was parsed **/
			 	return false;
			}

			// verify credentials 
			$result = $this->verifyToken($splitAuthInfo[0], $splitAuthInfo[1]);

			/** Verify the Authorization Token **/
			if(!$result) {
				/** Inform the user that a wrong request was parsed **/
				return false;
			}

			$this->apiUsername = $splitAuthInfo[0];
			$this->accessToken = $splitAuthInfo[1];

			/** Continue with the processing after verification **/
			return $result;			
			
		} else {
			/** Return error message **/
			return false;
		}
	}

	private function verifyToken($username, $accessToken) {

		/** Return error if database connection fails **/
		$stmt = $this->db->prepare("
			SELECT 
				a.username, a.user_guid AS guid, b.client_guid, 
				DATE(a.expiry_date) AS expiry_date, a.access_token,
				a.requests_limit,
				(
					SELECT c.requests_count FROM users_api_queries c
					WHERE c.client_guid = b.client_guid 
					AND DATE(request_date) = CURDATE()
				) AS requests_count
			FROM 
				users_api_keys a
			LEFT JOIN users b ON b.user_guid = a.user_guid
			WHERE 
				a.username = '{$username}'
			LIMIT 1
		");
		$stmt->execute();
		while($result = $stmt->fetch(PDO::FETCH_OBJ)) {
			// verify the access token that has been parsed
			if(password_verify($accessToken, $result->access_token)) {
				unset($result->access_token);
				return $result;
			}
		}

		return false;
	}

}
?>