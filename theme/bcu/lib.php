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

/**
 * Parses CSS before it is cached.
 *
 * This function can make alterations and replace patterns within the CSS.
 *
 * @param string $css The CSS
 * @param theme_config $theme The theme config object.
 * @return string The parsed CSS The parsed CSS.
 */
function theme_bcu_process_css($css, $theme) {

    // Set the font size.
    if (!empty($theme->settings->fsize)) {
        $fsize = $theme->settings->fsize;
    } else {
        $fsize = null;
    }
    $css = theme_bcu_set_fsize($css, $fsize);

    // Set the link color.
    if (!empty($theme->settings->linkcolor)) {
        $linkcolor = $theme->settings->linkcolor;
    } else {
        $linkcolor = null;
    }
    $css = theme_bcu_set_linkcolor($css, $linkcolor);

    // Set the link hover color.
    if (!empty($theme->settings->linkhover)) {
        $linkhover = $theme->settings->linkhover;
    } else {
        $linkhover = null;
    }
    $css = theme_bcu_set_linkhover($css, $linkhover);

    // Set the main color.
    if (!empty($theme->settings->maincolor)) {
        $maincolor = $theme->settings->maincolor;
    } else {
        $maincolor = null;
    }
    $css = theme_bcu_set_maincolor($css, $maincolor);

    // Set the main headings color.
    if (!empty($theme->settings->backcolor)) {
        $backcolor = $theme->settings->backcolor;
    } else {
        $backcolor = null;
    }
    $css = theme_bcu_set_backcolor($css, $backcolor);

    // Set custom CSS.
    if (!empty($theme->settings->customcss)) {
        $customcss = $theme->settings->customcss;
    } else {
        $customcss = null;
    }
    $css = theme_bcu_set_customcss($css, $customcss);
    
    if(!empty($theme->settings->rendereroverlaycolour)) {
        $rendereroverlaycolour = $theme->settings->rendereroverlaycolour;
    } else {
        $rendereroverlaycolour = null;
    }
    $css = theme_bcu_set_rendereroverlaycolour($css, $rendereroverlaycolour);
    
    if (!empty($theme->settings->rendereroverlayfontcolour)) {
        $rendereroverlayfontcolour = $theme->settings->rendereroverlayfontcolour;
    } else {
        $rendereroverlayfontcolour = null;
    }
    $css = theme_bcu_set_rendereroverlayfontcolour($css, $rendereroverlayfontcolour);
    
    if(!empty($theme->settings->buttoncolour)) {
        $buttoncolour = $theme->settings->buttoncolour;
    } else {
        $buttoncolour = null;
    }
    $css = theme_bcu_set_buttoncolour($css, $buttoncolour);
    
    if(!empty($theme->settings->buttonhovercolour)) {
        $buttonhovercolour = $theme->settings->buttonhovercolour;
    } else {
        $buttonhovercolour = null;
    }
    $css = theme_bcu_set_buttonhovercolour($css, $buttonhovercolour);
    
    return $css;
}


/**
 * Adds any custom CSS to the CSS before it is cached.
 *
 * @param string $css The original CSS.
 * @param string $customcss The custom CSS to add.
 * @return string The CSS which now contains our custom CSS.
 */
function theme_bcu_set_customcss($css, $customcss) {
    $tag = '[[setting:customcss]]';
    $replacement = $customcss;
    if (is_null($replacement)) {
        $replacement = '';
    }

    $css = str_replace($tag, $replacement, $css);

    return $css;
}

function theme_bcu_set_fsize($css, $fsize) {
    $tag = '[[setting:fsize]]';
    $replacement = $fsize;
    if (is_null($replacement)) {
        $replacement = '90';
    }
    $css = str_replace($tag, $replacement, $css);
    return $css;
}

function theme_bcu_set_linkcolor($css, $linkcolor) {
    $tag = '[[setting:linkcolor]]';
    $replacement = $linkcolor;
    if (is_null($replacement)) {
        $replacement = '#001E3C';
    }
    $css = str_replace($tag, $replacement, $css);
    return $css;
}

function theme_bcu_set_linkhover($css, $linkhover) {
    $tag = '[[setting:linkhover]]';
    $replacement = $linkhover;
    if (is_null($replacement)) {
        $replacement = '#001E3C';
    }
    $css = str_replace($tag, $replacement, $css);
    return $css;
}

