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
 * This file replaces the legacy STATEMENTS section in db/install.xml,
 * lib.php/modulename_install() post installation hook and partially defaults.php
 *
 * @package    local
 * @subpackage vmchat
 * @copyright  2014 Pinky Sharma <pinky@vidyamantra.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

/**
 * This is called at the beginning of the uninstallation process to give the module
 * a chance to clean-up its hacks, bits etc. where possible.
 *
 * @return bool true if success
 */
function xmldb_local_vmchat_uninstall() {
    global $DB, $CFG;
    // Remove footer div.
    $sql = "UPDATE {config} set value = replace(value, '<div id = \"stickycontainer\"></div>','') where value
    LIKE '%<div id = \"stickycontainer\"></div>%' and name = 'additionalhtmlfooter'";
    $DB->execute($sql);
    // Remove header html.
    $additionalhtmlhead = preg_replace("/<!-- fcStart -->.*<!-- fcEnd -->/", "", $CFG->additionalhtmlhead);
    $DB->execute('UPDATE {config} set value = "'.$additionalhtmlhead.'" WHERE name =:hname',
    array('hname' => 'additionalhtmlhead'));
    return true;
}