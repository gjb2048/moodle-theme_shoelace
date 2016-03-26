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
namespace theme_shoelace\output;

use html_writer;

defined('MOODLE_INTERNAL') || die();

trait core_renderer_toolbox {

    public function get_setting($setting) {
        $tcr = array_reverse($this->themeconfig, true);

        $settingvalue = false;
        foreach ($tcr as $tconfig) {
            if (property_exists($tconfig->settings, $setting)) {
                $settingvalue = $tconfig->settings->$setting;
                break;
            }
        }
        return $settingvalue;
    }

    public function setting_file_url($setting, $filearea) {
        $tcr = array_reverse($this->themeconfig, true);
        $settingconfig = null;
        foreach ($tcr as $tconfig) {
            if (property_exists($tconfig->settings, $setting)) {
                $settingconfig = $tconfig;
                break;
            }
        }

        if ($settingconfig) {
            return $settingconfig->setting_file_url($setting, $filearea);
        }
        return null;
    }

    public function pix_url($imagename, $component = 'moodle') {
        return end($this->themeconfig)->pix_url($imagename, $component);
    }

    public function standard_footer_html() {
        $output = parent::standard_footer_html();
        $output .= html_writer::start_tag('div', array ('class' => 'themecredit')).
                   get_string('credit', 'theme_shoelace').
                   html_writer::link('//about.me/gjbarnard', 'Gareth J Barnard', array('target' => '_blank')).
                   html_writer::end_tag('div');

        return $output;
    }

    // Mustache.
    public function render_wrapper_template() {
        $mustache = $this->page->theme->layouts[$this->page->pagelayout]['mustache'];

        $data = new \stdClass();
        $data->htmlattributes = $this->htmlattributes();
        $data->page_title = $this->page_title();
        $data->favicon = $this->favicon();
        $data->standard_head_html = $this->standard_head_html();

        if ($mustache != 'maintenance') {
            $cdnfonts = \theme_shoelace\toolbox::get_setting('cdnfonts');
            if (!empty($cdnfonts) && ($cdnfonts == 2)) {
                $data->cdn_fonts = $this->render_template('cdnfonts_tile');
            }
        }

        if ($mustache == 'columns2') {
            $data->body_attributes = $this->body_attributes('two-column');
        } else {
            $data->body_attributes = $this->body_attributes();
        }

        $data->standard_top_of_body_html = $this->standard_top_of_body_html();
        $data->pagelayout = $this->render_template($mustache);
        $data->standard_end_of_body_html = $this->standard_end_of_body_html();

        return $this->render_from_template('theme_shoelace/wrapper_layout', $data);
    }

    protected function render_template($mustache) {
        $callablemethod = 'render_'.$mustache.'_template';

        if (method_exists($this, $callablemethod)) {
            return $this->$callablemethod();
        }
        throw new coding_exception(get_string('norendertemplatemethod', 'theme_shoelace', array('callablemethod' => $callablemethod)));
    }

    protected function get_base_data() {
        global $CFG, $SITE;

        if (!$this->page->has_set_url()) {
            $thispageurl = new \moodle_url(\qualified_me());
            $this->page->set_url($thispageurl, $thispageurl->params());
        }

        $data = new \stdClass();

        /*
        if (!empty($this->page->theme->settings->logo)) {
            $data->html_heading = '<div class="logo"></div>';
        } else {
            $data->html_heading = $this->page_heading();
        }
        */

        // Add the other common page data.
        $data->course_content_header = $this->course_content_header();
        $data->main_content = $this->main_content();
        $data->course_content_footer = $this->course_content_footer();

/*
Logo only on frontpage.
        $logo = self::get_setting('logo');
        if (!empty($logo)) {
            global $CFG;
            $return->heading = \html_writer::link($CFG->wwwroot, '', array('title' => get_string('home'), 'class' => 'logo'));
        } else {
            global $OUTPUT;
            $return->heading = $OUTPUT->page_heading();
        }


*/
        return $data;
    }

    protected function render_columns2_template() {
        // Set default (LTR) layout mark-up for a two column page (side-pre-only).
        $regionmain = 'span9';
        $sidepre = 'span3';
        // Reset layout mark-up for RTL languages.
        if (right_to_left()) {
            $sidepre .= ' pull-right';
        } else {
            $regionmain .= ' pull-right';
            $sidepre .= ' desktop-first-column';
        }

        $data = $this->get_base_data();

        $data->regionmain = $regionmain;
        $data->blocks_side_pre = $this->blocks('side-pre', $sidepre);
        $data->header_tile = $this->render_template('header_tile');
        $data->page_header_tile = $this->render_template('page_header_tile');
        $data->footer_tile = $this->render_template('footer_tile');

        return $this->render_from_template('theme_shoelace/columns2', $data);
    }

    protected function render_cdnfonts_tile_template() {
        $data = new \stdClass();

        return $this->render_from_template('theme_shoelace/#cdfonts', $data);        
    }

    protected function render_header_tile_template() {
        global $CFG, $SITE;
        $data = new \stdClass();

        // Add the page data from the theme settings.
        $data->html_navbarclass = '';
        $inversenavbar = \theme_shoelace\toolbox::get_setting('inversenavbar');  // Refactor.
        if (!empty($this->page->theme->settings->invert)) {
            $data->html_navbarclass = ' navbar-inverse';
        }

        $data->wwwroot = $CFG->wwwroot;
        $data->shortname = \format_string($SITE->shortname, true,
            array('context' => \context_course::instance(\SITEID)));

        $data->gotobottom_menu = $this->gotobottom_menu();
        $data->user_menu = $this->user_menu();
        $data->custom_menu = $this->custom_menu();
        $data->page_heading_menu = $this->page_heading_menu();

        return $this->render_from_template('theme_shoelace/#header', $data);        
    }

    protected function render_page_header_tile_template() {
        $data = new \stdClass();

        if (right_to_left()) {
            $data->rtl = true;
        } else {
            $data->ltr = true;
        }

        $data->navbar = $this->navbar();
        $data->page_heading_button = $this->page_heading_button();

        $data->context_header = $this->context_header();
        $data->course_header = $this->course_header();

        return $this->render_from_template('theme_shoelace/#page_header', $data);        
    }

    protected function render_footer_tile_template() {
        $data = new \stdClass();

        if ($this->page->blocks->is_known_region('footer')) {
            $data->footer_blocks = $this->render_template('footer_blocks_tile');
        }

        $data->course_footer = $this->course_footer();
        $data->page_doc_link = $this->page_doc_link();

        $data->footnote = '';
        $footnote = \theme_shoelace\toolbox::get_setting('footnote');
        if (!empty($footnote)) {
            $data->footnote = '<div class="footnote text-center">'.$footnote.'</div>';
        }

        $data->login_info = $this->login_info();
        $data->home_link = $this->home_link();
        $data->standard_footer_html = $this->standard_footer_html();

        $data->anti_gravity = $this->anti_gravity();

        return $this->render_from_template('theme_shoelace/#footer', $data);        
    }

    protected function render_footer_blocks_tile_template() {
        $data = new \stdClass();

        $data->footer_blocks = $this->shoelaceblocks('footer', 'row-fluid', 'aside', \theme_shoelace\toolbox::get_setting('numfooterblocks'));;

        return $this->render_from_template('theme_shoelace/#footer_blocks', $data);        
    }
}
