<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * Version details
 *
 * @package    theme
 * @subpackage bcu
 * @copyright  2014 Birmingham City University <michael.grant@bcu.ac.uk>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 *
 */

$settings = null;

defined('MOODLE_INTERNAL') || die;
if (is_siteadmin()) {

    $ADMIN->add('themes', new admin_category('theme_bcu', 'BCU'));

    $temp = new admin_settingpage('theme_bcu_colour', get_string('coloursettings', 'theme_bcu'));
    $temp->add(new admin_setting_heading('theme_bcu_colour', get_string('coloursettingsheading', 'theme_bcu'),
        format_text(get_string('colourdesc', 'theme_bcu'), FORMAT_MARKDOWN)));

    $name = 'theme_bcu/linkcolor';
    $title = get_string('linkcolor', 'theme_bcu');
    $description = get_string('linkcolordesc', 'theme_bcu');
    $default = '#001E3C';
    $previewconfig = null;
    $setting = new admin_setting_configcolourpicker($name, $title, $description, $default, $previewconfig);
    $temp->add($setting);

    $name = 'theme_bcu/linkhover';
    $title = get_string('linkhover', 'theme_bcu');
    $description = get_string('linkhoverdesc', 'theme_bcu');
    $default = '#001E3C';
    $previewconfig = null;
    $setting = new admin_setting_configcolourpicker($name, $title, $description, $default, $previewconfig);
    $temp->add($setting);

    $name = 'theme_bcu/maincolor';
    $title = get_string('maincolor', 'theme_bcu');
    $description = get_string('maincolordesc', 'theme_bcu');
    $previewconfig = null;
    $setting = new admin_setting_configcolourpicker($name, $title, $description, '#001E3C', $previewconfig);
    $temp->add($setting);

    $name = 'theme_bcu/backcolor';
    $title = get_string('backcolor', 'theme_bcu');
    $description = get_string('backcolordesc', 'theme_bcu');
    $previewconfig = null;
    $setting = new admin_setting_configcolourpicker($name, $title, $description, '#FFF', $previewconfig);
    $temp->add($setting);
    
    $name = 'theme_bcu/buttoncolour';
    $title = get_string('buttoncolour', 'theme_bcu');
    $description = get_string('buttoncolourdesc', 'theme_bcu');
    $previewconfig = null;
    $setting = new admin_setting_configcolourpicker($name, $title, $description, '#00aeef', $previewconfig);
    $temp->add($setting);
    
    $name = 'theme_bcu/buttonhovercolour';
    $title = get_string('buttonhovercolour', 'theme_bcu');
    $description = get_string('buttonhovercolourdesc', 'theme_bcu');
    $previewconfig = null;
    $setting = new admin_setting_configcolourpicker($name, $title, $description, '#0084c2', $previewconfig);
    $temp->add($setting);
    
    $name = 'theme_bcu/rendereroverlaycolour';
    $title = get_string('rendereroverlaycolour', 'theme_bcu');
    $description = get_string('rendereroverlaycolourdesc', 'theme_bcu');
    $previewconfig = null;
    $setting = new admin_setting_configcolourpicker($name, $title, $description, '#001E3C', $previewconfig);
    $temp->add($setting);
    
    $name = 'theme_bcu/rendereroverlayfontcolour';
    $title = get_string('rendereroverlayfontcolour', 'theme_bcu');
    $description = get_string('rendereroverlayfontcolourdesc', 'theme_bcu');
    $previewconfig = null;
    $setting = new admin_setting_configcolourpicker($name, $title, $description, '#FFF', $previewconfig);
    $temp->add($setting);

    $ADMIN->add('theme_bcu', $temp);

    $temp = new admin_settingpage('theme_bcu_header', get_string('headersettings', 'theme_bcu'));
    $temp->add(new admin_setting_heading('theme_bcu_header', get_string('headersettingsheading', 'theme_bcu'),
        format_text(get_string('headerdesc', 'theme_bcu'), FORMAT_MARKDOWN)));
    
    $name = 'theme_bcu/sitetitle';
    $title = get_string('sitetitle', 'theme_bcu');
    $description = get_string('sitetitledesc', 'theme_bcu');
    $setting = new admin_setting_configcheckbox($name, $title, $description, $default, true, false);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);
        
    $name = 'theme_bcu/logo';
    $title = get_string('logo', 'theme_bcu');
    $description = get_string('logodesc', 'theme_bcu');
    $setting = new admin_setting_configstoredfile($name, $title, $description, 'logo');
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);
    
    $name = 'theme_bcu/alertbox';
    $title = get_string('alertbox', 'theme_bcu');
    $description = get_string('alertboxdesc', 'theme_bcu');
    $default = '';
    $setting = new admin_setting_confightmleditor($name, $title, $description, $default);
    $temp->add($setting);
    
    $temp->add(new admin_setting_heading('theme_bcu_navbar', get_string('navbarsettingsheading', 'theme_bcu'),
        format_text(get_string('navbardesc', 'theme_bcu'), FORMAT_MARKDOWN)));

    // Enable My.
    $name = 'theme_bcu/enablemy';
    $title = get_string('enablemy', 'theme_bcu');
    $description = get_string('enablemydesc', 'theme_bcu');
    $default = true;
    $setting = new admin_setting_configcheckbox($name, $title, $description, $default, true, false);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);

    // Enable View Profile.
    $name = 'theme_bcu/enableprofile';
    $title = get_string('enableprofile', 'theme_bcu');
    $description = get_string('enableprofiledesc', 'theme_bcu');
    $default = true;
    $setting = new admin_setting_configcheckbox($name, $title, $description, $default, true, false);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);

    // Enable Edit Profile.
    $name = 'theme_bcu/enableeditprofile';
    $title = get_string('enableeditprofile', 'theme_bcu');
    $description = get_string('enableeditprofiledesc', 'theme_bcu');
    $default = true;
    $setting = new admin_setting_configcheckbox($name, $title, $description, $default, true, false);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);

    // Enable Calendar.
    $name = 'theme_bcu/enablecalendar';
    $title = get_string('enablecalendar', 'theme_bcu');
    $description = get_string('enablecalendardesc', 'theme_bcu');
    $default = true;
    $setting = new admin_setting_configcheckbox($name, $title, $description, $default, true, false);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);

    // Enable Private Files.
    $name = 'theme_bcu/enableprivatefiles';
    $title = get_string('enableprivatefiles', 'theme_bcu');
    $description = get_string('enableprivatefilesdesc', 'theme_bcu');
    $default = false;
    $setting = new admin_setting_configcheckbox($name, $title, $description, $default, true, false);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);

    // Enable Badges.
    $name = 'theme_bcu/enablebadges';
    $title = get_string('enablebadges', 'theme_bcu');
    $description = get_string('enablebadgesdesc', 'theme_bcu');
    $default = false;
    $setting = new admin_setting_configcheckbox($name, $title, $description, $default, true, false);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);

    // Enable help link.
    $name = 'theme_bcu/enablehelp';
    $title = get_string('enablehelp', 'theme_bcu');
    $description = get_string('enablehelpdesc', 'theme_bcu');
    $setting = new admin_setting_configtext($name, $title, $description, '', PARAM_URL);
    $temp->add($setting);

    $ADMIN->add('theme_bcu', $temp);

    $temp = new admin_settingpage('theme_bcu_frontpage_blocks', get_string('frontpageblocksettings', 'theme_bcu'));
    
    $name = 'theme_bcu/infobox';
    $title = get_string('infobox', 'theme_bcu');
    $description = get_string('infoboxdesc', 'theme_bcu');
    $default = '';
    $setting = new admin_setting_confightmleditor($name, $title, $description, $default);
    $temp->add($setting);

    $name = 'theme_bcu/infobox2';
    $title = get_string('infobox2', 'theme_bcu');
    $description = get_string('infobox2desc', 'theme_bcu');
    $default = '';
    $setting = new admin_setting_confightmleditor($name, $title, $description, $default);
    $temp->add($setting);
    
    $temp->add(new admin_setting_heading('theme_bcu_marketing', get_string('marketingsettingsheading', 'theme_bcu'),
        format_text(get_string('marketingdesc', 'theme_bcu'), FORMAT_MARKDOWN)));

    $name = 'theme_bcu/market1';
    $title = get_string('market1', 'theme_bcu');
    $description = get_string('market1desc', 'theme_bcu');
    $default = '';
    $setting = new admin_setting_confightmleditor($name, $title, $description, $default);
    $temp->add($setting);

    $name = 'theme_bcu/market2';
    $title = get_string('market2', 'theme_bcu');
    $description = get_string('market2desc', 'theme_bcu');
    $setting = new admin_setting_confightmleditor($name, $title, $description, $default);
    $temp->add($setting);

    $name = 'theme_bcu/market3';
    $title = get_string('market3', 'theme_bcu');
    $description = get_string('market3desc', 'theme_bcu');
    $setting = new admin_setting_confightmleditor($name, $title, $description, $default);
    $temp->add($setting);

    $name = 'theme_bcu/market4';
    $title = get_string('market4', 'theme_bcu');
    $description = get_string('market4desc', 'theme_bcu');
    $setting = new admin_setting_confightmleditor($name, $title, $description, $default);
    $temp->add($setting);
    
    $ADMIN->add('theme_bcu', $temp);
    
    $temp = new admin_settingpage('theme_bcu_frontpage_slider', get_string('frontpageslidersettings', 'theme_bcu'));
    
    $temp->add(new admin_setting_heading('theme_bcu_slideshow', get_string('slideshowsettingsheading', 'theme_bcu'),
        format_text(get_string('slideshowdesc', 'theme_bcu'), FORMAT_MARKDOWN)));

    $name = 'theme_bcu/p1';
    $title = get_string('p1', 'theme_bcu');
    $description = get_string('p1desc', 'theme_bcu');
    $setting = new admin_setting_configstoredfile($name, $title, $description, 'p1');
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);

    $name = 'theme_bcu/p1url';
    $title = get_string('p1url', 'theme_bcu');
    $description = get_string('p1urldesc', 'theme_bcu');
    $setting = new admin_setting_configtext($name, $title, $description, '', PARAM_URL);
    $temp->add($setting);

    $name = 'theme_bcu/p1cap';
    $title = get_string('p1cap', 'theme_bcu');
    $description = get_string('p1capdesc', 'theme_bcu');
    $default = '';
    $setting = new admin_setting_confightmleditor($name, $title, $description, $default);
    $temp->add($setting);

    $name = 'theme_bcu/p2';
    $title = get_string('p2', 'theme_bcu');
    $description = get_string('p2desc', 'theme_bcu');
    $setting = new admin_setting_configstoredfile($name, $title, $description, 'p2');
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);

    $name = 'theme_bcu/p2url';
    $title = get_string('p2url', 'theme_bcu');
    $description = get_string('p2urldesc', 'theme_bcu');
    $setting = new admin_setting_configtext($name, $title, $description, '', PARAM_URL);
    $temp->add($setting);

    $name = 'theme_bcu/p2cap';
    $title = get_string('p2cap', 'theme_bcu');
    $description = get_string('p2capdesc', 'theme_bcu');
    $default = '';
    $setting = new admin_setting_confightmleditor($name, $title, $description, $default);
    $temp->add($setting);

    $name = 'theme_bcu/p3';
    $title = get_string('p3', 'theme_bcu');
    $description = get_string('p3desc', 'theme_bcu');
    $setting = new admin_setting_configstoredfile($name, $title, $description, 'p3');
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);

    $name = 'theme_bcu/p3url';
    $title = get_string('p3url', 'theme_bcu');
    $description = get_string('p3urldesc', 'theme_bcu');
    $setting = new admin_setting_configtext($name, $title, $description, '', PARAM_URL);
    $temp->add($setting);

    $name = 'theme_bcu/p3cap';
    $title = get_string('p3cap', 'theme_bcu');
    $description = get_string('p3capdesc', 'theme_bcu');
    $default = '';
    $setting = new admin_setting_confightmleditor($name, $title, $description, $default);
    $temp->add($setting);

    $name = 'theme_bcu/p4';
    $title = get_string('p4', 'theme_bcu');
    $description = get_string('p4desc', 'theme_bcu');
    $setting = new admin_setting_configstoredfile($name, $title, $description, 'p4');
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);

    $name = 'theme_bcu/p4url';
    $title = get_string('p4url', 'theme_bcu');
    $description = get_string('p4urldesc', 'theme_bcu');
    $setting = new admin_setting_configtext($name, $title, $description, '', PARAM_URL);
    $temp->add($setting);

    $name = 'theme_bcu/p4cap';
    $title = get_string('p4cap', 'theme_bcu');
    $description = get_string('p4capdesc', 'theme_bcu');
    $default = '';
    $setting = new admin_setting_confightmleditor($name, $title, $description, $default);
    $temp->add($setting);

    $name = 'theme_bcu/p5';
    $title = get_string('p5', 'theme_bcu');
    $description = get_string('p5desc', 'theme_bcu');
    $setting = new admin_setting_configstoredfile($name, $title, $description, 'p5');
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);

    $name = 'theme_bcu/p5url';
    $title = get_string('p5url', 'theme_bcu');
    $description = get_string('p5urldesc', 'theme_bcu');
    $setting = new admin_setting_configtext($name, $title, $description, '', PARAM_URL);
    $temp->add($setting);

    $name = 'theme_bcu/p5cap';
    $title = get_string('p5cap', 'theme_bcu');
    $description = get_string('p5capdesc', 'theme_bcu');
    $default = '';
    $setting = new admin_setting_confightmleditor($name, $title, $description, $default);
    $temp->add($setting);
        
    $ADMIN->add('theme_bcu', $temp);
    
    $temp = new admin_settingpage('theme_bcu_frontpage_courses', get_string('frontpagecoursesettings', 'theme_bcu'));
    $temp->add(new admin_setting_heading('theme_bcu_frontpage_courses', get_string('frontpagesettingsheading', 'theme_bcu'),
        format_text(get_string('frontpagedesc', 'theme_bcu'), FORMAT_MARKDOWN))); 
    
    $name = 'theme_bcu/frontpagerenderer';
    $title = get_string('frontpagerenderer', 'theme_bcu');
    $description = get_string('frontpagerendererdesc', 'theme_bcu');
    $choices = array(
        1 => get_string('frontpagerendereroption1', 'theme_bcu'),
        2 => get_string('frontpagerendereroption2', 'theme_bcu'),
    );
    $setting = new admin_setting_configselect($name, $title, $description, 2, $choices);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);
    
    $name = 'theme_bcu/frontpagerendererdefaultimage';
    $title = get_string('frontpagerendererdefaultimage', 'theme_bcu');
    $description = get_string('frontpagerendererdefaultimagedesc', 'theme_bcu');
    $setting = new admin_setting_configstoredfile($name, $title, $description, 'frontpagerendererdefaultimage');
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);
                
    $ADMIN->add('theme_bcu', $temp);

    $temp = new admin_settingpage('theme_bcu_footer', get_string('footersettings', 'theme_bcu'));
    $temp->add(new admin_setting_heading('theme_bcu_footer', get_string('footersettingsheading', 'theme_bcu'),
        format_text(get_string('footerdesc', 'theme_bcu'), FORMAT_MARKDOWN)));

    $name = 'theme_bcu/footer1header';
    $title = get_string('footer1header', 'theme_bcu');
    $description = get_string('footer1desc', 'theme_bcu');
    $default = '';
    $setting = new admin_setting_configtext($name, $title, $description, $default);
    $temp->add($setting);

    $name = 'theme_bcu/footer1content';
    $title = get_string('footer1content', 'theme_bcu');
    $description = get_string('footer1contentdesc', 'theme_bcu');
    $default = '';
    $setting = new admin_setting_confightmleditor($name, $title, $description, $default);
    $temp->add($setting);

    $name = 'theme_bcu/footer2header';
    $title = get_string('footer2header', 'theme_bcu');
    $description = get_string('footer2desc', 'theme_bcu');
    $default = '';
    $setting = new admin_setting_configtext($name, $title, $description, $default);
    $temp->add($setting);

    $name = 'theme_bcu/footer2content';
    $title = get_string('footer2content', 'theme_bcu');
    $description = get_string('footer2contentdesc', 'theme_bcu');
    $default = '';
    $setting = new admin_setting_confightmleditor($name, $title, $description, $default);
    $temp->add($setting);

    $name = 'theme_bcu/footer3header';
    $title = get_string('footer3header', 'theme_bcu');
    $description = get_string('footer3desc', 'theme_bcu');
    $default = '';
    $setting = new admin_setting_configtext($name, $title, $description, $default);
    $temp->add($setting);

    $name = 'theme_bcu/footer3content';
    $title = get_string('footer3content', 'theme_bcu');
    $description = get_string('footer3contentdesc', 'theme_bcu');
    $default = '';
    $setting = new admin_setting_confightmleditor($name, $title, $description, $default);
    $temp->add($setting);

    $name = 'theme_bcu/footer4header';
    $title = get_string('footer4header', 'theme_bcu');
    $description = get_string('footer4desc', 'theme_bcu');
    $default = '';
    $setting = new admin_setting_configtext($name, $title, $description, $default);
    $temp->add($setting);

    $name = 'theme_bcu/footer4content';
    $title = get_string('footer4content', 'theme_bcu');
    $description = get_string('footer4contentdesc', 'theme_bcu');
    $default = '';
    $setting = new admin_setting_confightmleditor($name, $title, $description, $default);
    $temp->add($setting);
    
    $name = 'theme_bcu/footnote';
    $title = get_string('footnote', 'theme_bcu');
    $description = get_string('footnotedesc', 'theme_bcu');
    $setting = new admin_setting_confightmleditor($name, $title, $description, $default);
    $temp->add($setting);

    $ADMIN->add('theme_bcu', $temp);

    $temp = new admin_settingpage('theme_bcu_generic', get_string('customcssjssettings', 'theme_bcu'));
    $temp->add(new admin_setting_heading('theme_bcu_generic', get_string('genericsettingsheading', 'theme_bcu'),
        format_text(get_string('genericsettingsdescription', 'theme_bcu'), FORMAT_MARKDOWN)));

    // Custom CSS file.
    $name = 'theme_bcu/customcss';
    $title = get_string('customcss', 'theme_bcu');
    $description = get_string('customcssdesc', 'theme_bcu');
    $default = '';
    $setting = new admin_setting_configtextarea($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);

    // Section for javascript to be added e.g. Google Analytics.
    $name = 'theme_bcu/jssection';
    $title = get_string('jssection', 'theme_bcu');
    $description = get_string('jssectiondesc', 'theme_bcu');
    $default = '';
    $setting = new admin_setting_configtextarea($name, $title, $description, $default);
    $temp->add($setting);

    $name = 'theme_bcu/fsize';
    $title = get_string('fsize', 'theme_bcu');
    $description = get_string('fsizedesc', 'theme_bcu');
    $setting = new admin_setting_configtext($name, $title, $description, '');
    $temp->add($setting);

    $ADMIN->add('theme_bcu', $temp);
}
