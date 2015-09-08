<?php
$hasheading = ($PAGE->heading);
$hasnavbar = (empty($PAGE->layout_options['nonavbar']) && $PAGE->has_navbar());
$hasfooter = (empty($PAGE->layout_options['nofooter']));
$hassidepre = (empty($PAGE->layout_options['noblocks']) && $PAGE->blocks->region_has_content('side-pre', $OUTPUT));
$hassidepost = (empty($PAGE->layout_options['noblocks']) && $PAGE->blocks->region_has_content('side-post', $OUTPUT));
$haslogininfo = (empty($PAGE->layout_options['nologininfo']));
$showsidepre = ($hassidepre && !$PAGE->blocks->region_completely_docked('side-pre', $OUTPUT));
$showsidepost = ($hassidepost && !$PAGE->blocks->region_completely_docked('side-post', $OUTPUT));
$haslangmenu = (!empty($PAGE->layout_options['langmenu']));
$custommenu = $OUTPUT->custom_menu();
$hascustommenu = (empty($PAGE->layout_options['nocustommenu']) && !empty($custommenu));

$bodyclasses = array();
if ($showsidepre && !$showsidepost) {
    $bodyclasses[] = 'side-pre-only';
} else if ($showsidepost && !$showsidepre) {
    $bodyclasses[] = 'side-post-only';
} else if (!$showsidepost && !$showsidepre) {
    $bodyclasses[] = 'content-only';
}
if ($hascustommenu) {
    $bodyclasses[] = 'has_custom_menu';
}

/* 
* Theme Settings 
*/
$haslogo = (!empty($PAGE->theme->settings->logo));
$hasheaderwidget = (!empty($PAGE->theme->settings->headerwidget));
$hasfooterwidget = (!empty($PAGE->theme->settings->footerwidget));

/* Logo settings */
if ($haslogo) {
$logourl = $PAGE->theme->settings->logo;
} else {
$logourl = $OUTPUT->pix_url('logo', 'theme');
}

/* Headerwidget settings */
if ($hasheaderwidget) {
$headerwidget = $PAGE->theme->settings->headerwidget;
} else {
$headerwidget = '<!-- There was no custom headerwidget content set -->';
}

