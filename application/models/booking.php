<?php
/*
App Name: Booking Api
App URI: https://www.myschoollearner.com/
Version: 1.0.1
Author: Emmanuel Obeng, Emmallen Networks Ltd.
Author URI: https://www.github.com/emmallob
*/
// ensure this file is being included by a parent file
if( !defined( 'SITE_URL' ) ) die( 'Restricted access' );

class Booking {

	/* A globl variable to set for the table to query */
	public $tableName;

	/* The edit url variable that will be used in the loadDetails class */
	public $editURL;
	public $permitPage;

	/* This is the global value for the browser and platform to use by all methods */
	public $browser;
	public $platform;
	public $baseUrl;
	public $client_guid;
	public $user_guid;
	public $clientData;

	public function __construct() {
		global $booking, $session, $config;

		$this->db = $booking;
		$this->booking = $booking;
		$this->config = $config;
		$this->baseUrl = $config->base_url();
		$this->session = $session;
		$this->client_guid = $this->session->client_guid;
		$this->ip_address = ip_address();
		$this->baseUrl = $this->config->base_url();

		$this->user_agent = load_class('user_agent', 'libraries');
		$this->platform = $this->user_agent->platform();
		$this->browser = $this->user_agent->browser();
		$this->clientData = $this->clientData($this->client_guid);
	}

