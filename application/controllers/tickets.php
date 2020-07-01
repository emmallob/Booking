<?php

class Tickets extends Booking {

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
    public function listItems(stdClass $params) {
        
        try {

            $stmt = $this->db->prepare("
                SELECT a.*,
                FROM tickets a
                WHERE a.client_guid = ?
            ");
            $stmt->execute([$params->clientId, 0]);

            /** Begin an empty array of the result */
            $data = [];

            /** Count the number of rows found */
            if($stmt->rowCount() > 0) {
                
                /** Loop through the results */
                while($result = $stmt->fetch(PDO::FETCH_OBJ)) {

                    // unset the id from the result set
                    unset($result->id);

                    $data[] = $result;

                }
            }

            return $data;


        } catch(\Exception $e) {
            return [];
        }

    }

    /**
     * This method lists getnerate a ticket
     * 
     * @param stdClass $params              This is a composite of several dataset to be used for the query
     * 
     * @return Array
     */
    public function generateTickets(stdClass $params) {
        
        try {

            

        } catch(\Exception $e) {
            return [];
        }

    }

    

}