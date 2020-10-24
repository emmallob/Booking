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
	protected $user_id_prefix 	= "BK";
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
		return ($this->session->bokLoggedIn && $this->session->userId) ? true : false;
	}

	/**
	 * Logout out the user from the system
	 * By removing all sessions that are currently in force
	 */
	public function logout_user() {
		$this->session->remove("bokLoggedIn");
		$this->session->remove("userId");
		$this->session->remove("clientId");
		$this->session->destroy();
	}

	/**
	 * This method lists all users
	 * 
	 * @param stdClass	$params		This is an object of all the parameters to use for the query
	 */
	public function list(stdClass $params) {

		return $this->listUsers($params);
	}

	/**
	 * This method lists all users
	 * 
	 * @param stdClass	$params		This is an object of all the parameters to use for the query
	 */
	public function listUsers(stdClass $params) {

		global $accessObject;

		$condition = "";
		$result = [];

		$condition = !empty($params->user_guid) ? "AND a.user_guid='{$params->user_guid}'" : null;

		try {
			$query = $this->booking->prepare("
				SELECT a.*, b.access_level_name, 
					(SELECT b.permissions FROM users_roles b WHERE b.user_guid = a.user_guid AND b.client_guid=a.client_guid LIMIT 1) AS user_permissions
					FROM users a 
				LEFT JOIN users_access_levels b
					ON a.access_level = b.id
					WHERE a.client_guid = ? && a.deleted = ? {$condition}
				LIMIT {$params->limit}
			");

			$manageUsers = $accessObject->hasAccess('manage', 'users');
			$deleteUsers = $accessObject->hasAccess('delete', 'users');
			$userAccessLevels = $accessObject->hasAccess('accesslevel', 'users');

			if ($query->execute([$params->clientId, 0])) {
				$i = 0;

				while ($data = $query->fetch(PDO::FETCH_OBJ)) {
					$i++;

					$date = date('jS F, Y', strtotime($data->created_on));

					$action = '<div width="100%" align="center">';

					if($manageUsers) {
						if(in_array($data->access_level, [1, 2]) && (in_array($this->session->accessLevel, [1, 2]))) {
								$action .= "<a href=\"{$this->baseUrl}profile/{$data->user_guid}\" title=\"Edit the details of {$data->name}\" class=\"btn btn-sm btn-outline-success edit-user\" data-user-id=\"{$data->user_guid}\">
								<i class=\"fa fa-edit\"></i>
							</a> ";
						} elseif(!in_array($data->access_level, [1, 2])) {
							$action .= "<a href=\"{$this->baseUrl}profile/{$data->user_guid}\" title=\"Edit the details of {$data->name}\" class=\"btn btn-sm btn-outline-success edit-user\" data-user-id=\"{$data->user_guid}\">
								<i class=\"fa fa-edit\"></i>
							</a> ";
						}
					}

					if($deleteUsers) {
						if(in_array($data->access_level, [1, 2]) && (in_array($this->session->accessLevel, [1, 2]))) {
							if($data->user_guid != $this->session->userId) {
								$action .= "&nbsp;<a href=\"javascript:void(0)\" title=\"Delete the record of {$data->name}\" class=\"btn btn-sm btn-outline-danger delete-item\" data-url=\"{$this->baseUrl}api/remove/confirm\" data-item=\"user\" data-item-id=\"{$data->user_guid}\" data-msg=\"Are you sure you want to delete the user {$data->name}?\">
									<i class=\"fa fa-trash\"></i>
								</a> ";
							}
						} elseif(!in_array($data->access_level, [1, 2])) {
							$action .= "&nbsp;<a href=\"javascript:void(0)\" title=\"Delete the record of {$data->name}\" class=\"btn btn-sm btn-outline-danger delete-item\" data-url=\"{$this->baseUrl}api/remove/confirm\" data-item=\"user\" data-item-id=\"{$data->user_guid}\" data-msg=\"Are you sure you want to delete the user {$data->name}?\">
								<i class=\"fa fa-trash\"></i>
							</a> ";
						}
					}

					$action .= "</div>";

					$result[] = (object) [
						'user_id' => $data->user_guid,
						'row_id' => $i,
						'fullname' => $data->name . ((!$data->status) ? "<br><span class='badge badge-danger'>Inactive</span>" : "<br><span class='badge badge-success'>Active</span>"),
						'access_level' => $data->access_level_name,
						'access_level_id' => $data->access_level,
						'gender' => $data->gender,
						'contact' => $data->contact,
						'email' => $data->email,
						'registered_date' => $date,
						'user_permissions' => $data->user_permissions,
						'action' => $action,
						'deleted' => 0
					];

				}
			}
			return $result;

		} catch(PDOException $e) {
			return $e->getMessage();
		}
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
			$field = (preg_match("/^[0-9]+$/", $value)) ? "id" : "user_guid";
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
	 * @return Object
	 */
	public function get_user_basic($userId, $clientId){
		
		try {

			$stmt = $this->db->prepare("
				SELECT 
					name, gender, email, username, permissions,
					access_level,users_access_levels.id AS access_level_id, access_level_name, 
					theme, contact, last_login, created_on,
					access_level_permissions, image, status
				FROM `users` 
				LEFT JOIN users_access_levels ON `users`.access_level = users_access_levels.id 
				LEFT JOIN users_roles ON `users`.user_guid = users_roles.user_guid 
				WHERE users.user_guid = ? AND users.deleted = ? AND users.client_guid = ? LIMIT 1");
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
	 * Get the list of access levels
	 * @param Int $id		This is an Id to exempty from the query list
	 * 
	 * @return Object
	 */
	public function singleAccessLevel($id){
		$sql = $this->db->prepare("SELECT * FROM users_access_levels WHERE id = '{$id}'");
		$sql->execute();

		return $sql->fetch(PDO::FETCH_OBJ);
	}


	/**
	 * Add a new user account
	 * @param stdClass $userData
	 * 
	 * @return String
	 */
	public function add(stdClass $params) {

		// update directory
        $uploadDir = 'assets/img/profiles/';
		
		// load the user session key to be used for all the queries
		$accountInfo = $this->clientData($params->clientId);
		$cSubscribe = json_decode( $accountInfo->subscription, true );

		// confirm that the user has not reached the subscription ratio
		if($cSubscribe['users_created'] >= $cSubscribe['users']) {
			return ["code" => 203, "msg" => "Sorry! Your current subscription will only permit a maximum of {$cSubscribe['users']} users"];
		}

		// confirm that the username is already existing
		if(empty($params->email) || !filter_var($params->email, FILTER_VALIDATE_EMAIL)) {
			// return error message
			return ["code" => 203, "msg" => "Sorry! Enter a valid email address."];
		}

		// confirm that the email address does not belong to this client already
		if($this->check_existing("users", "email", $params->email, "AND client_guid='{$params->clientId}' AND deleted='0'")) {
			return ["code" => 203, "code" => 203, "msg" => "Sorry! This email address have already been linked to this Account."];
		}

		// confirm a valid contact number
		if(!empty($params->contact) && !preg_match("/^[0-9+]+$/", $params->contact)) {
			// return error message
			return ["code" => 203, "msg" => "Sorry! Enter a valid contact number."];
		}

		// contact number should be at most 15 characters long
		if(strlen($params->contact) > 15) {
			// return error message
			return ["code" => 203, "msg" => "Sorry! The contact number must be at most 15 characters long."];
		}

		// get the username only from the email address
		$params->username = explode("@", $params->email)[0];

		// confirm username is not already taken
		if($this->check_existing("users", "login", $params->username, "AND client_guid='{$params->clientId}' AND deleted='0' AND user_type='user'")) {
			return ["code" => 203, "msg" => "Sorry! The username already exist."];
		}

		//** set the access level id */
		if(!isset($params->access_level_id)) {
			$params->access_level_id = 2;
			$permits = $this->singleAccessLevel(2)->access_level_permissions;
			$permissions = json_decode($permits, true);
		}

		// confirm valid access levels list
		if(!empty($params->access_level) && !is_array($params->access_level)) {
			return ["code" => 203, "msg" => "An invalid Access Level Permissions were parsed"];
		}

		// confirm valid access levels list
		if(empty($params->access_level_id) || !preg_match("/^[0-9]+$/", $params->access_level_id)) {
			return ["code" => 203, "msg" => "An invalid Access Level Permission ID was parsed"];
		}

		// initialiate
		$accessLevel = [];

		// clean the access permissions well
		if(!isset($permissions)) {
			// loop through the access permissions parsed
			foreach($params->access_level as $eachKey => $eachValue) {
				foreach($eachValue as $key => $value) {
					foreach($value as $i => $e) {
						$accessLevel[$eachKey][$key] = ($e == "on") ? 1 : 0;
					}
				}
			}
			$permissions["permissions"] = $accessLevel;
		}

		// lets move ahead and create some more variables
		$params->userId = $this->generate_user_id();
		$params->verifyToken = $this->generate_verification_code();
		$params->created_by = $params->curUserId;

		try {

			// confirm that a logo was parsed
			if(isset($params->user_image)) {

				// File path config 
				$fileName = basename($params->user_image["name"]); 
				$targetFilePath = $uploadDir . $fileName; 
				$fileType = strtolower(pathinfo($targetFilePath, PATHINFO_EXTENSION));

				// Allow certain file formats 
				$allowTypes = array('jpg', 'png', 'jpeg'); 
				
				// check if its a valid image
				if(!empty($fileName) && in_array($fileType, $allowTypes)){
					
					// set a new filename
					$fileName = $uploadDir . random_string('alnum', 25).'.'.$fileType;

					// Upload file to the server 
					if(move_uploaded_file($params->user_image["tmp_name"], $fileName)){ 
						$uploadedFile = $fileName;
					}
				}
			}

			// begin transaction
			$this->db->beginTransaction();

			// set the settings into an empty object
			$settings = (object) [];

			// update the user dashboard settings
			if(isset($params->navbar)) {
				$settings->navbar = $params->navbar;
			}

			if(isset($params->theme)) {
				$settings->theme = $params->theme;
			}

			// insert the user account the user profile information
			$stmt = $this->db->prepare("
				INSERT INTO `users` SET
				name = ?, email = ?, contact = ?, client_guid=?, created_on = now(), 
				created_by = ?, verify_token = ?, username = ?".
				(empty($uploadedFile) ? '' : ", image = '{$uploadedFile}'").
				(empty($settings) ? '' : ", dashboard_settings = '".json_encode($settings)."'").
				(empty($params->access_level_id) ? '' : ", access_level = '{$params->access_level_id}'").
				", user_guid = ?, user_type = ?, password = ?
			");
			$stmt->execute([
				$params->fullname, $params->email, $params->contact, $params->clientId,
				$params->curUserId, $params->verifyToken, $params->username, 
				$params->userId, "user", password_hash(random_string('alnum', 12), PASSWORD_DEFAULT)
			]);

			// insert the user access levels
			$stmt = $this->db->prepare("INSERT INTO users_roles SET permissions = ?, client_guid=?, last_updated = now(), user_guid = ?");
			$stmt->execute([json_encode($permissions), $params->clientId, $params->userId]);
			
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
			$this->db->query("UPDATE users_accounts SET subscription='".json_encode($cSubscribe)."' WHERE client_guid='{$params->clientId}'");

			// set the new value for the subscription stored in session
			$this->session->accountPackage = $cSubscribe;

			// record the email sending to be processed by the cron job
			$sms = $this->db->prepare("
				INSERT INTO users_email_list SET client_guid = ?, template_type = ?, item_guid = ?, recipients_list = ?, request_performed_by = ?, message = ?, subject = ?
			");
			$sms->execute([
				$params->clientId, 'general', $params->userId, json_encode($userEmail), $params->curUserId, $emailMessage, $emailSubject
			]);
			
			$this->db->commit();

			return [
				"code" => 200, 
				"msg" => "User account successfully created", 
				"additional" => [
					"clear" => true
				]
			];
			
		} catch(PDOException $e) {
			$this->db->rollBack();
			return $e->getMessage();
		}
		
	}

	/**
	 * Update the user profile information
	 * This method is only accessing on the Web Platform only.
	 * Hence a session is used to save the user id to update the information
	 * 
	 * @param stdClass $userData		This contains all the variables for updating the user information
	 * 
	 * @return String
	 */
	public function update(stdClass $userData){
		
		// update directory
        $uploadDir = 'assets/img/profiles/';

		// global variables
		global $accessObject;

		// sanitize the user email address
		$userData->email = (!empty($userData->email)) ? filter_var($userData->email, FILTER_SANITIZE_EMAIL) : null;

		// confirm valid contact number
		if(isset($userData->contact) && !preg_match("/^[0-9+]+$/", $userData->contact)) {
			return ["code" => 203, "msg" => "invalid-phone"];
		}

		// confirm valid email address
		if(!filter_var($userData->email, FILTER_VALIDATE_EMAIL)) {
			return ["code" => 203, "msg" => "invalid-email"];
		}

		// confirm valid access levels list
		if(!empty($userData->access_level) && !is_array($userData->access_level)) {
			return ["code" => 203, "msg" => "invalid-access_levels"];
		}

		// run this section if the access level permissions were parsed
		if(!empty($userData->access_level)) {
			// initialiate
			$accessLevel = [];
			// clean the access permissions well
			foreach($userData->access_level as $eachKey => $eachValue) {
				foreach($eachValue as $key => $value) {
					foreach($value as $i => $e) {
						$accessLevel[$eachKey][$key] = ($e == "on") ? 1 : 0;
					}
				}
			}
			$permissions["permissions"] = $accessLevel;
		}

		// Check If User ID Exists
		$checkData = $this->pushQuery("COUNT(*) AS userTotal, access_level, dashboard_settings", "users", "user_guid='{$userData->user_guid}' AND client_guid = '{$userData->clientId}'");

		if ($checkData != false && $checkData[0]->userTotal == '1') {

			// confirm that a logo was parsed
			if(isset($userData->user_image)) {

				// File path config 
				$fileName = basename($userData->user_image["name"]); 
				$targetFilePath = $uploadDir . $fileName; 
				$fileType = strtolower(pathinfo($targetFilePath, PATHINFO_EXTENSION));

				// Allow certain file formats 
				$allowTypes = array('jpg', 'png', 'jpeg'); 
				
				// check if its a valid image
				if(!empty($fileName) && in_array($fileType, $allowTypes)){
					
					// set a new filename
					$fileName = $uploadDir . random_string('alnum', 25).'.'.$fileType;

					// Upload file to the server 
					if(move_uploaded_file($userData->user_image["tmp_name"], $fileName)){ 
						$uploadedFile = $fileName;
					}
				}
			}
			
			// set the user dashboard settings into an object
			$settings = json_decode($checkData[0]->dashboard_settings);

			// update the user dashboard settings
			if(isset($userData->navbar)) {
				$settings->navbar = $userData->navbar;
			}

			if(isset($userData->theme)) {
				$settings->theme = $userData->theme;
			}

			// update user data
			$query = $this->updateData(
				"users",
				"name='{$userData->fullname}', email='{$userData->email}', 
				dashboard_settings='".json_encode($settings)."'
				".(isset($userData->contact) ? ",contact='{$userData->contact}'" : null)."
				".(isset($uploadedFile) ? ",image='{$uploadedFile}'" : null)."
				".(isset($userData->access_level_id) ? ",access_level='{$userData->access_level_id}'" : null)."	",
				"user_guid='{$userData->user_guid}' && client_guid='{$userData->clientId}'"
			);

			if ($query == true) {

				// Record user activity
				if($userData->user_guid == $userData->userId) {
					$this->userLogs('users', $userData->user_guid, 'You have updated your account information.', $userData->userId, $userData->clientId);
				} else {
					$this->userLogs('users', $userData->user_guid, 'Update the user details.', $userData->userId, $userData->clientId);
				}

				// if the user has permission to perform this action
				if($accessObject->hasAccess('accesslevel', 'users')) {
					/** if the access level id was parsed */
					if(isset($permissions) && !empty($permissions)) {
						// update the user access levels
						$stmt = $this->db->prepare("UPDATE users_roles SET permissions = ?, last_updated = now() WHERE user_guid = ? AND client_guid= ?");
						$stmt->execute([json_encode($permissions), $userData->user_guid, $userData->clientId]);
					}
				}

				return ["msg" => "User Details Have Been Successfully Updated."];
			} else {
				return ["msg" => "Sorry! User Records Failed To Update."];
			}
		} else {
			return ["code" => 203, "msg" => "invalid"];
		}
	}

	/**
	 * Change a users password
	 * Run basic check for a strong password supplied and confirm if they match
	 * 
	 * @param String $password 		The password
	 * @param String $password_2 	The second password to match
	 */
	public function change_password($params) {

		/** Matching test */
		if($params->password != $params->password_2) {
			return ["code" => 203, "msg" => "match-error"];
		}

		/** Strength test */
		if(!passwordTest($params->password)) {
			return ["code" => 203, "msg" => "strength-error"];
		}

		// Check If User ID Exists
		$checkData = $this->pushQuery("COUNT(*) AS userTotal, access_level", "users", "user_guid='{$params->user_guid}' AND client_guid='{$params->clientId}'");

		/** Confirm that the count is 1 */
		if ($checkData != false && $checkData[0]->userTotal == '1') {
			/** Hash the password */
			$password = password_hash($params->password, PASSWORD_DEFAULT);

			/** Update the user profile information */
			$this->db->query("UPDATE users SET password='{$password}' WHERE user_guid='{$params->user_guid}' AND client_guid='{$params->clientId}' LIMIT 1");

			// Record user activity
			$this->userLogs('users', $params->user_guid, 'Changed the password.', $params->user_guid, $params->clientId);

			/** Logout if the user who changed the password is the same person logged in */
			if($params->remote) {
				return ["code" => 203, "msg" => "User password successfully changed"];
			} else {
				// the print the alert to logout
				if($params->user_guid == $this->session->userId) {
					// destroy the session
					$this->session->destroy();

					// return the success message
					return ["code" => 203, "msg" => "Your password successfully changed. You have been automatically logged out from the system."];
				} else {
					return ["code" => 203, "msg" => "User password was successfully changed"];
				}
			}
		} else {
			return ["code" => 203, "msg" => "user-error"];
		}
		
	}

	/**
	 * Load the user permissions
	 * 
	 * @return Array
	 */
	public function loadPermissions(stdClass $params) {
		// global variable
		global $accessObject;

		// load the user permission and parse back the array data
		$access_level = (isset($params->access_level)) ? xss_clean($params->access_level) : null;
		$access_user  = (isset($params->user_guid)) ? xss_clean($params->user_guid) : null;

		// Check If User Is Selected
		if (!empty($access_user) && $access_user != "null") {

			// Get User Permissions
			$query = $this->pushQuery("permissions", "users_roles", "user_guid='{$access_user}'");		

			if ($query != false) {
				$message = json_decode($query[0]->permissions);
			} else {
				$message = "no-user";
			}
		} else {

			$query = $accessObject->getPermissions($access_level);
			if ($query != false) {
				$message = json_decode($query[0]->access_level_permissions);
			} else {
				$message = "no-permission";
			}
		}

		return $message;
	}

	/**
	 * Save the user access level permissions
	 * 
	 * @param stdClass $params
	 * 
	 * @return Array|String
	 */
	public function savePermissions(stdClass $params) {
		
		// global variables
		global $accessObject;

		if(!is_array($params->access_permissions)) {
			return "Sorry! The permissions must be an array";
		}

		// Prepare Settings
		$aclPermissions = [];

		foreach($params->access_permissions as $eachItem) {
			$expl = explode(",", $eachItem);

			$aclPermissions[$expl[0]][$expl[1]] =  xss_clean($expl[2]);

		}

		// push the permissions into an array set
		$permissions = json_encode(["permissions" => $aclPermissions]);

		// if the user id is not empty
		if ($params->user_guid != "" && $params->user_guid != "null") {

			// Update Settings For User
			$checkData = $this->pushQuery("COUNT(*) AS userTotal", "users", "user_guid='{$params->user_guid}' && status = '1'");

			if ($checkData != false && $checkData[0]->userTotal == '1') {

				$query = $accessObject->assignUserRole($params->user_guid, $params->access_level, $permissions);

				if ($query == true) {
					return "Access Level Updated Successfully!";
				} else {
					return "error";
				}

			} else {
				return "error";
			}

		} else {
			// Update Settings For Access Level Group
			$checkData = $this->pushQuery("COUNT(*) AS aclTotal", "access_levels", "id='{$params->access_level}'");

			if ($checkData != false && $checkData[0]->aclTotal == '1') {

				$stmt = $this->booking->prepare(
					"UPDATE access_levels SET access_level_permissions = '{$permissions}' WHERE id = '{$params->access_level}'"
				);

				if ($stmt->execute()) {
					return "Access Level Updated Successfully";
				} else {
					return "error";
				}

			} else {
				return "no-permission";
			}
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
    public function history(stdClass $params) {
        try {
            
			$stmt = $this->db->prepare("SELECT `page`, `date_recorded`, `description`, `user_agent` FROM users_activity_logs WHERE client_guid = ? AND user_guid = ? ORDER BY id DESC LIMIT {$params->limit}");
            $stmt->execute([$params->clientId, $params->user_id]);

			$i = 0;
			$results = [];
            while($result = $stmt->fetch(PDO::FETCH_OBJ)) {
				
				$i++;
				$result->page = ucfirst($result->page);
				$result->row_id = $i;
				$results[] = $result;
			}

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
	public function theme(array $data) {

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
	 * Return the list of access level permissions for this id
	 * 
	 * @param Int $params->level_id			 	The level id
	 * @param String $params->user_guid			The id of the user
	 * 
	 * @return String
	 */
	public function access_levels_list($params) {

		try {

			$stmt = $this->db->prepare("SELECT access_level_permissions, access_level_name FROM users_access_levels WHERE id=?");
			$stmt->execute([$params->level_id]);
			$result = $stmt->fetch(PDO::FETCH_OBJ);

			// if the access level exists
			if ($stmt->rowCount()) {

				// convert to an array
				$item = json_decode($result->access_level_permissions, true);

				// check if the user guid parameter was parsed
				if(isset($params->user_guid)) {
					// load the user current roles
					$thisUser = $this->get_user_basic($params->user_guid, $params->clientId);
					$thisUserAccess = json_decode($thisUser->permissions, true)["permissions"];
				}

				// get the first key
				$item = $item["permissions"];
				
				$level_data = "<div class='row'>";
				// loop through the list
				foreach ($item as $key => $value) {
					$header = ucwords(str_replace("_", " ", $key));
					$level_data .= "<div class='".(isset($thisUserAccess) ? "col-lg-4 col-md-4" : "col-lg-12")." mb-2 border-bottom border-default'><h6 style='font-weight:bolder'>".$header."</h6>";
					
					if(!isset($thisUserAccess)) {
						$level_data .= "<div class='row'>";
					}
					
					foreach($value as $nkey => $nvalue) {						
						
						// if the user access was parsed
						if(isset($thisUserAccess)) {
							$level_data .= "<div class='col-lg-12'>";
							$level_data .= "<input ".(isset($thisUserAccess[$key][$nkey]) && ($thisUserAccess[$key][$nkey] == 1) ? "checked" : null )." type='checkbox' id='access_level[$key][$nkey]' class='custom-checkbox' name='access_level[$key][$nkey][]'>";
						} else {
							$level_data .= "<div class='col-lg-6'>";
							$level_data .= "<input checked='checked' type='checkbox' id='access_level[$key][$nkey]' class='custom-checkbox' name='access_level[$key][$nkey][]'>";
						}
						$level_data .= "<label class='cursor' for='access_level[$key][$nkey]'>".ucfirst($nkey)."</label>";
						$level_data .= "</div>";
						
					}

					if(!isset($thisUserAccess)) {
						$level_data .= "</div>";
					}
					$level_data .= "</div>";
				}
				$level_data .= "</div>";

				return ["msg" => $level_data];
			}
		} catch(PDOException $e) {
			return false;
		}
		
	}

	/**
	 * Confirm if the record is already existing
	 * 
	 * @return Bool
	 */
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

	/**
	 * Generate a new user id
	 * 
	 * @return String
	 */
	public function generate_user_id(){
		$userId = $this->user_id_prefix.random_string('nozero', 12);
		return !$this->data_unique("users", "user_guid", $userId) ? $this->generate_user_id() : $userId;
	}

	/**
	 * Generate a new verification code
	 * 
	 * @return String
	 */
	private function generate_verification_code(){
		return random_string('alnum', mt_rand(55, 75));
	}

	/**
	 * Generate a new SMS verification code
	 * 
	 * @return String
	 */
	private function generate_sms_code(){
		$code = random_string('numeric', 6);
		return !$this->data_unique("users", "verification_sms_code", $code) ? $this->generate_sms_code() : $code;
	}

	/**
	 * Confirm if the record is unique
	 * 
	 * @return Bool
	 */
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

	/**
	 * Display if the user has not yet activated the account
	 * 
	 * @return String
	 */
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