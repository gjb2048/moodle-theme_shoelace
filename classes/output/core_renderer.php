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

namespace theme_shoelace\output;

use custom_menu;
use html_writer;
use coding_exception;
use block_contents;
use block_move_target;
use moodle_url;

require_once($CFG->dirroot . '/theme/bootstrapbase/renderers/core_renderer.php');  // Urrgh, but it works for child themes.

class core_renderer extends \theme_bootstrapbase_core_renderer {
    use core_renderer_toolbox;

    protected $shoelace = null; // Used for determining if this is a Shoelace or child of renderer.

    protected $themeconfig = array();

    public function __construct(\moodle_page $page, $target) {
        $this->themeconfig[] = \theme_config::load('shoelace');
        parent::__construct($page, $target);
    }

    public function get_less_file($filename) {
        global $CFG;
        $filename .= '.less';

        if (file_exists("$CFG->dirroot/theme/shoelace/less/$filename")) {
            return "$CFG->dirroot/theme/shoelace/less/$filename";
        } else if (!empty($CFG->themedir) and file_exists("$CFG->themedir/shoelace/less/$filename")) {
            return "$CFG->themedir/shoelace/less/$filename";
        } else {
            return dirname(__FILE__) . "/$filename";
        }
    }

    /*
     * This renders the navbar.
     * Uses bootstrap compatible html.
     */
    public function navbar() {
        $items = $this->page->navbar->get_items();
        if (right_to_left()) {
            $dividericon = 'fa-angle-left';
        } else {
            $dividericon = 'fa-angle-right';
        }
        $divider = html_writer::tag('span', html_writer::start_tag('span',
            array('class' => 'fa '.$dividericon.' fa-lg', 'aria-hidden' => 'true')).
            html_writer::end_tag('span'), array('class' => 'divider'));
        $breadcrumbs = array();
        foreach ($items as $item) {
            $item->hideicon = true;
            $breadcrumbs[] = $this->render($item);
        }
        $listitems = html_writer::start_tag('li').implode("$divider".html_writer::end_tag('li').
            html_writer::start_tag('li'), $breadcrumbs).html_writer::end_tag('li');
        $title = html_writer::tag('span', get_string('pagepath'), array('class' => 'accesshide', 'id' => 'navbar-label'));
        return $title.html_writer::start_tag('nav', array('aria-labelledby' => 'navbar-label')).
            html_writer::tag('ul', "$listitems", array('class' => 'breadcrumb')).
            html_writer::end_tag('nav');
    }

    /**
     * Returns HTML to display a "Turn editing on/off" button in a form.
     *
     * @param moodle_url $url The URL + params to send through when clicking the button
     * @return string HTML the button
     */
    public function edit_button(moodle_url $url) {
        $url->param('sesskey', sesskey());
        if ($this->page->user_is_editing()) {
            $url->param('edit', 'off');
            $btn = 'btn-danger';
            $title = get_string('turneditingoff');
            $icon = 'icon-off';
        } else {
            $url->param('edit', 'on');
            $btn = 'btn-success';
            $title = get_string('turneditingon');
            $icon = 'icon-edit';
        }
        return html_writer::tag('a', html_writer::start_tag('span', array('class' => $icon . ' icon-white')) .
            html_writer::end_tag('span'), array('href' => $url, 'class' => 'btn ' . $btn, 'title' => $title));
    }

    /**
     * Renders tabtree
     *
     * @param tabtree $tabtree
     * @return string
     */
    protected function render_tabtree(\tabtree $tabtree) {
        if (empty($tabtree->subtree)) {
            return '';
        }
        $firstrow = $secondrow = '';
        foreach ($tabtree->subtree as $tab) {
            $firstrow .= $this->render($tab);
            if (($tab->selected || $tab->activated) && !empty($tab->subtree) && $tab->subtree !== array()) {
                $secondrow = $this->tabtree($tab->subtree);
            }
        }
        return html_writer::tag('ul', $firstrow, array('class' => 'nav nav-pills')) . $secondrow;
    }

