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
 * @copyright  &copy; 2018-onwards G J Barnard in respect to modifications of the Bootstrap theme.
 * @author     G J Barnard - {@link http://moodle.org/user/profile.php?id=442195}
 * @author     Based on code originally written by Bas Brands, David Scotson and many other contributors.
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

 defined('MOODLE_INTERNAL') || die;

$functions = array(
    'theme_shoelace_output_load_fontawesome_icon_map' => array(
        'classname' => 'theme_shoelace\output\external',
        'methodname' => 'load_fontawesome_icon_map',
        'description' => 'Load the mapping of names to icons',
        'type' => 'read',
        'loginrequired' => false,
        'ajax' => true
    )
);

$services = array(
        'Shoelace theme FontAwesome map' => array(
                'functions' => array ('theme_shoelace_output_load_fontawesome_icon_map'),
                'restrictedusers' => 0,
                'enabled' => 1
        )
);
