<?php 

class Remove extends Booking {

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Remove Results
     * 
     * Confirm if the user has the permission to perform the action before proceeding with it
     * 
     * @param \stdClass $params
     * 
     * @return Array
     */
    public function confirm($params) {

        global $accessObject;
        
        // confirm that the user has the permission to perform the action
        if((!in_array($params->item, ["cancel-event","confirm-booking","remove-booking","event-media", "return-ticket"])) && !$accessObject->hasAccess("delete", "{$params->item}s")) {
            // permission denied message
            return ["code" => 203, "msg" => $this->permission_denied];
        }
        // if the events is to canceled
        elseif(in_array($params->item, ["cancel-event","event-media"]) && !$accessObject->hasAccess("delete", "events")) {
            // permission denied message
            return ["code" => 203, "msg" => $this->permission_denied];
        }
        // return tickets
        elseif(in_array($params->item, ["return-ticket"]) && !$accessObject->hasAccess("return", "tickets")) {
            // permission denied message
            return ["code" => 203, "msg" => $this->permission_denied];
        } else {
            
            // process the user request
            $request = $this->do_delete($params);
            
            // processing the request
            if($request === "denied") {
                return ["code" => 203, "msg" => $this->permission_denied];
            } elseif($request === "great") {
                if($params->item == "cancel-event") {
                    return ["code" => 200, "msg" => "The event was successfully cancelled."];
                } elseif($params->item == "confirm-booking") {
                    return ["code" => 200, "msg" => "The Booking was successfully confirmed."];
                } elseif($params->item == "remove-booking") {
                    return ["code" => 200, "msg" => "The Booked Seat was successfully reversed."];
                } else {
                    return ["code" => 200, "msg" => "The ".ucfirst($params->item)." was successfully deleted"];
                }
            } else {
                return ["code" => 203, "msg" => "Sorry! Your request could not be processed. Please try again later."];
            }
        }
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
    public function do_delete(stdClass $params) {

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
					$stmt = $this->db->prepare("UPDATE `halls` SET `deleted`=? WHERE `hall_guid` = ? AND `client_guid` = ?");
					$stmt->execute([1, $params->item_id, $params->clientId]);

					/** Remove the hall id from the list of all events */
					$events = $this->db->prepare("SELECT `id`, `halls_guid` FROM `events` WHERE `client_guid` = ? AND `state` = ? AND `deleted`=?");
					$events->execute([$params->clientId, "pending", 0]);
					
					// loop through the list of events
					while($event = $events->fetch(PDO::FETCH_OBJ)) {
						
						/** Remove the hall id from the list of halls for this event */
						$halls = $this->removeArrayValue($event->halls_guid, $params->item_id, ",");
						$hallIds = implode(",", $halls);
						
						/** Update the event ids */
						$this->db->query("UPDATE `events` SET `halls_guid`='{$hallIds}' WHERE id='{$event->id}'");
					}

					/** Remove the hall from the list of all events that is currently not in use */
					$this->db->query("DELETE FROM `events_halls_configuration` WHERE hall_guid = '{$params->item_id}' AND `commenced` = '0'");

					/** Reduce the number of brands created for this account */
					$cSubscribe = json_decode( $clientData->subscription, true );
					$cSubscribe['halls_created'] = isset($cSubscribe['halls_created']) ? ($cSubscribe['halls_created'] - 1) : 2;

					/** update the client brands setup_info count */
					$this->db->query("UPDATE `users_accounts` SET `subscription`='".json_encode($cSubscribe)."' WHERE `client_guid`='{$params->clientId}'");

					/** Log the user activity */
					$this->userLogs("remove", $params->item_id, "Deleted a hall.", $params->userId, $params->clientId);

					/** Commit the transactions */
					$this->db->commit();
					
					/** Return the success response */
					return "great";
				}
				
			}

			/** remove a department */
			elseif($params->item == "department") {
				
				/** Confirm that department is not already deleted */
				$userActive = $this->db->prepare("SELECT `id` FROM `departments` WHERE `department_guid` = ? AND `status`=? AND client_guid = ?");
				$userActive->execute([$params->item_id, 1, $params->clientId]);

				/** Count the number of rows */
				if($userActive->rowCount() != 1) {
					return "denied";
				} else {
					
					/** Remove the department from the list of departments by setting it as been deleted */
					$stmt = $this->db->prepare("UPDATE `departments` SET `status`=? WHERE `department_guid` = ? AND client_guid = ?");
					$stmt->execute([0, $params->item_id, $params->clientId]);

					/** Log the user activity */
					$this->userLogs("remove", $params->item_id, "Deleted a department.", $params->userId, $params->clientId);

					/** Commit the transactions */
					$this->db->commit();
					
					/** Return the success response */
					return "great";
				}
				
			}