    /**
     * Returns lang menu or '', this method also checks forcing of languages in courses.
     *
     * This function calls {@link core_renderer::render_single_select()} to actually display the language menu.
     *
     * @return string The lang menu HTML or empty string
     */
    public function lang_menu() {
        if (!empty($this->page->layout_options['langmenu'])) {
            return parent::lang_menu();
        } else {
            return '';
        }
    }

    /**
     * Returns a search box.
     *
     * @param  string $id     The search box wrapper div id, defaults to an autogenerated one.
     * @return string         HTML with the search form hidden by default.
     */
    public function search_box($id = false) {
        global $CFG;

        // Accessing $CFG directly as using \core_search::is_global_search_enabled would
        // result in an extra included file for each site, even the ones where global search
        // is disabled.
        if (empty($CFG->enableglobalsearch) || !has_capability('moodle/search:query', \context_system::instance())) {
            return '';
        }

        if ($id == false) {
            $id = uniqid();
        } else {
            // Needs to be cleaned, we use it for the input id.
            $id = clean_param($id, PARAM_ALPHANUMEXT);
        }

        // JS to animate the form.
        $this->page->requires->js_call_amd('core/search-input', 'init', array($id));

        $searchicon = html_writer::tag('span', '',
            array('class' => 'fa fa-search', 'aria-hidden' => 'true', 'title' => get_string('search', 'search')));
        $searchicon = html_writer::tag('div', $searchicon, array('role' => 'button', 'tabindex' => 0));
        $formattrs = array('class' => 'search-input-form', 'action' => $CFG->wwwroot . '/search/index.php');
        $inputattrs = array('type' => 'text', 'name' => 'q', 'placeholder' => get_string('search', 'search'),
            'size' => 13, 'tabindex' => -1, 'id' => 'id_q_' . $id);

        $contents = html_writer::tag('label', get_string('enteryoursearchquery', 'search'),
            array('for' => 'id_q_' . $id, 'class' => 'accesshide')) . html_writer::tag('input', '', $inputattrs);
        $searchinput = html_writer::tag('form', $contents, $formattrs);

        return html_writer::tag('div', $searchicon . $searchinput, array('class' => 'search-input-wrapper', 'id' => $id));
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
        $layout = \theme_shoelace\toolbox::get_setting('layout_'.$this->page->pagelayout);
        if ($layout) {
            $mustache = $layout;
        } else {
            $mustache = $this->page->theme->layouts[$this->page->pagelayout]['mustache'];
        }

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

        if ($this->page->user_is_editing()) {
            $hasblocks = true;
            $haspre = true;
            $hasmiddle = true;
            $haspost = true;
        } else {
            if (empty($this->page->layout_options['noblocks'])) {
                $haspre = $this->page->blocks->region_has_content('side-pre', $this);
                $hasmiddle = $this->page->blocks->region_has_content('middle', $this);
                $haspost = $this->page->blocks->region_has_content('side-post', $this);
                $hasblocks = ($haspre || $haspost || $hasmiddle);
            } else {
                $hasblocks = false;
            }
        }

        if ($hasblocks) {
            $blockcolumns = \theme_shoelace\toolbox::get_setting('nummiddleblocks');
            $data->blocks = '<div class="row-fluid onecblocks">';
            if ($haspre) {
                $data->blocks .= $this->shoelaceblocks('side-pre', 'row-fluid', 'aside', $blockcolumns);
            }
            if ($hasmiddle) {
                $data->blocks .= $this->shoelaceblocks('middle', 'row-fluid', 'aside', $blockcolumns);
            }
            if ($haspost) {
                $data->blocks .= $this->shoelaceblocks('side-post', 'row-fluid', 'aside', $blockcolumns);
            }
            $data->blocks .= '</div>';
        }

        $data->footer_tile = $this->render_template('footer_tile');

        return $this->render_from_template('theme_shoelace/columns1', $data);
    }

