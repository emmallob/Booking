<?php
// ensure this file is being included by a parent file
if( !defined( 'SITE_URL' ) && !defined( 'SITE_DATE_FORMAT' ) ) die( 'Restricted access' );

class Users extends Booking {

	# Constants
	const ACTIVE_USER_STATUS 	= 1;
	const REMOVED_USER_STATUS 	= 0;
	
	# set the number of users that can be created by an account
	public $list_users;
	public $clientId;

	# DB Class Instance
	protected $db;

	# ID Prefixes
	protected $user_id_prefix 	= "FW";
	protected $brand_id_prefix 	= "FB";
	protected $instance_id_prefix = "FI";

	# start the construct
	public function __construct() {
		parent::__construct();
	}

	/**
	 * Confirm that the user is currently logged in
	 * 
	 * @return bool
	 */
	public function logged_InControlled() {
		return ($this->session->userLoggedIn && $this->session->userId) ? true : false;
	}

	/**
	 * Logout out the user from the system
	 * By removing all sessions that are currently in force
	 */
	public function logout_user() {
		$this->session->remove("userLoggedIn");
		$this->session->remove("userId");
		$this->session->remove("userName");
		$this->session->destroy();
	}

	/**
	 * Get the current user logged role
	 */
	public function logged_Role() {
		return ($this->session->userRole) ? $this->session->userRole : false;	
	}

	/**
	 * Global function to search for item based on the predefined columns and values parsed
	 * @param String $table 	This is the name of the table to query
	 * @param String $value		The value to match the column with
	 * @param String $column	The name of the column to return after the search
	 * @param String $field		An optional field (column) to search
	 * 
	 * @return Object
	 */
	public function item_by_id($table, $value, $column = null, $field=null) {
		global $booking;

		$this->found = false;

		if(is_null($field)){
			$field = (preg_match("/^[0-9]+$/", $value)) ? "id" : "user_id";
		}

		try {

			$sql = $booking->prepare("SELECT * FROM `$table` WHERE `$field`='$value'");
			$sql->execute();
			
			if($sql->rowCount() == 1) {

				$this->found = true;

				while($results = $sql->fetch(PDO::FETCH_ASSOC)) {
					# first confirm that the column the user is requesting
					# does results to be a valid column before you return the value
					if(!empty($column)) {
						# use the column supplied to fetch the result for the user
						return $results[$column];
					}

					#run the second part of this code to return an empty array set
					else {
						# return an empty result
						if(isset($results['password'])) {
							unset($results['password']);
						}
						return $results;
					}
				}
			} 

		} catch(PDOException $e) {

			return;

		}

	}