function theme_bcu_set_maincolor($css, $maincolor) {
    $tag = '[[setting:maincolor]]';
    $replacement = $maincolor;
    if (is_null($replacement)) {
        $replacement = '#001e3c';
    }
    $css = str_replace($tag, $replacement, $css);
    return $css;
}

function theme_bcu_set_backcolor($css, $backcolor) {
    $tag = '[[setting:backcolor]]';
    $replacement = $backcolor;
    if (is_null($replacement)) {
        $replacement = '#F1EEE7';
    }
    $css = str_replace($tag, $replacement, $css);
    return $css;
}

function theme_bcu_set_rendereroverlaycolour($css, $rendereroverlaycolour) {
    $tag = '[[setting:rendereroverlaycolour]]';
    $replacement = $rendereroverlaycolour;
    if (is_null($replacement)) {
        $replacement = '#001e3c';
    }
    $css = str_replace($tag, $replacement, $css);
    return $css;
}

function theme_bcu_set_rendereroverlayfontcolour($css, $rendereroverlayfontcolour) {
    $tag = '[[setting:rendereroverlayfontcolour]]';
    $replacement = $rendereroverlayfontcolour;
    if (is_null($replacement)) {
        $replacement = '#FFF';
    }
    $css = str_replace($tag, $replacement, $css);
    return $css;
}

function theme_bcu_set_buttoncolour($css, $buttoncolour) {
    $tag = '[[setting:buttoncolour]]';
    $replacement = $buttoncolour;
    if (is_null($replacement)) {
        $replacement = '#00aeef';
    }
    $css = str_replace($tag, $replacement, $css);
    return $css;
}

function theme_bcu_set_buttonhovercolour($css, $buttonhovercolour) {
    $tag = '[[setting:buttonhovercolour]]';
    $replacement = $buttonhovercolour;
    if (is_null($replacement)) {
        $replacement = '#0084c2';
    }
    $css = str_replace($tag, $replacement, $css);
    return $css;
}

/**
 * Deprecated: Please call theme_bcu_process_css instead.
 * @deprecated since 2.5.1
 */
function bcu_process_css($css, $theme) {
    debugging('Please call theme_'.__FUNCTION__.' instead of '.__FUNCTION__, DEBUG_DEVELOPER);
    return theme_bcu_process_css($css, $theme);
}

/**
 * Deprecated: Please call theme_bcu_set_customcss instead.
 * @deprecated since 2.5.1
 */
function bcu_set_customcss($css, $customcss) {
    debugging('Please call theme_'.__FUNCTION__.' instead of '.__FUNCTION__, DEBUG_DEVELOPER);
    return theme_bcu_set_customcss($css, $customcss);
}

function theme_bcu_initialise_zoom(moodle_page $page) {
    user_preference_allow_ajax_update('theme_bcu_zoom', PARAM_TEXT);
    $page->requires->yui_module('moodle-theme_bcu-zoom', 'M.theme_bcu.zoom.init', array());
}

/**
 * Get the user preference for the zoom function.
 */
function theme_bcu_get_zoom() {
    return get_user_preferences('theme_bcu_zoom', '');
}

// Full width funcs.

function theme_bcu_initialise_full(moodle_page $page) {
    user_preference_allow_ajax_update('theme_bcu_full', PARAM_TEXT);
    $page->requires->yui_module('moodle-theme_bcu-full', 'M.theme_bcu.full.init', array());
}

/**
 * Get the user preference for the zoom function.
 */
function theme_bcu_get_full() {
    return get_user_preferences('theme_bcu_full', '');
}

function theme_bcu_get_html_for_settings(renderer_base $output, moodle_page $page) {
    global $CFG;
    $return = new stdClass;

    $return->navbarclass = '';
    if (!empty($page->theme->settings->invert)) {
        $return->navbarclass .= ' navbar-inverse';
    }

    if (!empty($page->theme->settings->logo)) {
        $return->heading = html_writer::link($CFG->wwwroot, '', array('title' => get_string('home'), 'class' => 'logo'));
    } else {
        $return->heading = $output->page_heading();
    }

    $return->footnote = '';
    if (!empty($page->theme->settings->footnote)) {
        $return->footnote = '<div class="footnote">'.$page->theme->settings->footnote.'</div>';
    }

    return $return;
}