    protected function render_columns2_template() {
        if ($this->page->user_is_editing()) {
            $hasblocks = true;
            $haspre = true;
            $hasmiddle = true;
            $haspost = true;
        } else {
            if (empty($this->page->layout_options['noblocks'])) {
                $haspre = $this->page->blocks->region_has_content('side-pre', $this);
                $hasmiddle = $this->page->blocks->region_has_content('middle', $this);
                $haspost = $this->page->blocks->region_has_content('side-post', $this);
                $hasblocks = ($haspre || $haspost || $hasmiddle);
            } else {
                $hasblocks = false;
            }
        }

        $regionmain = 'span9';
        if ($hasblocks) {
            $side = 'span3';
        } else {
            $regionmain = 'span12';
        }
        if (!right_to_left()) {
            // Layout mark-up for LTR languages.
            if ($hasblocks) {
                $regionmain .= ' pull-right';
                $side .= ' desktop-first-column';
            }
        }

        $data = $this->get_base_data();

        $data->regionmain = $regionmain;
        if ($hasblocks) {
            $data->blocks = '<div class="'.$side.'">';
            if ($haspre) {
                $data->blocks .= $this->shoelaceblocks('side-pre');
            }
            if ($hasmiddle) {
                $data->blocks .= $this->shoelaceblocks('middle');
            }
            if ($haspost) {
                $data->blocks .= $this->shoelaceblocks('side-post');
            }
            $data->blocks .= '</div>';
        }
        $data->header_tile = $this->render_template('header_tile');
        $data->page_header_tile = $this->render_template('page_header_tile');
        $data->footer_tile = $this->render_template('footer_tile');

        return $this->render_from_template('theme_shoelace/columns2', $data);
    }

    protected function get_threecolumns_common_data() {
        if ($this->page->user_is_editing()) {
            $hassidepre = $hassidepost = $hasmiddle = $hassidepremiddle = true;
        } else {
            $hassidepre = (empty($this->page->layout_options['noblocks']) &&
                $this->page->blocks->region_has_content('side-pre', $this));
            $hasmiddle = (empty($this->page->layout_options['noblocks']) &&
                $this->page->blocks->region_has_content('middle', $this));
            $hassidepremiddle = (($hassidepre) || ($hasmiddle));
            $hassidepost = (empty($this->page->layout_options['noblocks']) &&
                $this->page->blocks->region_has_content('side-post', $this));
        }

        if ($hassidepremiddle) {
            $regionmain = 'span8';
            $sidepremiddle = 'span4';
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
            if ($hassidepremiddle) {
                $regionmain .= ' pull-right';
                $sidepremiddle .= ' desktop-first-column';
            }
        }

        $data = $this->get_base_data();

        $data->regionmainbox = $regionmainbox;
        $data->regionmain = $regionmain;

        if ($hassidepremiddle) {
            $data->blocks_side_pre_middle = '<div class="'.$sidepremiddle.'">';
            if ($hassidepre) {
                $data->blocks_side_pre_middle .= $this->shoelaceblocks('side-pre');
            }
            if ($hasmiddle) {
                $data->blocks_side_pre_middle .= $this->shoelaceblocks('middle');
            }
            $data->blocks_side_pre_middle .= '</div>';
        }

        if ($hassidepost) {
            $data->blocks_side_post = $this->shoelaceblocks('side-post', $sidepost);
        }
        $data->header_tile = $this->render_template('header_tile');
        $data->footer_tile = $this->render_template('footer_tile');

        return $data;
    }

