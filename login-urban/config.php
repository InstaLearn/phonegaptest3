<?php  // Urban Login configuration file

/*
------------------------------------------------------


	URBAN - Moodle Alternate Login 
	by Inserver Elearning Factory
	http://www.inserver.es


------------------------------------------------------
----------------- CONFIGURATION FILE -----------------
------------------------------------------------------
*/


unset($URBAN);
global $URBAN;
global $CFG;
$URBAN = new stdClass();

/* get moodle config */
define('__LOGINROOT__', dirname(dirname(__FILE__))); 
require_once(__LOGINROOT__ . '/config.php');


/* STRINGS: */
// 1 - Page title
$URBAN->str_title = 'Urban - Alternate LMS login for Moodle';

// 2 - Invalid error message
//	2.a - Use Moodle lang string:
$URBAN->str_loginerror = get_string("invalidlogin");
//	2.b - Use your own string:
// $URBAN->str_loginerror = 'My own login error string';

// 3 - Username text
//	3.a - Use Moodle lang string:
if (empty($CFG->authloginviaemail)) {
    $URBAN->str_username = get_string('username');
} else {
    $URBAN->str_username = get_string('usernameemail');
}
//	3.b - Use your own string:
// $URBAN->str_username = 'My own username string';

// 4 - Password text
//	4.a - Use Moodle lang string:
$URBAN->str_password = get_string("password");
//	4.b - Use your own string:
//$URBAN->str_password = 'My own password string';


// 5 - Log in button caption
//	5.a - Use Moodle lang string:
$URBAN->str_loginbtn = get_string("login");
//	5.b - Use your own string:
//$URBAN->str_loginbtn = 'My own login string';


// 6 - Remember username text
//	6.a - Use Moodle lang string:
$URBAN->str_remember = get_string('rememberusername', 'admin');
//	6.b - Use your own string:
//$URBAN->str_remember = 'My own remember username string';


// 7 - Forgotten pass text
//	7.a - Use Moodle lang string:
$URBAN->str_forgotten = get_string("forgotten");
//	7.b - Use your own string:
//$URBAN->str_forgotten = 'My own forgotten password string';

/* Enable/Disable image carousel:
$URBAN->carousel = 1; // carousel enabled
$URBAN->carousel = 0; // carousel disabled (fixed image)
*/
$URBAN->carousel = 1;

/* Enable/Disable disclaimer:
$URBAN->show_disclaimer = 1; // disclaimer is visible
$URBAN->show_disclaimer = 0; // disclaimer is hidden
*/
$URBAN->show_disclaimer = 1;

/* Default course redirect:
$URBAN->default_course_redirect = 0; // Frontpage or My, as set in Moodle config.
$URBAN->show_disclaimer = X; // makes default page the course with id = X
*/
$URBAN->default_course_redirect = 8;


/* Header colors and opacity
	URBAN Default: 
	$URBAN->headerbgcolor = '#E3E3E3';
	$URBAN->headerbgcolor_o = 0.9;
*/

$URBAN->headerbgcolor = '#E3E3E3';
$URBAN->headerbgcolor_o = 0.9;


/* Header border bottom color
	URBAN Default: 
	$URBAN->headerbordercolor = '#BBBBBB';
*/

$URBAN->headerbordercolor = '#BBBBBB';

/* Form colors and opacity
	
	URBAN Default: 
	$URBAN->formbgcolor = '#F1F1F1';
	$URBAN->formbgcolor_o = 0.9;
*/

$URBAN->formbgcolor = '#F1F1F1';
$URBAN->formbgcolor_o = 0.9;

/*	Login button colors
	URBAN Default: 

	$URBAN->buttontextcolor = '#ffffff';
	$URBAN->buttonbgcolor = '#333333';

	$URBAN->buttonhovertextcolor = '#ffffff';
	$URBAN->buttonhoverbgcolor = '#ff6600';
*/
$URBAN->buttontextcolor = '#ffffff';
$URBAN->buttonbgcolor = '#333333';

$URBAN->buttonhovertextcolor = '#ffffff';
$URBAN->buttonhoverbgcolor = '#ff6600';

/* Footer colors and opacity
	HEX 
	URBAN Default: 

	$URBAN->footerbgcolor = '#E3E3E3';
	$URBAN->footerbgcolor_o = 0.9;
*/

	$URBAN->footerbgcolor = '#E3E3E3';
	$URBAN->footerbgcolor_o = 0.9;

/* footer colors
	URBAN Default: 

	$URBAN->footerbordercolor = '#BBBBBB';
	$URBAN->footertextcolor = '#333333';
	$URBAN->footerhovertextcolor = '#ff6600';
*/
$URBAN->footerbordercolor = '#BBBBBB';
$URBAN->footertextcolor = '#333333';
$URBAN->footerhovertextcolor = '#ff6600';

?>