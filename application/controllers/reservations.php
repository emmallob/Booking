<?php

class Reservations extends Booking {

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

            return [];

        } catch(\Exception $e) {
            return [];
        }

    }

    /**
     * This method reserves a set for a user
     * 
     * @param stdClass $params              This is a composite of several dataset to be used for the query
     * 
     * @return Array
     */
    public function reserveSeat(stdClass $params) {
        
        try {

            

        } catch(\Exception $e) {
            return [];
        }

    }

}