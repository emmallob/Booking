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
    public function sendEmail(stdClass $params) {

        // assign variables
        $content = isset($params->content) ? trim($params->content) : null;
        $subject = isset($params->subject) ? $params->subject : null;
        $sender = isset($params->sender) ? $params->sender : null;

        //: the attachments list
        $totalAttachments = (!empty($this->session->emailAttachment)) ? ($this->tempAttachmentsSize()) : 0;

        // Email Recipients
        $bugs = [];
        $mailingList = [];
        $recipients = explode(",", $params->recipients);

        // loop through the list
        foreach($recipients as $receiver) {
            // confirm that a valid email was parsed
            if(!filter_var($receiver, FILTER_VALIDATE_EMAIL)) {
                $bugs[] = $receiver; 
            } else {
                $mailingList[] = [
                    "fullname" => $receiver,
                    "email_adress" => $receiver
                ];
            }
        }

        // if the attachment is more than 25mb
        if(!empty($bugs)) {
            return 'Please ensure that all emails are valid: '.implode(",", $bugs);
        } elseif(($totalAttachments > 25)) {
            return 'Maximum attachment allowed is 25MB.';
        } else { 
            //: Looping through the list to insert the data
            $content = htmlspecialchars_decode($content);
            $content = htmlspecialchars($content);
            
            //: push the information into the database
            $data = $this->sendBulkEmails($params, $mailingList);

            //: If the response is true
            if($data) {

                //: remove all sessions
                $this->session->remove('emailsList');
                $this->session->remove('newListNames');
                $this->session->remove('emailAttachment');
                
                //: Set new values
                return 'Sent';
            
            }

            return "Sorry! There was an error while processing the request.";
        }
    }

    /**
     * Send the mail
     * 
     * @param stdClass $params
     * @param String $mailingList
     * 
     * @return Bool
     */
    private function sendBulkEmails($params, $mailingList){
        
        // begin transaction
		$this->db->beginTransaction();

		try {

			//: if is array the mailing list
			if(is_array($mailingList)) {

				//: Generate a new token id
				$emailId = random_string('alnum', mt_rand(25, 35));

				$this->addEmailAttachment($emailId, $params->clientId);

				//: Process the form
				$stmt = $this->db->prepare("
					INSERT INTO emails 
					SET client_guid = ?, email_guid = ?, 
						user_guid=?, sent_via = ?, 
						recipient = ?, subject = ?, message = ?,
						date_sent = now()
				");
				$stmt->execute([
					$params->clientId, $emailId, 
					$params->userId, $params->sender, json_encode($mailingList),
					$params->subject, $params->message
				]);

				$this->db->commit();

				return true;
			}

			return false;

		} catch(PDOException $e) {
			$this->db->rollBack();
			return $e->getMessage();
		}
    }

    /**
     * Add the email attachments
     */
    public function addEmailAttachment($emailId = null, $clientId) {

		try {
			//: Process the email attachments
			if(!empty($this->session->tempAttachments) && is_array($this->session->tempAttachments)) {
				
				// using foreach loop to get the list of attached documents
				foreach($this->session->tempAttachments as $key => $values) {
					
					//: Insert the documents
					$stmt = $this->db->prepare("
						INSERT INTO emails_attachments SET 
							client_guid = ?, email_guid = ?, document_name = ?, document_link = ?,
							document_type = ?, document_size = ?
					");
					$stmt->execute([
						$clientId, $emailId, $values['item_value'],
						$values['item_id'], $values['fifth_item'], $values['item_name']
					]);

					// copy each file and send it into the main directory
					$file_newname = 'assets/emails/docs/'.$values['item_id'];
					$file_oldname = 'assets/emails/tmp/'.$values['item_id'];
					
					// first copy the file to a separate folder
					copy($file_oldname, $file_newname);

					// delete the old file
					unlink($file_oldname);
				}

			}
		} catch(PDOException $e) {
			return false;
		}

	}

}
?>