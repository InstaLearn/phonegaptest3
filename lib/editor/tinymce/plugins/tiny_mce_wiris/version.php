<?php
//
//  Copyright (c) 2011, Maths for More S.L. http://www.wiris.com
//  This file is part of WIRIS Plugin.
//
//  WIRIS Plugin is free software: you can redistribute it and/or modify
//  it under the terms of the GNU General Public License as published by
//  the Free Software Foundation, either version 3 of the License, or
//  any later version.
//
//  WIRIS Plugin is distributed in the hope that it will be useful,
//  but WITHOUT ANY WARRANTY; without even the implied warranty of
//  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
//  GNU General Public License for more details.
//
//  You should have received a copy of the GNU General Public License
//  along with WIRIS Plugin. If not, see <http://www.gnu.org/licenses/>.
//

defined('MOODLE_INTERNAL') || die();

$plugin->version   = 2015050600;         	 // The current plugin version (Date: YYYYMMDDXX).
$plugin->release = '3.53.4.1156';
$plugin->requires  = 2012120300;        		// Requires this Moodle version.
$plugin->component = 'tinymce_tiny_mce_wiris'; // Full name of the plugin (used for diagnostics).

// If uninstall method is enabled, dependencies are disabled.
// cyclical dependencies prevents uninstall.
global $DB;
$dbman = $DB->get_manager();
if ($dbman->table_exists('config_plugins')) {
	if (!get_config('tinymce_tiny_mce_wiris', 'uninstall')) {
		$plugin->dependencies = array (
			 'filter_wiris' => 2015050600
		);
	}
}