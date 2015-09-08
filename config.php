<?php // Moodle configuration file 
unset($CFG); 
global $CFG; 
$CFG = new stdClass(); 
$CFG->dbtype = 'mysqli'; 
$CFG->dblibrary = 'native'; 
$CFG->dbhost = 'localhost'; 
$CFG->dbname = 'moodle1'; 
$CFG->dbuser = 'root'; 
$CFG->dbpass = 'dontaskagain'; 
$CFG->prefix = 'mdl1_'; 
$CFG->dboptions = array (
  'dbpersist' => 0,
  'dbport' => '',
  'dbsocket' => '', ); 

$CFG->wwwroot = 'http://ilearn.instalearn.co.in'; 
$CFG->dataroot = '/var/www/moodledata'; 
$CFG->admin = 'admin'; 
$CFG->directorypermissions = 0777; 
//$CFG->dbsessions = 0; 
$CFG->logouturl = 'http://instalearn.co.in'; 
require_once(dirname(__FILE__) . '/lib/setup.php'); // There is no php closing tag in this file, 
// it is intentional because it prevents trailing whitespace problems!