			/** remove an event */
			elseif($params->item == "event") {
				
				/** Confirm that events is not already deleted */
				$userActive = $this->db->prepare("SELECT `id` FROM `events` WHERE `event_guid` = ? AND `deleted`=? AND client_guid = ?");
				$userActive->execute([$params->item_id, 0, $params->clientId]);

				/** Count the number of rows */
				if($userActive->rowCount() != 1) {
					return "denied";
				} else {
					
					/** Remove the item from the list of events by setting it as been deleted */
					$stmt = $this->db->prepare("UPDATE `events` SET `deleted`=? WHERE `event_guid` = ? AND client_guid = ?");
					$stmt->execute([1, $params->item_id, $params->clientId]);

					/** Log the user activity */
					$this->userLogs("remove", $params->item_id, "Deleted an Event from the System.", $params->userId, $params->clientId);

					/** Commit the transactions */
					$this->db->commit();
					
					/** Return the success response */
					return "great";
				}
				
			}

			/** cancel an event */
			elseif($params->item == "cancel-event") {
				
				/** Confirm that events is not already deleted */
				$userActive = $this->db->prepare("SELECT `id` FROM `events` WHERE `event_guid` = ? AND `deleted`=? AND `state` !='cancelled' AND client_guid = ?");
				$userActive->execute([$params->item_id, 0, $params->clientId]);

				/** Count the number of rows */
				if($userActive->rowCount() != 1) {
					return "denied";
				} else {
					
					/** Remove the item from the list of events by setting it as been deleted */
					$stmt = $this->db->prepare("UPDATE `events` SET `state`=? WHERE `event_guid` = ? AND client_guid = ?");
					$stmt->execute(["cancelled", $params->item_id, $params->clientId]);

					/** Log the user activity */
					$this->userLogs("remove", $params->item_id, "Cancelled an Event that is yet to be held.", $params->userId, $params->clientId);

					/** Commit the transactions */
					$this->db->commit();
					
					/** Return the success response */
					return "great";
				}
				
			}

			/** confirm event booking */
			elseif($params->item == "confirm-booking") {

				/** Split the event and the row id */
				$event = explode("_", $params->item_id);

				/** If there is not a second item */
				if(!isset($event[1])) {
					return "denied";
				}
				
				/** Confirm that events is not already deleted */
				$userActive = $this->db->prepare("SELECT `id` FROM `events` WHERE `event_guid` = ? AND `deleted`=? AND `state` !='cancelled' AND client_guid = ?");
				$userActive->execute([$event[0], 0, $params->clientId]);

				/** Count the number of rows */
				if($userActive->rowCount() != 1) {
					return "denied";
				} else {
					
					/** Confirm the item from the list of events by setting it as been deleted */
					$stmt = $this->db->prepare("UPDATE `events` SET `state`=? WHERE `event_guid` = ? AND client_guid = ?");
					$stmt->execute(["in-progress", $event[0], $params->clientId]);

					/** Update the user row */
					$stmt = $this->db->prepare("UPDATE `events_booking` SET `status`=? WHERE `event_guid` = ? AND id = ?");
					$stmt->execute([1, $event[0], $event[1]]);

					/** Log the user activity */
					$this->userLogs("booking", $event[1], "The Booking was successfully confirmed.", $params->userId, $params->clientId);

					/** Commit the transactions */
					$this->db->commit();
					
					/** Return the success response */
					return "great";
				}
				
			}

			/** Unbook a seat */
			elseif($params->item == "remove-booking") {
				/** Split the event and the row id */
				$event = explode("_", $params->item_id);

				/** If there is not a second item */
				if(!isset($event[1])) {
					return "denied";
				}
				
				/** Confirm that events is not already deleted */
				$userActive = $this->db->prepare("SELECT `id` FROM `events` WHERE `event_guid` = ? AND `deleted`=? AND `state` !='cancelled' AND client_guid = ?");
				$userActive->execute([$event[0], 0, $params->clientId]);

				/** Count the number of rows */
				if($userActive->rowCount() != 1) {
					return "denied";
				} else {
					$reserveObj = load_class("reservations", "controllers");
					$unbook = $reserveObj->unbookSeat($event[0], $event[1], $params->clientId);

					/** Log the user activity */
					$this->userLogs("booking", $event[1], "The booked seat was successfully unbooked and released.", $params->userId, $params->clientId);

					/** Commit the transactions */
					$this->db->commit();
					
					return $unbook;
				}

			}
			