/* Footerwidget settings */
if (!empty($PAGE->theme->settings->footerwidget)) {
$footerwidget = $PAGE->theme->settings->footerwidget;
} else {
$footerwidget = '<!-- There was no custom footerwidget content set -->';
}
echo $OUTPUT->doctype() ?>
<html <?php echo $OUTPUT->htmlattributes() ?>>
<head>
    <title><?php echo $PAGE->title ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <link rel="shortcut icon" href="<?php echo $OUTPUT->pix_url('favicon', 'theme')?>" />
    <meta name="description" content="" />
    <meta name="author" content="Moodle Theme by 3rd Wave Media Ltd, UK | elearning.3rdwavemedia.com" /> 
    <link href='http://fonts.googleapis.com/css?family=Droid+Serif' rel='stylesheet' type='txt/css'>
    <?php echo $OUTPUT->standard_head_html() ?>
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    
</head>
<body id="<?php p($PAGE->bodyid) ?>" class="<?php p($PAGE->bodyclasses.' '.join(' ', $bodyclasses)) ?> ">
<?php echo $OUTPUT->standard_top_of_body_html() ?>
<div id="page">

     <?php if ($hasheading || $hasnavbar) { ?>
	 <div id="page-header">
        <div id="page-header-inner">    

            <?php if ($PAGE->heading) { ?>     
            <?php //THEME SETTING - DEFINE LOGO ?> 
            <h1 id="logo"><a href="<?php echo $CFG->wwwroot ?>"><img src="<?php echo $logourl;?>" alt="Logo" /></a></h1>    
            
                        
            <?php } ?>
            
            <?php //THEME SETTING - DEFINE HEADER WIDGET CONTENT ?>          
            <div class="headerwidget"><?php echo $headerwidget; ?></div>
            
            <div class="headermenu">                      
            
                <?php  
                
                 
                
                if ($haslogininfo) {
                    
                    echo "<div id='toplogin-wrapper'>";
                                        
                    //Print login info below
                    echo $OUTPUT->login_info();
                    
                    //Print user profile image below                   
                    echo  "<div id='profilepic'>";
            		if (!isloggedin() or isguestuser()) {
            			echo '<a href="'.$CFG->wwwroot.'/user/view.php?id='.$USER->id.'&amp;course='.$COURSE->id.'"><img src="'.$CFG->wwwroot.'/user/pix.php?file=/'.$USER->id.'/f2.jpg" width="20px" height="20px" title="Guest" alt="Guest" /></a>';
            		}else{
            			echo '<a href="'.$CFG->wwwroot.'/user/view.php?id='.$USER->id.'&amp;course='.$COURSE->id.'"><img src="'.$CFG->wwwroot.'/user/pix.php?file=/'.$USER->id.'/f2.jpg" width="20px" height="20px" title="'.$USER->firstname.' '.$USER->lastname.'" alt="'.$USER->firstname.' '.$USER->lastname.'" /></a>';
            		}
            		echo "</div>";  
                    
                    echo "</div>"; //end of toplogin-wrapper
                }
                
                if ($haslangmenu) {
                    echo $OUTPUT->lang_menu();
                }    
                     
                                 
                /*$PAGE->headingmenu:This heading menu is special HTML that the page you are viewing wants to add. It can be anything from drop down boxes to buttons and any number of each.*/
                echo $PAGE->headingmenu
                ?>            
            </div><!--//headermenu-->
		</div><!--//#page-header-inner-->       
        
    </div><!-- END OF HEADER -->
          <?php } ?>     
        
                 
        

    <div id="page-content">
        <?php if ($hascustommenu) { ?>
        <a id="mobile-custommenu-toggle" href="#">Menu</a>
        <div id="custommenu"><?php echo $custommenu; ?></div>
        <?php } ?>
         <?php if ($hasnavbar) { ?>
            <div class="navbar">               
                    <div class="breadcrumb"><?php echo $OUTPUT->navbar(); ?></div>
                    <div class="navbutton"> <?php echo $PAGE->button; ?></div>
                </div><!--//navbar-inner-->
          
         <?php } ?>   
        <div id="region-main-box">
            <div id="region-post-box">
                <div id="region-main-wrap">
                    <div id="region-main">
                        <div class="region-content"> 						
                            <?php echo core_renderer::MAIN_CONTENT_TOKEN ?>
                        </div>
                    </div>
                </div>

                <?php if ($hassidepre) { ?>
                <div id="region-pre" class="block-region">	
                    <div class="region-content">
                        <?php echo $OUTPUT->blocks_for_region('side-pre') ?>
                    </div>
                </div>
                <?php } ?>

                <?php if ($hassidepost) { ?>
                <div id="region-post" class="block-region">
                    <div class="region-content">
                        <?php echo $OUTPUT->blocks_for_region('side-post') ?>
                    </div>
                </div>
                <?php } ?>
            </div>
        </div>
    </div><!--//#page-content-->

<!-- START OF FOOTER -->
    <?php if ($hasfooter) { ?>
    <div id="page-footer" class="clearfix">
        <?php
        echo $OUTPUT->login_info();
        echo $OUTPUT->standard_footer_html();
        ?>
        
        <?php //THEME SETTING - DEFINE FOOTER WIDGET CONTENT ?>
        <div class="footerwidget"><?php echo $footerwidget; ?></div>
        
    </div>
    <?php } ?>
</div>
<?php echo $OUTPUT->standard_end_of_body_html() ?>
<script type="text/javascript">
  $.noConflict();
  jQuery(document).ready(function($) {
   
        /* Mobile menu */
        var $custommenu = $('#custommenu');
        var $custommenuItem = $('#custommenu li');
        var $mobileMenuToggle = $('#mobile-custommenu-toggle');
        
        
        $mobileMenuToggle.on('click', function(e) {
            e.preventDefault();
            $custommenu.slideToggle();	    
        });
        
        //Close the menu after clicking a menu item
        $custommenuItem.on('click', function() {
            if ($mobileMenuToggle.is(':visible')) {
        	    $mobileMenuToggle.trigger('click');
            }
        });
        
        $(window).resize(function(){
            if ( $(window).width() >= 768 ){
                $custommenu.show();
                $('#custommenu li').css({
                    'width': 'auto !important',
                    'height': 'auto !important'
                });
            };
            if ( $(window).width() <= 768 ){
                $custommenu.hide();           
            };
        });
  
	
  });
</script>
</body>
</html>