    protected function get_threecolumns_middle_common_data($middlecolumns) {
        if ($this->page->user_is_editing()) {
            $hassidepre = $hassidepost = $hasmiddle = true;
        } else {
            $hassidepre = (empty($this->page->layout_options['noblocks']) &&
                $this->page->blocks->region_has_content('side-pre', $this));
            $hasmiddle = (empty($this->page->layout_options['noblocks']) &&
                $this->page->blocks->region_has_content('middle', $this));
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

        if (($middlecolumns) && ($hasmiddle)) {
            $data->blocks_middle = $this->shoelaceblocks('middle', 'row-fluid', 'aside', $middlecolumns);
        }
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

    protected function render_columns3middle_template() {
        $data = $this->get_threecolumns_middle_common_data(\theme_shoelace\toolbox::get_setting('nummiddleblocks'));
        $data->page_header_tile = $this->render_template('page_header_tile');
        return $this->render_from_template('theme_shoelace/columns3middle', $data);
    }

    protected function render_secure_template() {
        // Template does not have course content header and footer, so even though in data will not be rendered.
        $data = $this->get_threecolumns_common_data();
        $data->page_header_tile = $this->render_template('page_header_tile');
        return $this->render_from_template('theme_shoelace/secure', $data);
    }

    protected function render_frontpage_template() {
        $data = $this->get_threecolumns_middle_common_data(\theme_shoelace\toolbox::get_setting('nummarketingblocks'));

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

            if (($this->page->user_is_editing()) || (!empty($this->page->layout_options['noblocks']))) {
                if ($this->page->blocks->is_known_region('footer')) {
                    $data->footer_blocks = $this->render_template('footer_blocks_tile');
                }
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

    /**
     * Get the HTML for blocks in the given region.
     *
     * @since 2.5.1 2.6
     * @param string $region The region to get HTML for.
     * @param array $classes array of classes for the tag.
     * @param string $tag Tag to use.
     * @param int $blocksperrow if > 0 then this is a footer block specifying the number of blocks per row, max of '4'.
     * @return string HTML.
     */
    public function shoelaceblocks($region, $classes = array(), $tag = 'aside', $blocksperrow = 0) {
        $classes = (array) $classes;
        $classes[] = 'block-region';

        $attributes = array(
            'id' => 'block-region-' . preg_replace('#[^a-zA-Z0-9_\-]+#', '-', $region),
            'class' => join(' ', $classes),
            'data-blockregion' => $region,
            'data-droptarget' => '1'
        );

        $regioncontent = '';
        $editing = $this->page->user_is_editing();
        if ($editing) {
            $regioncontent .= html_writer::tag('div', get_string('region-'.$region, 'theme_shoelace'), array('class' => 'regionname'));
        }

        if ($this->page->blocks->region_has_content($region, $this)) {
            if ($blocksperrow > 0) {
                if ($editing) {
                    $attributes['class'] .= ' '.$region.'-edit';
                }
                $regioncontent .= $this->shoelace_blocks_for_region($region, $blocksperrow, $editing);
                $output = html_writer::tag($tag, $regioncontent, $attributes);
            } else {
                $regioncontent .= $this->blocks_for_region($region);
                $output = html_writer::tag($tag, $regioncontent, $attributes);
            }
        } else {
            $output = html_writer::tag($tag, $regioncontent, $attributes);
        }

        return $output;
    }

    /**
     * Output all the blocks in a particular region.
     *
     * @param string $region the name of a region on this page.
     * @param int $blocksperrow Number of blocks per row, if > 4 will be set at 4.
     * @param boolean $editing If we are editing.
     * @return string the HTML to be output.
     */
    protected function shoelace_blocks_for_region($region, $blocksperrow, $editing) {
        $blockcontents = $this->page->blocks->get_content_for_region($region, $this);
        $output = '';

        $blockcount = count($blockcontents);

        if ($blockcount >= 1) {
            if (!$editing) {
                $output .= html_writer::start_tag('div', array('class' => 'row-fluid'));
            }
            $blocks = $this->page->blocks->get_blocks_for_region($region);
            $lastblock = null;
            $zones = array();
            foreach ($blocks as $block) {
                $zones[] = $block->title;
            }

            /*
             * When editing we want all the blocks to be the same as side-pre / side-post so set by CSS:
             *
             * aside.footer-edit .block {
             *     .footer-fluid-span(3);
             * }
             */
            if (($blocksperrow > 4) || ($editing)) {
                $blocksperrow = 4; // Will result in a 'span3' when more than one row.
            }
            $rows = $blockcount / $blocksperrow; // Maximum blocks per row.

            if (!$editing) {
                if ($rows <= 1) {
                    $span = 12 / $blockcount;
                    if ($span < 1) {
                        // Should not happen but a fail safe - block will be small so good for screen shots when this happens.
                        $span = 1;
                    }
                } else {
                    $span = 12 / $blocksperrow;
                }
            }

            $currentblockcount = 0;
            $currentrow = 0;
            $currentrequiredrow = 1;
            foreach ($blockcontents as $bc) {

                if (!$editing) { // Using CSS and special 'span3' only when editing.
                    $currentblockcount++;
                    if ($currentblockcount > ($currentrequiredrow * $blocksperrow)) {
                        // Tripping point.
                        $currentrequiredrow++;
                        // Break...
                        $output .= html_writer::end_tag('div');
                        $output .= html_writer::start_tag('div', array('class' => 'row-fluid'));
                        // Recalculate span if needed...
                        $remainingblocks = $blockcount - ($currentblockcount - 1);
                        if ($remainingblocks < $blocksperrow) {
                            $span = 12 / $remainingblocks;
                            if ($span < 1) {
                                // Should not happen but a fail safe.
                                // Block will be small so good for screen shots when this happens.
                                $span = 1;
                            }
                        }
                    }

                    if ($currentrow < $currentrequiredrow) {
                        $currentrow = $currentrequiredrow;
                    }

                    // The 'desktop-first-column' done in CSS with ':first-of-type' and ':nth-of-type'.
                    // The 'spanX' done in CSS with calculated special width class as fixed at 'span3' for all.
                    $bc->attributes['class'] .= ' span' . $span;
                }

                if ($bc instanceof block_contents) {
                    $output .= $this->block($bc, $region);
                    $lastblock = $bc->title;
                } else if ($bc instanceof block_move_target) {
                    $output .= $this->block_move_target($bc, $zones, $lastblock);
                } else {
                    throw new coding_exception('Unexpected type of thing ('.get_class($bc).') found in list of block contents.');
                }
            }
            if (!$editing) {
                $output .= html_writer::end_tag('div');
            }
        }

        return $output;
    }

    public function gotobottom_menu() {
        $gotobottommenu = new custom_menu('', current_language());
        return $this->render_gotobottom_menu($gotobottommenu);
    }

    protected function render_gotobottom_menu(custom_menu $menu) {
        if (($this->page->pagelayout == 'course') ||
            ($this->page->pagelayout == 'incourse') ||
            ($this->page->pagelayout == 'admin')) { // Go to bottom.
            $gotobottom = html_writer::tag('span', '',
                array('class' => 'fa fa-arrow-circle-o-down slgotobottom', 'aria-hidden' => 'true'));
            $url = new moodle_url($this->page->url);
            $url->set_anchor('page-footer');
            $menu->add($gotobottom, $url, get_string('gotobottom', 'theme_shoelace'), 10001);
        }

        $content = html_writer::start_tag('ul', array('class' => 'nav slgotobottommenu'));
        foreach ($menu->get_children() as $item) {
            $content .= $this->render_custom_menu_item($item, 1);
        }
        $content .= html_writer::end_tag('ul');

        return $content;
    }

    public function anti_gravity() {
        $icon = html_writer::start_tag('span',
            array('class' => 'fa fa-arrow-circle-o-up', 'aria-hidden' => 'true')).
            html_writer::end_tag('span');
        $antigravity = html_writer::tag('span', $icon, array('class' => 'antiGravity', 'title' => get_string('antigravity',
            'theme_shoelace')));

        return $antigravity;
    }

    /**
     * Either returns the parent version of the header bar, or a version with the logo replacing the header.
     *
     * @since Moodle 2.9
     * @param array $headerinfo An array of header information, dependant on what type of header is being displayed. The following
     *                          array example is user specific.
     *                          heading => Override the page heading.
     *                          user => User object.
     *                          usercontext => user context.
     * @param int $headinglevel What level the 'h' tag will be.
     * @return string HTML for the header bar.
     */
    public function context_header($headerinfo = null, $headinglevel = 1) {
        if ($headinglevel == 1 && !empty($this->page->theme->settings->logo)) {
            global $CFG;
            return html_writer::link($CFG->wwwroot, '', array('title' => get_string('home'), 'class' => 'logo'));
        }
        return parent::context_header($headerinfo, $headinglevel);
    }
}
