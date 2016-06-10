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
 * @author     G J Barnard - gjbarnard at gmail dot com and {@link http://moodle.org/user/profile.php?id=442195}
 * @author     Based on code originally written by Mary Evans, Bas Brands, Stuart Lamour and David Scotson.
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

function theme_shoelace_process_css($css, $theme) {
    global $PAGE;
    $outputus = $PAGE->get_renderer('theme_shoelace', 'core');
    \theme_shoelace\toolbox::set_core_renderer($outputus);

    // Set the logo.
    $logo = \theme_shoelace\toolbox::setting_file_url('logo', 'logo');
    $css = \theme_shoelace\toolbox::set_setting($css, '[[setting:logo]]', $logo, '');

    // Set the logo height.
    $logoheight = \theme_shoelace\toolbox::get_setting('logoheight');
    $css = \theme_shoelace\toolbox::set_height_setting($css, '[[setting:logoheight]]', $logoheight, 75);

    // Set the slide header colour.
    $slideshowcolor = \theme_shoelace\toolbox::get_setting('slideshowcolor');
    $css = \theme_shoelace\toolbox::set_colour($css, $slideshowcolor, '[[setting:slideshowcolor]]', '#30add1');

    // Set the slide header colour.
    $slideheadercolor = \theme_shoelace\toolbox::get_setting('slideheadercolor');
    $css = \theme_shoelace\toolbox::set_colour($css, $slideheadercolor, '[[setting:slideheadercolor]]', '#30add1');

    // Set the slide caption text colour.
    $slidecaptiontextcolor = \theme_shoelace\toolbox::get_setting('slidecaptiontextcolor');
    $css = \theme_shoelace\toolbox::set_colour($css, $slidecaptiontextcolor, '[[setting:slidecaptiontextcolor]]',
        '#ffffff');

    // Set the slide caption background colour.
    $slidecaptionbackgroundcolor = \theme_shoelace\toolbox::get_setting('slidecaptionbackgroundcolor');
    $css = \theme_shoelace\toolbox::set_colour($css, $slidecaptionbackgroundcolor,
        '[[setting:slidecaptionbackgroundcolor]]', '#30add1');

    // Set the slide button colour.
    $slidebuttoncolor = \theme_shoelace\toolbox::get_setting('slidebuttoncolor');
    $css = \theme_shoelace\toolbox::set_colour($css, $slidebuttoncolor, '[[setting:slidebuttoncolor]]', '#30add1');

    // Set the slide button hover colour.
    $slidebuttonhcolor = \theme_shoelace\toolbox::get_setting('slidebuttonhovercolor');
    $css = \theme_shoelace\toolbox::set_colour($css, $slidebuttonhcolor, '[[setting:slidebuttonhovercolor]]', '#217a94');

    // Set custom CSS.
    $customcss = \theme_shoelace\toolbox::get_setting('customcss');
    if (empty($customcss)) {
        $customcss = null;
    }
    $css = \theme_shoelace\toolbox::set_setting($css, '[[setting:customcss]]', $customcss, '');

    return $css;
}

/**
 * Returns variables for LESS.
 *
 * We will inject some LESS variables from the settings that the user has defined
 * for the theme. No need to write some custom LESS for this.
 *
 * Ref: https://docs.moodle.org/dev/Themes_overview#Compiling_LESS_on_the_fly
 *
 * @param theme_config $theme The theme config object.
 * @return array of LESS variables without the @.
 */
function theme_shoelace_less_variables($theme) {
    if (empty($theme)) {  // Child theme needs to supply 'null' so that we use our 'theme_config' object instead.
        $theme = \theme_config::load('shoelace');
    }
    $variables = array();

    if (!empty($theme->settings->themecolour)) {
        $variables['bodyBackgroundAlt'] = $theme->settings->themecolour;
    }
    if (!empty($theme->settings->pagecolour)) {
        $variables['bodyBackground'] = $theme->settings->pagecolour;
    }
    if (!empty($theme->settings->textcolour)) {
        $variables['textColor'] = $theme->settings->textcolour;
    }
    if (!empty($theme->settings->navbartextcolour)) {
        $variables['navbarText'] = $theme->settings->navbartextcolour;
    }

    return $variables;
}
/**
 * Extra LESS code to inject.
 *
 * This will generate some LESS code from the settings used by the user. We cannot use
 * the {@link theme_shoelace_less_variables()} here because we need to create selectors or
 * alter existing ones.
 *
 * @param theme_config $theme The theme config object.
 * @return string Raw LESS code.
 */
function theme_shoelace_extra_less($theme) {
    global $CFG;

    $content = '@import "'.$CFG->dirroot.'/theme/bootstrapbase/less/bootstrap/mixins";';
    $content = '@import "'.$CFG->dirroot.'/theme/bootstrapbase/less/moodle";';

    $content .= \theme_shoelace\toolbox::get_extra_less('variables-shoelace');
    $content .= \theme_shoelace\toolbox::get_extra_less('bootstrapchanges');
    $content .= \theme_shoelace\toolbox::get_extra_less('moodlechanges');
    $content .= \theme_shoelace\toolbox::get_extra_less('shoelacechanges');
    $content .= \theme_shoelace\toolbox::get_extra_less('variables-fontawesome');
    $content .= \theme_shoelace\toolbox::get_extra_less('shoelacecustom');

    return $content;
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
function theme_shoelace_pluginfile($course, $cm, $context, $filearea, $args, $forcedownload, array $options = array()) {
    static $theme;
    if (empty($theme)) {
        $theme = theme_config::load('shoelace');
    }
    if ($context->contextlevel == CONTEXT_SYSTEM) {
        if ($filearea === 'logo') {
            // By default, theme files must be cache-able by both browsers and proxies.  From 'More' theme.
            if (!array_key_exists('cacheability', $options)) {
                $options['cacheability'] = 'public';
            }
            return $theme->setting_file_serve('logo', $args, $forcedownload, $options);
        } else if (preg_match("/^(slide)[1-9][0-9]*image$/", $filearea)) {
            return $theme->setting_file_serve($filearea, $args, $forcedownload, $options);
        } else {
            send_file_not_found();
        }
    } else {
        send_file_not_found();
    }
}
