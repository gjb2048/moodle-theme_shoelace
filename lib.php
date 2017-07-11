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

defined('MOODLE_INTERNAL') || die();

function theme_shoelace_process_css($css, $theme) {
    global $PAGE;
    $outputus = $PAGE->get_renderer('theme_shoelace', 'core');
    \theme_shoelace\toolbox::set_core_renderer($outputus);

    // Set the logo.
    $logoname = get_config('core_admin', 'logo');
    if ($logoname) {
        global $CFG;

        require_once("$CFG->libdir/filelib.php");

        $fs = get_file_storage();

        $fileinfo = array(
            'component' => 'core_admin',
            'filearea' => 'logo',
            'itemid' => 0,
            'contextid' => context_system::instance()->id,
            'filepath' => '/',
            'filename' => $logoname);

        $file = $fs->get_file($fileinfo['contextid'], $fileinfo['component'], $fileinfo['filearea'],
            $fileinfo['itemid'], $fileinfo['filepath'], $fileinfo['filename']);
        $imageinfo = $file->get_imageinfo();
        $logo = moodle_url::make_pluginfile_url($fileinfo['contextid'], $fileinfo['component'], $fileinfo['filearea'],
            '0'.$fileinfo['filepath'], theme_get_revision(), $fileinfo['filename']);
        $logoheight = $imageinfo['width'];
    } else {
        $logo = '';
        $logoheight = '';
    }
    $css = \theme_shoelace\toolbox::set_setting($css, '[[setting:logo]]', $logo, '');

    // Set the logo height.
    $css = \theme_shoelace\toolbox::set_height_setting($css, '[[setting:logoheight]]', $logoheight, 75);

    // Set the compact logo.
    $compactlogoname = get_config('core_admin', 'logocompact');
    if ($compactlogoname) {
        global $CFG;

        require_once("$CFG->libdir/filelib.php");

        $fs = get_file_storage();

        $fileinfo = array(
            'component' => 'core_admin',
            'filearea' => 'logocompact',
            'itemid' => 0,
            'contextid' => context_system::instance()->id,
            'filepath' => '/',
            'filename' => $compactlogoname);

        $file = $fs->get_file($fileinfo['contextid'], $fileinfo['component'], $fileinfo['filearea'],
            $fileinfo['itemid'], $fileinfo['filepath'], $fileinfo['filename']);
        $imageinfo = $file->get_imageinfo();
        $compactlogo = moodle_url::make_pluginfile_url($fileinfo['contextid'], $fileinfo['component'], $fileinfo['filearea'],
            '0'.$fileinfo['filepath'], theme_get_revision(), $fileinfo['filename']);
        $compactlogoheight = $imageinfo['width'];
    } else {
        $compactlogo = $logo;
        $compactlogoheight = $logoheight;
    }
    $css = \theme_shoelace\toolbox::set_setting($css, '[[setting:compactlogo]]', $compactlogo, '');

    // Set the compact logo height.
    $css = \theme_shoelace\toolbox::set_height_setting($css, '[[setting:compactlogoheight]]', $compactlogoheight, 75);

    // Set the background image.
    $backgroundimage = \theme_shoelace\toolbox::setting_file_url('backgroundimage', 'backgroundimage');
    $css = \theme_shoelace\toolbox::set_background_image($css, $backgroundimage);

    // Set the background style for the page.
    $bgimagestyle = \theme_shoelace\toolbox::get_setting('backgroundimagestyle');
    $css = \theme_shoelace\toolbox::set_background_image_style($css, $bgimagestyle);

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

    // Icon colour.
    if (\theme_shoelace\toolbox::get_setting('iconcoloursetting')) {
        \theme_shoelace\toolbox::change_icons();
    }

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
    $variables = array();

    $themecolour = \theme_shoelace\toolbox::get_setting('themecolour');
    if (!empty($themecolour)) {
        $variables['bodyBackgroundAlt'] = $themecolour;
    }
    $themetextcolour = \theme_shoelace\toolbox::get_setting('themetextcolour');
    if (!empty($themetextcolour)) {
        $variables['themeTextColour'] = $themetextcolour;
    }
    $backgroundcolour = \theme_shoelace\toolbox::get_setting('backgroundcolour');
    if (!empty($backgroundcolour)) {
        $variables['bodyBackground'] = $backgroundcolour;
    }
    $backgroundtextcolour = \theme_shoelace\toolbox::get_setting('backgroundtextcolour');
    if (!empty($backgroundtextcolour)) {
        $variables['backgroundTextColour'] = $backgroundtextcolour;
    }
    $pagecolour = \theme_shoelace\toolbox::get_setting('pagecolour');
    if (!empty($pagecolour)) {
        $variables['pageColour'] = $pagecolour;
    }
    $textcolour = \theme_shoelace\toolbox::get_setting('textcolour');
    if (!empty($textcolour)) {
        $variables['textColor'] = $textcolour;
    }

    $fontselect = \theme_shoelace\toolbox::get_setting('fontselect');
    if ((!empty($fontselect)) && ($fontselect == 3)) {
        $fontnameheading = \theme_shoelace\toolbox::get_setting('fontnameheading');
        $fontnamebody = \theme_shoelace\toolbox::get_setting('fontnamebody');
        if (!empty($fontnameheading)) {
            $variables['headingsFontFamily'] = '"'.$fontnameheading.'", "Varela Round", "Helvetica Neue", Helvetica, Arial, sans-serif';
        }
        if (!empty($fontnamebody)) {
            $variables['baseFontFamily'] = '"'.$fontnamebody.'", "Cabin", "Helvetica Neue", Helvetica, Arial, sans-serif';
        }
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
    $content .= \theme_shoelace\toolbox::get_font_content();
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
        // By default, theme files must be cache-able by both browsers and proxies.  From 'More' theme.
        if (!array_key_exists('cacheability', $options)) {
            $options['cacheability'] = 'public';
        }
        if ($filearea === 'logo') {
            return $theme->setting_file_serve('logo', $args, $forcedownload, $options);
        } else if (preg_match("/^(slide)[1-9][0-9]*image$/", $filearea)) {
            return $theme->setting_file_serve($filearea, $args, $forcedownload, $options);
        } else if (preg_match("/^fontfile(eot|otf|svg|ttf|woff|woff2)(heading|body)$/", $filearea)) {
            // Ref: http://www.regexr.com/.
            return $theme->setting_file_serve($filearea, $args, $forcedownload, $options);
        } else if ($filearea === 'backgroundimage') {
            return $theme->setting_file_serve('backgroundimage', $args, $forcedownload, $options);
        } else if ($filearea === 'syntaxhighlighter') {
            \theme_shoelace\toolbox::serve_syntaxhighlighter($args[1]);
        } else {
            send_file_not_found();
        }
    } else {
        send_file_not_found();
    }
}
