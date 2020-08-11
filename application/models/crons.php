<?php
 
class Crons {

	private $dbConn;
	private $storeContent;
	public $rootUrl = "/absolute/path/to/website/root";
	private $siteName = "BookingLog - Emmallen Networks";
	private $siteHost;
	private $sitePassword;

	public function addToMailList(stdClass $mailData) {
		global $evelyn;
	}

	public function dbConn() {
		
		// CONNECT TO THE DATABASE
		$connectionArray = array(
			'hostname' => "localhost",
			'database' => 'database_name',
			'username' => 'database_username',
			'password' => 'password'
		);

		$conn_name = $connectionArray['username'];
		// run the database connection
		try {
			$conn = "mysql:host={$connectionArray['hostname']}; dbname={$connectionArray['database']}; charset=utf8";			
			$this->dbConn = new PDO($conn, $connectionArray['username'], $connectionArray['password']);
			$this->dbConn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$this->dbConn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_BOTH);
		} catch(PDOException $e) {
			die("Database Connection Error: ".$e->getMessage());
		}

		return $this->dbConn;

	}

	private function generateGeneralMessage($message, $subject, $template_type) {

		$mailerContent = '
		<!DOCTYPE html>
        <html>
            <head>
                <title>'.$subject.'</title>
            </head>
            <body>
                <div style="margin: auto auto; width: 610px; box-shadow: 0px 1px 2px #000; border-radius: 5px">
                    <table width="600px" border="0" cellpadding="0" style="min-height: 400px; margin: auto auto;" cellspacing="0">
                        <tr style="padding: 5px; border-bottom: solid 1px #ccc;">
                            <td colspan="4" align="center" style="padding: 10px;">
                                <h1 style="margin-bottom: 0px; margin-top:0px">'.$this->siteName.'</h1>
                                <hr style="border: dashed 1px #ccc;">
                                <div style="font-family: Calibri Light; background: #9932cc; font-size: 20px; padding: 5px;color: white; text-transform: uppercase; font-weight; bolder">
                                <strong>'.$subject.'</strong>
                                </div>
                                <hr style="border: dashed 1px #ccc;">
                            </td>
                        </tr>

                        <tr>
                            <td style="padding: 5px; font-family: Calibri Light; text-transform: uppercase;">
                                '.$message.'
                            </td>
                        </tr>
                    </table>
                    <table width="600px">
                        <tbody style="text-align: center;">
                            <tr>
                                <td colspan="4">
                                    <hr style="border: dashed 1px #ccc; text-align: center;">
                                    <img width="150px" src="'.$this->baseUrl.'assets/images/'.$this->storeContent->client_logo.'"  alt="logo-small" class="logo-sm">
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </body>
        </html>';

		return $mailerContent;
	}

	/** Load general emails list */
	public function loadEmailRequests() {
		
		// begin the database connection
		$this->dbConn();

		// run the query
		$stmt = $this->dbConn->prepare(
            "SELECT 
            	a.*, b.client_email_host, b.client_email_password,
            	b.name AS client_name, b.email AS client_email, b.account_logo, 
            	b.phone AS primary_contact, b.address AS address_1
            FROM users_email_list a
            LEFT JOIN users_accounts b ON a.client_guid = b.client_guid
            WHERE a.sent_status='0' AND a.deleted='0' ORDER BY id DESC LIMIT 200
        ");
        $stmt->execute();

        $dataToUse = null;

        // looping through the content
        while($result = $stmt->fetch(PDO::FETCH_OBJ)) {
        	
        	// set the store content
        	$this->storeContent = $result;
        	$this->siteName = $result->client_name;
			$this->siteEmail = $result->client_email;
			$this->siteHost = $result->client_email_host;
			$this->sitePassword = $result->client_email_password;

        	$expl = explode('/', $this->storeContent->account_logo);

        	$this->storeContent->account_logo = $expl[2];

        	// commence the processing
			$subject = $result->subject;
			$dataToUse = $this->generateGeneralMessage($result->message, $subject, $result->template_type);

        	// use the content submitted
        	if(!empty($dataToUse)) {

        		// convert the recipient list to an array
        		$recipient_list = json_decode($result->recipients_list, true);
        		$recipient_list = $recipient_list["recipients_list"];
        		
    			// submit the data for processing
    			$mailing = $this->cronSendMail($recipient_list, $subject, $dataToUse);

    			// set the mail status to true
    			if($mailing) {
    				$this->dbConn->query("UPDATE users_email_list SET sent_status = '1', date_sent=now() WHERE id='{$result->id}'");
    				print "Mails successfully sent\n";
    			}

        	}
        }


	}

	/** Send emails generated under the communication section */
	public function loadCommunicationEmails() {

		// begin the database connection
		$this->dbConn();

		// run the query
		$stmt = $this->dbConn->prepare(
            "SELECT 
            	a.*, b.client_email_host, b.client_email_password,
            	b.name AS client_name, b.email AS client_email, b.account_logo, 
            	b.phone AS primary_contact, b.address AS address_1
            FROM emails a
            LEFT JOIN users_accounts b ON a.client_guid = b.client_guid
            WHERE a.status='1' AND a.email_status='Pending' ORDER BY id DESC LIMIT 200
        ");
        $stmt->execute();

        $dataToUse = null;

        // looping through the content
        while($result = $stmt->fetch(PDO::FETCH_OBJ)) {
        	
        	// set the store content
        	$this->storeContent = $result;
        	$this->siteName = $result->client_name;
			$this->siteEmail = $result->client_email;
			$this->siteHost = $result->client_email_host;
			$this->sitePassword = $result->client_email_password;

        	$expl = explode('/', $this->storeContent->account_logo);

        	$this->storeContent->account_logo = $expl[2];

        	// commence the processing
			$subject = $result->subject;
			$dataToUse = $this->generateGeneralMessage($result->message, $subject, $result->template_type);

        	// use the content submitted
        	if(!empty($dataToUse)) {

        		// convert the recipient list to an array
        		$recipient_list = json_decode($result->recipient, true);
        		
    			// submit the data for processing
    			$mailing = $this->cronSendMail($recipient_list, $subject, $dataToUse);

    			// set the mail status to true
    			if($mailing) {
    				$this->dbConn->query("UPDATE emails SET a.email_status='Pending', date_sent=now() WHERE id='{$result->id}'");
    				print "Mails successfully sent\n";
    			}

        	}
        }

	}

	private function cronSendMail($recipient_list, $subject, $message) {

		require $this->rootUrl."/system/libraries/Phpmailer.php";
		require $this->rootUrl."/system/libraries/Smtp.php";

		$mail = new Phpmailer();
		$smtp = new Smtp();

		$config = (Object) array(
			'subject' => $subject,
			'headers' => "From: {$this->siteName} - BookingLog<{$this->siteEmail}> \r\n Content-type: text/html; charset=utf-8",
			'Smtp' => true,
			'SmtpHost' => "{$this->siteHost}",
			'SmtpPort' => '465',
			'SmtpUser' => "{$this->siteEmail}",
			'SmtpPass' => "{$this->sitePassword}",
			'SmtpSecure' => 'ssl'
		);

		$mail->isSMTP();
		$mail->SMTPDebug = 0;
		$mail->Host = $config->SmtpHost;
		$mail->SMTPAuth = true;
		$mail->Username = $config->SmtpUser;
		$mail->Password = $config->SmtpPass;
		$mail->SMTPSecure = $config->SmtpSecure;
		$mail->Port = $config->SmtpPort;

		// set the user from which the email is been sent
		$mail->setFrom("{$this->siteEmail}", $this->siteName .' - BookingLog');

		// loop through the list of recipients for this mail
        foreach($recipient_list as $emailRecipient) {
			$mail->addAddress($emailRecipient['email'], $emailRecipient['fullname']);
		}

		// this is an html message
		$mail->isHTML(true);

		// set the subject and message
		$mail->Subject = $subject;
		$mail->Body    = $message;
		
		// send the email message to the users
		if($mail->send()) {
			return true;
		} else {
 			return false;
		}
	}

}

// create new object
$cronJobs = new Crons;
$cronJobs->loadCommunicationEmails();
$cronJobs->loadEmailRequests();
?>