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
 * Shoelace theme with the underlying Bootstrap theme.
 *
 * @package    theme
 * @subpackage shoelace
 * @copyright  &copy; 2013-onwards G J Barnard in respect to modifications of the Clean theme.
 * @author     G J Barnard - {@link http://moodle.org/user/profile.php?id=442195}
 * @author     Based on code originally written by Mary Evans, Bas Brands, Stuart Lamour and David Scotson.
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die;

$THEME->doctype = 'html5';
$THEME->name = 'shoelace';
$THEME->parents = array('bootstrapbase');
$THEME->enable_dock = true;

$THEME->lessfile = 'moodleallshoelace';
$THEME->lessvariablescallback = 'theme_shoelace_less_variables';
$THEME->extralesscallback = 'theme_shoelace_extra_less';

$fontselect = \theme_shoelace\toolbox::get_config_setting('fontselect');
if (!empty($fontselect)) {
    if (($fontselect == 1) || ($fontselect == 3)) {
        $THEME->sheets[] = 'font';
        $THEME->sheets[] = 'fa-brands';
        $THEME->sheets[] = 'fa-regular';
        $THEME->sheets[] = 'fa-solid';
        $THEME->sheets[] = 'fontawesome';
    }
}

$THEME->sheets[] = 'custom';

$THEME->supportscssoptimisation = false;
$THEME->yuicssmodules = array();

$THEME->parents_exclude_sheets = array(
    'bootstrapbase' => array(
        'moodle'
    )
);

$THEME->plugins_exclude_sheets = array(
    'block' => array(
        'html'
    )
);

$THEME->rendererfactory = 'theme_overridden_renderer_factory';

$empty = array();
$regions = array('side-pre', 'side-post', 'middle', 'footer');

$THEME->layouts = array(
    // Most backwards compatible layout without the blocks - this is the layout used by default.
    'base' => array(
        'file' => 'layout.php',
        'mustache' => 'columns1',
        'regions' => $regions,
        'defaultregion' => 'footer'
    ),
    // Standard layout with blocks, this is recommended for most pages with general information.
    'standard' => array(
        'file' => 'layout.php',
        'mustache' => 'columns3',
        'regions' => $regions,
        'defaultregion' => 'side-pre'
    ),
    // Main course page.
    'course' => array(
        'file' => 'layout.php',
        'mustache' => 'columns3',
        'regions' => $regions,
        'defaultregion' => 'side-pre',
        'options' => array('langmenu' => true)
    ),
    'coursecategory' => array(
        'file' => 'layout.php',
        'mustache' => 'columns3',
        'regions' => $regions,
        'defaultregion' => 'side-pre'
    ),
    // Part of course, typical for modules - default page layout if $cm specified in require_login().
    'incourse' => array(
        'file' => 'layout.php',
        'mustache' => 'columns3',
        'regions' => $regions,
        'defaultregion' => 'side-pre'
    ),
    // The site home page.
    'frontpage' => array(
        'file' => 'layout.php',
        'mustache' => 'frontpage',
        'regions' => $regions,
        'defaultregion' => 'side-pre',
        'options' => array('langmenu' => true)
    ),
    // Server administration scripts.
    'admin' => array(
        'file' => 'layout.php',
        'mustache' => 'columns2l',
        'regions' => $regions,
        'defaultregion' => 'side-pre'
    ),
    // My dashboard page.
    'mydashboard' => array(
        'file' => 'layout.php',
        'mustache' => 'columns3',
        'regions' => $regions,
        'defaultregion' => 'side-pre',
        'options' => array('langmenu' => true)
    ),
    // My public page.
    'mypublic' => array(
        'file' => 'layout.php',
        'mustache' => 'columns3',
        'regions' => $regions,
        'defaultregion' => 'side-pre'
    ),
    'login' => array(
        'file' => 'layout.php',
        'mustache' => 'columns1',
        'regions' => $empty,
        'options' => array('langmenu' => true)
    ),
    // Pages that appear in pop-up windows - no navigation, no blocks, no header.
    'popup' => array(
        'file' => 'layout.php',
        'mustache' => 'popup',
        'regions' => $empty,
        'options' => array('nofooter' => true, 'nonavbar' => true)
    ),
    // No blocks and minimal footer - used for legacy frame layouts only!
    'frametop' => array(
        'file' => 'layout.php',
        'mustache' => 'columns1',
        'regions' => $empty,
        'options' => array('nofooter' => true, 'nocoursefooter' => true)
    ),
    // Embeded pages, like iframe/object embeded in moodleform - it needs as much space as possible.
    'embedded' => array(
        'file' => 'layout.php',
        'mustache' => 'embedded',
        'regions' => $empty
    ),
    // Used during upgrade and install, and for the 'This site is undergoing maintenance' message.
    // This must not have any blocks, and it is good idea if it does not have links to
    // other places - for example there should not be a home link in the footer...
    'maintenance' => array(
        'file' => 'layout.php',
        'mustache' => 'maintenance',
        'regions' => $empty
    ),
    // Should display the content and basic headers only.
    'print' => array(
        'file' => 'layout.php',
        'mustache' => 'columns1',
        'regions' => $empty,
        'options' => array('nofooter' => true, 'nonavbar' => false)
    ),
    // The pagelayout used when a redirection is occuring.
    'redirect' => array(
        'file' => 'layout.php',
        'mustache' => 'embedded',
        'regions' => $empty
    ),
    // The pagelayout used for reports.
    'report' => array(
        'file' => 'layout.php',
        'mustache' => 'columns2l',
        'regions' => $regions,
        'defaultregion' => 'side-pre'
    ),
    // The pagelayout used for safebrowser and securewindow.
    'secure' => array(
        'file' => 'layout.php',
        'mustache' => 'secure',
        'regions' => $regions,
        'defaultregion' => 'side-pre'
    ),
);

$THEME->javascripts_footer = array(
    'shoelace'
);

$properties = core_useragent::check_ie_properties(); // In /lib/classes/useragent.php.
if ((is_array($properties)) && ($properties['version'] <= 8.0)) {
    $THEME->javascripts[] = 'html5shiv';
}

$THEME->csspostprocess = 'theme_shoelace_process_css';

$THEME->iconsystem = '\\theme_shoelace\\output\\icon_system_fontawesome';