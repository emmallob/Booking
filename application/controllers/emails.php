<?php 

class Emails extends Booking {

    public function __construct() {
        parent::__construct();

        // Allow certain file formats 
        $this->allowedFileTypes = [
            'jpg', 'png', 'jpeg', 'txt', 'pdf', 
            'sql', 'docx', 'doc', 'xls', 'xlsx', 
            'ppt', 'pptx', 'php', 'html', 'css',
            'csv', 'rtf', 'gif', 'pub'
        ];
    }

    /**
     * List the temporary attachments to a specify email
     * 
     * Loops through the session value and populates the list of attachments and gets its size
     * 
     * @return Array
     */
    public function tempAttachments() {

        // List the attached documents
        $attachments = '';
        // append the list
        if(!empty($this->session->tempAttachments) && is_array($this->session->tempAttachments)) {
            // using foreach loop to get the list of attached documents
            foreach($this->session->tempAttachments as $key => $values) {
                // check if the name is more than 35 characters
                if(strlen($values['item_value']) > 30) {
                    $name = substr($values['item_value'], 0, 30)."...";
                } else {
                    $name = substr($values['item_value'], 0, 30);
                }
                // print the name
                $attachments .= "<div data-value=\"{$values['item_id']}\" class=\"row mt-2 justify-content-between\">";
                $attachments .= "<div style=\"overflow:hidden\" class='mt-1'>";
                $attachments .= "<a title=\"{$values['item_value']}\" class=\"font-weight-bolder cursor\" style=\"color:#000;\" target=\"_blank\">{$name} <span class=\"text-muted font-weight-light\">({$values['item_name']})</span></a>";
                $attachments .= "</div><div class=\"text-right\">";
                $attachments .= "<i title=\"Delete Item Attached\" data-value=\"{$values['item_id']}\" class=\"fa delete-document text-danger cursor fa-trash\"></i>";
                $attachments .= "</div></div>";
            }
        }

        $totalAttachments = (!empty($this->session->tempAttachments)) ? ($this->tempAttachmentsSize()) : 0;

        return [
            'files' => $attachments,
            'total' => ((!empty($this->session->tempAttachments)) ? count($this->session->tempAttachments) : 0)." Files - <strong ".(($totalAttachments > 25) ? 'class="text-danger cursor" title="Maximum file size exceeded."' : 'class="text-success cursor"').">Total Size: ".$totalAttachments." MB</strong>"
        ];

    }

    /**
     * Upload a temporary document to be attached to a mail
     * 
     * @param stdClass $params      This contains the file to upload
     * 
     * @return Array
     */
    public function uploadAttachment(stdClass $params) {
        
        // get the current attachment session id
        $curId = $this->session->tempAttachment;

        //: create a new session
        $sessionClass = load_class('sessions', 'controllers');

        // set the upload dir
        $uploadDir = 'assets/emails/tmp/';

        // if there is not any name key
        if(!isset($params->mail_attachment["name"])) {
            return;
        }
        
        // File path config 
        $fileName = basename($params->mail_attachment["name"]); 

        $newFileName = random_string('alnum', 25);
        $targetFilePath = $uploadDir . $fileName;
        $n_FileTitle_Real = preg_replace('/\\.[^.\\s]{3,4}$/', '', $fileName);
        $fileType = strtolower(pathinfo($targetFilePath, PATHINFO_EXTENSION));

        // check if its a valid image
        if(!empty($fileName) && in_array($fileType, $this->allowedFileTypes)){

            // set a new filename
            $uploadPath = $uploadDir . $newFileName;

            // Upload file to the server 
            if(move_uploaded_file($params->mail_attachment["tmp_name"], $uploadPath)){ 
                $uploadStatus = 1;

                //: set this session data
                $sessionClass->addSessionData('tempAttachments', $newFileName, $n_FileTitle_Real, $curId, file_size_convert("{$uploadDir}{$newFileName}", true), $fileType);

            } else { 
                $uploadStatus = 0; 
            }

        } else { 
            $uploadStatus = 2;
        }

        return [
            'upload_status' => $uploadStatus,
            'allowed_types' => implode(',', $this->allowedFileTypes)
        ];
		
    }

    /**
     * Remove a temporary email attachment
     * 
     * @param String $params->document_id       This is the temp document id
     * 
     * @return Array
     */
    public function removeTempAttachment(stdClass $params) {

        //: Total attachments
        $totalAttachments = 0;
        //: Ensure the array is not empty
        if(!empty($this->session->tempAttachments) && is_array($this->session->tempAttachments)) {
            
            //: create a new session
            $sessionClass = load_class('sessions', 'controllers');
            
            // get the total file size
            $totalAttachments = (!empty($this->session->tempAttachments)) ? ($this->tempAttachmentsSize()) : 0;

            // set the data record
            $postData = (object) $params;

            //: remove the attached document
            $sessionClass->removeSessionValue('tempAttachments', $postData->document_id, 'assets/emails/tmp/');
        }

        return [
            'total' => ((!empty($this->session->tempAttachments)) ? count($this->session->tempAttachments) : 0)." Files - <strong ".(($totalAttachments > 25) ? 'class="text-danger cursor" title="Maximum file size exceeded."' : 'class="text-success cursor"').">Total Size: ".$totalAttachments." MB</strong>",
            'result' => 'Attachment Removed'
        ];
    }

    /**
     * Discard The Email message Composing
     * 
     * @return Bool
     */
    public function discardEmail() {

        //: create a new session
        $sessionClass = load_class('sessions', 'controllers');

        // unset the sessions
        $this->session->remove("emailsList");
        $this->session->remove("newListNames");
        
        //: remove the attached documents
        if(!empty($this->session->tempAttachments) && is_array($this->session->tempAttachments)) {
            $sessionClass->removeAllItems('tempAttachments', 'assets/emails/tmp/');
        }

        // remove all sessions
        $this->session->remove('tempAttachments');

        return true;

    }
    
    /**
	 * Send out messages to a list of recipients
     * 
     * @param String $params->recipients    The list of receipients to receive the mail
     * @param String $params->subject       The subject of the email message
     * @param String $params->content       The content of the mail
     * @param String $params->sender        The email address to send the mail from
     * 
	 * @return Bool
	 **/
    public function sendEmail() {

    }

}
?>