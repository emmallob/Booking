<?php 

class Members extends Booking {

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * List members
     * 
     * @return Array
     */
    public function list($params) {

        try {

            global $accessObject;

            $isUpdate = $accessObject->hasAccess('update', 'users');
			$isDelete = $accessObject->hasAccess('delete', 'members');

            $stmt = $this->db->prepare("
                SELECT a.*,
                    (SELECT b.name FROM class b WHERE b.id = a.m_class) AS class_name
                FROM members a
                WHERE a.status = ? AND a.client_guid = ?
            ");
            $stmt->execute([1, $params->client_guid]);

            $data = [];
            $row = 1;
            while($result = $stmt->fetch(PDO::FETCH_OBJ)) {
                
                $result->action = "";

                $result->action = "<a href='{$this->baseUrl}members-edit/{$result->id}' class='btn btn-sm btn-outline-success'><i class='fa fa-eye'></i></a>";

                if($isDelete) {
                    $result->action .= "&nbsp; <a href='javascript:void(0)' data-title=\"Delete member\" title=\"Click to delete this member.\" class=\"btn btn-sm btn-outline-danger delete-item\" data-url=\"{$this->baseUrl}api/remove/confirm\" data-msg=\"Are you sure you want to delete this member?\" data-item=\"member\" data-item-id=\"{$result->id}\"><i class='fa fa-trash'></i></a> ";
                }

                $result->row_id = $row;
                $data[] = $result;

                $row++;
            }

            return $data;

        } catch(PDOException $e) {
            return $e->getMessage();
        }
    }
}
?>