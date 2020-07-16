<?php 
#call the GLOBAL function 
GLOBAL $SITEURL, $session, $config;

header("content-type: application/json");

// confirm that the fist index has been set
if(confirm_url_id(1)) {
    
    // set the response
	$response = (Object) [
		'status' => 203,
		'result' => 'Error processing request'
	];

	// add some libraries
	$forms = load_class('form_validation', 'libraries');
	$auth = load_class('authenticate', 'controllers');

	$password_ErrorMessage = "<div class='alert alert-danger' style='width:100%'>Sorry! Please use a stronger password. <br><strong>Password Format</strong><br><ul>
			<li style='padding-left:15px;'>Password should be at least 8 characters long</li>
			<li style='padding-left:15px;'>At least 1 Uppercase</li>
			<li style='padding-left:15px;'>At least 1 Lowercase</li>
			<li style='padding-left:15px;'>At least 1 Numeric</li>
			<li style='padding-left:15px;'>At least 1 Special Character</li></ul></div>";

	// confirm that the user has submitted the login form
	if(confirm_url_id(1, "login")) {

		// confirm that all the form fields was submitted assign variables
		if(isset($_POST["username"], $_POST["password"])) {

			// assign variables and clean them
			$username = xss_clean($_POST["username"]);
			$password = xss_clean($_POST["password"]);
			$href = isset($_POST["href"]) ? xss_clean($_POST["href"]) : "";

			// validate the form
			if(!$forms->min_length($username, 5)) {
				$response->result = "Sorry! Invalid username/password";
			} elseif(!$forms->min_length($password, 8)) {
				$response->result = "Sorry! Invalid username/password";
			} else {	
				// submit credentials to the users class to process
				if($auth->processLogin($username, $password, $href)->status) {
					$response->result = $auth->success_response;
					$response->status = 200;
					$response->reload = true;
					$response->href = $config->base_url('dashboard');
				} else {
					$response->result = $auth->error_response;
				}
			}

		}

	}

	// confirm that the user wants to reset his or her password
	elseif(confirm_url_id(1, "recover")) {

		// confirm that the email field was submitted
		if(isset($_POST["email"])) {

			// set a variable
			$email = xss_clean($_POST["email"]);

			// validate the email address
			if(!$forms->valid_email($email)) {
				$response->result = "Sorry! We could not validate your email address!";
			} else {
				// continue to process the form
				if($auth->sendPasswordResetToken($email)) {
					$response->result = "Please check your email for steps to reset password.";
					$response->status = 200;
					$response->reload = true;
					$response->href = $config->base_url('login');
				} else {
					$response->result = "Sorry! We could not validate your email address!";
				}
			}
		} else {
			$response->result = "Sorry! Please enter your email address to continue!";
		}

	}

	// confirm if the user wants to reset his or her password
	elseif(confirm_url_id(1, "reset")) {

		// confirm that all the fields has been parsed
		if(isset($_POST["password"]) and isset($_POST["password2"]) and isset($_POST["user_guid"])) {

			// assign variables to the passwords
			$password = xss_clean($_POST["password"]);
			$password2 = xss_clean($_POST["password2"]);
			$access_token = base64_decode(xss_clean($_POST["access_token"]));
			$access_session = $session->get("resetAccess_Token");
			$reset_token = $session->get("resetAccess_Token");
			$username = $session->get("userName");
			$user_id = $session->get("resetUserId");
			$user_id_parsed = base64_decode($_POST["user_guid"]);

			// confirm that the user id matches what we have in the session
			if($access_token != $access_session) {
				$response->result = "Sorry! A Session Access Token forgery has been detected. Reload the page to continue.";
			} elseif($user_id_parsed != $user_id) {
				$response->result = "Sorry! A Session Access Token forgery has been detected. Reload the page to continue.";
			} else {
				// confirm that the password is a bit strong
				if($password != $password2) {
					$response->result = "Sorry! The passwords do not match!";
				} elseif(!passwordTest($password)) {
					print "$password_ErrorMessage";
				} else {
					
					// do update the password and print out success message
					// continue to process the form
					if($auth->resetUserPassword($password, $user_id, $username, $reset_token)) {
						$response->result = "Your password was successfully changed.";
						$response->status = 200;
						$response->reload = true;
						$response->href = $config->base_url('login');
					} else {
						$response->result = "Sorry! We could not validate the information that was submitted for processing.";
					}
				}
			}
		}
	}

	// confirm that the user wants to logout of the system
	elseif(confirm_url_id(1, "logout")) {

		// destroy all sessions that has been set
		$session->destroy();

		// set the session logout to true
		$session->set("logoutOk", true);
	}

	// contact number session
	elseif(confirm_url_id(1, "reserve")) {
		// contact number is parsed
		if(isset($_POST["payload"]) && (strlen($_POST["payload"]) > 9) && (strlen($_POST["payload"]) < 13)) {
			// verify
			if(preg_match("/^[+0-9]+$/", $_POST["payload"])) {
				// set the contact number in a cookie
				set_cookie("loggedInUser", xss_clean($_POST["payload"]), (60*60*48), "", "/");
				
				// save the contact number in a session
				$session->loggedInUser = $_POST["payload"];

				// success response
				$response->result = "Contact number saved.";
				$response->status = 200;
			}
		}
	}

	echo json_encode($response);

} else {
	show_error('Page Not Found', 'Sorry the page you are trying to view does not exist on this server', 'error_404');
}

?>