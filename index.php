<?php
# set the names of the directories
$system_folder = "system";
$application_folder = "application";

// session_start();

#display errors
error_reporting(E_ALL);
// ini_set("display_errors", 0);
#set new places for my error recordings
ini_set("log_errors","1");
ini_set("error_log", "errors_log");

# Path to the system directory
define('BASEPATH', $system_folder.DIRECTORY_SEPARATOR);
define('APPPATH', $application_folder.DIRECTORY_SEPARATOR);
define('VIEWPATH', $application_folder.DIRECTORY_SEPARATOR);

function forceHttps() {
	if($_SERVER["SERVER_PORT"] !==433 && (empty($_SERVER["HTTPS"]) || $_SERVER["HTTPS"]=="off")) {
		// header("Location: https://dev.".$_SERVER["HTTP_HOST"].'.com'.$_SERVER["REQUEST_URI"]."");
	}
}

forceHttps();

function server_log() {
	print json_encode([
	    "response_code" => 900,
	    "request_request" => $_SERVER['REQUEST_URI'],
	    "route_error" => "Sorry! You are trying to access an invalid route on this server."
	]);
}

/*
	replace array indexes:
	1) fix windows slashes
	2) strip up-tree ../ as possible hack attempts
*/
$URL = STR_REPLACE( ARRAY( '\\', '../'), ARRAY( '/',  '' ), $_SERVER['REQUEST_URI'] );

#strip all forms of get data
IF ($offset = STRPOS($URL, '?')) { $URL = SUBSTR($URL, 0, $offset); } ELSE IF ($offset = STRPOS($URL, '#')) {
	$URL = SUBSTR($URL, 0, $offset);
}

# call the main core function and start processing your document
REQUIRE "system/core/booking.php";

/*
	the path routes below aren't just handy for stripping out
	the REQUEST_URI and looking to see if this is an attempt at
	direct file access, they're also useful for moving uploads,
	creating absolute URI's if needed, etc, etc
*/
$chop = -STRLEN(BASENAME($_SERVER['SCRIPT_NAME']));
define('DOC_ROOT', SUBSTR($_SERVER['SCRIPT_FILENAME'], 0, $chop));
define('URL_ROOT', SUBSTR($_SERVER['SCRIPT_NAME'], 0, $chop));

# strip off the URL root from REQUEST_URI
IF (URL_ROOT != '/') $URL = SUBSTR($URL, STRLEN(URL_ROOT));

# strip off excess slashes
$URL = TRIM($URL, '/');

# 404 if trying to call a real file
IF ( FILE_EXISTS(DOC_ROOT.'/'.$URL) && ($_SERVER['SCRIPT_FILENAME'] != DOC_ROOT.$URL) && ($URL != '') && ($URL != 'Index.php') )
	die(server_log());

/*
	If $url is empty of default value, set action to 'default'
	otherwise, explode $URL into an array
*/
$SITEURL = (($URL == '') || ($URL == 'Index.php') || ($URL == 'Index.html')) ? ARRAY('Index') : EXPLODE('/', html_entity_decode($URL));

/*
	I strip out non word characters from $SITEURL[0] as the include
	which makes sure no other oddball attempts at directory
	manipulation can be done. This means your include's basename
	can only contain a..z, A..Z, 0..9 and underscore!
	
	for example, as root this would make:
	pages/default.php
*/

// call the user logged in class
$bookingClass = load_class('booking', 'models');
$usersClass = load_class('users', 'controllers');
$accessObject = load_class('accesslevel', 'controllers');

// default file to include
$defaultFile = config_item('default_view_path').strtolower(preg_replace('/[^\w_]-/','',$SITEURL[0])).'.php';

# Check the site status
GLOBAL $SITEURL, $session;

// confirm if the first index has been parsed
// however the api api is exempted from this file traversing loop
if(isset($SITEURL[1]) && (!in_array($SITEURL[0], ["api", "auth", "reservation"]))) {

	// default file to include
	$otherFile = config_item('default_view_path').strtolower(preg_replace('/[^\w_]-/','',$SITEURL[1])).'.php';

	// include the file
	if(is_file($otherFile) and file_exists($otherFile)) {
		include($otherFile);
	} elseif(is_file($defaultFile) and file_exists($defaultFile)) {
		include($defaultFile);
	} else {
		server_log();
	}
} 
// confirm if the first index has been parsed
elseif(is_file($defaultFile) and file_exists($defaultFile)) {
	include($defaultFile);
} else {
	server_log();
}
?>