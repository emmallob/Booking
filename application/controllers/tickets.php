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
    public function listItems(stdClass $params) : array {
        
        try {

            return $this->output;

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