	/**
	 * Get the information of this user
	 * @param String $userId	The unique id of the user
	 * @param String $clientId	This is the client id that have been parsed
	 * 
	 * @return Array Object
	 */
	public function get_user_basic($userId, $clientId){
		
		try {

			$stmt = $this->db->prepare("
				SELECT 
					name, gender, email, login, brand_ids, permissions,
					access_level, access_level_code, access_level_name, 
					theme, phone_number, country, city, last_login, created_on,
					access_level_permissions, image, status
				FROM `users` 
				LEFT JOIN users_access_levels ON `users`.access_level = users_access_levels.access_level_code 
				LEFT JOIN users_roles ON `users`.user_id = users_roles.user_id 
				WHERE users.user_id = ? AND users.deleted = ? AND users.clientId = ? LIMIT 1");
			$stmt->execute([$userId, 0, $clientId]);

			return $stmt->fetch(PDO::FETCH_OBJ);

		} catch(PDOException $e) {
			return false;
		}

	}

	/**
	 * Get the list of all Admin users the clientid specified
	 * @param String $clientId	This is the client id that have been parsed
	 * 
	 * @return Array Object
	 */
	public function get_users_basic($clientId){

		$sql = "
		SELECT 
			users.user_id, name, gender, email, login, brand_ids, image, access_level, access_level_code, 
			access_level_name, permissions, theme, phone_number, country, city, last_login, created_by, 
			access_level_permissions, created_on, status
		FROM `users` 
		LEFT JOIN users_access_levels ON `users`.access_level = users_access_levels.access_level_code 
		LEFT JOIN users_roles ON `users`.user_id = users_roles.user_id 
		WHERE users.clientId = ? AND users.deleted=?";

		$stmt = $this->db->prepare($sql);

		$stmt->execute([$clientId, 0]);

		return $stmt->fetchAll(PDO::FETCH_OBJ);

	}

	public function get_user_genders(){
		$sql = $this->db->query("SELECT id, name FROM `users_gender`");
		return $sql;
	}

	/**
	 * Add_user method is called by the auth.php file when the signUp endpoint is accessed.
	 * This creates a user account and a user profile for the new user,
	 * An authentication token is sent to the users email address for verification of the account.
	 * 
	 * The user is automatically logged in after all the process is completed.
	 * 
	 * @return bool
	 */
	public function add_user($user){

		try {
			
			$this->db->beginTransaction();

			if(empty($user)) return false;
			
			$user->userId = $this->generate_user_id();
			$user->brandId 	= $this->generate_brand_id();
			$user->instanceId = $this->generate_instance_id();
			$user->clientId = random_string('nozero', 16);
			$user->verifyToken = $this->generate_verification_code();

			if($this->insert_client($user)){

				$this->insert_user($user);
				
				// auto sign in after registering
				$this->session->set("userLoggedIn", random_string('alnum', 50));
                $this->session->set("userId", $user->userId);
                $this->session->set("userName", $user->username);
                $this->session->set("userRole", 1);
                $this->session->set("clientId", $user->clientId);
                $this->session->set("instanceIds", $user->instanceId);

				$this->db->commit();

				return $user->userId;
			}
			else return false;
		} catch(PDOException $e) {
			$this->db->rollBack();
			return $e->getMessage();
		}
	}

	/**
	 * Get the list of access levels
	 * @param Int $id		This is an Id to exempty from the query list
	 * 
	 * @return array objects
	 */
	public function get_access_levels($id = null){
		$sql = "SELECT * FROM users_access_levels ".(!empty($id) ? " WHERE id != '{$id}'" : null);
		return $this->db->query($sql);
	}

	/**
	 * Insert the User Account (Client) Details.
	 * This method is runned when a new user signs up to use booking
	 * 
	 * An account is created for the company and a user account with admin privileges is also created.
	 * The use is automatically logged in once that is done.
	 * The Subscription details is set in a session there after
	 * 
	 * @return bool
	 */
	public function insert_client($user) {

		$subscription = (Object) [
			'brands' => 5,
			'users' => 5,
			'account_type' => 'trial',
			'registered_date' => date("Y-m-d"),
			'expiry_date' => date("Y-m-d", strtotime("today + 14 days")),
			'brands_created' => 0,
			'users_created' => 1
		];

		$keys = (Object) [
			'key' => random_string('alnum', 75),
			'expiry' => date("Y-m-d", strtotime("today + 3 months"))
		];

		// form the email message
        $emailSubject = "Setup - {$user->brand} \[".config_item('site_name')."\]\n";
        $emailMessage = "Hello {$user->fullname},\n";
        $emailMessage .= "Thank you for registering your Brand <strong>{$user->brand}</strong> with ".config_item('site_name').". We are pleased to have you join and experiment with our platform.\n\n";
        $emailMessage .= "One of our personnel will get in touch shortly to assist you with additional setup processes that is required to aid you quick start the usage of the application.\n\n";
      	$emailMessage .= "<a href='".$this->config->base_url('verify/account?token='.$user->verifyToken)."'><strong>Click Here</strong></a> to verify your Email Address\n\n";
        
        $userEmail = [
            "recipients_list" => [
                [
                    "fullname" => $user->fullname,
                    "email" => $user->email,
                    "customer_id" => $user->userId
                ]
            ]
        ];
            
        // record the email sending to be processed by the cron job
        $sms = $this->db->prepare("
            INSERT INTO email_list 
            SET clientId = ?, template_type = ?, itemId = ?, recipients_list = ?,
                request_performed_by = ?, message = ?, subject = ?
        ");
        $sms->execute([
            $user->clientId, 'general', $user->clientId, json_encode($userEmail), 
            $user->userId, $emailMessage, $emailSubject
		]);
		
		// save the subscription package in an array session
		$this->session->set("accountPackage", (array) $subscription);

		// prepare the user account details and execute the statement
		$client = $this->db->prepare("
			INSERT INTO users_accounts
			SET clientId = ?, name = ?, email = ?, phone = ?, country = ?, city = ?,
			account_type = ?, industry = ?, subscription = ?, client_key = ?, created_by = ?
		");
		return $client->execute([
			$user->clientId, $user->brand, $user->email, $user->phone, $user->country, $user->city,
			$user->account_type, $user->industry, json_encode($subscription), json_encode($keys), $user->userId
		]);

	}

	/**
	 * Inserts data into `users` table
	 * @param  stdClass $user - Object containing user's information
	 * @return boolean	true if data successfully inserted. false otherwise.
	 */
	private function insert_user($user){

		global $accessObject;

		$initialAccess = 1;
		$createdOn = date("Y-m-d H:i:s");
		$verificationEmailCode = $user->verifyToken;
		$verificationSMSCode = $this->generate_sms_code();
		$accessPermissions = $accessObject->getPermissions($initialAccess);

		$params = [
			$user->clientId,
			$user->userId,
			$user->fullname,
			$user->gender,
			$user->email,
			$user->username,
			password_hash($user->password, PASSWORD_DEFAULT),
			$initialAccess,		// Initial Access Level
			$user->phone,
			$user->country,		// Country Id
			$user->city,		// City Id
			$user->instanceId,
			$createdOn,
			(!empty($user->created_by) ? $user->created_by : $user->userId),
			$verificationSMSCode,
			$verificationEmailCode
		];

		$sql = "
		INSERT INTO users (
			clientId, user_id, `name`, gender, 
			email, `login`, `password`, 
			access_level,phone_number,country,
			city, instance_ids,
			created_on, created_by, verification_sms_code, 
			verification_email_code
		) VALUES (" . str_repeat('?,', 15) . "?)";

		try {
			$stmt = $this->db->prepare($sql);
			$stmt->execute($params);
			
			// load the access level permissions
			$accessPermissions = $accessPermissions[0]->access_level_permissions;
			
			// log the user access level
			$stmt2 = $this->db->prepare("
				INSERT INTO users_roles SET clientId = ?, user_id = ?, permissions = ?
			");
			return $stmt2->execute([$user->clientId, $user->userId, $accessPermissions]);
		}
		catch(PDOException $e){
			return false;
		}
	}

	/**
	 * Add a new user account
	 * @param stdClass $params
	 * 
	 * @return String
	 */
	public function addUserProfile(stdClass $params) {
		
		// load the user session key to be used for all the queries
		$accountInfo = $this->clientData;
		$cSubscribe = json_decode( $accountInfo->subscription, true );

		// confirm that the user has not reached the subscription ratio
		if($cSubscribe['users_created'] >= $cSubscribe['users']) {
			return "Sorry! Your current subscription will only permit a maximum of {$cSubscribe['users']} users";
		}

		// confirm a valid contact number
		if(!empty($params->phone) && !preg_match("/^[0-9+]+$/", $params->phone)) {
			// return error message
			return "Sorry! Enter a valid contact number.";
		}

		// contact number should be at most 15 characters long
		if(strlen($params->phone) > 15) {
			// return error message
			return "Sorry! The contact number must be at most 15 characters long.";
		}

		// confirm that the username is already existing
		if(empty($params->email) || !filter_var($params->email, FILTER_VALIDATE_EMAIL)) {
			// return error message
			return "Sorry! Enter a valid email address.";
		}

		// confirm that the email address does not belong to this client already
		if($this->check_existing("users", "email", $params->email, "AND clientId='{$params->clientId}' AND deleted='0'")) {
			return "Sorry! This email address have already been linked to this Account.";
		}

		// get the username only from the email address
		$params->username = explode("@", $params->email)[0];

		// confirm username is not already taken
		if($this->check_existing("users", "login", $params->username, "AND clientId='{$params->clientId}' AND deleted='0' AND user_type='user'")) {
			return "Sorry! The username already exist.";
		}

		// confirm valid access levels list
		if(empty($params->access_level) || !is_array($params->access_level)) {
			return "An invalid Access Level Permissions were parsed";
		}

		// confirm valid access levels list
		if(empty($params->access_level_id) || !preg_match("/^[0-9]+$/", $params->access_level_id)) {
			return "An invalid Access Level Permission ID was parsed";
		}

		// confirm brand ids list
		if(empty($params->brand_ids) || !is_array($params->brand_ids)) {
			return "Sorry! Please check the selected brands to continue (Select at least one)";
		}

		// get the list of brand ids of this current account
		$activeBrands = $this->clientBrandIds($params->clientId);

		// confirm that all the brands are in the users session
		foreach(array_keys($params->brand_ids) as $eachBrand) {
			if(!in_array($eachBrand, $activeBrands)) {
				return "An invalid brand id was parsed. Please confirm and try again.";
				break;
			}
		}

		// initialiate
		$accessLevel = [];

		// clean the access permissions well
		foreach($params->access_level as $eachKey => $eachValue) {
			foreach($eachValue as $key => $value) {
				foreach($value as $i => $e) {
					$accessLevel[$eachKey][$key] = ($e == "on") ? 1 : 0;
				}
			}
		}
		$permissions["permissions"] = $accessLevel;

		// lets move ahead and create some more variables
		$params->userId = $this->generate_user_id();
		$params->verifyToken = $this->generate_verification_code();
		$params->created_by = $params->curUserId;
		
		try {

			// begin transaction
			$this->db->beginTransaction();

			// create a new object
			$instancesClass = load_class("instances", "controllers");

			$instance = (object)[];
			$instanceIds = [];
			$instance->userId = $params->userId;
			$instance->created_by = $params->created_by;

			// foreach brand create a new instance for this user
			foreach(array_keys($params->brand_ids) as $eachBrand) {
				// instance parameters
				$instance->instanceId = $this->generate_instance_id();
				$instance->brandId = $eachBrand;
				$instanceIds[] = $instance->instanceId;

				// add the brand instances
				$instancesClass->add_brand_instance($instance);
			}

			// insert the user account the user profile information
			$stmt = $this->db->prepare("
				INSERT INTO `users` SET
				name = ?, gender = ?, email = ?, phone_number = ?, clientId=?, created_on = now(), 
				created_by = ?, verification_email_code = ?, instance_ids = ?, login = ?".
				(empty($params->city) ? '' : ", city = '{$params->city}'").
				(empty($params->country) ? '' : ", country = '{$params->country}'").
				(empty($params->image) ? '' : ", image = '{$params->image}'").
				(empty($params->brand_ids) ? '' : ", brand_ids = '".implode("|", array_keys($params->brand_ids))."'").
				(empty($params->access_level_id) ? '' : ", access_level = '{$params->access_level_id}'").
				", user_id = ?, user_type = ?, password = ?
			");
			$stmt->execute([
				$params->fullname, $params->gender, $params->email, $params->phone, $params->clientId,
				$params->curUserId, $params->verifyToken, implode("|", $instanceIds), $params->username, 
				$params->userId, "user", password_hash(random_string('alnum', 12), PASSWORD_DEFAULT)
			]);

			// insert the user access levels
			$stmt = $this->db->prepare("INSERT INTO users_roles SET permissions = ?, clientId=?, last_updated = now(), user_id = ?");
			$stmt->execute([json_encode($permissions), $params->clientId, $params->userId]);
			
			// insert the current brand id of the user
			$stmt = $this->db->prepare("INSERT INTO users_brand_settings SET clientId = ?, brand_id = ?, user_id = ?");
			$stmt->execute([$params->clientId, array_keys($params->brand_ids)[0], $params->userId]);

			// insert the user activity
			$this->userLogs("profile", $params->userId, "Added a new the Profile Account of {$params->fullname}.", $params->curUserId, $params->clientId);

			// form the email message
			$emailSubject = "Account Setup \[".config_item('site_name')."\]\n";
			$emailMessage = "Hello {$params->fullname},\n";
			$emailMessage .= "You have been added as a user on <strong>{$accountInfo->name}</strong> to help manage the Account.\n\n";
			$emailMessage .= "Your username to be used for login is <strong>{$params->username}</strong>\n";
			
			// They can use their old password to login into the system if they already have an active account
			if($this->userAccountsCount($params->email) > 0) {
				$emailMessage .= "You can use your previous password to continue to login.\n";
			} else {
				// check if the user already has an account if not then they will get the prompt to set a new password
				$emailMessage .= "The Password would be set once you verify your email address.\n";
			}		

			// create the verification link
			$emailMessage .= "Please <a href='".$this->config->base_url('verify/account?token='.$params->verifyToken)."'><strong>Click Here</strong></a> to verify your Email Address.\n\n";

			// set the email address
			$userEmail = [
				"recipients_list" => [
					[
						"fullname" => $params->fullname,
						"email" => $params->email,
						"customer_id" => $params->userId
					]
				]
			];
			
			// increment the number of brands created for the account subscription
			$cSubscribe['users_created'] = (!isset($cSubscribe['users_created'])) ? 1 : ($cSubscribe['users_created']+1);

			// update the client brands subscription count
			$this->db->query("UPDATE users_accounts SET subscription='".json_encode($cSubscribe)."' WHERE clientId='{$params->clientId}'");

			// set the new value for the subscription stored in session
			$this->session->accountPackage = $cSubscribe;

			// record the email sending to be processed by the cron job
			$sms = $this->db->prepare("
				INSERT INTO email_list SET clientId = ?, template_type = ?, itemId = ?, recipients_list = ?, request_performed_by = ?, message = ?, subject = ?
			");
			$sms->execute([
				$params->clientId, 'general', $params->userId, json_encode($userEmail), $params->curUserId, $emailMessage, $emailSubject
			]);
			
			$this->db->commit();

			return "account-created";
			
		} catch(PDOException $e) {
			$this->db->rollBack();
			return "An unexpected error occured.";
		}
		
	}

	/**
	 * Update the user profile information
	 * This method is only accessing on the Web Platform only.
	 * Hence a session is used to save the user id to update the information
	 * 
	 * @param stdClass $user		This contains all the variables for updating the user information
	 * 
	 * @return String
	 */
	public function updateUserProfile(stdClass $user){

		// global variable
		global $accessObject;

		// confirm that the user id has been parsed
		if(empty($this->session->currentUserId)) {
			return;
		}

		// set the user to update the profile from the session variable
		$userId = $this->session->currentUserId;

		// sanitize the user email address
		$user->email = (!empty($user->email)) ? filter_var($user->email, FILTER_SANITIZE_EMAIL) : null;
		
		// confirm valid email address
		if(!filter_var($user->email, FILTER_VALIDATE_EMAIL)) {
			return "invalid-email";
		}

		// confirm valid contact number
		if(!preg_match("/^[0-9+]+$/", $user->phone)) {
			return "invalid-phone";
		}

		// confirm valid access levels list
		if(!empty($user->access_level) && !is_array($user->access_level)) {
			return "invalid-access_levels";
		}

		// confirm brand ids list
		if(!empty($user->brand_ids) && !is_array($user->brand_ids)) {
			return "invalid-brand_ids";
		}

		// get the list of brand ids of this current account
		$activeBrands = $this->clientBrandIds($this->clientId);

		// run this section if the brand ids are not empty
		if(!empty($user->brand_ids)) {
			// confirm that all the brands are in the users session
			foreach(array_keys($user->brand_ids) as $eachBrand) {
				if(!in_array($eachBrand, $activeBrands)) {
					return "invalid-brand_ids";
				break;
				}
			}
		}

		// run this section if the access level permissions were parsed
		if(!empty($user->access_level)) {
			// initialiate
			$accessLevel = [];
			// clean the access permissions well
			foreach($user->access_level as $eachKey => $eachValue) {
				foreach($eachValue as $key => $value) {
					foreach($value as $i => $e) {
						$accessLevel[$eachKey][$key] = ($e == "on") ? 1 : 0;
					}
				}
			}
			$permissions["permissions"] = $accessLevel;
		}
		
		// set the parameters to push
		$params = [
			$user->fullname,
			$user->gender,
			$user->email,
			$user->phone
		];

		array_push($params, $userId);

		try {
			
			$this->db->beginTransaction();

			// update the user profile information
			$stmt = $this->db->prepare("
				UPDATE `users` SET
				name = ?, gender = ?, email = ?, phone_number = ?".
				(empty($user->city) ? '' : ", city = '{$user->city}'").
				(empty($user->country) ? '' : ", country = '{$user->country}'").
				(empty($user->image) ? '' : ", image = '{$user->image}'").
				(empty($user->brand_ids) ? '' : ", brand_ids = '".implode("|", array_keys($user->brand_ids))."'").
				(empty($user->access_level_id) ? '' : ", access_level = '{$user->access_level_id}'").
				" WHERE user_id = ? LIMIT 1
			");
			$stmt->execute($params);
			
			// if the user access level was parsed
			if(isset($permissions) && !empty($permissions)) {
				// update the user access levels
				$stmt = $this->db->prepare("UPDATE users_roles SET permissions = ?, last_updated = now() WHERE user_id = ? AND clientId= ?");
				$stmt->execute([json_encode($permissions), $userId, $user->clientId]);
			}

			// update the brand ids in the session list
			if(!empty($user->brand_ids)) {
				// unset the brands list data session
				$this->session->brandsListData = null;
				
				// set the new list of brand ids to show on the user panel
				$brandsIds = implode("|", array_keys($user->brand_ids));
				$this->session->brandIds = $brandsIds;

				// if the brands is just one then set this as the current brand for the account
				if(count(array_keys($user->brand_ids)) == 1) {
					// set this in session
					$this->session->currentBrandId = array_keys($user->brand_ids)[0];
					
					// update the current brand id of the user
					$stmt = $this->db->prepare("UPDATE users_brand_settings SET brand_id = ? WHERE user_id = ?");
					$stmt->execute([array_keys($user->brand_ids)[0], $userId]);
				}
				// what if the user select more than 1 brand however the current brand is not in the list of the selected brands
				// get the list of of all brands parsed and check that against that of what the user is permitted to do
				else {
					// get some more items
					$userPermittedBrands = $this->userBrandIds($userId);
					$nowPermittedList = array_keys($user->brand_ids);
					
					// get the default brand id of the user
					$currentDefaultId = $this->defaultBrandSetting($userId);

					// find the difference between the keys
					$arrayDiff = array_diff($userPermittedBrands, $nowPermittedList);

					// if the current brand id is found in the now exempted brand ids
					if(!in_array($currentDefaultId->brand_id, $arrayDiff)) {

						// set this in session
						$this->session->currentBrandId = $nowPermittedList[0];

						// update the current brand id of the user using the very first id within the brands ids list
						$stmt = $this->db->prepare("UPDATE users_brand_settings SET brand_id = ? WHERE user_id = ?");
						$stmt->execute([$nowPermittedList[0], $userId]);
					}

				}
			}

			// insert a new user activity log
			if($userId != $this->session->userId) {
				$this->userLogs("profile", $userId, "Update the Profile Details of {$user->fullname}.", $this->session->userId, $user->clientId);
			} else {
				$this->userLogs("profile", $userId, "You updated your profile details.", $this->session->userId, $user->clientId);
			}

			// commit the transactions
			$this->db->commit();

			// return true if all went well
			return true;

		} catch(PDOException $e) {
			$this->db->rollBack();
			return "unknown-error";
		} 

	}

	/**
     * Load the list of user activity logs
     * 
     * @param String $userId   The unique id of the post
     * 
     * @return Array        Empty if an error occurs or data from the file
     * 
     */
    public function userActivityLogs(stdClass $params) {
        try {
            
			$stmt = $this->db->prepare("SELECT page, date_recorded, description, user_agent FROM users_activity_logs WHERE clientId = ? AND userId = ? ORDER BY id DESC LIMIT {$params->limit}");
            $stmt->execute([$params->clientId, $params->user_id]);

            $results = $stmt->fetchAll(PDO::FETCH_OBJ);

            return $results;

        } catch(PDOException $e) {
            return false;
        }
    }

	/**
	 * Update the user theme color
	 * @param Array $data		This contains the variable theme for updating the user theme color
	 * @param String $userId	The user id of the user performing the function
	 * 
	 * @return Bool
	 */
	public function updateUserTheme(array $data) {

		// confirm that the theme variable was parsed
		if( isset($data['theme']) ) {
			
			// assign variables and clean them
			$userId = $this->session->userId;
			
			// set the theme in a session
			$this->session->userPreferedTheme = ($data['theme'] == 1) ? "light-theme" : "dark-theme";

			// update the user theme settings
			$stmt = $this->db->prepare("UPDATE users SET theme='{$data['theme']}' WHERE user_id='{$userId}'");
			return $stmt->execute();
		}
	}

	/**
	 * Select and Save the User Account Id in a session
	 *
	 * @param $accountId This is the Account Id to be saved in a session
	 *
	 * @return bool
	 **/
	public function selectAccount(array $data) {
		
		// confirm that the theme variable was parsed
		if( isset($data['accountId']) ) {

			// save this client id into the session
			$this->session->clientId = $data['accountId'];

			// load the user session key to be used for all the queries
			$clientData = $this->clientData($data['accountId']);

			// get the user id attached to this email address and the supplied client account id
			$userInfo = $this->userIdSearch($this->session->get("tempEmailAddress"), $data['accountId']);

			// set the session for what has already been set
			$this->session->userId = $userInfo->user_id;
			$this->session->brandIds = $userInfo->brand_ids;
			$this->session->instanceIds = $userInfo->instance_ids;
			$this->session->currentBrandId = $userInfo->current_brand_id;

			// remove the list of all brand ids
			$this->session->remove("brandsListData");

			// unset the temporal email address
			$this->session->remove("tempEmailAddress");

			// convert the keys column to an array
			$accessToken = json_decode( $clientData->client_key, true );
			$subscription = json_decode( $clientData->subscription, true );

			$this->session->clientKey = $accessToken['key'];

			$this->session->accountPackage =  $subscription;

			return true;
		}

	}

	/**
	 * Return the list of access level permissions for this id
	 * 
	 * @param Int $level_id 	This is the access level id
	 * 
	 * @return String
	 */
	public function userAccessLevels($level_id) {

		try {

			$stmt = $this->db->prepare("SELECT access_level_permissions, access_level_name FROM users_access_levels WHERE id=?");
			$stmt->execute([$level_id]);
			$result = $stmt->fetch(PDO::FETCH_OBJ);

			if ($stmt->rowCount()) {
				// convert to an array
				$item = json_decode($result->access_level_permissions, true);

				// get the first key
				$item = $item["permissions"];
				
				$level_data = "<div class='row'>";
				// loop through the list
				foreach ($item as $key => $value) {
					$header = ucwords(str_replace("_", " ", $key));
					$level_data .= "<div class='col-lg-12 border-bottom border-default pb-2'><h6 style='font-weight:bolder'>".$header."</h6></div>";
					foreach($value as $nkey => $nvalue) {
						$level_data .= "<div class='col-lg-6 pt-2'>";
						$level_data .= "<input checked='checked' type='checkbox' id='access_level[$key][$nkey]' class='brands-checkbox' name='access_level[$key][$nkey][]'>";
						$level_data .= "<label class='cursor' for='access_level[$key][$nkey]'>".ucfirst($nkey)."</label>";
						$level_data .= "</div>";
					}
				}
				$level_data .= "</div>";

				return $level_data;
			}
		} catch(PDOException $e) {
			return false;
		}
		
	}

	// public function update_user_channels($userId, array $channels){

	// 	$channelsString = implode("|", $channels);
	// 	$sql = $this->db->prepare("
	// 		UPDATE `brand` SET channel_codes = ?
	// 		WHERE user_id = ? LIMIT 1
	// 	");
	// 	return $sql->execute([$channelsString, $userId]);

	// }

	public function remove_user($user_id){
		$stmt = $this->db->prepare("
			UPDATE `users` SET
			status = ? WHERE user_id = ? LIMIT 1");
		return $stmt->execute([self::REMOVED_USER_STATUS, $user_id]);
	}

	public function generate_user_id(){
		$userId = $this->user_id_prefix.random_string('nozero', 9);
		return !$this->data_unique("users", "user_id", $userId) ? $this->generate_user_id() : $userId;
	}

	public function generate_brand_id(){
		$brandId = $this->brand_id_prefix.random_string('nozero', 9);
		return !$this->data_unique("brand", "brand_id", $brandId) ? $this->generate_brand_id() : $brandId;
	}

	public function generate_instance_id(){
		$instanceId = $this->instance_id_prefix.random_string('nozero', 9);
		return !$this->data_unique("instances", "instance_id", $instanceId) ? $this->generate_instance_id() : $instanceId;
	}

	private function generate_verification_code(){
		return random_string('alnum', mt_rand(55, 75));
	}

	private function generate_sms_code(){
		$code = random_string('numeric', 6);
		return !$this->data_unique("users", "verification_sms_code", $code) ? $this->generate_sms_code() : $code;
	}

	public function check_existing($table, $column, $data, $addWhere = null){
		try {
			$stmt = $this->db->prepare("
				SELECT COUNT(*) AS rowcount 
				FROM `{$table}` 
				WHERE `{$column}`='{$data}' {$addWhere}
			");
			$stmt->execute();

			return (!empty($stmt->fetch(PDO::FETCH_OBJ)->rowcount)) ? true : false;
		} catch (PDOException $e) {
			return false;
		}
	}

	public function data_unique($table, $column, $data){
		try {
			$stmt = $this->db->query("
				SELECT COUNT(*) AS rowcount 
				FROM `{$table}` 
				WHERE `{$column}` = '{$data}'
			");
			$rows = $stmt->fetch();
			return empty($rows->rowcount);
		} catch (PDOException $e) {
			return false;
		}
	}

	public function fetch_user_channels($brandId) {

		$stmt = $this->db->prepare("
			SELECT 
				GROUP_CONCAT(DISTINCT channel_code SEPARATOR '|') AS user_channels
			FROM 
				brand_channels WHERE brand_id = ? AND status = ? 
		");
		$stmt->execute([$brandId, 1]);

		return $stmt->fetch(PDO::FETCH_OBJ);
	}

	public function fetch_user_brand_settings($userId) {

		$stmt = $this->db->prepare("
			SELECT 
				user_id, brand_id, facebook, twitter, instagram, youtube, linkedin, pinterest
			FROM 
				users_brand_settings WHERE user_id = ?
		");
		$stmt->execute([$userId]);

		return $stmt->fetch(PDO::FETCH_OBJ);
	}

	public function accountActivation() {
		if( !$this->session->activated ) { ?>
		<div class="row justify-content-center">
			<div class="col-lg-12 col-md-8 col-sm-12" style="border-radius: 0px">
				<div class="alert alert-danger text-center">Your account has not yet been activated. Please check your email for the activation link.</div>
			</div>
		</div>
		<?php }
	}

}

?>