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

defined('MOODLE_INTERNAL') || die;

// Settings.
    $settings = null;

    $readme = new moodle_url('/theme/eyelet/Readme.md');
    $readme = html_writer::link($readme, 'Readme.md', array('target' => '_blank'));

    $ADMIN->add('themes', new admin_category('theme_eyelet', 'Eyelet'));

    $generalsettings = new admin_settingpage('theme_eyelet_general', get_string('generalsettings', 'theme_eyelet'));

    $ADMIN->add('theme_eyelet', $generalsettings);
