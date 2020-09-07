<?php
// include some global variables
global $functions, $db, $usersClass;
// if the user is logged in
if($usersClass->logged_InControlled()) {
	$token ="";
	//using the switch case to get the right file to display
	if(isset($SITEURL[1])) {
		//set a variable for the file
		$file = $SITEURL[1];
		// confirm that the file really exists
		if(file_exists(config_item('default_view_path')."{$file}.php")) {
			// include the file if it exists
			include_once config_item('default_view_path')."{$file}.php";
		}
		else {
			// include the dashboard file if the file does not exist
			include_once config_item('default_view_path')."dashboard.php";
		}
	} else {
		// include the dashboard file
		include_once config_item('default_view_path')."dashboard.php";
	}
} else {
	// confirm that the file really exists
	if(is_file(config_item('default_view_path')."login.php")) {
		// if the user is not logged in
		require config_item('default_view_path')."login.php";
	} else {
		// echo the error message
		server_log();
	}
}