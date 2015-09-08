<?php
 
/**
 * Theme Settings
 */

defined('MOODLE_INTERNAL') || die;

if ($ADMIN->fulltree) {
 
// Logo file setting
$name = 'theme_ergo/logo';
$title = get_string('logo','theme_ergo');
$description = get_string('logodesc', 'theme_ergo');
$setting = new admin_setting_configtext($name, $title, $description, '', PARAM_URL);
$settings->add($setting); 

// Header widget setting
$name = 'theme_ergo/headerwidget';
$title = get_string('headerwidget','theme_ergo');
$description = get_string('headerwidgetdesc', 'theme_ergo');
$setting = new admin_setting_confightmleditor($name, $title, $description, '');
$settings->add($setting); 

// Footer widget setting
$name = 'theme_ergo/footerwidget';
$title = get_string('footerwidget','theme_ergo');
$description = get_string('footerwidgetdesc', 'theme_ergo');
$setting = new admin_setting_confightmleditor($name, $title, $description, '');
$settings->add($setting);

/* Slideshow Widget Settings */

/* 
* Slide 1 
*/

// Image
$name = 'theme_ergo/slide1';
$title = get_string('slide1','theme_ergo');
$description = get_string('slide1desc', 'theme_ergo');
$setting = new admin_setting_configtext($name, $title, $description, '', PARAM_URL);
$settings->add($setting); 

// Caption
$name = 'theme_ergo/slide1caption';
$title = get_string('slide1caption','theme_ergo');
$description = get_string('slide1captiondesc', 'theme_ergo');
$setting = new admin_setting_configtext($name, $title, $description, '');
$settings->add($setting); 

// URL
$name = 'theme_ergo/slide1url';
$title = get_string('slide1url','theme_ergo');
$description = get_string('slide1urldesc', 'theme_ergo');
$setting = new admin_setting_configtext($name, $title, $description, '', PARAM_URL);
$settings->add($setting); 


/* 
* Slide 2 
*/

// Image
$name = 'theme_ergo/slide2';
$title = get_string('slide2','theme_ergo');
$description = get_string('slide2desc', 'theme_ergo');
$setting = new admin_setting_configtext($name, $title, $description, '', PARAM_URL);
$settings->add($setting); 

// Caption
$name = 'theme_ergo/slide2caption';
$title = get_string('slide2caption','theme_ergo');
$description = get_string('slide2captiondesc', 'theme_ergo');
$setting = new admin_setting_configtext($name, $title, $description, '');
$settings->add($setting); 

// URL
$name = 'theme_ergo/slide2url';
$title = get_string('slide2url','theme_ergo');
$description = get_string('slide2urldesc', 'theme_ergo');
$setting = new admin_setting_configtext($name, $title, $description, '', PARAM_URL);
$settings->add($setting); 


/* 
* Slide 3 
*/

// Image
$name = 'theme_ergo/slide3';
$title = get_string('slide3','theme_ergo');
$description = get_string('slide3desc', 'theme_ergo');
$setting = new admin_setting_configtext($name, $title, $description, '', PARAM_URL);
$settings->add($setting); 

// Caption
$name = 'theme_ergo/slide3caption';
$title = get_string('slide3caption','theme_ergo');
$description = get_string('slide3captiondesc', 'theme_ergo');
$setting = new admin_setting_configtext($name, $title, $description, '');
$settings->add($setting); 

// URL
$name = 'theme_ergo/slide3url';
$title = get_string('slide3url','theme_ergo');
$description = get_string('slide3urldesc', 'theme_ergo');
$setting = new admin_setting_configtext($name, $title, $description, '', PARAM_URL);
$settings->add($setting); 


/* 
* Slide 4
*/

//Image
$name = 'theme_ergo/slide4';
$title = get_string('slide4','theme_ergo');
$description = get_string('slide4desc', 'theme_ergo');
$setting = new admin_setting_configtext($name, $title, $description, '', PARAM_URL);
$settings->add($setting); 


// Caption
$name = 'theme_ergo/slide4caption';
$title = get_string('slide4caption','theme_ergo');
$description = get_string('slide4captiondesc', 'theme_ergo');
$setting = new admin_setting_configtext($name, $title, $description, '');
$settings->add($setting); 

// URL
$name = 'theme_ergo/slide4url';
$title = get_string('slide4url','theme_ergo');
$description = get_string('slide4urldesc', 'theme_ergo');
$setting = new admin_setting_configtext($name, $title, $description, '', PARAM_URL);
$settings->add($setting); 


}