<?php

////////////////////////////////////////////////////////////////////////////////
/// Moodle Theme designed and developed by 3rd Wave Media Ltd. (elearning.3rdwavemedia.com)
////////////////////////////////////////////////////////////////////////////////

$THEME->name = 'ergo';
$THEME->parents = array('base');
$THEME->sheets = array('general');

$THEME->parents_exclude_sheets = array('base'=>array('pagelayout')); /*TODO: Add more if needed*/
////////////////////////////////////////////////////
// An array of stylesheets not to inherit from the
// themes parents
////////////////////////////////////////////////////

$THEME->layouts = array(
    // Most pages - if we encounter an unknown or a missing page type, this one is used.
    'base' => array(
        'file' => 'general.php',
        'regions' => array(),
    ),
    'standard' => array(
        'file' => 'general.php',
        'regions' => array('side-post'),
        'defaultregion' => 'side-post',
        'options' => array('langmenu'=>true),
       
    ),
    // Course page
    'course' => array(
        'file' => 'course.php',
        'regions' => array('side-post'),
        'defaultregion' => 'side-post',
    ),
    // Course page
    'coursecategory' => array(
        'file' => 'general.php',
        'regions' => array('side-post'),
        'defaultregion' => 'side-post',
      
    ),
    'incourse' => array(
        'file' => 'course.php',
        'regions' => array('side-post'),
        'defaultregion' => 'side-post',
        
    ),
    'frontpage' => array(
        'file' => 'frontpage.php',
        'regions' => array( 'side-post'),
        'defaultregion' => 'side-post',
        'options' => array('langmenu'=>true),

    ),
    'admin' => array(
        'file' => 'general.php',
        'regions' => array('side-post'),
        'defaultregion' => 'side-post',
  
    ),
    'mydashboard' => array(
        'file' => 'general.php',
        'regions' => array('side-post'),
        'defaultregion' => 'side-post',
        'options' => array('langmenu'=>true),
    
    ),
    'mypublic' => array(
        'file' => 'general.php',
        'regions' => array('side-post'),
        'defaultregion' => 'side-post',	    
    ),
	
    'login' => array(
        'file' => 'general.php',
        'regions' => array(),   
        'options' => array('langmenu'=>true), 
    ),
	
    // Pages that appear in pop-up windows - no navigation, no blocks, no header.
    'popup' => array(
        'file' => 'general.php',
        'regions' => array(),
        'options' => array('nofooter'=>true, 'nonavbar'=>true, 'noblocks'=>true),
    ),
    // No blocks and minimal footer - used for legacy frame layouts only!
    'frametop' => array(
        'file' => 'general.php',
        'regions' => array(),
        'options' => array('nofooter'=>true, 'noblocks'=>true),
    ),
    // Embeded pages, like iframe embeded in moodleform
    'embedded' => array(
        'file' => 'general.php',
        'regions' => array(),
        'options' => array('nofooter'=>true, 'nonavbar'=>true, 'noblocks'=>true, 'nocustommenu'=>true),
    ),
    // Used during upgrade and install, and for the 'This site is undergoing maintenance' message.
    // This must not have any blocks, and it is good idea if it does not have links to
    // other places - for example there should not be a home link in the footer...
    'maintenance' => array(
        'file' => 'general.php',
        'regions' => array(),
        'options' => array('nofooter'=>true, 'nonavbar'=>true, 'noblocks'=>true,'nocustommenu'=>true),
    ),
    // Should display the content and basic headers only.
    'print' => array(
        'file' => 'general.php',
        'regions' => array(),
        'options' => array('nofooter'=>true, 'nonavbar'=>false, 'noblocks'=>true),
    ),
   
    // The pagelayout used for reports
    'report' => array(
        'file' => 'general.php',
        'regions' => array(),
		'options' => array(/*'nofooter'=>true, 'nonavbar'=>true, 'noblocks'=>true,'nocustommenu'=>true*/),
    ),
);
////////////////////////////////////////////////////
// An array setting the layouts for the theme.
// These are all of the possible layouts in Moodle.
////////////////////////////////////////////////////


//$THEME->csspostprocess = 'mytheme_process_css';
////////////////////////////////////////////////////
// Allows the user to provide the name of a function
// that all CSS should be passed to before being
// delivered.
////////////////////////////////////////////////////

$THEME->enable_dock = true;

////////////////////////////////////////////////////
// An array containing the names of JavaScript files
// located in /javascript/ to include in the theme.
// (gets included in the head)
////////////////////////////////////////////////////

//Add jQuery
$THEME->javascripts_footer = array('jquery.min', 'slides.min.jquery');

////////////////////////////////////////////////////
// As above but will be included in the page footer.
////////////////////////////////////////////////////

$THEME->larrow    = '<';
////////////////////////////////////////////////////
// Overrides the left arrow image used throughout
// Moodle
////////////////////////////////////////////////////

$THEME->rarrow    = '>'; 

////////////////////////////////////////////////////
// Overrides the right arrow image used throughout Moodle
////////////////////////////////////////////////////

// $THEME->parents_exclude_javascripts

////////////////////////////////////////////////////
// An array of JavaScript files NOT to inherit from
// the themes parents
////////////////////////////////////////////////////

// $THEME->plugins_exclude_sheets

////////////////////////////////////////////////////
// An array of plugin sheets to ignore and not
// include.
////////////////////////////////////////////////////

//$THEME->rendererfactory = 'theme_overridden_renderer_factory';

////////////////////////////////////////////////////
// Sets a custom render factory to use with the
// theme, used when working with custom renderers.
////////////////////////////////////////////////////



