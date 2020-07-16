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
	public function listUsers(stdClass $params) {

		global $accessObject;

		$condition = "";
		$result = [];

		$condition = !empty($params->user_guid) ? "AND a.user_guid='{$params->user_guid}'" : null;

		$query = $this->booking->prepare("
			SELECT a.*, b.access_level_name
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

				if($userAccessLevels) {
					$action .= "<button title=\"Manage access permissions of {$data->name}\" class=\"btn btn-sm btn-outline-primary edit-access-level\" data-user-id=\"{$data->user_guid}\">
							<i class=\"fa fa-sitemap\"></i>
						</button>";
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

				$result[] = [
					'user_id' => $data->user_guid,
					'row_id' => $i,
					'fullname' => $data->name . ((!$data->status) ? "<br><span class='badge badge-danger'>Inactive</span>" : "<br><span class='badge badge-success'>Active</span>"),
					'access_level' => $data->access_level_name,
					'access_level_id' => $data->access_level,
					'gender' => $data->gender,
					'contact' => $data->contact,
					'email' => $data->email,
					'registered_date' => $date,
					'action' => $action,
					'deleted' => 0
				];

			}
		}
		return $result;
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
	 * @return Array Object
	 */
	public function get_user_basic($userId, $clientId){
		
		try {

			$stmt = $this->db->prepare("
				SELECT 
					name, gender, email, username, permissions,
					access_level, access_level_code, access_level_name, 
					theme, contact, last_login, created_on,
					access_level_permissions, image, status
				FROM `users` 
				LEFT JOIN users_access_levels ON `users`.access_level = users_access_levels.access_level_code 
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
	 * @param stdClass $userData
	 * 
	 * @return String
	 */
	public function addUserProfile(stdClass $params) {
		
		// load the user session key to be used for all the queries
		$accountInfo = $this->clientData($params->clientId);
		$cSubscribe = json_decode( $accountInfo->subscription, true );

		// confirm that the user has not reached the subscription ratio
		if($cSubscribe['users_created'] >= $cSubscribe['users']) {
			return "Sorry! Your current subscription will only permit a maximum of {$cSubscribe['users']} users";
		}

		// confirm a valid contact number
		if(!empty($params->contact) && !preg_match("/^[0-9+]+$/", $params->contact)) {
			// return error message
			return "Sorry! Enter a valid contact number.";
		}

		// contact number should be at most 15 characters long
		if(strlen($params->contact) > 15) {
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

			// insert the user account the user profile information
			$stmt = $this->db->prepare("
				INSERT INTO `users` SET
				name = ?, email = ?, contact = ?, client_guid=?, created_on = now(), 
				created_by = ?, verify_token = ?, username = ?".
				(empty($params->image) ? '' : ", image = '{$params->image}'").
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
				INSERT INTO email_list SET client_guid = ?, template_type = ?, itemId = ?, recipients_list = ?, request_performed_by = ?, message = ?, subject = ?
			");
			$sms->execute([
				$params->clientId, 'general', $params->userId, json_encode($userEmail), $params->curUserId, $emailMessage, $emailSubject
			]);
			
			$this->db->commit();

			return "account-created";
			
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
	public function updateUserProfile(stdClass $userData){
		
		// global variables
		global $accessObject;

		// sanitize the user email address
		$userData->email = (!empty($userData->email)) ? filter_var($userData->email, FILTER_SANITIZE_EMAIL) : null;

		// confirm valid contact number
		if(!preg_match("/^[0-9+]+$/", $userData->contact)) {
			return "invalid-phone";
		}

		// confirm valid email address
		if(!filter_var($userData->email, FILTER_VALIDATE_EMAIL)) {
			return "invalid-email";
		}

		// Check If User ID Exists
		$checkData = $this->pushQuery("COUNT(*) AS userTotal, access_level", "users", "user_guid='{$userData->user_guid}'");

		if ($checkData != false && $checkData[0]->userTotal == '1') {

			// update user data
			$query = $this->updateData(
				"users",
				"name='{$userData->fullname}',
				email='{$userData->email}', contact='{$userData->contact}'
				".(isset($userData->access_level) ? ",access_level='{$userData->access_level}'" : null)."	
				",
				"user_guid='{$userData->user_guid}' && client_guid='{$userData->clientId}'"
			);

			if ($query == true) {

				// Record user activity
				$this->userLogs('users', $userData->user_guid, 'Update the user details.', $userData->userId, $userData->clientId);

				/** if the access level id was parsed */
				if(isset($userData->access_level)) {
					// check if the user has the right permissions to perform this action
					if($accessObject->hasAccess('accesslevel', 'users')) {

						// Check If User ID Exists
						$userRole = $this->pushQuery("COUNT(*) AS userTotal, permissions", "users_roles", "user_guid='{$userData->user_guid}'");

						// confirm if the user has no credentials
						if($userRole[0]->userTotal == 0) {
							// insert the permissions to this user
							$getPermissions = $accessObject->getPermissions($userData->access_level)[0]->access_level_permissions;
							// assign these permissions to the user
							$accessObject->assignUserRole($userData->user_guid, $userData->access_level);
						}

						// Check Access Level
						if ($userData->access_level != $checkData[0]->access_level) {

							$getPermissions = $accessObject->getPermissions($userData->access_level)[0]->access_level_permissions;

							$accessObject->assignUserRole($userData->user_guid, $userData->access_level, $getPermissions);
						}
					}
				}

				return "User Details Have Been Successfully Updated.";
			} else {
				return "Sorry! User Records Failed To Update.";
			}
		} else {
			return "invalid";
		}
	}

	/**
	 * Change a users password
	 * Run basic check for a strong password supplied and confirm if they match
	 * 
	 * @param String $password 		The password
	 * @param String $password_2 	The second password to match
	 */
	public function changePassword($params) {

		/** Matching test */
		if($params->password != $params->password_2) {
			return "match-error";
		}

		/** Strength test */
		if(!passwordTest($params->password)) {
			return "strength-error";
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
				return "User password successfully changed";
			} else {
				// the print the alert to logout
				if($params->user_guid == $this->session->userId) {
					// destroy the session
					$this->session->destroy();

					// return the success message
					return "Your password successfully changed. You have been automatically logged out from the system.";
				} else {
					return "User password was successfully changed";
				}
			}
		} else {
			return "user-error";
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
    public function userActivityLogs(stdClass $params) {
        try {
            
			$stmt = $this->db->prepare("SELECT page, date_recorded, description, user_agent FROM users_activity_logs WHERE client_guid = ? AND user_guid = ? ORDER BY id DESC LIMIT {$params->limit}");
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
						$level_data .= "<input checked='checked' type='checkbox' id='access_level[$key][$nkey]' class='custom-checkbox' name='access_level[$key][$nkey][]'>";
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


	public function remove_user($user_id){
		$stmt = $this->db->prepare("
			UPDATE `users` SET
			status = ? WHERE user_guid = ? LIMIT 1");
		return $stmt->execute([self::REMOVED_USER_STATUS, $user_id]);
	}

	public function generate_user_id(){
		$userId = $this->user_id_prefix.random_string('nozero', 9);
		return !$this->data_unique("users", "user_guid", $userId) ? $this->generate_user_id() : $userId;
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