function theme_bcu_get_setting($setting, $format = false) {
    static $theme;
    if (empty($theme)) {
        $theme = theme_config::load('bcu');
    }
    if (empty($theme->settings->$setting)) {
        return false;
    } else if (!$format) {
        return $theme->settings->$setting;
    } else if ($format === 'format_text') {
        return format_text($theme->settings->$setting, $format = FORMAT_HTML, $options = array('trusted' => true));
    } else {
        return format_string($theme->settings->$setting);
    }
}

/**
 * Serves any files associated with the theme settings.
 *
 * @param stdClass $course
 * @param stdClass $cm
 * @param context $context
 * @param string $filearea
 * @param array $args
 * @param bool $forcedownload
 * @param array $options
 * @return bool
 */
function theme_bcu_pluginfile($course, $cm, $context, $filearea, $args, $forcedownload, array $options = array()) {
    static $theme;
    if (empty($theme)) {
        $theme = theme_config::load('bcu');
    }
    if ($context->contextlevel == CONTEXT_SYSTEM) {
        if ($filearea === 'logo') {
            return $theme->setting_file_serve('logo', $args, $forcedownload, $options);
        } else if ($filearea === 'style') {
            theme_essential_serve_css($args[1]);
        } else if ($filearea === 'pagebackground') {
            return $theme->setting_file_serve('pagebackground', $args, $forcedownload, $options);
        } else if (preg_match("/p[1-9][0-9]/", $filearea) !== false) {
            return $theme->setting_file_serve($filearea, $args, $forcedownload, $options);
        } else if ((substr($filearea, 0, 9) === 'marketing') && (substr($filearea, 10, 5) === 'image')) {
            return $theme->setting_file_serve($filearea, $args, $forcedownload, $options);
        } else if ($filearea === 'iphoneicon') {
            return $theme->setting_file_serve('iphoneicon', $args, $forcedownload, $options);
        } else if ($filearea === 'iphoneretinaicon') {
            return $theme->setting_file_serve('iphoneretinaicon', $args, $forcedownload, $options);
        } else if ($filearea === 'ipadicon') {
            return $theme->setting_file_serve('ipadicon', $args, $forcedownload, $options);
        } else if ($filearea === 'ipadretinaicon') {
            return $theme->setting_file_serve('ipadretinaicon', $args, $forcedownload, $options);
        } else if ($filearea === 'fontfilettfheading') {
            return $theme->setting_file_serve('fontfilettfheading', $args, $forcedownload, $options);
        } else if ($filearea === 'fontfilettfbody') {
            return $theme->setting_file_serve('fontfilettfbody', $args, $forcedownload, $options);
        } else {
            send_file_not_found();
        }
    } else {
        send_file_not_found();
    }
}

function theme_bcu_get_course_activities() {
    GLOBAL $CFG, $PAGE, $OUTPUT;
    // A copy of block_activity_modules.
    $course = $PAGE->course;
    $content = new stdClass();
    $modinfo = get_fast_modinfo($course);
    $modfullnames = array();

    $archetypes = array();

    foreach ($modinfo->cms as $cm) {
        // Exclude activities which are not visible or have no link (=label).
        if (!$cm->uservisible or !$cm->has_view()) {
            continue;
        }
        if (array_key_exists($cm->modname, $modfullnames)) {
            continue;
        }
        if (!array_key_exists($cm->modname, $archetypes)) {
            $archetypes[$cm->modname] = plugin_supports('mod', $cm->modname, FEATURE_MOD_ARCHETYPE, MOD_ARCHETYPE_OTHER);
        }
        if ($archetypes[$cm->modname] == MOD_ARCHETYPE_RESOURCE) {
            if (!array_key_exists('resources', $modfullnames)) {
                $modfullnames['resources'] = get_string('resources');
            }
        } else {
            $modfullnames[$cm->modname] = $cm->modplural;
        }
    }
    core_collator::asort($modfullnames);

    return $modfullnames;
}

function theme_bcu_performance_output($param) {
    $html = html_writer::tag('span', get_string('loadtime', 'theme_bcu').' '. round($param['realtime'], 2) . ' ' . get_string('seconds'), array('id' => 'load'));
    return $html;
}