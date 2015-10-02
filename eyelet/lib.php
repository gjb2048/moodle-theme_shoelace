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
 * Eyelet theme.
 *
 * @package    theme
 * @subpackage eyelet
 * @copyright  &copy; 2015-onwards G J Barnard in respect to modifications of the Bootstrap theme.
 * @author     G J Barnard - gjbarnard at gmail dot com and {@link http://moodle.org/user/profile.php?id=442195}
 * @author     Based on code originally written by Bas Brands, David Scotson and many other contributors.
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

function theme_eyelet_process_css($css, $theme) {
    global $CFG;
    if (file_exists("$CFG->dirroot/theme/shoelace/lib.php")) {
        require_once("$CFG->dirroot/theme/shoelace/lib.php");
    } else if (!empty($CFG->themedir) and file_exists("$CFG->themedir/shoelace/lib.php")) {
        require_once("$CFG->themedir/shoelace/lib.php");
    } // else will just fail when cannot find theme_shoelace_process_css!
    static $parenttheme;
    if (empty($parenttheme)) {
        $parenttheme = theme_config::load('shoelace'); 
    }
    $css = theme_shoelace_process_css($css, $parenttheme);

    // If you have your own settings, then add them here.

    // Finally return processed CSS
    return $css;
}
