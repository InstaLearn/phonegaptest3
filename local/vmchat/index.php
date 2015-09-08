<?php
// This file is part of Moodle - http://vidyamantra.com/
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
 * vmchat footer chat module
 *
 * @package    local
 * @subpackage vmchat
 * @copyright  2014 Pinky Sharma
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once('../../config.php');
require_once($CFG->libdir.'/adminlib.php');
require_once('form.php');

require_login();
require_capability('moodle/site:config', context_system::instance());
admin_externalpage_setup('vmchat');

$PAGE->set_url(new moodle_url('/local/vmchat/index.php'));

$value = 0;
$value = get_config('local_vmchat', 'enablevmchat');
$jqhandle = get_config('local_vmchat', 'jqhandle');
$mform = new local_vmchat_form(null, array('enablevmchat' => $value, 'jqhandle' => $jqhandle));
$statusmsg = '';
$errormsg = '';

if ($fromform = $mform->get_data()) {

    $enablevmchat = isset($fromform->enablevmchat) ? $fromform->enablevmchat : 0;
    $jqhandle = isset($fromform->jqhandle) ? $fromform->jqhandle : 0;

    if(!set_config('jqhandle', $jqhandle, 'local_vmchat')){
        $errormsg = get_string('changesnotsaved', 'local_vmchat');
    }
    if (!set_config('enablevmchat', $enablevmchat, 'local_vmchat')) {
        $errormsg = get_string('changesnotsaved', 'local_vmchat');
    } else {
        $statusmsg = get_string('changessaved');
    }

    preg_match("/<!-- fcStart -->.*<!-- fcEnd -->/", $CFG->additionalhtmlhead, $m);// Check header already exist.
    //if (!empty($fromform->enablevmchat) && empty($m)) {
    if (!empty($fromform->enablevmchat)) {
        if($fromform->enablevmchat != $value){
        // Footer part.
        $sql = "UPDATE {config} SET value = concat(value, "
                . "'<div id=\"stickycontainer\"></div>') WHERE name = 'additionalhtmlfooter'";
        $DB->execute($sql);
        }
        // Header part.
        // Remove header html.
        $additionalhtmlhead = preg_replace("/<!-- fcStart -->.*<!-- fcEnd -->/", "", $CFG->additionalhtmlhead);
        set_config('additionalhtmlhead', $additionalhtmlhead);
        if(!empty($fromform->jqhandle)){
            // Add header html.
            $fstring = '<!-- fcStart --><script language = "JavaScript"> var wwwroot="'.$CFG->wwwroot.'/";</script><script type="text/javascript" src = "'.$CFG->wwwroot.'/local/vmchat/bundle/chat/bundle/jquery/jquery-ui.min.js"></script><script type="text/javascript" src = "'.$CFG->wwwroot.'/local/vmchat/auth.php"></script><script type="text/javascript" src = "'.$CFG->wwwroot.'/local/vmchat/bundle/chat/bundle/io/build/iolib.min.js"></script><script type="text/javascript" src = "'.$CFG->wwwroot.'/local/vmchat/bundle/chat/build/chat.min.js"></script><script type="text/javascript" src = "'.$CFG->wwwroot.'/local/vmchat/index.js"></script><!-- fcEnd -->';

        }else{
            // Add header html.
            $fstring = '<!-- fcStart --><script language = "JavaScript"> var wwwroot="'.$CFG->wwwroot.'/";</script><script type="text/javascript" src = "'.$CFG->wwwroot.'/local/vmchat/bundle/chat/bundle/jquery/jquery-1.11.0.min.js"></script><script type="text/javascript">$=jQuery.noConflict( );</script><script type="text/javascript" src = "'.$CFG->wwwroot.'/local/vmchat/bundle/chat/bundle/jquery/jquery-ui.min.js"></script><script type="text/javascript" src = "'.$CFG->wwwroot.'/local/vmchat/auth.php"></script><script type="text/javascript" src = "'.$CFG->wwwroot.'/local/vmchat/bundle/chat/bundle/io/build/iolib.min.js"></script><script type="text/javascript" src = "'.$CFG->wwwroot.'/local/vmchat/bundle/chat/build/chat.min.js"></script><script type="text/javascript" src = "'.$CFG->wwwroot.'/local/vmchat/index.js"></script><!-- fcEnd -->';

        }
        $DB->execute('UPDATE {config} set value = concat(value, :fstring) WHERE  name = :hname',
                array( 'fstring' => $fstring, 'hname' => 'additionalhtmlhead'));
    }

    // Disable vmchat.
    if (empty($fromform->enablevmchat)) {
        // Remove footer div.
        $sql = "UPDATE {config} set value = replace(value, '<div id=\"stickycontainer\"></div>','') "
                . "where value LIKE '%<div id=\"stickycontainer\"></div>%' and name='additionalhtmlfooter'";
        $DB->execute($sql);

        // Remove header html.
        $additionalhtmlhead = preg_replace("/<!-- fcStart -->.*<!-- fcEnd -->/", "", $CFG->additionalhtmlhead);
        set_config('additionalhtmlhead', $additionalhtmlhead);

        set_config('jqhandle', 0, 'local_vmchat');
    }
    unset($fromform->enablevmchat);
    purge_all_caches();
}

echo $OUTPUT->header();

// Api key exist in db.
if (!get_config('local_getkey', 'keyvalue')) {
    echo $OUTPUT->error_text("Visit Administration Block > <a href = '".
    $CFG->wwwroot."/local/getkey/index.php'>Get key </a> and register for API key. Please ignore if already done.");
}
if ($errormsg !== '') {
    echo $OUTPUT->notification($errormsg);
} else if ($statusmsg !== '') {
    echo $OUTPUT->notification($statusmsg, 'notifysuccess');
}
$mform->display();
echo $OUTPUT->footer();