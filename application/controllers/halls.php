<?php

class Halls extends Booking {

    /** Output */
    private $output = [];
    
    /**
     * Initialize the parent class
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * This method lists items from the database table
     * 
     * @param stdClass $params              This is a composite of several dataset to be used for the query
     * 
     * @return Array
     */
    public function listItems(stdClass $params, $item = false) {

        global $accessObject;

        try {
            
            $condition = !empty($params->hall_guid) ? "AND a.hall_guid='{$params->hall_guid}'" : null;

            $stmt = $this->db->prepare("
                SELECT 
                    a.client_guid, a.hall_guid AS guid, a.rows, a.columns, 
                    a.hall_name, a.hall_name AS title, a.facilities AS description, a.seats, 
                    a.created_on, a.status, a.configuration
                FROM halls a
                WHERE a.client_guid = ? AND a.deleted = ? {$condition} ORDER BY id DESC
            ");
            $stmt->execute([$params->clientId, 0]);

            /** Begin an empty array of the result */
            $data = [];
            $i = 0;
            /** Count the number of rows found */
            if($stmt->rowCount() > 0) {
                
                /** Loop through the results */
                while($result = $stmt->fetch(PDO::FETCH_OBJ)) {
                    $i++;
                    
                    /** Add additional information */
                    $result->state = ($result->status) ? "Active" : "Inactive";
                    $result->row_id = $i;
                    
                    /** Generate the action button */
                    $action = "";

                    // update the hall
                    if($accessObject->hasAccess('update', 'halls')) {
                        $action .= "<a href='{$this->baseUrl}halls-edit/{$result->guid}' title='Edit the details of this hall' class='btn btn-outline-success btn-sm'><i class='fa fa-edit'></i></a>";
                    }

                    // configure the seats
                    if($accessObject->hasAccess('configure', 'halls')) {
                        $action .= "&nbsp; <a href='{$this->baseUrl}halls-configuration/{$result->guid}' title='Click to Configure Hall Setup' class='btn btn-outline-secondary btn-sm'><i class='fa fa-sitemap'></i></a>";
                    }
                    
                    // check the status
                    if(!$result->status) {
                        $action .= "&nbsp; <a href='javascript:void(0)' data-url='api/halls/activate' data-redirect='halls' data-item='hall_guid' data-guid='{$result->guid}' title='Click to Activate this Hall' class='btn btn-outline-primary btn-sm activate-item'><i class='fa fa-check'></i></a>";
                    }

                    // delete the hall
                    if($accessObject->hasAccess('delete', 'halls')) {
                        $action .= "&nbsp; <a href='javascript:void(0)' data-title=\"Delete Hall\" title=\"Click to delete this hall.\" class=\"btn btn-sm btn-outline-danger delete-item\" data-url=\"{$this->baseUrl}api/remove/confirm\" data-msg=\"Are you sure you want to delete this hall?\" data-item=\"hall\" data-item-id=\"{$result->guid}\"><i class='fa fa-trash'></i></a> ";
                    }


                    $result->action = $action;
                    $result->configuration = json_decode($result->configuration, true);

                    /** Append to the array */
                    $data[] = $result;
                }
            }

            return ($item) ? $data[0] : $data;

        } catch(\Exception $e) {
            return $e->getMessage();
        }

    }

    /**
     * This method lists items from the database table
     * 
     * @param stdClass $params              This is a composite of several dataset to be used for the query
     * 
     * @return Array
     */
    public function listEventHalls($hall_guid, $event_guid, $item = false) {

        global $accessObject;

        try {

            $stmt = $this->db->prepare("
                SELECT 
                    a.*, a.hall_guid AS guid
                FROM events_halls_configuration a
                WHERE a.hall_guid='{$hall_guid}' AND a.event_guid='{$event_guid}' ORDER BY id DESC
            ");
            $stmt->execute([0]);

            /** Begin an empty array of the result */
            $data = [];
            $i = 0;
            /** Count the number of rows found */
            if($stmt->rowCount() > 0) {
                
                /** Loop through the results */
                while($result = $stmt->fetch(PDO::FETCH_OBJ)) {
                    $i++;
                    $result->configuration = json_decode($result->configuration, true);

                    // the seats available count
                    $result->seats = count($result->configuration["labels"]);
                
                    /** Append to the array */
                    $data[] = $result;
                }
            }

            return ($item) ? $data[0] : $data;

        } catch(\Exception $e) {
            return $e->getMessage();
        }

    }

    /**
     * This method activates a hall
     * 
     * @param stdClass $params     This is a composite of several dataset to be used for the query
     * 
     * @return Array
     */
    public function activateHall(stdClass $params) {
        
        try {

            /** Prepare the statement */
            $stmt = $this->db->prepare("
                UPDATE halls SET status = ? WHERE client_guid = ? AND hall_guid = ?
            ");
            return $stmt->execute([1, $params->clientId, $params->hall_guid]);

        } catch(\Exception $e) {
            return false;
        }

    }

    /**
     * Add a new hall data
     * Increment the number of halls created once the processing goes through
     * 
     * @param stdClass      $params         This contains the data to create a new hall with
     *                      $params->hall_name
     *                      $params->hall_rows
     *                      $params->hall_columns
     *                      $params->description
     * 
     * @return Array
     */
    public function addItem(stdClass $params) {

        // load the user session key to be used for all the queries
		$cSubscribe = json_decode( $this->clientData($params->clientId)->subscription, true );

        // confirm that the user has not reached the subscription ratio
		if($cSubscribe['halls_created'] >= $cSubscribe['halls']) {
			return "Sorry! Your current subscription will only permit a maximum of {$cSubscribe['halls']} halls";
		}

        // continue processing
        $params->hall_rows = (int) $params->hall_rows;
        $params->hall_columns = (int) $params->hall_columns;
        $params->description = !empty($params->description) ? $params->description : null;

        if($params->hall_rows > 100) {
            return "Maximum hall rows must be 100";
        }

        if($params->hall_columns > 70) {
            return "Maximum hall columns must be 70";
        }

        // configure default hall information
        $counter = 1;
        $configuration = []; 
        $configuration["blocked"] = [];
        $configuration["removed"] = [];
        $configuration["labels"] = [];

        /** Generate the labels for the seats configuration */
        $labels = [];
        for($i = 1; $i < $params->hall_rows + 1; $i++) {
            for($ii = 1; $ii < $params->hall_columns + 1; $ii++) {
                $labels["{$i}_{$ii}"] = $counter;
                $counter++;
            }
        }
        $configuration["labels"] = $labels;

        /** Count the available seats */
        $available = count($labels);
        
        // ensure that new lines are replaced with breaks
        $params->description = nl2br($params->description);

        try {

            /** 32 random string for the guid */
            $guid = random_string("alnum", 32);

            /** Execute the statement */
            $stmt = $this->db->prepare("
                INSERT INTO halls 
                SET `client_guid` = ?, `hall_guid` = ?, `rows` = ?, `columns` = ?, `seats` = ?,
                `hall_name` = ?, `created_by` = ?, `facilities` = ?, `configuration` = ?
            ");
            
            /** Execute */
            if($stmt->execute([
                $params->clientId, $guid, $params->hall_rows, 
                $params->hall_columns, $available, $params->hall_name, $params->userId, 
                $params->description, json_encode($configuration)
            ])) {

                /** Log the user activity */
                $this->userLogs('halls', $guid, 'Created a new hall.');
                
                /** Return the success message */
                $cSubscribe['halls_created'] = (!isset($cSubscribe['halls_created'])) ? 1 : ($cSubscribe['halls_created']+1);

                // update the client brands subscription count
                $this->db->query("UPDATE users_accounts SET subscription='".json_encode($cSubscribe)."' WHERE client_guid='{$params->clientId}'");

                /** Format the response to parse */
                return [
                    "state" => 200,
                    "msg" => "Hall details was successfully inserted"
                ];
            }

        } catch(PDOException $e) {
            return $e->getMessage();
        }
        

    }

    /**
     * Save the hall configuration
     * @param stdClass      $params         This contains the data to create a new hall with
     *                      $params->blocked_seats
     *                      $params->removed_seats
     *                      $params->hall_guid
     *                      $params->available_seats 
     * 
     * @return String
     */
    public function configureHall(stdClass $params) {

        // load the hall data
        $hallData = $this->pushQuery("*", "halls", "hall_guid='{$params->hall_guid}' && client_guid='{$params->clientId}'");
        
        // confirm that data was found
        if(empty($hallData)) {
            return "Sorry! An invalid hall guid was parsed";
        }

        // confirm that an array data was parsed
        if(!is_array($params->available_seats)) {
            return "Sorry, The seats must be an array data";
        }

        // confirm valid array for the blocked list
        if(!empty($params->blocked_seats) && !is_array($params->blocked_seats)) {
            return "Sorry, The blocked seats must be an array data";
        }
        
        // confirm valid array for the removed list
        if(!empty($params->removed_seats) && !is_array($params->removed_seats)) {
            return "Sorry, The removed seats must be an array data";
        }        

        // set the variables
        $hallData = $hallData[0];

        // reset the data
        $hallConf = !empty($hallData->configuration) ? json_decode($hallData->configuration, true) : [];
        
        // reassign some data
        $params->blocked_seats = !empty($params->blocked_seats) ? $params->blocked_seats : [];
        $params->removed_seats = !empty($params->removed_seats) ? $params->removed_seats : [];

        // merge the existing configuration with the new incoming data
        $removedSeats = array_merge($hallConf['removed'], $params->removed_seats);
        $blockedSeats = $params->blocked_seats;
        
        // remove all the duplicates
        $removedSeats = array_unique($removedSeats);
        $blockedSeats = array_unique($blockedSeats);

        // configure default hall information
        $configuration = []; 
        $configuration["blocked"] = $blockedSeats;
        $configuration["removed"] = $removedSeats;
        $configuration["labels"] = [];

        /** Generate the labels for the seats configuration */
        $labels = [];
        foreach($params->available_seats as $key => $value) {
            $labels[$key] = $value;
        }
        $configuration["labels"] = $labels;

        /** count the seats available */
        $available = count($labels);
        
        /** Finalize and save the record */
        try {

            /** Prepare the statement */
            $stmt = $this->db->prepare("UPDATE halls SET `configuration` = ?, `status` = ?, `seats` = ? WHERE `client_guid` = ? AND hall_guid = ?");
            
            /** Execute the statement */
            if($stmt->execute([json_encode($configuration), 0, $available, $params->clientId, $params->hall_guid])) {

                /** Update any existing event that will use this hall and has not commenced yet (no user has yet booked a seat) */
                $this->db->query("UPDATE events_halls_configuration SET `configuration` = '".json_encode($configuration)."' WHERE hall_guid = '{$params->hall_guid}' AND commenced = '0'");

                /** Log the user activity */
                $this->userLogs('halls', $params->hall_guid, 'Updated the hall configuration data.');
                
                /** Return success messge */
                return [
                    'state' => 200,
                    'msg' => "The hall seats were successfully configured."
                ];
            }

        } catch(PDOException $e) {
            return $e->getMessage();
        }
    }

    /**
     * This method resets a hall
     * 
     * @param stdClass $params     This is a composite of several dataset to be used for the query
     * 
     * @return Array
     */
    public function resetHall(stdClass $params) {
        
        // load the hall data
        $hallData = $this->pushQuery("`rows`, `columns`", "halls", "hall_guid='{$params->hall_guid}' && client_guid='{$params->clientId}'");
        
        // confirm that data was found
        if(empty($hallData)) {
            return "Sorry! An invalid hall guid was parsed";
        }
        
        // configure default hall information
        $counter = 1;
        $configuration = []; 
        $configuration["blocked"] = [];
        $configuration["removed"] = [];
        $configuration["labels"] = [];

        /** Generate the labels for the seats configuration */
        $labels = [];
        for($i = 1; $i < $hallData[0]->rows + 1; $i++) {
            for($ii = 1; $ii < $hallData[0]->columns + 1; $ii++) {
                $labels["{$i}_{$ii}"] = $counter;
                $counter++;
            }
        }
        $configuration["labels"] = $labels;

        try {

            /** Prepare the statement */
            $stmt = $this->db->prepare("UPDATE halls SET `status` = ?, `configuration` = ? WHERE `client_guid` = ? AND `hall_guid` = ?");
            $stmt->execute([0, json_encode($configuration), $params->clientId, $params->hall_guid]);

            /** Reset the hall configuration in the events configuration table as well */
            return $this->db->query("UPDATE events_halls_configuration SET `configuration` = '".json_encode($configuration)."' WHERE hall_guid = '{$params->hall_guid}' AND commenced = '0'");

        } catch(\Exception $e) {
            return false;
        }

    }

    /**
     * Update an existing hall details
     * 
     * Increment the number of halls created once the processing goes through
     * 
     * @param stdClass      $params         This contains the data to create a new hall with
     *                      $params->hall_name
     *                      $params->hall_rows
     *                      $params->hall_columns
     *                      $params->description
     *                      $params->hall_guid
     * 
     * @return Array
     */
    public function updateItem(stdClass $params) {

        // load the hall information
        $hallQuery = $this->pushQuery("`configuration`, `hall_name`, `id`, `rows`, `columns`", "`halls`", "`hall_guid`='{$params->hall_guid}' AND client_guid='{$params->clientId}' AND deleted='0'");

        // return error
        if(empty($hallQuery)) {
            return "Sorry! An invalid hall guid was parsed.";
        }
        
        // continue processing
        $params->hall_rows = (int) $params->hall_rows;
        $params->hall_columns = (int) $params->hall_columns;
        $params->description = !empty($params->description) ? $params->description : null;

        if($params->hall_rows > 100) {
            return "Maximum hall rows must be 100";
        }

        if($params->hall_columns > 70) {
            return "Maximum hall columns must be 70";
        }

        // configure default hall information
        $hallConf = !empty($hallQuery[0]->configuration) ? json_decode($hallQuery[0]->configuration, true) : [];
        
        // // set more variables
        $removedSeats = $hallConf['removed'];
        $blockedSeats = $hallConf['blocked'];
        $available = $hallConf["labels"];

        // go on to run more processing and checks
        $counter = 1;

        /** Generate the labels for the seats configuration */
        $labels = [];
        for($i = 1; $i < $params->hall_rows + 1; $i++) {
            for($ii = 1; $ii < $params->hall_columns + 1; $ii++) {
                $labels["{$i}_{$ii}"] = $counter;
                $counter++;
            }
        }
        $configuration["labels"] = $labels;

        /** Count the available seats */
        $available = count($labels) - count($removedSeats) - count($blockedSeats);
        
        // ensure that new lines are replaced with breaks
        $params->description = nl2br($params->description);

        try {

            /** Execute the statement */
            $stmt = $this->db->prepare("
                UPDATE halls 
                SET `rows` = ?, columns = ?, seats = ?,
                    hall_name = ?, created_by = ?, facilities = ?
                WHERE client_guid = ? AND hall_guid = ?
            ");
            
            /** Execute */
            if($stmt->execute([
                $params->hall_rows, $params->hall_columns, $available, $params->hall_name, 
                $params->userId, $params->description, $params->clientId, $params->hall_guid
            ])) {
                
                /** Update the hall name for all events that have not commenced it */
                $this->db->query("
                    UPDATE 
                        events_halls_configuration 
                    SET 
                        `hall_name` = '{$params->hall_name}',
                        `rows` = '{$params->hall_rows}', 
                        `columns` = '{$params->hall_columns}'
                    WHERE 
                        hall_guid = '{$params->hall_guid}' AND commenced = '0'
                ");

                /** Log the user activity */
                $this->userLogs('halls', $params->hall_guid, 'Updated hall details.');
                
                /** Format the response to parse */
                return [
                    "state" => 200,
                    "msg" => "Hall details was successfully updated"
                ];
            }

        } catch(PDOException $e) {
            return $e->getMessage();
        }
        

    }
}