	public function clientData($client_guid = null) {
		try {

			$client_guid = (!empty($client_guid)) ? $client_guid : $this->session->client_guid;

			$stmt = $this->db->prepare(
				"SELECT a.*, b.country_name
				FROM users_accounts a
				LEFT JOIN country b ON b.id = a.id WHERE a.client_guid='{$client_guid}'
			");
			$stmt->execute();

			$result = $stmt->fetch(PDO::FETCH_OBJ);

			$clientData = !empty($result) ? $result : null;

			return $clientData;
		} catch(PDOException $e) {
			return $e->getMessage();
		}
	}

	/**
	 * @method recordDetails($recordId, $whereClause)
	 * @desc This call returns the details of a single / multiple records in the database that meets the filter
	 * @return array
	 *
	 **/
	public function recordDetails($recordId=null, $columnNames = 'mn.*', $whereClause = 1, $joinClause = null) {

		global $config;

		try {

			// call the access level object
			$accessObject = load_class('accesslevel', 'controllers');
			$accessObject->user_guid = $this->user_guid;


			$filter = (!empty($recordId)) ? "mn.unique_id = '{$recordId}'" : null;
			$clientLimit = ($this->tableName == "countries") ? null : "mn.client_guid = '{$this->client_guid}' AND ";

			$stmt = $this->db->prepare("
				SELECT {$columnNames} FROM {$this->tableName} mn $joinClause WHERE $clientLimit {$filter} {$whereClause}
			");
			$stmt->execute();

			$results = [];
			$row = 0;

			if($stmt->rowCount() > 0) {
				while($result = $stmt->fetch(PDO::FETCH_OBJ)) {

					$row++;

					$result->editButton = '';
					$result->deleteButton = '';

					/* If the result set contains a unique_id then set the action, delete and edit buttons */
					if(isset($result->unique_id) && !empty($this->editURL)) {

						// confirm if the user has the permission to edit this item
						if($accessObject->hasAccess('view', $this->permitPage)) {
							$result->editButton = "-";
						}

						if($accessObject->hasAccess('update', $this->permitPage)) {
							$result->editButton = "<a class=\"btn btn-outline-success\" href=\"".$config->base_url("{$this->editURL}/{$result->unique_id}")."\"><i class=\"fa fa-edit\"></i></a>";
						}

						// confirm if the user has the permission to delete this item
						if($accessObject->hasAccess('delete', $this->permitPage)) {
							$result->deleteButton = " <a data-content=\"{$this->permitPage}\" data-value=\"{$result->unique_id}\" data-msg=\"Are you sure you want to delete this ".substr((ucfirst($this->permitPage)), 0, -1)."?\" class=\"btn btn-outline-danger delete-button\" href=\"javascript:void(0)\"><i class=\"fa fa-trash\"></i></a>";
						}

						$result->actionButton = $result->editButton . $result->deleteButton;
					}
					
					/* Set the row id for the result set that has been retrieved from the database */
					$result->row = $row;

					$results[] = $result;
				}
			}

			return $results;

		} catch(PDOException $e) {
			return [];
		}
	}

	/**
	 * @method lastRowId()
	 * @param $tableName The user needs to specify the table name for the query
	 * @return $rowId
	 **/
	public function lastRowId($tableName) {

		$stmt = $this->db->prepare("
				SELECT id AS rowId FROM {$tableName} WHERE client_guid = ? ORDER BY id DESC LIMIT 1
		");
		$stmt->execute([$this->client_guid]);

		return $stmt->fetch(PDO::FETCH_OBJ)->rowId;
	}

	/**
	 * @method itemsCount($whereClause)
	 * @desc This method counts the number of rows found
	 * @return int
	 *
	 **/
	public function itemsCount($tableName, $whereClause = 1) {
		
		try {

			$stmt = $this->db->prepare("
				SELECT * FROM {$tableName} WHERE $whereClause AND client_guid = ?
			");
			$stmt->execute([$this->client_guid]);

			return $stmt->rowCount();

		} catch(PDOException $e) {
			return false;
		}

	}

	/**
	 * @method pushQuery($columns, $table, $whereClause)
	 * @desc Receives user query and returns the full data array
	 * 
	 * @return Object
	 **/
	public function pushQuery($columns = "*", $tableName, $whereClause = null) {

		try {
			
			$stmt = $this->db->prepare("SELECT {$columns} FROM {$tableName} WHERE $whereClause");
			$stmt->execute();

			return $stmt->fetchAll(PDO::FETCH_OBJ);

		} catch(PDOException $e) {
			return [];
		}

	}

	public function justExecute($queryString) {
		try {

			$stmt = $this->db->prepare("$queryString");
			return $stmt->execute();

		} catch(PDOException $e) {
			return [];
		}
	}

	/**
	 * @method userLogs
	 * @param $page 	This is the page that the user is managing
	 * @param $item_guid	This relates to the item that is being managed
	 * @param $description This is the full description of what is being done
	 * @return null
	 *
	 **/
	final function userLogs($page, $item_guid, $description, $user_guid = null, $client_guid = null) {
		
		try {

			$ur_agent = $this->platform .' | '.$this->browser . ' | '.ip_address();

			$stmt = $this->db->prepare("
				INSERT INTO 
					users_activity_logs 
				SET 
					user_guid = ?, page = ?, item_guid = ?, description = ?, user_agent = ?, client_guid = ?
			");
			return $stmt->execute([($user_guid ?? $this->user_guid), $page, $item_guid, $description, $ur_agent, ($client_guid ?? $this->client_guid)]);

		} catch(PDOException $e) {
			return false;
		}

	}

	/**
	 * @method dataMonitoring
	 * @param string $data_type	This is the data that the user is updating (employee, leave)
	 * @param string $unique_id	This is the unique id that defines a recordset
	 * @param json $data_set 	This is a json encoded data of the initial record before update
	 * @return bool
	 **/
	final function dataMonitoring($data_type, $uniqueId, $data_set) : bool {

		try {

			$ur_agent = $this->platform .' | '.$this->browser . ' | '.ip_address();

			$stmt = $this->db->prepare("
				INSERT INTO 
					users_data_monitoring 
				SET 
					data_type = ?, unique_id = ?, data_set = ?, 
					user_guid = ?, user_agent = ?, client_guid = ?
			");
			return $stmt->execute([
				$data_type, $uniqueId, $data_set, 
				$this->user_guid, $ur_agent, $this->client_guid
			]);

		} catch(PDOException $e) {
			return false;
		}

	}

	/**
	 * @method percentageCalculator
	 * @param totalAmount	This is the Amount that the percentage is to be calculated on
	 * @param percentageValue	This is the percentage value that is to be used for the calculation
	 * @return number_format of the value result
	 **/
	public function percentageCalculator($totalAmount, $percentageValue) {

		return number_format(
			(
				($percentageValue / 100 ) * $totalAmount), 2
			);

	}

	/**
	 * @method dateFormater
	 * @param string $dateParam
	 * @return date
	 **/
	public function dateFormater(array $dateParam) {
		$dateParam = (object)$dateParam;
		$date = ($dateParam->date) ?? date("Y-m-d");
		$period = ($dateParam->period) ?? "+1 days";
		$format = ($dateParam->format) ?? "Y-m-d";

		return date("$format", strtotime($date . " $period "));
	}

	/**
	 * @method sendEmail
	 * @param $fullname	- This is the fullname of the recipient
	 * @param $subject - This will contain the subject of the mail
	 * @param $sent_to - This is the email address of the recipient
	 * @param $copy_to - This will contain the list of users to copy the message to
	 * @param $sent_from - This is the email from which the mail will be sent 
	 * @param $message - This will contain the actual content of the email
	 * @return bool
	 **/
	final function sendEmail($unique_id, $template = 'default', $fullname = null, $subject, $sent_to, $message, $copy_to = null) : bool {

		$stmt = $this->db->prepare("
			INSERT INTO emails SET unique_id = ?, template=?, subject = ?, fullname = ?, sent_to = ?, message = ?, copy_to = ?, client_guid = ?
		");
		return $stmt->execute([$unique_id, $template, $subject, $fullname, $sent_to, $message, $copy_to, $this->client_guid]);
	}

	/**
	 * @method allowedTime
	 * @desc Check if the User is within the time frame for logging an attendance
	 * @return bool
	 */
	final function allowedTime($openingHour = "5:00", $closinghour = "23:59") {
		
	    $currentTime = DateTime::createFromFormat('H:i', date("H:i"));
		$fromTime = DateTime::createFromFormat('H:i', $openingHour);
		$endTime = DateTime::createFromFormat('H:i', $closinghour);

		if ($currentTime > $fromTime && $currentTime < $endTime) {
			return true;
		} else {
			return false;
		}

	}

	/**
	 * @method listDays
	 * @desc It lists dates between two specified dates
	 * @param string $startDate 	This is the date to begin query from
	 * @param string $endDate	This is the date to end the request query
	 * @param string $format 	This is the format that will be applied to the date to be returned
	 * @return array
	 **/
	public function listDays($startDate, $endDate, $format='Y-m-d', $weekends = false) {

		$period = new DatePeriod(
		  new DateTime($startDate),
		  new DateInterval('P1D'),
		  new DateTime(date('Y-m-d',strtotime($endDate. '+1 days')))
		);

		$days = array();
		$sCheck = (array) $period->start;

		// check the date parsed
		if(date("Y-m-d", strtotime($sCheck['date'])) == "1970-01-01") {
			
			// set a new start date and call the function again
			return $this->listDays(date("Y-m-d", strtotime("first day of this month")), date("Y-m-d", strtotime("yesterday")));

			// exit the query
			exit;
		}
		
		// fetch the days to display
		foreach ($period as $key => $value) {

			if(!$weekends && (!in_array(date("l", strtotime($value->format($format))), ['Saturday', 'Sunday']))) {
				$days[] = $value->format($format);
			}

		}
		
		return $days;
	}

	/**
	 * @method stringToArray
	 * 
	 * @desc Converts a string to an array
	 * @param $string The string that will be converted to the array
	 * @param $delimeter The character for the separation
	 * 
	 * @return Array
	 */
	final function stringToArray($string, $delimiter = ",") {
		if(is_array($string)) {
			return $string;
		}

		$array = [];
		$expl = explode($delimiter, $string);
		foreach($expl as $each) {
			if(!empty($each)) {
				$array[] = trim($each);
			}
		}
		return $array;
	}

	public function attachmentsTotalSize() {

		//: Process the email attachments
		if(!empty($this->session->reportsAttachment) && is_array($this->session->reportsAttachment)) {
			
			// calculate the file size
			$totalFileSize = 0;
			
			// using foreach loop to get the list of attached documents
			foreach($this->session->reportsAttachment as $key => $values) {
				
				//: get the file size
				$n_FileSize = file_size_convert("assets/attachments/tmp/{$values['item_id']}");
				$n_FileSize_KB = file_size("assets/attachments/tmp/{$values['item_id']}");
				$totalFileSize += $n_FileSize_KB;
			}

			return round(($totalFileSize / 1024), 2);
		}

	}

	/**
	 * @method cleanLimit
	 * @desc This method takes the limit clause parsed in the query and formats it correctly
	 * @param string $limit 	This is the limit string that has been parsed
	 * @return string
	 **/
	final function cleanLimit($limit) {

		// process the string
		$limit = explode(',', $limit);
		$fPart = (isset($limit[0]) && ($limit[0] > -1)) ? (int) $limit[0] : 0;
		$lPart = (isset($limit[1]) && ($limit[1] > -1)) ? (int) $limit[1] : 25;

		$lPart = ($lPart != 0) ? $lPart : 25;

		$fPart = ($fPart > 100) ? 100 : $fPart;
		$lPart = ($lPart > 100) ? 100 : $lPart;

		return (!isset($limit[1])) ? $fPart : "$fPart,$lPart";
	}

	/**
	 * Verify if a string parsed is a valid date
	 * @param string $date 		This is the date string that has been parsed by the user
	 * @param string $format 	This is the format for that date to use
	 * @return bool
	 */
	public function validDate($date, $format = 'Y-m-d') {
	    $d = DateTime::createFromFormat($format, $date);
	    return $d && $d->format($format) === $date;
	}

	/**
	 * This method prepares a string to be used in a query
	 * This will format the user parameters to for a valid IN query
	 * 
	 * @param String $params 	This is the string that the user has parsed
	 * @param Array $compare 	This is the string to test the user's own against
	 * @param String $colum 	This is the column name
	 * 
	 * @return String
	 */
	public function formatInQuery($param, array $compare, $column) {

		$params = (is_array($param)) ? $param : $this->stringToArray($param);

		if(count($params) > count($compare)) {
			return;
		}

		$string = '(';
		foreach($params as $item) {
			if(!in_array($item, $compare)) {
				return null;
				break;
			}

			$string .= "'{$item}',";
		}
		$string = substr($string, 0, -1);
		$string .= ')';

		return " AND $column IN $string"; 
	}

	/**
	 * @method cleanDateRange
	 * @desc This method prepares and submits a clean date for processing
	 * @param string $date This is the date range that has been parsed
	 * @param string $prefix This is the SQL Query placeholder
	 **/
	final function cleanDateRange($date, $prefix) {

		// process the string
		$date = explode(':', $date);
		$fPart = (isset($date[0]) && $this->validDate($date[0])) ? $date[0] : '2020-05-01';
		$lPart = (isset($date[1]) && $this->validDate($date[1])) ? $date[1] : date('Y-m-d');

		if(!empty($date[1])) {
			return " AND (DATE($prefix.created_date) >= '{$fPart}' AND DATE($prefix.created_date) <= '{$lPart}')";
		} else {
			return " AND (DATE($prefix.created_date) = '{$fPart}')";
		}
	}

	/**
	 * This logs the user activity for trying to perform a suspected activity
	 *
	 * @param string $endpoint 		This is the activity that the user wants to perform
	 * @param string $tableName 	This is the name of the table that the activity was to be carried on
	 * @param array $invalids		The content of the data to be parsed that does not exist
	 * @param array $itemIds		This is the entire ids that have been parsed.
	 * @return bool
	 **/
	final function deleteBreach($endpoint, $tableName, array $invalids = [], array $itemIds = []) {
		
		try {

			// algorithm for severity
			$itemCount = count($itemIds);
			$invalidCount = count($invalids);

			$diff = $itemCount - $invalidCount;

			// find 30 percent of the entire list
			$thirtyPercent = round($itemCount * 0.3);

			// severity range
			if($diff >= $thirtyPercent) {
				$severity = "high";
			} else {
				$severity = "low";
			}

			// insert the record
			$stmt = $this->db->prepare("
				INSERT INTO breach_notifications
				SET request_method = ?, client_guid = ?, table_name = ?, severity = ?, suspected_ids = ?
			");
			return $stmt->execute([
				$endpoint, $this->client_guid, $tableName, $severity, json_encode($invalids)
			]);

		} catch(PDOException $e) {
			return false;
		}

	}

	/**
	 * Delete an item from the system. 
	 *
	 * @param String $itemId 	This is the item id that was parsed
	 * @param String $tableName This is the name of the table to effect the change on
	 * @param Array $itemIds	This is the array to filter
	 * 
	 * @return Bool
	 **/
	public function deleteItem($itemId, $tableName) {

		// convert the user string to an array
		$itemIds = $this->stringToArray($itemId, ',');

		$queryData = '';
		$error = false;
		$invalids = [];

		// loop through the array
		foreach($itemIds as $eachItem) {

			// confirm that the item already exists
			$prevData = $this->pushQuery("id, guid", $tableName, "guid='{$eachItem}' AND client_guid='{$this->client_guid}' AND status='1'");

			// confirm that the request returned some dataset
			if(!empty($prevData)) {

				// update the row information
				$queryData .= "UPDATE $tableName SET status = '0' WHERE guid = '{$eachItem}' AND client_guid = '{$this->client_guid}';";

			} else {
				$error = true;
				$invalids[] = $eachItem;
			}

		}

		// if at least one id parsed is invalid
		if($error) {
			// notify the admins of a possible breach of data
			$this->deleteBreach('delete', $tableName, $invalids, $itemIds);

			// return the invalid ids
			return $invalids;
		} else {
			$request = (!empty($queryData)) ? $this->db->query($queryData) : null;

			return !(empty($request)) ? 'successful' : null;
		}

	}

	public function statusChecker($status) {

		$status = strtolower($status);
		if(($status == 'active') || ($status == 1)) {
			return 1;
		} elseif(($status == 'inactive') || ($status == 0)) {
			return 0;
		}
	}

	/**
	 * This returns an array of the page posts
	 * 
	 * @param string $post_type		This is the type of the pages that is to be fetched
	 * @param string $status 		This is the status of the post page (Default is Published)
	 * @param int $limit			The number to limit the query
	 * @param string $where_clause	This is an optional where clause to append to the query
	 * 
	 * @return array objects
	 */
	public function page_posts(string $post_type, string $status = 'Published', $where_clause = null, int $limit = 10, $order_by = "ORDER BY id DESC") {
		try {
			$posts = $this->db->prepare("
				SELECT * 
				FROM posts 
				WHERE post_type='{$post_type}' 
				AND post_status='{$status}' {$where_clause} {$order_by} LIMIT {$limit}
			");
			$posts->execute();

			return $posts->fetchAll(PDO::FETCH_OBJ);

		} catch(PDOException $e) {
			return $e->getMessage();
		}
	}

	/**
	 * This returns an array of a single page post using the id or slug
	 * 
	 * @param string $postId	This is the page post or slug that is to be fetched
	 * @param stirng $status 	This is the status of the page to be parsed
	 * @return array object
	 */
	public function get_post($postId, $status = 'Published', $parentslug = null) {

		$field = (preg_match('/^[0-9]+$/', $postId)) ? "a.id" : "a.post_slug";
		try {
			$posts = $this->db->prepare("
				SELECT a.*,
					b.post_title AS parent_title,
					b.post_slug AS parent_slug
				FROM posts a
				LEFT JOIN posts b ON b.id = a.parent_page
				WHERE {$field}='{$postId}' AND a.post_status='{$status}'
			");
			$posts->execute();

			return $posts->fetch(PDO::FETCH_OBJ);

		} catch(PDOException $e) {
			return $e->getMessage();
		}
	}

	/**
	 * This formats the post media properly
	 * 
	 * @param array $media 	This is the array of the media string
	 * @param int $quantity	This is the number of items to return
	 * @param string $type This is the type of data to return
	 * 
	 * @return $postImage
	 */
	public function postImage(array $media, $quantity = null, $type = 'all') {

		$i = 0;
		$limit = empty($quantity) ? 10000: (int) $quantity;
		$mediaData = [];

		foreach($media as $eachItem) {

			if(($type != 'all') && ($eachItem['type'] == $type)) {
				$mediaData[] = $eachItem['url'];
			} else {
				$mediaData[] = $eachItem;
			}
			
			$i++;
			if($i == $limit) {
				break;
			}
		}
		
		return $mediaData;
	}	

	/**
	 * Compare array and remove item from the list
	 * 
	 * @param String $arrayList		The list to loop through
	 * @param String $item			The value to find in the array list
	 * @param String $delimeter		The delimiter to use for converting the string to array
	 * 
	 * @return Array
	 */
	public function removeArrayValue($arrayList, $item, $delimeter = ",") {

		$arrayVariables = !is_array($arrayList) ? $this->stringToArray($arrayList, $delimeter) : $arrayList;
		$arrayKey = array_search($item, $arrayVariables);

		/** Remove the value from the array list */
		if(!empty($arrayKey)) {
			unset($arrayVariables[$arrayKey]);
		}

		return $arrayVariables;
	}

	/**
	 * Remove a record from the database table
	 * 
	 * @param stdClass 	$params				This object contains the item and its id to delete
	 * 					$params->item 		This refers to either a brand or user or any other item to remove
	 * 					$params->item_id	This is the unique id of the item to remove
	 * 					$params->client_guid	This is the unique id for the user account
	 * 
	 * @return String | Bool
	 */
	public function removeRecord(stdClass $params) {
		/** Process the request */
		if(empty($params->item) || empty($params->item_id) || empty($params->clientId)) {
			return "denied";
		}

		/** Get the client data */
		$clientData = $this->clientData($params->clientId);

		try {
			/** Begin the transaction */
			$this->db->beginTransaction();
			
			/** remove a hall */
			if($params->item == "hall") {
				
				/** Confirm that user is not already deleted */
				$userActive = $this->db->prepare("SELECT id FROM halls WHERE hall_guid = ? AND deleted=? AND client_guid = ?");
				$userActive->execute([$params->item_id, 0, $params->clientId]);

				/** Count the number of rows */
				if($userActive->rowCount() != 1) {
					return "denied";
				} else {
					/** Remove the user from the list of users by setting it as been deleted */
					$stmt = $this->db->prepare("UPDATE halls SET deleted=? WHERE hall_guid = ? AND client_guid = ?");
					$stmt->execute([1, $params->item_id, $params->clientId]);

					/** Reduce the number of brands created for this account */
					$cSubscribe = json_decode( $clientData->subscription, true );
					$cSubscribe['halls_created'] = isset($cSubscribe['halls_created']) ? ($cSubscribe['halls_created'] - 1) : 2;

					/** update the client brands setup_info count */
					$this->db->query("UPDATE users_accounts SET subscription='".json_encode($cSubscribe)."' WHERE client_guid='{$params->clientId}'");

					/** Log the user activity */
					$this->userLogs("remove", $params->item_id, "Deleted a hall.", $params->clientId, $params->userId);

					/** Commit the transactions */
					$this->db->commit();
					
					/** Return the success response */
					return "great";
				}
				
			}

			/** remove a department */
			elseif($params->item == "department") {
				
				/** Confirm that department is not already deleted */
				$userActive = $this->db->prepare("SELECT id FROM departments WHERE department_guid = ? AND `status`=? AND client_guid = ?");
				$userActive->execute([$params->item_id, 1, $params->clientId]);

				/** Count the number of rows */
				if($userActive->rowCount() != 1) {
					return "denied";
				} else {
					
					/** Remove the department from the list of departments by setting it as been deleted */
					$stmt = $this->db->prepare("UPDATE departments SET `status`=? WHERE department_guid = ? AND client_guid = ?");
					$stmt->execute([0, $params->item_id, $params->clientId]);

					/** Log the user activity */
					$this->userLogs("remove", $params->item_id, "Deleted a department.", $params->clientId, $params->userId);

					/** Commit the transactions */
					$this->db->commit();
					
					/** Return the success response */
					return "great";
				}
				
			}

			/** remove ticket  */
			elseif($params->item == "ticket") {

				/** Confirm that user is not already deleted */
				$userActive = $this->db->prepare("SELECT id FROM tickets WHERE ticket_guid = ? AND `status`=? AND client_guid = ? AND number_sold = ?");
				$userActive->execute([$params->item_id, 1, $params->clientId, 0]);

				/** Count the number of rows */
				if($userActive->rowCount() != 1) {
					return "denied";
				} else {
					
					/** Remove the ticket from the list of tickets by setting it as been deleted */
					$stmt = $this->db->prepare("UPDATE tickets SET `status`=? WHERE ticket_guid = ? AND client_guid = ?");
					$stmt->execute([0, $params->item_id, $params->clientId]);

					/** Delete the tickets list as well */
					$this->db->query("DELETE FROM tickets_listing WHERE ticket_guid = '{$params->item_id}'");

					/** Log the user activity */
					$this->userLogs("remove", $params->item_id, "Deleted a Ticket that was generated.", $params->clientId, $params->userId);

					/** Commit the transactions */
					$this->db->commit();
					
					/** Return the success response */
					return "great";
				}
			}

		} catch(PDOException $e) {
			$this->db->rollBack();
			return $e->getMessage();
		}
	}

	/**
	 * Quick mode to add data to the database
	 * 
	 * @param String $table				This is the name of the table
	 * @param String $columnValues		This is a composite of the column names and their respective values
	 * 
	 * @return Bool
	 */
	public function addData($table, $columnValues) {
		$stmt = $this->evelyn->prepare("INSERT INTO {$table} SET {$columnValues}");
		return $stmt->execute();
	}

	/**
	 * Quick mode to update data to the database
	 * 
	 * @param String $table				This is the name of the table
	 * @param String $columnValues		This is a composite of the column names and their respective values
	 * 
	 * @return Bool
	 */
	public function updateData($table, $columnValues, $where_clause) {
		$stmt = $this->evelyn->prepare("UPDATE {$table} SET {$columnValues} WHERE {$where_clause}");
		return $stmt->execute();
	}

	/**
	 * Order Id format by adding zeros to the begining
	 * 
	 * @param String $requestId		This is the id to format
	 * 
	 * @return String
	 */
	public function serialIdFormat($requestId, $number = 6) {
		$preOrder = str_pad($requestId, $number, '0', STR_PAD_LEFT);
		return $preOrder;
	}
}
?>