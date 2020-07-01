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
		return ($this->session->evcrmLoggedIn && $this->session->userId) ? true : false;
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
	 * This method lists all users
	 * 
	 * @param stdClass	$params		This is an object of all the parameters to use for the query
	 */
	public function listUsers(stdClass $params) {

		global $accessObject;

		$condition = "";
		$result = [];

		$condition = !empty($params->user_guid) ? "AND user_guid='{$params->user_guid}'" : null;

		$query = $this->booking->prepare("
			SELECT a.*, b.access_level_name
				FROM users a 
			LEFT JOIN users_access_levels b
				ON a.access_level = b.id
				WHERE a.client_guid = ? && a.deleted = ? {$condition}
			LIMIT {$params->limit}
		");

		if ($query->execute([$params->clientId, 0])) {
			$i = 0;

			while ($data = $query->fetch(PDO::FETCH_OBJ)) {
				$i++;

				$date = date('jS F, Y', strtotime($data->created_on));

				$action = '<div width="100%" align="center">';

				if($accessObject->hasAccess('update', 'users')) {
					if(in_array($data->access_level, [1, 2]) && (in_array($this->session->accessLevel, [1, 2]))) {
							$action .= "<button title=\"Edit the details of {$data->name}\" class=\"btn btn-sm btn-outline-success edit-user\" data-user-id=\"{$data->user_guid}\">
							<i class=\"fa fa-edit\"></i>
						</button> ";
					} elseif(!in_array($data->access_level, [1, 2])) {
						$action .= "<button title=\"Edit the details of {$data->name}\" class=\"btn btn-sm btn-outline-success edit-user\" data-user-id=\"{$data->user_guid}\">
							<i class=\"fa fa-edit\"></i>
						</button> ";
					}
				}

				if($accessObject->hasAccess('accesslevel', 'users')) {
					$action .= "<button title=\"Manage access permissions of {$data->name}\" class=\"btn btn-sm btn-outline-primary edit-access-level\" data-user-id=\"{$data->user_guid}\">
							<i class=\"fa fa-sitemap\"></i>
						</button> ";
				}

				if($accessObject->hasAccess('delete', 'users')) {
					if(in_array($data->access_level, [1, 2]) && (in_array($this->session->accessLevel, [1, 2]))) {
						$action .= "<button title=\"Delete the record of {$data->name}\" class=\"btn btn-sm btn-outline-danger delete-item\" data-url=\"{$this->baseUrl}api/remove\" data-item=\"user\" data-item-id=\"{$data->user_id}\" data-msg=\"Are you sure you want to delete the user {$data->name}?\">
							<i class=\"fa fa-trash\"></i>
						</button> ";
					} elseif(!in_array($data->access_level, [1, 2])) {
						$action .= "<button title=\"Delete the record of {$data->name}\" class=\"btn btn-sm btn-outline-danger delete-item\" data-url=\"{$this->baseUrl}api/remove\" data-item=\"user\" data-item-id=\"{$data->user_id}\" data-msg=\"Are you sure you want to delete the user {$data->name}?\">
							<i class=\"fa fa-trash\"></i>
						</button> ";
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
	 * @param stdClass $userData
	 * 
	 * @return String
	 */
	public function addUserProfile(stdClass $userData) {
		// global variable
		global $accessObject;

		// load the user session key to be used for all the queries
		$accountInfo = $this->clientData;
		$cSubscribe = json_decode( $accountInfo->setup_info, true );

		// sanitize the user email address
		$userData->email = (!empty($userData->email)) ? filter_var($userData->email, FILTER_SANITIZE_EMAIL) : null;
		
		// confirm valid contact number
		if(!preg_match("/^[0-9+]+$/", $userData->phone)) {
			return "invalid-phone";
		}

		// confirm valid email address
		if(!filter_var($userData->email, FILTER_VALIDATE_EMAIL)) {
			return "invalid-email";
		}

		try {

			// begin transaction
			$this->booking->beginTransaction();

			// Check Email Exists
			$checkData = $this->getAllRows("users", "COUNT(*) AS proceed", "email='{$userData->email}' && status = '1'");

			if ($checkData != false && $checkData[0]->proceed == '0') {

				// Add Record To Database
				$getUserId   = random_string('alnum', mt_rand(20, 30));
				$getPassword = random_string('alnum', mt_rand(8, 10));
				$hashPassword= password_hash($getPassword, PASSWORD_DEFAULT);
				$username = explode("@", $userData->email)[0];

				$userData->verifyToken = random_string('alnum', mt_rand(50, 80));

				$query = $this->addData(
					"users" ,
					"clientId='{$userData->clientId}', user_id='{$getUserId}', name='{$userData->fullname}', 
					gender='{$userData->gender}', email='{$userData->email}', phone='{$userData->phone}', 
					verify_token='{$userData->verifyToken}', status='0', access_level='{$userData->access_level}', 
					branchId='{$userData->branch_id}', password='{$hashPassword}', login='{$username}'"
				);

				if ($query == true) {

					// Record user activity
					$this->userLogs('users', $getUserId, 'Added a new user.');
					
					// Assign Roles To User
					$accessObject->assignUserRole($getUserId, $userData->access_level);
					
					// form the email message
					$emailSubject = "Account Setup \[".config_item('site_name')."\]<br>";
					$emailMessage = "Hello {$userData->fullname},<br>";
					$emailMessage .= "You have been added as a user on <strong>{$accountInfo->client_name}</strong> to help manage the Account.<br><br>";
					$emailMessage .= "Username: <strong>{$userData->email}</strong><br>";
					$emailMessage .= "Password: <strong>{$getPassword}</strong><br>";
					
					// create the verification link
					$emailMessage .= "Please <a href='".$this->config->base_url('verify/account?token='.$userData->verifyToken)."'><strong>Click Here</strong></a> to verify your Email Address.\n\n";

					// set the email address
					$userEmail = [
						"recipients_list" => [
							[
								"fullname" => $userData->fullname,
								"email" => $userData->email,
								"customer_id" => $userData->userId
							]
						]
					];
					
					// increment the number of brands created for the account subscription
					$cSubscribe['users_created'] = (!isset($cSubscribe['users_created'])) ? 1 : ($cSubscribe['users_created']+1);

					// update the client brands subscription count
					$this->booking->query("UPDATE settings SET setup_info='".json_encode($cSubscribe)."' WHERE clientId='{$userData->clientId}'");

					// set the new value for the subscription stored in session
					$this->session->accountPackage = $cSubscribe;

					// record the email sending to be processed by the cron job
					$sms = $this->booking->prepare("
						INSERT INTO email_list SET clientId = ?, template_type = ?, itemId = ?, recipients_list = ?, request_performed_by = ?, message = ?, subject = ?
					");
					$sms->execute([
						$userData->clientId, 'general', $userData->userId, json_encode($userEmail), $userData->curUserId, $emailMessage, $emailSubject
					]);

					$this->booking->commit();

					return "account-created";
				
				} else {
					return "Sorry! User Records Failed To Save.";
				}
			} else {
				return "Sorry! Email Already Belongs To Another User.";
			}
		} catch(PDOException $e) {
			$this->booking->rollBack();
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
		if(!preg_match("/^[0-9+]+$/", $userData->phone)) {
			return "invalid-phone";
		}

		// confirm valid email address
		if(!filter_var($userData->email, FILTER_VALIDATE_EMAIL)) {
			return "invalid-email";
		}

		// CHeck If User ID Exists
		$checkData = $this->getAllRows("users", "COUNT(*) AS userTotal, access_level", "user_id='{$userData->user_id}'");

		if ($checkData != false && $checkData[0]->userTotal == '1') {

			// update user data
			$query = $this->updateData(
				"users",
				"name='{$userData->fullname}', gender='{$userData->gender}', email='{$userData->email}', phone='{$userData->phone}', access_level='{$userData->access_level}', branchId='{$userData->branch_id}'",
				"user_id='{$userData->user_id}' && clientId='{$userData->clientId}'"
			);

			if ($query == true) {

				// Record user activity
				$this->userLogs('users', $userData->user_id, 'Update the user details.');

				// check if the user has the right permissions to perform this action
				if($accessObject->hasAccess('accesslevel', 'users')) {

					// Check If User ID Exists
					$userRole = $this->getAllRows("users_roles", "COUNT(*) AS userTotal, permissions", "user_id='{$userData->user_id}'");

					// confirm if the user has no credentials
					if($userRole[0]->userTotal == 0) {
						// insert the permissions to this user
						$getPermissions = $accessObject->getPermissions($userData->access_level)[0]->default_permissions;
						// assign these permissions to the user
						$accessObject->assignUserRole($userData->user_id, $userData->access_level);
					}

					// Check Access Level
					if ($userData->access_level != $checkData[0]->access_level) {

						$getPermissions = $accessObject->getPermissions($userData->access_level)[0]->default_permissions;

						$accessObject->assignUserRole($userData->user_id, $userData->access_level, $getPermissions);
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
	 * Load the user permissions
	 * 
	 * @return Array
	 */
	public function loadPermissions(stdClass $params) {
		// global variable
		global $accessObject;

		// load the user permission and parse back the array data
		$access_level = (isset($params->access_level)) ? xss_clean($params->access_level) : null;
		$access_user  = (isset($params->user_id)) ? xss_clean($params->user_id) : null;

		// Check If User Is Selected
		if (!empty($access_user) && $access_user != "null") {

			// Get User Permissions
			$query = $this->getAllRows("users_roles", "permissions", "user_id='{$access_user}'");

			

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
		if ($params->user_id != "" && $params->user_id != "null") {

			// Update Settings For User
			$checkData = $this->getAllRows("users", "COUNT(*) AS userTotal", "user_id='{$params->user_id}' && status = '1'");

			if ($checkData != false && $checkData[0]->userTotal == '1') {

				$query = $accessObject->assignUserRole($params->user_id, $params->access_level, $permissions);

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
			$checkData = $this->getAllRows("access_levels", "COUNT(*) AS aclTotal", "id='{$params->access_level}'");

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