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
 * Renderer for outputting the masonry course format.
 *
 * @package    course format
 * @subpackage masonry
 * @copyright  2013 Renaat Debleu (www.eWallah.net)
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();
require_once($CFG->dirroot.'/course/format/renderer.php');

class format_masonry_renderer extends format_section_renderer_base {

    /**
     * Generate the starting masonry container html for a list of brick sections
     * @return string HTML to output.
     */
    protected function start_section_list() {
        return html_writer::start_tag('ul', array('id' => 'coursemasonry' , 'class' => "topics masonry"));
    }

    /**
     * Generate the closing container html for a list of sections
     * @return string HTML to output.
     */
    protected function end_section_list() {
        return html_writer::end_tag('ul');
    }

    /**
     * Generate the title for this section page
     * @return string the page title
     */
    protected function page_title() {
        return get_string('topicoutline');
    }

    /**
     * Generate the content to displayed on the left part of a section
     * before course modules are included 
     *
     * @param stdClass $section The course_section entry from DB
     * @param stdClass $course The course entry from DB
     * @param bool $onsectionpage true if being printed on a section page
     * @return string HTML to output.
     */
    protected function section_left_content($section, $course, $onsectionpage) {
        return '';
    }

    /**
     * Generate the display of the header part of a section before
     * course modules are included
     *
     * @param stdClass $section The course_section entry from DB
     * @param stdClass $course The course entry from DB
     * @param bool $onsectionpage true if being printed on a single-section page
     * @param int $sectionreturn The section to return to after an action
     * @return string HTML to output.
     */
    protected function section_header($section, $course, $onsectionpage, $sectionreturn=null) {
        global $PAGE;
        $class = 'section main';
        $style = 'background:' .$section->backcolor . ' !important;';
        if (!$section->visible) {
            $class .= ' hidden';
            $style .= ' opacity:0.3;filter:alpha(opacity=30);';
        } else {
            // No need for empty first sections.
            if ($section->id == 0 && empty($section->sequence)) {
                return '';
            }
        }
        if (course_get_format($course)->is_section_current($section)) {
            $style .= 'border: ' . 2 * $course->borderwidth . 'px solid '.  $course->bordercolor.';';
        } else {
            $style .= 'border: ' . $course->borderwidth . 'px solid '.  $course->bordercolor.';';
        }
        $o = html_writer::start_tag('li', array('id' => 'section-'.$section->section, 'class' => $class, 'style' => $style));
        $o .= html_writer::start_tag('div', array('class' => 'content'));
        $o .= $this->output->heading($this->section_title($section, $course), 3, 'sectionname');
        $o .= html_writer::start_tag('div', array('class' => 'summary'));
        $o .= $this->format_summary_text($section);
        $o .= html_writer::end_tag('div');
        $context = context_course::instance($course->id);
        $o .= $this->section_availability_message($section, has_capability('moodle/course:viewhiddensections', $context));
        return $o;
    }

    /**
     * If section is not visible, returns blank.
     *
     * For users with the ability to view hidden sections, it shows the
     * information even though you can view the section and also may include
     * slightly fuller information (so that teachers can tell when sections
     * are going to be unavailable etc). This logic is the same as for
     * activities.
     *
     * @param stdClass $section The course_section entry from DB
     * @param bool $canviewhidden True if user can view hidden sections
     * @return string HTML to output
     */
    protected function section_availability_message($section, $canviewhidden) {
        global $CFG;
        $o = '';
        if (!$section->uservisible) {
            $o .= '';
        } else if ($canviewhidden && !empty($CFG->enableavailability) && $section->visible) {
            $ci = new condition_info_section($section);
            $fullinfo = $ci->get_full_information();
            if ($fullinfo) {
                $o .= html_writer::start_tag('div', array('class' => 'availabilityinfo'));
                $o .= get_string(
                        ($section->showavailability ? 'userrestriction_visible' : 'userrestriction_hidden'),
                        'condition', $fullinfo);
                $o .= html_writer::end_tag('div');
            }
        }
        return $o;
    }

    /**
     * Generate the html for the 'Jump to' menu on a single section page.
     *
     * @param stdClass $course The course entry from DB
     * @param array $sections The course_sections entries from the DB
     * @param $displaysection the current displayed section number.
     *
     * @return string HTML to output.
     */
    protected function section_nav_selection($course, $sections, $displaysection) {
        return '';
    }

}
