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
    // Set the background image for the logo.
    $logo = $theme->setting_file_url('logo', 'logo');
    $css = theme_shoelace_set_logo($css, $logo);

    // Set custom CSS.
    if (!empty($theme->settings->customcss)) {
        $customcss = $theme->settings->customcss;
    } else {
        $customcss = null;
    }
    $css = theme_shoelace_set_customcss($css, $customcss);

    return $css;
}

function theme_shoelace_set_logo($css, $logo) {
    global $OUTPUT;
    $tag = '[[setting:logo]]';
    $replacement = $logo;
    if (is_null($replacement)) {
        $replacement = '';
    }

    $css = str_replace($tag, $replacement, $css);

    return $css;
}

function theme_shoelace_set_customcss($css, $customcss) {
    $tag = '[[setting:customcss]]';
    $replacement = $customcss;
    if (is_null($replacement)) {
        $replacement = '';
    }

    $css = str_replace($tag, $replacement, $css);

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
    $variables = array();

    if (!empty($theme->settings->themecolour)) {
        $variables['bodyBackgroundAlt'] = $theme->settings->themecolour;
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
 * the {@link theme_more_less_variables()} here because we need to create selectors or
 * alter existing ones.
 *
 * @param theme_config $theme The theme config object.
 * @return string Raw LESS code.
 */
function theme_shoelace_extra_less($theme) {
    global $CFG, $OUTPUT;

    $content = '@import "'.$CFG->dirroot.'/theme/bootstrapbase/less/bootstrap/mixins";';
    $content = '@import "'.$CFG->dirroot.'/theme/bootstrapbase/less/moodle";';
    /*
    $content .= '@import "variables-shoelace";';
    $content .= '@import "bootstrapchanges";';
    $content .= '@import "moodlechanges";';
    $content .= '@import "shoelacechanges";';
    $content .= '@import "shoelacecustom";';
    */

    $content .= '@import "'.\theme_shoelace\toolbox::get_less_file('variables-shoelace').'";';
    $content .= '@import "'.\theme_shoelace\toolbox::get_less_file('bootstrapchanges').'";';
    $content .= '@import "'.\theme_shoelace\toolbox::get_less_file('moodlechanges').'";';
    $content .= '@import "'.\theme_shoelace\toolbox::get_less_file('shoelacechanges').'";';
    $content .= '@import "'.\theme_shoelace\toolbox::get_less_file('shoelacecustom').'";';

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
    if ($context->contextlevel == CONTEXT_SYSTEM) {
        if ($filearea === 'logo') {
            $theme = theme_config::load('shoelace');
            // By default, theme files must be cache-able by both browsers and proxies.  From 'More' theme.
            if (!array_key_exists('cacheability', $options)) {
                $options['cacheability'] = 'public';
            }
            return $theme->setting_file_serve('logo', $args, $forcedownload, $options);
        } else {
            send_file_not_found();
        }
    } else {
        send_file_not_found();
    }
}
