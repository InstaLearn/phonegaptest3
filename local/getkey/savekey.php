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
 * Key manupulation
 *
 * @package    local
 * @subpackage get_key
 * @copyright  2014 Pinky Sharma
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once('../../config.php');
require_once($CFG->libdir.'/adminlib.php');
require_once('key_form.php');
$action = optional_param('action', null, PARAM_ALPHA);   // Action.


require_login();
require_capability('moodle/site:config', context_system::instance());
admin_externalpage_setup('getkey');

$PAGE->set_url(new moodle_url('/local/getkey/savekey.php'));

$kform = new local_getkey_savekey_form(null, '');

if ($kform->is_cancelled()) {
     redirect($CFG->wwwroot."/local/getkey/index.php");
} else if ($keyform = $kform->get_data()) {
    if (!set_config('keyvalue', $keyform->key, 'local_getkey')) {
        echo $OUTPUT->error_text(get_string('keynotsaved', 'local_getkey'));
    }
    redirect($CFG->wwwroot."/local/getkey/index.php");
}

echo $OUTPUT->header();
// Process the action.
if ($action == 'confirmdelete') {
    $PAGE->navbar->add(get_string($action, 'local_getkey'));
    echo $OUTPUT->heading('Deleting existing Vidya.io Api key');
    echo $OUTPUT->confirm(get_string("confirmkeydeletion", "local_getkey"), "savekey.php?action=delete", "index.php");
} else if ($action == 'delete') {
    // Delete key.
    $DB->delete_records('config_plugins', array('name' => 'keyvalue', 'plugin' => 'local_getkey'));
    // Clear cache.
    purge_all_caches();
    redirect($CFG->wwwroot."/local/getkey/index.php");
} else {
    // Form to save key.
    $kform->display();
}

echo $OUTPUT->footer();
