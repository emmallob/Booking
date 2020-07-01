<?php
// ensure this file is being included by a parent file
if( !defined( 'SITE_URL' ) && !defined( 'SITE_DATE_FORMAT' ) ) die( 'Restricted access' );

class Accesslevel {

    private $_status = false;
    public $userId;
    public $currentPage;

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

        $stmt = $this->db->prepare("SELECT * FROM users_roles WHERE user_guid = '{$this->userId}' AND client_guid = '{$this->session->clientId}'");

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

        if ($permissions == false) {

            // Get Default Permissions
            $permissions = ($this->getPermissions($accessLevel) != false) ? 
                $this->getPermissions($accessLevel)[0]->access_level_permissions : null;

            $stmt = $this->db->prepare("
                INSERT INTO users_roles SET clientId='{$this->session->clientId}', user_guid = '{$userID}', permissions = '{$permissions}'
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
        if ($this->userPermission($role, $currentPage) == false) {

            return false;

        }

        return true;
    }

    protected function userPermission($role, $currentPage = null) {

        // force the setting of the current page
        if(!empty($currentPage)) {
            $this->currentPage = $currentPage;
        }

        $permissions = $this->getUserPermissions();

        if ($permissions != false) {

            $permissions = json_decode($permissions[0]->permissions, true);

            $i = 0;
            $permissions = $permissions['permissions'];
            $arrKeys = array_keys($permissions);
            
            // confirm that the requested page exists
            if(!isset($permissions[$this->currentPage])) {

                return false;

            } else {

                if(isset($permissions[$this->currentPage][$role])) {
                    if($permissions[$this->currentPage][$role] == 1) {
                        return true;
                    } else {
                        return false;
                    }
                } else {
                    return false;
                }
                
            }

        }

    }
}