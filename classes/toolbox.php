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
 * Shoelace theme.
 *
 * @package    theme
 * @subpackage shoelace
 * @copyright  &copy; 2015-onwards G J Barnard in respect to modifications of the Bootstrap theme.
 * @author     G J Barnard - gjbarnard at gmail dot com and {@link http://moodle.org/user/profile.php?id=442195}
 * @author     Based on code originally written by Bas Brands, David Scotson and many other contributors.
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace theme_shoelace;

class toolbox {

    static protected $corerenderer = null;

    static public function set_core_renderer($core) {
        // Set only once from the initial calling lib.php process_css function.  Must happen before parents.
        if (null === self::$corerenderer) {
            self::$corerenderer = $core;
        }
    }

    /**
     * Finds the given tile file in the theme.  If it does not exist for the Shoelace child theme then the parent is checked.
     * @param string $filename Filename without extension to get.
     * @return string Complete path of the file.
     */
    static public function get_tile_file($filename) {
        global $CFG, $PAGE;
        $themedir = $PAGE->theme->dir;
        $filename .= '.php';

        /* Check only if a child of 'Shoelace' to prevent conflicts with other themes using the 'tiles' folder.
           The test is to change theme from Shoelace to Eyelet with the theme selector and not get an error. */
        if (in_array('shoelace', $PAGE->theme->parents)) {
            $themename = $PAGE->theme->name;
            if (file_exists("$themedir/layout/tiles/$filename")) {
                return "$themedir/layout/tiles/$filename";
            } else if (file_exists("$CFG->dirroot/theme/$themename/layout/tiles/$filename")) {
                return "$CFG->dirroot/theme/$themename/layout/tiles/$filename";
            } else if (!empty($CFG->themedir) and file_exists("$CFG->themedir/$themename/layout/tiles/$filename")) {
                return "$CFG->themedir/$themename/layout/tiles/$filename";
            }
        }
        // Check Shoelace.
        if (file_exists("$CFG->dirroot/theme/shoelace/layout/tiles/$filename")) {
            return "$CFG->dirroot/theme/shoelace/layout/tiles/$filename";
        } else if (!empty($CFG->themedir) and file_exists("$CFG->themedir/shoelace/layout/tiles/$filename")) {
            return "$CFG->themedir/shoelace/layout/tiles/$filename";
        } else {
            return dirname(__FILE__)."/$filename";
        }
    }

    /**
     * Finds the given less file in the theme.  If it does not exist for the Shoelace child theme then the parent is checked.
     * @param string $filename Filename without extension to get.
     * @return string Complete path of the file.
     */
    static private function get_less_file($filename) {
        global $CFG, $PAGE;
        $themedir = $PAGE->theme->dir;
        $filename .= '.less';

        /* Check only if a child of 'Shoelace' to prevent conflicts with other themes using the 'tiles' folder.
           The test is to change theme from Shoelace to Eyelet with the theme selector and not get an error. */
        if (in_array('shoelace', $PAGE->theme->parents)) {
            $themename = $PAGE->theme->name;
            if (file_exists("$themedir/less/$filename")) {
                return "$themedir/less/$filename";
            } else if (file_exists("$CFG->dirroot/theme/$themename/less/$filename")) {
                return "$CFG->dirroot/theme/$themename/layout/tiles/$filename";
            } else if (!empty($CFG->themedir) and file_exists("$CFG->themedir/$themename/less/$filename")) {
                return "$CFG->themedir/$themename/less/$filename";
            }
        }
        // Check Shoelace.
        if (file_exists("$CFG->dirroot/theme/shoelace/less/$filename")) {
            return "$CFG->dirroot/theme/shoelace/less/$filename";
        } else if (!empty($CFG->themedir) and file_exists("$CFG->themedir/shoelace/less/$filename")) {
            return "$CFG->themedir/shoelace/less/$filename";
        } else {
            return null;
        }
    }

    /**
     * Finds the given less file in the theme.  If it does not exist for the Shoelace child theme then the parent is checked.
     * @param string $filename Filename without extension to get.
     * @return string LESS import statement for the file if it exists otherwise an empty string.
     */
    static public function get_extra_less($filename) {
        $content = '';
        $thefile = self::get_less_file($filename);
        if (!empty($thefile)) {
            $content .= '@import "'.$thefile.'";';
        }
        return $content;
    }

    /**
     * Finds the given setting in the theme from the themes' configuration object.
     * @param string $setting Setting name.
     * @param string $format false|'format_text'|'format_html'.
     * @param theme_config $theme null|theme_config object.
     * @return any false|value of setting.
     */
    static public function get_setting($setting, $format = false) {

        if (empty(self::$corerenderer)) {
            // Use $OUTPUT.
            global $OUTPUT;
            self::$corerenderer = $OUTPUT;
        }
        error_log('get_setting toolbox: '.get_class(self::$corerenderer));
        $settingvalue = self::$corerenderer->get_setting($setting);

        global $CFG;
        require_once($CFG->dirroot . '/lib/weblib.php');
        if (empty($settingvalue)) {
            return false;
        } else if (!$format) {
            return $settingvalue;
        } else if ($format === 'format_text') {
            return format_text($settingvalue, FORMAT_PLAIN);
        } else if ($format === 'format_html') {
            return format_text($settingvalue, FORMAT_HTML, array('trusted' => true, 'noclean' => true));
        } else {
            return format_string($settingvalue);
        }
    }

    static public function setting_file_url($setting, $filearea, $theme = null) {
        if (empty(self::$corerenderer)) {
            // Use $OUTPUT.
            global $OUTPUT;
            self::$corerenderer = $OUTPUT;
        }
        error_log('get_setting toolbox: '.get_class(self::$corerenderer));

        return self::$corerenderer->setting_file_url($setting, $filearea);
    }


    /**
     * Finds the given setting in the theme using the get_config core function for when the theme_config object has not been created.
     * @param string $setting Setting name.
     * @param themename $themename null(default of 'shoelace' used)|theme name.
     * @return any false|value of setting.
     */
    static public function get_config_setting($setting, $themename = null) {
        if (empty($themename)) {
            $themename = 'shoelace';
        }
        return \get_config('theme_'.$themename, $setting);
    }

    /**
     * Returns an object containing HTML for the areas affected by settings.
     *
     * @param $theme Theme to use if not parent.
     * @return stdClass An object with the following properties:
     *      - navbarclass A CSS class to use on the navbar. By default ''.
     *      - heading HTML to use for the heading. A logo if one is selected or the default heading.
     *      - footnote HTML to use as a footnote. By default ''.
     */
    static function get_html_for_settings($theme = null) {

        global $CFG;
        $return = new \stdClass;

        $return->navbarclass = '';
        if (!empty(self::get_setting('invert'))) {
            $return->navbarclass .= ' navbar-inverse';
        }

        if (!empty(self::get_setting('logo'))) {
            $return->heading = \html_writer::link($CFG->wwwroot, '', array('title' => get_string('home'), 'class' => 'logo'));
        } else {
            $return->heading = self::$corerenderer->page_heading();
        }

        $return->footnote = '';
        if (!empty(self::get_setting('footnote'))) {
            $return->footnote = '<div class="footnote text-center">'.self::get_setting('footnote').'</div>';
        }

        return $return;
    }
}
