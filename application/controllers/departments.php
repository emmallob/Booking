<?php

class Departments extends Booking {

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
    public function list(stdClass $params) {
        
        global $accessObject;

        try {
            
            $condition = !empty($params->department_guid) ? "AND a.department_guid='{$params->department_guid}'" : null;

            $stmt = $this->db->prepare("
                SELECT 
                    a.department_guid AS guid, a.color, 
                    a.department_name, a.department_name AS title, a.description, a.color,
                    (
                        SELECT COUNT(*) FROM events b 
                        WHERE b.department_guid = a.department_guid AND b.deleted=? 
                        AND b.state = ?
                    ) AS pending_events,
                    (
                        SELECT COUNT(*) FROM events b 
                        WHERE b.department_guid = a.department_guid AND b.deleted=? 
                        AND b.state != ?
                    ) AS no_of_events
                FROM departments a
                WHERE a.client_guid = ? AND a.status = ? {$condition} ORDER BY id DESC
            ");
            $stmt->execute([0, "pending", 0, "cancelled", $params->clientId, 1]);

            /** Begin an empty array of the result */
            $data = [];
            $i = 0;

            /** Count the number of rows found */
            if($stmt->rowCount() > 0) {
                
                /** Loop through the results */
                while($result = $stmt->fetch(PDO::FETCH_OBJ)) {
                    $i++;
                    
                    /** Add additional information */
                    $result->row_id = $i;
                    
                    /** Generate the action button */
                    $action = "";

                    $result->description = htmlspecialchars_decode($result->description);
                    
                    if($accessObject->hasAccess('update', 'departments')) {
                        $action .= "<a href='{$this->baseUrl}departments-edit/{$result->guid}' title='Edit the details of this department' class='btn btn-outline-success btn-sm'><i class='fa fa-edit'></i></a>";
                    }

                    if($accessObject->hasAccess('delete', 'departments')) {
                        $action .= "&nbsp; <a data-title=\"Delete Department\" href='javascript:void(0)' title=\"Click to delete this department.\" class=\"btn btn-sm btn-outline-danger delete-item\" data-url=\"{$this->baseUrl}api/remove/confirm\" data-msg=\"Are you sure you want to delete this department?\" data-item=\"department\" data-item-id=\"{$result->guid}\"><i class='fa fa-trash'></i></a> ";
                    }

                    $result->action = $action;

                    /** Append to the array */
                    $data[] = $result;
                }
            }

            return $data;

        } catch(\Exception $e) {
            return $e->getMessage();
        }

    }

    /**
     * Add a new department
     * @param stdClass      $params              A composite of variables
     *                      $params->department_name
     *                      $params->color
     *                      $params->description
     * @return Array
     */
    public function add(stdClass $params) {

        // ensure that new lines are replaced with breaks
        $params->description = !empty($params->description) ? $params->description : null;
        $params->description = nl2br($params->description);

        try {

            /** 32 random string for the guid */
            $guid = random_string("alnum", 32);

            /** Execute the statement */
            $stmt = $this->db->prepare("
                INSERT INTO departments 
                SET client_guid = ?, department_guid = ?, department_name = ?, description = ?, color = ?
            ");
            
            /** Execute */
            if($stmt->execute([
                $params->clientId, $guid, $params->department_name, $params->description, $params->color
            ])) {

                /** Log the user activity */
                $this->userLogs('departments', $guid, 'Created a new Department.', $params->userId, $params->clientId);

                /** Format the response to parse */
                return [
                    "state" => 200,
                    "msg" => "Department details was successfully inserted",
                    "additional" => [
                        "clear" => true
                    ]
                ];
            }

        } catch(PDOException $e) {
            return $e->getMessage();
        }

    }

    /**
     * Update the details of an existing department
     * @param stdClass      $params              A composite of variables
     *                      $params->department_name
     *                      $params->color
     *                      $params->description
     *                      $params->department_guid
     * @return Array
     */
    public function update(stdClass $params) {

        // ensure that new lines are replaced with breaks
        $params->description = !empty($params->description) ? $params->description : null;
        $params->description = nl2br($params->description);

        try {

            /** Execute the statement */
            $stmt = $this->db->prepare("
                UPDATE departments 
                SET department_name = ?, description = ?, color = ? WHERE client_guid = ? AND department_guid = ?
            ");
            
            /** Execute */
            if($stmt->execute([
                $params->department_name, $params->description, $params->color, $params->clientId, $params->department_guid
            ])) {

                /** Log the user activity */
                $this->userLogs('departments', $params->department_guid, 'Updated the details of the department.', $params->userId, $params->clientId);

                /** Format the response to parse */
                return [
                    "state" => 200,
                    "msg" => "Department details was successfully updated"
                ];
            }

        } catch(PDOException $e) {
            return $e->getMessage();
        }

    }

}