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

    protected $corerenderer = null;
    protected static $instance;

    private function __construct() {
    }

    public static function get_instance() {
        if (!is_object(self::$instance)) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    static public function set_core_renderer($core) {
        $us = self::get_instance();
        // Set only once from the initial calling lib.php process_css function so that subsequent parent calls do not override it.
        // Must happen before parents.
        if (null === $us->corerenderer) {
            $us->corerenderer = $core;
        }
    }

    /**
     * Finds the given setting in the theme from the themes' configuration object.
     * @param string $setting Setting name.
     * @param string $format false|'format_text'|'format_html'.
     * @param theme_config $theme null|theme_config object.
     * @return any false|value of setting.
     */
    static public function get_setting($setting, $format = false, $default = false) {
        $us = self::check_corerenderer();
        $settingvalue = $us->get_setting($setting);

        global $CFG;
        require_once($CFG->dirroot . '/lib/weblib.php');
        if (empty($settingvalue)) {
            return $default;
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

    static public function setting_file_url($setting, $filearea) {
        $us = self::check_corerenderer();
        return $us->setting_file_url($setting, $filearea);
    }

    static public function pix_url($imagename, $component) {
        $us = self::check_corerenderer();
        return $us->pix_url($imagename, $component);
    }

    static private function check_corerenderer() {
        $us = self::get_instance();
        if (empty($us->corerenderer)) {
            // Use $OUTPUT unless is not a Shoelace or child core_renderer which can happen on theme switch.
            global $OUTPUT;
            if (property_exists($OUTPUT, 'shoelace')) {
                $us->corerenderer = $OUTPUT;
            } else {
                // Use $PAGE->theme->name as will be accurate than $CFG->theme when using URL theme changes.
                // Core 'allowthemechangeonurl' setting.
                global $PAGE;
                $corerenderer = $PAGE->get_renderer('theme_'.$PAGE->theme->name, 'core');
                // Fallback check.
                if (property_exists($corerenderer, 'shoelace')) {
                    $us->corerenderer = $corerenderer;
                } else {
                    // Probably during theme switch, '$CFG->theme' will be accurrate.
                    global $CFG;
                    $corerenderer = $PAGE->get_renderer('theme_'.$CFG->theme, 'core');
                    if (property_exists($corerenderer, 'shoelace')) {
                        $us->corerenderer = $corerenderer;
                    } else {
                        // Last resort.  Hopefully will be fine on next page load for Child themes.
                        // However '***_process_css' in lib.php will be fine as it sets the correct renderer.
                        $us->corerenderer = $PAGE->get_renderer('theme_shoelace', 'core');
                    }
                }
            }
        }
        return $us->corerenderer;
    }

    /**
     * Finds the given less file in the theme.  If it does not exist for the Shoelace child theme then the parent is checked.
     * @param string $filename Filename without extension to get.
     * @return string Complete path of the file.
     */
    static private function get_less_file($filename) {
        $us = self::check_corerenderer();
        return $us->get_less_file($filename);
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
     * Finds the given setting in the theme using the get_config core function for when the
     * theme_config object has not been created.
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

    static public function get_categories_list() {
        static $catlist = null;
        if (empty($catlist)) {
            global $DB;
            $catlist = $DB->get_records('course_categories', null, 'sortorder', 'id, name, depth, path');

            foreach ($catlist as $category) {
                $category->parents = array();
                if ($category->depth > 1 ) {
                    $path = preg_split('|/|', $category->path, -1, PREG_SPLIT_NO_EMPTY);
                    $category->namechunks = array();
                    foreach ($path as $parentid) {
                        $category->namechunks[] = $catlist[$parentid]->name;
                        $category->parents[] = $parentid;
                    }
                    $category->parents = array_reverse($category->parents);
                } else {
                    $category->namechunks = array($category->name);
                }
            }
        }

        return $catlist;
    }

    /**
     * Returns an object containing HTML for the areas affected by settings.
     *
     * @return stdClass An object with the following properties:
     *      - navbarclass A CSS class to use on the navbar. By default ''.
     *      - heading HTML to use for the heading. A logo if one is selected or the default heading.
     *      - footnote HTML to use as a footnote. By default ''.
     */
    static public function get_html_for_settings() {
        $return = new \stdClass;

        $return->navbarclass = '';
        $inversenavbar = self::get_setting('inversenavbar');
        if (!empty($inversenavbar)) {
            $return->navbarclass .= ' navbar-inverse';
        }

        $logo = self::get_setting('logo');
        if (!empty($logo)) {
            global $CFG;
            $return->heading = \html_writer::link($CFG->wwwroot, '', array('title' => get_string('home'), 'class' => 'logo'));
        } else {
            global $OUTPUT;
            $return->heading = $OUTPUT->page_heading();
        }

        $return->footnote = '';
        $footnote = self::get_setting('footnote');
        if (!empty($footnote)) {
            $return->footnote = '<div class="footnote text-center">'.$footnote.'</div>';
        }

        return $return;
    }

    static public function set_setting($css, $tag, $value, $default) {
        $replacement = $value;
        if (is_null($replacement)) {
            $replacement = $default;
        }

        $css = str_replace($tag, $replacement, $css);
        return $css;
    }

    static public function set_height_setting($css, $tag, $value, $default) {
        $replacement = $value;
        if (empty($replacement)) {
            $replacement = $default;
        }

        $css = str_replace($tag, 'height: '.$replacement.'px;', $css);
        return $css;
    }

    static public function set_colour($css, $themecolour, $tag, $defaultcolour, $alpha = null) {
        if (!($themecolour)) {
            $replacement = $defaultcolour;
        } else {
            $replacement = $themecolour;
        }
        if (!is_null($alpha)) {
            $replacement = self::hex2rgba($replacement, $alpha);
        }
        $css = str_replace($tag, $replacement, $css);
        return $css;
    }

    static public function serve_syntaxhighlighter($filename) {
        global $CFG;
        if (file_exists("{$CFG->dirroot}/theme/shoelace/javascript/syntaxhighlighter_3_0_83/scripts/")) {
            $thesyntaxhighlighterpath = $CFG->dirroot.'/theme/shoelace/javascript/syntaxhighlighter_3_0_83/scripts/';
        } else if (!empty($CFG->themedir) && file_exists("{$CFG->themedir}/shoelace/javascript/syntaxhighlighter_3_0_83/scripts/")) {
            $thesyntaxhighlighterpath = $CFG->themedir.'/shoelace/javascript/syntaxhighlighter_3_0_83/scripts/';
        } else {
            header('HTTP/1.0 404 Not Found');
            die('Shoelace syntax highlighter scripts folder not found, check $CFG->themedir is correct.');
        }
        $thefile = $thesyntaxhighlighterpath . $filename;

        /* Ref: http://css-tricks.com/snippets/php/intelligent-php-cache-control/ - rather than /lib/csslib.php as it is a static
          file who's contents should only change if it is rebuilt.  But! There should be no difference with TDM on so will see for
          the moment if that decision is a factor. */

        $etagfile = md5_file($thefile);
        // File.
        $lastmodified = filemtime($thefile);
        // Header.
        $ifmodifiedsince = (isset($_SERVER['HTTP_IF_MODIFIED_SINCE']) ? $_SERVER['HTTP_IF_MODIFIED_SINCE'] : false);
        $etagheader = (isset($_SERVER['HTTP_IF_NONE_MATCH']) ? trim($_SERVER['HTTP_IF_NONE_MATCH']) : false);

        if ((($ifmodifiedsince) && (strtotime($ifmodifiedsince) == $lastmodified)) || $etagheader == $etagfile) {
            self::send_unmodified($lastmodified, $etagfile, 'application/javascript');
        }
        self::send_cached($thesyntaxhighlighterpath, $filename, $lastmodified, $etagfile, 'application/javascript');
    }

    static private function send_unmodified($lastmodified, $etag, $contenttype) {
        $lifetime = 60 * 60 * 24 * 60;
        header('HTTP/1.1 304 Not Modified');
        header('Expires: '.gmdate('D, d M Y H:i:s', time() + $lifetime).' GMT');
        header('Cache-Control: public, max-age=' . $lifetime);
        header('Content-Type: '.$contenttype.'; charset=utf-8');
        header('Etag: "'.$etag.'"');
        if ($lastmodified) {
            header('Last-Modified: ' . gmdate('D, d M Y H:i:s', $lastmodified).' GMT');
        }
        die;
    }

    static private function send_cached($path, $filename, $lastmodified, $etag, $contenttype) {
        global $CFG;
        require_once($CFG->dirroot . '/lib/configonlylib.php'); // For min_enable_zlib_compression().
        // Sixty days only - the revision may get incremented quite often.
        $lifetime = 60 * 60 * 24 * 60;

        header('Etag: "'.$etag.'"');
        header('Content-Disposition: inline; filename="'.$filename.'"');
        header('Last-Modified: '.gmdate('D, d M Y H:i:s', $lastmodified).' GMT');
        header('Expires: '.gmdate('D, d M Y H:i:s', time() + $lifetime).' GMT');
        header('Pragma: ');
        header('Cache-Control: public, max-age='.$lifetime);
        header('Accept-Ranges: none');
        header('Content-Type: '.$contenttype.'; charset=utf-8');
        if (!min_enable_zlib_compression()) {
            header('Content-Length: '.filesize($path . $filename));
        }

        readfile($path . $filename);
        die;
    }

    static public function change_icons() {
        static $lastrun = 0;
        if (empty($lastrun)) {
            $lastrun = time();
        } else {
            $thisrun = time();
            if (($thisrun - $lastrun) <= 5) {
                $lastrun = $thisrun;
                /* Prevent muiltiple runs within a five second period.
                   Helps to reduce the issue of multiple calls when 'Purging all caches'. */
                return;
            }
            $lastrun = $thisrun;
        }

        static $folder = null;
        if (empty($folder)) {
            global $CFG, $PAGE;
            $themedir = $PAGE->theme->dir;
            $folder = '.';

            if (file_exists("$CFG->dirroot/theme/shoelace/$folder")) {
                $folder = "$CFG->dirroot/theme/shoelace";
            } else if (!empty($CFG->themedir) and file_exists("$CFG->themedir/shoelace")) {
                $folder = "$CFG->themedir/shoelace";
            } else {
                $folder = dirname(__FILE__);
            }
        }

        $iconcolour = self::get_setting('iconcolour');
        if (strlen($iconcolour) > 0) {
            $currenticoncolour = self::get_config_setting('currenticoncolour');
            // Do we need to look at all the files and change them?
            if (strcmp($currenticoncolour, $iconcolour) != 0) {
                set_config('currenticoncolour', $iconcolour, 'theme_shoelace');
                $files = array();
                self::svg_files($files, $folder . '/pix/fp');
                self::svg_files($files, $folder . '/pix_core');
                self::svg_files($files, $folder . '/pix_plugins');
                $attrset = false;

                foreach ($files as $file => $filename) {
                    $svg = simplexml_load_file($filename);
                    if (isset($svg->path)) {
                        foreach ($svg->path as $pathidx => $path) {
                            foreach ($path->attributes() as $attridx => $attr) {
                                if ((strcmp($attridx, 'fill') == 0)) {
                                    if ((strcmp($attr, '#fff') != 0) && (strcmp($attr, $iconcolour) != 0)) {
                                        $path['fill'] = $iconcolour;
                                        $attrset = true;
                                    }
                                }
                            }
                        }
                        if ($attrset) {
                            $svg->asXML($filename);
                            $attrset = false;
                        }
                    }
                }
                \purge_all_caches();  // Reset cache even though setting would have done this, files not updated on system!
            }
        }
    }

    static private function svg_files(&$files, $root) {
        if (file_exists($root)) {
            $thefiles = scandir($root);

            foreach ($thefiles as $file => $filename) {
                if ((strlen($filename) == 1) && ($filename[0] == '.')) {
                    continue;
                }
                if ((strlen($filename) == 2) && ($filename[0] == '.') && ($filename[1] == '.')) {
                    continue;
                }
                if (is_dir("$root/$filename")) {
                    self::svg_files($files, "$root/$filename");
                } else if (strpos($filename, '.svg') !== false) { // TODO: See if 'finfo_file' is better.
                    $files[] = $root . '/' . $filename;
                }
            }
        }
    }

    /**
     * Returns the RGB for the given hex.
     *
     * @param string $hex
     * @return array
     */
    static private function hex2rgb($hex) {
        // From: http://bavotasan.com/2011/convert-hex-color-to-rgb-using-php/.
        $hex = str_replace("#", "", $hex);

        if (strlen($hex) == 3) {
            $r = hexdec(substr($hex, 0, 1).substr($hex, 0, 1));
            $g = hexdec(substr($hex, 1, 1).substr($hex, 1, 1));
            $b = hexdec(substr($hex, 2, 1).substr($hex, 2, 1));
        } else {
            $r = hexdec(substr($hex, 0, 2));
            $g = hexdec(substr($hex, 2, 2));
            $b = hexdec(substr($hex, 4, 2));
        }
        $rgb = array('r' => $r, 'g' => $g, 'b' => $b);
        return $rgb; // Returns the rgb as an array.
    }

    /**
     * Returns the RGBA for the given hex and alpha.
     *
     * @param string $hex
     * @param string $alpha
     * @return string
     */
    static private function hex2rgba($hex, $alpha) {
        $rgba = self::hex2rgb($hex);
        $rgba[] = $alpha;
        return 'rgba('.implode(", ", $rgba).')'; // Returns the rgba values separated by commas.
    }
}
