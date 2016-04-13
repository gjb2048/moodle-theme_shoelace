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
        $settingvalue = false;
        foreach ($this->themeconfig as $tconfig) {
            if (property_exists($tconfig->settings, $setting)) {
                $settingvalue = $tconfig->settings->$setting;
                break;
            }
        }
        return $settingvalue;
    }

    public function setting_file_url($setting, $filearea) {
        $settingconfig = null;
        foreach ($this->themeconfig as $tconfig) {
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

    // The page.
    public function render_page() {
        // Setup other elements for the page.
        if ($this->page->pagelayout == 'course') {
            $this->page->requires->js_call_amd('theme_shoelace/course_navigation', 'init');
        }
        if (\theme_shoelace\toolbox::get_setting('navbarscroll') == 2) {
            $data = array('data' => array('navbarscrollupamount' => \theme_shoelace\toolbox::get_setting('navbarscrollupamount')));
            $this->page->requires->js_call_amd('theme_shoelace/scroll', 'init', $data);
        }

        return $this->render_wrapper_template();
    }

    // Mustache.
    protected function render_wrapper_template() {
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

        $data->body_attributes = $this->body_attributes();
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
        throw new \coding_exception(get_string('norendertemplatemethod', 'theme_shoelace',
            array('callablemethod' => $callablemethod)));
    }

    protected function get_base_data() {
        global $CFG, $SITE;

        if (!$this->page->has_set_url()) {
            $thispageurl = new \moodle_url(\qualified_me());
            $this->page->set_url($thispageurl, $thispageurl->params());
        }

        $data = new \stdClass();

        // Add the other common page data.
        if (empty($this->page->layout_options['nocourseheader'])) {
            $data->course_content_header = $this->course_content_header();
        } else {
            $data->course_content_header = '';
        }
        $data->main_content = $this->main_content();
        if (empty($this->page->layout_options['nocoursefooter'])) {
            $data->course_content_footer = $this->course_content_footer();
        } else {
            $data->course_content_footer = '';
        }

        return $data;
    }

    protected function render_columns1_template() {
        $data = $this->get_base_data();

        $data->header_tile = $this->render_template('header_tile');
        $data->page_header_tile = $this->render_template('page_header_tile');
        $data->footer_tile = $this->render_template('footer_tile');

        return $this->render_from_template('theme_shoelace/columns1', $data);
    }

    protected function render_columns2_template() {
        if ($this->page->user_is_editing()) {
            $hassidepre = true;
        } else {
            $hassidepre = (empty($this->page->layout_options['noblocks']) &&
                $this->page->blocks->region_has_content('side-pre', $this));
        }

        $regionmain = 'span9';
        if ($hassidepre) {
            $sidepre = 'span3';
        } else {
            $regionmain = 'span12';
        }
        if (!right_to_left()) {
            // Layout mark-up for LTR languages.
            if ($hassidepre) {
                $regionmain .= ' pull-right';
                $sidepre .= ' desktop-first-column';
            }
        }

        $data = $this->get_base_data();

        $data->regionmain = $regionmain;
        if ($hassidepre) {
            $data->blocks_side_pre = $this->shoelaceblocks('side-pre', $sidepre);
        }
        $data->header_tile = $this->render_template('header_tile');
        $data->page_header_tile = $this->render_template('page_header_tile');
        $data->footer_tile = $this->render_template('footer_tile');

        return $this->render_from_template('theme_shoelace/columns2', $data);
    }

    protected function get_threecolumns_common_data() {
        if ($this->page->user_is_editing()) {
            $hassidepre = $hassidepost = true;
        } else {
            $hassidepre = (empty($this->page->layout_options['noblocks']) &&
                $this->page->blocks->region_has_content('side-pre', $this));
            $hassidepost = (empty($this->page->layout_options['noblocks']) &&
                $this->page->blocks->region_has_content('side-post', $this));
        }

        if ($hassidepre) {
            $regionmain = 'span8';
            $sidepre = 'span4';
        } else {
            $regionmain = 'span12';
        }

        if ($hassidepost) {
            $regionmainbox = 'span9';
            $sidepost = 'span3';
        } else {
            $regionmainbox = 'span12';
        }

        if (right_to_left()) {
            // Layout mark-up for RTL languages.
            if ($hassidepost) {
                $regionmainbox .= ' pull-right';
                $sidepost .= ' desktop-first-column';
            }
        } else {
            // Layout mark-up for LTR languages.
            if ($hassidepre) {
                $regionmain .= ' pull-right';
                $sidepre .= ' desktop-first-column';
            }
        }

        $data = $this->get_base_data();

        $data->regionmainbox = $regionmainbox;
        $data->regionmain = $regionmain;
        if ($hassidepre) {
            $data->blocks_side_pre = $this->shoelaceblocks('side-pre', $sidepre);
        }
        if ($hassidepost) {
            $data->blocks_side_post = $this->shoelaceblocks('side-post', $sidepost);
        }
        $data->header_tile = $this->render_template('header_tile');
        $data->footer_tile = $this->render_template('footer_tile');

        return $data;
    }

    protected function render_columns3_template() {
        $data = $this->get_threecolumns_common_data();
        $data->page_header_tile = $this->render_template('page_header_tile');
        return $this->render_from_template('theme_shoelace/columns3', $data);
    }

    protected function render_secure_template() {
        // Template does not have course content header and footer, so even though in data will not be rendered.
        $data = $this->get_threecolumns_common_data();
        $data->page_header_tile = $this->render_template('page_header_tile');
        return $this->render_from_template('theme_shoelace/secure', $data);
    }

    protected function render_frontpage_template() {
        $data = $this->get_threecolumns_common_data();

        // Logo only on frontpage.
        $logo = \theme_shoelace\toolbox::get_setting('logo');
        if (!empty($logo)) {
            global $CFG;
            $heading = \html_writer::link($CFG->wwwroot, '', array('title' => get_string('home'), 'class' => 'logo'));
        } else {
            global $OUTPUT;
            $heading = $this->page_heading();
        }

        $data->page_header_tile = '<header id="page-header" class="clearfix">'.$heading.'</header>';

        // Marketing blocks.
        $nummarketingblocks = \theme_shoelace\toolbox::get_setting('nummarketingblocks');
        if ($nummarketingblocks) {
            $data->marketing_blocks = $this->shoelaceblocks('marketing', 'row-fluid', 'aside', $nummarketingblocks);
        }

        // Slideshow.
        $data->slideshow = $this->render_template('carousel_tile');

        return $this->render_from_template('theme_shoelace/frontpage', $data);
    }

    protected function render_popup_template() {
        $data = $this->get_base_data();

        return $this->render_from_template('theme_shoelace/popup', $data);
    }

    protected function render_embedded_template() {
        $data = new \stdClass();

        $data->main_content = $this->main_content();

        return $this->render_from_template('theme_shoelace/embedded', $data);
    }

    protected function render_maintenance_template() {
        $data = new \stdClass();

        $data->heading = $this->page_heading();
        $data->main_content = $this->main_content();
        $data->footer = $this->standard_footer_html();

        return $this->render_from_template('theme_shoelace/maintenance', $data);
    }

    protected function render_cdnfonts_tile_template() {
        $data = new \stdClass();

        return $this->render_from_template('theme_shoelace/#cdnfonts', $data);
    }

    protected function render_header_tile_template() {
        if (empty($this->page->layout_options['nonavbar'])) {
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
            $data->search_box = $this->search_box();
            $data->user_menu = $this->user_menu();
            $data->custom_menu = $this->custom_menu();
            $data->page_heading_menu = $this->page_heading_menu();

            return $this->render_from_template('theme_shoelace/#header', $data);
        } else {
            return '';
        }
    }

    protected function render_page_header_tile_template() {
        $data = new \stdClass();

        if (right_to_left()) {
            $data->rtl = true;
        } else {
            $data->ltr = true;
        }

        $data->breadcrumb = $this->navbar();
        $data->page_heading_button = $this->page_heading_button();

        $data->context_header = $this->context_header();
        $data->course_header = $this->course_header();

        return $this->render_from_template('theme_shoelace/#page_header', $data);
    }

    protected function showslider() {
        // Get the specified slidecount.
        $numberofslides = \theme_shoelace\toolbox::get_setting('numberofslides');

        if ($numberofslides > 0) {
            // Show slides according to toggle setting.
            $toggleslider = \theme_shoelace\toolbox::get_setting('toggleslideshow');
            switch ($toggleslider) {
                case 1:
                    $showslides = true;
                    break;
                case 2:
                    $showslides = !(isloggedin());
                    break;
                case 3:
                    $showslides = isloggedin();
                    break;
                case 0:
                default:
                    $showslides = false;
            }

            // We can show slides and we have slides, then finally check if we can show on this device.
            if ($showslides) {
                $devicetype = \core_useragent::get_device_type(); // In useragent.php.
                if (($devicetype == "mobile") && \theme_shoelace\toolbox::get_setting('hideonphone')) {
                    $numberofslides = 0;
                } else if (($devicetype == "tablet") && \theme_shoelace\toolbox::get_setting('hideontablet')) {
                    $numberofslides = 0;
                }
            } else {
                $numberofslides = 0;
            }
        }

        return $numberofslides;
    }

    protected function render_carousel_tile_template() {
        $numberofslides = $this->showslider();
        if (!empty($numberofslides)) {

            $data = new \stdClass();

            $data->my_carousel = 'shoelacecarousel';

            $jsdata = array('data' => array('slideinterval' => \theme_shoelace\toolbox::get_setting('slideinterval'),
                'id' => $data->my_carousel));
            $this->page->requires->js_call_amd('theme_shoelace/carousel', 'init', $jsdata);

            $data->centered = (\theme_shoelace\toolbox::get_setting('slidecaptioncentred')) ? ' centred' : '';

            $captionoptions = \theme_shoelace\toolbox::get_setting('slidecaptionoptions');

            switch($captionoptions) {
                case 1:
                    $data->below = ' ontop';
                break;
                case 2:
                    $data->below = ' below';
                break;
                default:
                    $data->below = '';
            }
            if ($captionoptions == 0) {
                $slideextraclass = ' side-caption';
            } else {
                $slideextraclass = '';
            }

            for ($slideindex = 1; $slideindex <= $numberofslides; $slideindex++) {
                $slideurl = \theme_shoelace\toolbox::get_setting('slide'.$slideindex.'url');
                $slideurltarget = \theme_shoelace\toolbox::get_setting('slide'.$slideindex.'target');
                $slidetitle = \theme_shoelace\toolbox::get_setting('slide'.$slideindex);
                $slidecaption = \theme_shoelace\toolbox::get_setting('slide'.$slideindex.'caption', 'format_html');
                if ($slideurl) {
                    // Strip links from the caption to prevent link in a link.
                    $slidecaption = preg_replace('/<a href=\"(.*?)\">(.*?)<\/a>/', "\\2", $slidecaption);
                }
                $slideimagealt = strip_tags($slidetitle);

                $indicator = '<li data-target="#'.$data->my_carousel.'" data-slide-to="'.($slideindex - 1).'"';
                if ($slideindex == 1) {
                    $indicator .= ' class="active"';
                }
                $indicator .= '></li>';
                $data->indicators[] = $indicator;

                // Get slide image or fallback to default.
                $slideimage = self::get_setting('slide'.$slideindex.'image');
                if ($slideimage) {
                    $slideimage = self::setting_file_url('slide'.$slideindex.'image', 'slide'.$slideindex.'image');
                } else {
                    $slideimage = self::pix_url('default_slide', 'theme');
                }

                if ($slideurl) {
                    $slide = '<a href="'.$slideurl.'" target="'.$slideurltarget.'" class="item'.$slideextraclass;
                } else {
                    $slide = '<div class="item'.$slideextraclass;
                }
                if ($slideindex == 1) {
                    $slide .= ' active';
                }
                $slide .= '">';

                if ($captionoptions == 0) {
                    $slide .= '<div class="container-fluid">';
                    $slide .= '<div class="row-fluid">';

                    if ($slidetitle || $slidecaption) {
                        $slide .= '<div class="span5 the-side-caption">';
                        $slide .= '<div class="the-side-caption-content">';
                        $slide .= '<h4>'.$slidetitle.'</h4>';
                        $slide .= '<div>'.$slidecaption.'</div>';
                        $slide .= '</div>';
                        $slide .= '</div>';
                        $slide .= '<div class="span7">';
                    } else {
                        $slide .= '<div class="span10 offset1 nocaption">';
                    }
                    $slide .= '<div class="carousel-image-container">';
                    $slide .= '<img src="'.$slideimage.'" alt="'.$slideimagealt.'" class="carousel-image">';
                    $slide .= '</div>';
                    $slide .= '</div>';

                    $slide .= '</div>';
                    $slide .= '</div>';
                } else {
                    $nocaption = (!($slidetitle || $slidecaption)) ? ' nocaption' : '';
                    $slide .= '<div class="carousel-image-container'.$nocaption.'">';
                    $slide .= '<img src="'.$slideimage.'" alt="'.$slideimagealt.'" class="carousel-image">';
                    $slide .= '</div>';

                    // Output title and caption if either is present.
                    if ($slidetitle || $slidecaption) {
                        $slide .= '<div class="carousel-caption">';
                        $slide .= '<div class="carousel-caption-inner">';
                        $slide .= '<h4>'.$slidetitle.'</h4>';
                        $slide .= '<div>'.$slidecaption.'</div>';
                        $slide .= '</div>';
                        $slide .= '</div>';
                    }
                }

                $slide .= ($slideurl) ? '</a>' : '</div>';
                $data->slides[] = $slide;
            }
            return $this->render_from_template('theme_shoelace/#carousel', $data);
        } else {
            return '';
        }
    }

    protected function render_footer_tile_template() {
        if (empty($this->page->layout_options['nofooter'])) {
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
        } else {
            return '';
        }
    }

    protected function render_footer_blocks_tile_template() {
        $data = new \stdClass();

        $data->footer_blocks = $this->shoelaceblocks('footer', 'row-fluid', 'aside',
            \theme_shoelace\toolbox::get_setting('numfooterblocks'));

        return $this->render_from_template('theme_shoelace/#footer_blocks', $data);
    }
}
