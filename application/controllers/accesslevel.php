<?php
// ensure this file is being included by a parent file
if( !defined( 'SITE_URL' ) && !defined( 'SITE_DATE_FORMAT' ) ) die( 'Restricted access' );

class Accesslevel {

    private $_status = false;
    public $userId;
    public $clientId;
    public $currentPage;
    public $userPermits = null;

    private $_message = '';

    public function __construct(){
        global $booking, $session;
        
        $this->db = $booking;
        $this->session = $session;
    }

    /**
     * A method to fetch access level details from DB
     *
     * @param String $accessLevel Pass level id to fetch details
     *
     * @return Object $this->_message
     */
    public function getPermissions($accessLevel = false)
    {
        $this->_message = false;

        $condition = ($accessLevel == false) ? "1" : " (id = '{$accessLevel}' OR access_level_name = '{$accessLevel}')";

        $stmt = $this->db->prepare("
            SELECT * FROM users_access_levels WHERE {$condition}
        ");

        if ($stmt->execute()) {
            $this->_message = $stmt->fetchAll(PDO::FETCH_OBJ);
        }

        return $this->_message;
    }

    /**
     * A method to fetch access level details from DB
     *
     * @param String $accessLevel Pass level user_guid to fetch details
     *
     * @return Object $this->_message
     */
    public function getUserPermissions()
    {
        $this->_message = false;
        $clientId = !empty($this->clientId) ? $this->clientId : $this->session->clientId;

        $stmt = $this->db->prepare("SELECT * FROM users_roles WHERE user_guid = '{$this->userId}' AND client_guid = '{$clientId}'");

        if ($stmt->execute()) {
            $this->_message = $stmt->fetchAll(PDO::FETCH_OBJ);
        }

        return $this->_message;
    }

    /**
     * A method to save SMS Into history
     *
     * @param String $message Pass message to send
     * @param String $to      Pass recipients number
     *
     * @return Bool $this->_message
     */
    public function assignUserRole($userID, $accessLevel, $permissions = false)
    {
        $this->_message = false;
        $clientId = !empty($this->clientId) ? $this->clientId : $this->session->clientId;

        if ($permissions == false) {

            // Get Default Permissions
            $permissions = ($this->getPermissions($accessLevel) != false) ? 
                $this->getPermissions($accessLevel)[0]->access_level_permissions : null;

            $stmt = $this->db->prepare("
                INSERT INTO users_roles SET clientId='{$clientId}', user_guid = '{$userID}', permissions = '{$permissions}'
            ");

            if ($stmt->execute()) {
                $this->_message = true;
            }
        } else {

            $stmt = $this->db->prepare("
                UPDATE users_roles 
                SET permissions = '".(is_array($permissions) ? json_encode($permissions) : $permissions)."' WHERE user_guid = '{$userID}' AND client_guid='{$this->session->clientId}'
            ");

            if ($stmt->execute()) {
                $this->_message = true;
            }
        }

        return $this->_message;
    }

    public function hasAccess($role, $currentPage = null) {
        
        // Check User Roles Table
        $permits = !empty($this->userPermits) ? $this->userPermits : $this->getUserPermissions();
        
        // user permissions
        if ($permits != false) {

            // code the user permissions section
            $permit = empty($this->userPermits) ? json_decode($permits[0]->permissions) : json_decode($this->userPermits);
            $permissions = $permit->permissions;
            
            // confirm that the requested page exists
            if(!isset($permissions->$currentPage)) {
                return false;
            }

            // confirm that the role exists
            if(isset($permissions->$currentPage->$role)) {
                return (bool) ($permissions->$currentPage->$role == 1) ? true : false;
            } else {
                return false;
            }
        }
    }

}