			/** return ticket and set as inactive */
			elseif($params->item == "return-ticket") {

				/** Split the event and the row id */
				$ticket = explode("_", $params->item_id);

				/** If there is not a second item */
				if(!isset($ticket[2])) {
					return "denied";
				}
				
				/** Confirm that ticket is not already deleted */
				$ticketActive = $this->db->prepare("
					SELECT a.id, a.fullname, a.contact 
					FROM ticket_purchases a
					LEFT JOIN tickets_listing b ON a.ticket_id = b.id
					WHERE a.id = ? AND a.event_id = ? AND a.ticket_id = ? AND b.client_guid = ? AND b.status = ? LIMIT 1
				");
				$ticketActive->execute([$ticket[0], $ticket[1], $ticket[2], $params->clientId, 'pending']);

				/** Count the number of rows */
				if($ticketActive->rowCount() != 1) {
					return "denied";
				} else {

					// get the ticket information
					$result = $ticketActive->fetch(PDO::FETCH_OBJ);
					
					/** Remove the item from the list of events by setting it as been deleted */
					$stmt = $this->db->prepare("
						UPDATE tickets_listing a SET a.status = ? WHERE `id` = ? AND client_guid = ?
					");
					$stmt->execute(["invalid", $ticket[2], $params->clientId]);

					/** Log the user activity */
					$this->userLogs("ticket", $ticket[1], "The ticket sold out to {$result->fullname} ({$result->contact}) was returned.", $params->userId, $params->clientId);

					/** Commit the transactions */
					$this->db->commit();
					
					/** Return the success response */
					return "great";
				}
				
			}

			/** remove event media */
			elseif($params->item == "event-media") {
				/** Split the event and the row id */
				$event = explode("_", $params->item_id);

				/** If there is not a second item */
				if(!isset($event[1])) {
					return "denied";
				}
				
				/** Confirm that events is not already deleted */
				$userActive = $this->db->prepare("SELECT `id` FROM `events` WHERE `event_guid` = ? AND `deleted`=? AND client_guid = ?");
				$userActive->execute([$event[0], 0, $params->clientId]);

				/** Count the number of rows */
				if($userActive->rowCount() != 1) {
					return "denied";
				} else {
					// remove the media
					$this->db->query("UPDATE events_media SET status = '0' WHERE event_guid='{$event[0]}' AND id='{$event[1]}'");
					
					/** Commit the transactions */
					$this->db->commit();
					
					return "great";
				}

			}

			/** remove ticket  */
			elseif($params->item == "ticket") {

				/** Confirm that user is not already deleted */
				$userActive = $this->db->prepare("SELECT id FROM `tickets` WHERE `ticket_guid` = ? AND `status`=? AND `client_guid` = ? AND `number_sold` = ?");
				$userActive->execute([$params->item_id, 1, $params->clientId, 0]);

				/** Count the number of rows */
				if($userActive->rowCount() != 1) {
					return "denied";
				} else {
					
					/** Remove the ticket from the list of tickets by setting it as been deleted */
					$stmt = $this->db->prepare("UPDATE `tickets` SET `status`=? WHERE ticket_guid = ? AND `client_guid` = ?");
					$stmt->execute([0, $params->item_id, $params->clientId]);

					/** Delete the tickets list as well */
					$this->db->query("DELETE FROM `tickets_listing` WHERE `ticket_guid` = '{$params->item_id}'");

					/** Log the user activity */
					$this->userLogs("remove", $params->item_id, "Deleted a Ticket that was generated.", $params->userId, $params->clientId);

					/** Commit the transactions */
					$this->db->commit();
					
					/** Return the success response */
					return "great";
				}
			}

			/** If the user wants to remove a user */
			elseif($params->item == "user") {
				
				/** Confirm that user is not already deleted */
				$itemActive = $this->db->prepare("SELECT id FROM users WHERE deleted=? AND user_guid = ? AND client_guid = ?");
				$itemActive->execute([0, $params->item_id, $params->clientId]);

				/** Count the number of rows */
				if($itemActive->rowCount() != 1) {
					return "denied";
				} else {
					/** Remove the user from the list of users by setting it as been deleted */
					$stmt = $this->db->prepare("UPDATE users SET status=?, deleted=? WHERE user_guid = ? AND client_guid = ?");
					$stmt->execute([0, 1, $params->item_id, $params->clientId]);

					/** Reduce the number of brands created for this account */
					$cSubscribe = json_decode( $clientData->subscription, true );
					$cSubscribe['users_created'] = isset($cSubscribe['users_created']) ? ($cSubscribe['users_created'] - 1) : 2;

					/** update the client brands subscription count */
					$this->db->query("UPDATE users_accounts SET subscription='".json_encode($cSubscribe)."' WHERE client_guid='{$params->clientId}'");

					/** Log the user activity */
					$this->userLogs("remove", $params->item_id, "Deleted the User From the List of Users for this Account.", $params->userId, $params->clientId);

					/** Commit the transactions */
					$this->db->commit();
					
					/** Return the success response */
					return "great";
				}
				
			}

			/** remove a member */
			elseif($params->item == "member") {
				
				/** Confirm that department is not already deleted */
				$userActive = $this->db->prepare("SELECT `id` FROM `members` WHERE `id` = ? AND `status`=? AND client_guid = ?");
				$userActive->execute([$params->item_id, 1, $params->clientId]);

				/** Count the number of rows */
				if($userActive->rowCount() != 1) {
					return "denied";
				} else {
					
					/** Remove the department from the list of members by setting it as been deleted */
					$stmt = $this->db->prepare("UPDATE `members` SET `status`=? WHERE `id` = ? AND client_guid = ?");
					$stmt->execute([0, $params->item_id, $params->clientId]);

					/** Log the user activity */
					$this->userLogs("remove", $params->item_id, "Deleted a member.", $params->userId, $params->clientId);

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

}