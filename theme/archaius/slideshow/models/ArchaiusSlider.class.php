<?php
/*

This program is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.
*/

/**
 * Archaius slider from page slider
 *
 * @package theme_archaius
 * @copyright 2013 onwards Daniel Munera
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

class ArchaiusSlider{
	
	private $slides;
	private static $instance = null;

	private function __construct(){
		$this->slides = $this->fill_slider();

	}
	/** 
	*	Get ArchaiusSlider object
	*	@return ArchaiusSlider object
	*/
	public static function Instance(){
        if (self::$instance === null) {
            self::$instance = new ArchaiusSlider();
        }
        return self::$instance;
    }

    /** 
    *   Get Slides attribute
    *   @return Array with available slides
    */

    public function get_slides(){
    	return $this->slides;
    }

	/** 
	*	Get slides from database
	*	@return Array
	*/
	private function fill_slider(){
		global $DB;
		$slides= "SELECT * FROM {theme_archaius} ORDER BY position ASC";
	    $slides= $DB->get_records_sql($slides);
	    return $slides;
	}


}