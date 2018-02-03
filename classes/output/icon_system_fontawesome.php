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
 * @copyright  &copy; 2017-onwards G J Barnard in respect to modifications of the Clean theme.
 * @author     G J Barnard - {@link http://moodle.org/user/profile.php?id=442195}
 * @author     Based on code originally written by Mary Evans, Bas Brands, Stuart Lamour and David Scotson.
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
namespace theme_shoelace\output;

defined('MOODLE_INTERNAL') || die();

class icon_system_fontawesome extends \core\output\icon_system_fontawesome {

    /**
     * @var array $map Cached map of moodle icon names to font awesome icon names.
     */
    private $map = [];

    protected function get_updated_core_icon_map() {
        // Information on https://fontawesome.com/how-to-use/upgrading-from-4.
        return [
            'core:docs' => 'fa fa-info-circle',
            'core:help' => 'fa fa-question-circle text-info',
            'core:req' => 'fa fa-exclamation-circle text-danger',
            'core:a/add_file' => 'far fa-file',
            'core:a/create_folder' => 'far fa-folder',
            'core:a/download_all' => 'fa fa-download',
            'core:a/help' => 'fa fa-question-circle text-info',
            'core:a/logout' => 'fas fa-sign-out-alt',
            'core:a/refresh' => 'fas fa-sync',
            'core:a/search' => 'fa fa-search',
            'core:a/setting' => 'fa fa-cog',
            'core:a/view_icon_active' => 'fa fa-th',
            'core:a/view_list_active' => 'fa fa-list',
            'core:a/view_tree_active' => 'fa fa-folder',
            'core:b/bookmark-new' => 'fa fa-bookmark',
            'core:b/document-edit' => 'fas fa-pencil-alt',
            'core:b/document-new' => 'far fa-file',
            'core:b/document-properties' => 'fa fa-info',
            'core:b/edit-copy' => 'far fa-file',
            'core:b/edit-delete' => 'fa fa-trash',
            'core:e/abbr' => 'fa fa-comment',
            'core:e/absolute' => 'fa fa-crosshairs',
            'core:e/accessibility_checker' => 'fa fa-universal-access',
            'core:e/acronym' => 'fa fa-comment',
            'core:e/advance_hr' => 'fas fa-arrows-alt-h',
            'core:e/align_center' => 'fa fa-align-center',
            'core:e/align_left' => 'fa fa-align-left',
            'core:e/align_right' => 'fa fa-align-right',
            'core:e/anchor' => 'fas fa-link',
            'core:e/backward' => 'fa fa-undo',
            'core:e/bold' => 'fa fa-bold',
            'core:e/bullet_list' => 'fa fa-list-ul',
            'core:e/cancel' => 'fa fa-times',
            'core:e/cell_props' => 'fa fa-info',
            'core:e/cite' => 'fa fa-quote-right',
            'core:e/cleanup_messy_code' => 'fa fa-eraser',
            'core:e/clear_formatting' => 'fa fa-i-cursor',
            'core:e/copy' => 'fa fa-clone',
            'core:e/cut' => 'fas fa-cut',
            'core:e/decrease_indent' => 'fa fa-outdent',
            'core:e/delete_col' => 'fa fa-minus',
            'core:e/delete_row' => 'fa fa-minus',
            'core:e/delete' => 'fa fa-minus',
            'core:e/delete_table' => 'fa fa-minus',
            'core:e/document_properties' => 'fa fa-info',
            'core:e/emoticons' => 'far fa-smile',
            'core:e/find_replace' => 'fa fa-search-plus',
            'core:e/forward' => 'fa fa-arrow-right',
            'core:e/fullpage' => 'fas fa-expand-arrows-alt',
            'core:e/fullscreen' => 'fas fa-expand-arrows-alt',
            'core:e/help' => 'fa fa-question-circle',
            'core:e/increase_indent' => 'fa fa-indent',
            'core:e/insert_col_after' => 'fa fa-columns',
            'core:e/insert_col_before' => 'fa fa-columns',
            'core:e/insert_date' => 'fas fa-calendar-alt',
            'core:e/insert_edit_image' => 'fas fa-image',
            'core:e/insert_edit_link' => 'fa fa-link',
            'core:e/insert_edit_video' => 'fas fa-video',
            'core:e/insert_file' => 'fa fa-file',
            'core:e/insert_horizontal_ruler' => 'fas fa-arrows-alt-h',
            'core:e/insert_nonbreaking_space' => 'far fa-square',
            'core:e/insert_page_break' => 'fas fa-level-down-alt',
            'core:e/insert_row_after' => 'fa fa-plus',
            'core:e/insert_row_before' => 'fa fa-plus',
            'core:e/insert' => 'fa fa-plus',
            'core:e/insert_time' => 'far fa-clock',
            'core:e/italic' => 'fa fa-italic',
            'core:e/justify' => 'fa fa-align-justify',
            'core:e/layers_over' => 'fas fa-level-up-alt',
            'core:e/layers' => 'fa fa-window-restore',
            'core:e/layers_under' => 'fas fa-level-down-alt',
            'core:e/left_to_right' => 'fa fa-chevron-right',
            'core:e/manage_files' => 'far fa-copy',
            'core:e/math' => 'fa fa-calculator',
            'core:e/merge_cells' => 'fa fa-compress',
            'core:e/new_document' => 'far fa-file',
            'core:e/numbered_list' => 'fa fa-list-ol',
            'core:e/page_break' => 'fas fa-level-down-alt',
            'core:e/paste' => 'far fa-clipboard',
            'core:e/paste_text' => 'far fa-clipboard',
            'core:e/paste_word' => 'far fa-clipboard',
            'core:e/prevent_autolink' => 'fa fa-exclamation',
            'core:e/preview' => 'fa fa-search-plus',
            'core:e/print' => 'fa fa-print',
            'core:e/question' => 'fa fa-question',
            'core:e/redo' => 'fas fa-redo',
            'core:e/remove_link' => 'fas fa-unlink',
            'core:e/remove_page_break' => 'fas fa-times',
            'core:e/resize' => 'fa fa-expand',
            'core:e/restore_draft' => 'fa fa-undo',
            'core:e/restore_last_draft' => 'fa fa-undo',
            'core:e/right_to_left' => 'fa fa-chevron-left',
            'core:e/row_props' => 'fa fa-info',
            'core:e/save' => 'far fa-floppy',
            'core:e/screenreader_helper' => 'fa fa-braille',
            'core:e/search' => 'fa fa-search',
            'core:e/select_all' => 'fas fa-arrows-alt-h',
            'core:e/show_invisible_characters' => 'fa fa-eye-slash',
            'core:e/source_code' => 'fa fa-code',
            'core:e/special_character' => 'fas fa-pen-square',
            'core:e/spellcheck' => 'fa fa-check',
            'core:e/split_cells' => 'fa fa-columns',
            'core:e/strikethrough' => 'fa fa-strikethrough',
            'core:e/styleprops' => 'fa fa-info',
            'core:e/subscript' => 'fa fa-subscript',
            'core:e/superscript' => 'fa fa-superscript',
            'core:e/table_props' => 'fa fa-table',
            'core:e/table' => 'fa fa-table',
            'core:e/template' => 'fa fa-sticky-note',
            'core:e/text_color_picker' => 'fa fa-paint-brush',
            'core:e/text_color' => 'fa fa-paint-brush',
            'core:e/text_highlight_picker' => 'far fa-lightbulb',
            'core:e/text_highlight' => 'far fa-lightbulb',
            'core:e/tick' => 'fa fa-check',
            'core:e/toggle_blockquote' => 'fa fa-quote-left',
            'core:e/underline' => 'fa fa-underline',
            'core:e/undo' => 'fa fa-undo',
            'core:e/visual_aid' => 'fa fa-universal-access',
            'core:e/visual_blocks' => 'fa fa-audio-description',
            'theme:fp/add_file' => 'far fa-file',
            'theme:fp/alias' => 'fa fa-share',
            'theme:fp/alias_sm' => 'fa fa-share',
            'theme:fp/check' => 'fa fa-check',
            'theme:fp/create_folder' => 'far fa-folder',
            'theme:fp/cross' => 'fas fa-times',
            'theme:fp/download_all' => 'fa fa-download',
            'theme:fp/help' => 'fa fa-question-circle',
            'theme:fp/link' => 'fa fa-link',
            'theme:fp/link_sm' => 'fa fa-link',
            'theme:fp/logout' => 'fas fa-sign-out-alt',
            'theme:fp/path_folder' => 'fa fa-folder',
            'theme:fp/path_folder_rtl' => 'fa fa-folder',
            'theme:fp/refresh' => 'fas fa-sync',
            'theme:fp/search' => 'fa fa-search',
            'theme:fp/setting' => 'fa fa-cog',
            'theme:fp/view_icon_active' => 'fa fa-th',
            'theme:fp/view_list_active' => 'fa fa-list',
            'theme:fp/view_tree_active' => 'fa fa-folder',
            'core:i/assignroles' => 'fa fa-user-plus',
            'core:i/backup' => 'far fa-file-zip',
            'core:i/badge' => 'fas fa-shield-alt',
            'core:i/calc' => 'fa fa-calculator',
            'core:i/calendar' => 'fas fa-calendar-alt',
            'core:i/calendareventdescription' => 'fa fa-align-left',
            'core:i/calendareventtime' => 'far fa-clock',
            'core:i/caution' => 'fa fa-exclamation text-warning',
            'core:i/checked' => 'fa fa-check',
            'core:i/checkpermissions' => 'fa fa-unlock-alt',
            'core:i/cohort' => 'fa fa-users',
            'core:i/competencies' => 'far fa-check-square',
            'core:i/completion_self' => 'far fa-user',
            'core:i/dashboard' => 'fas fa-tachometer-alt',
            'core:i/lock' => 'fa fa-lock',
            'core:i/categoryevent' => 'fa fa-cubes',
            'core:i/courseevent' => 'fa fa-university',
            'core:i/db' => 'fa fa-database',
            'core:i/delete' => 'fa fa-trash',
            'core:i/down' => 'fa fa-arrow-down',
            'core:i/dragdrop' => 'fas fa-arrows-alt',
            'core:i/duration' => 'far fa-clock',
            'core:i/edit' => 'fas fa-pencil-alt',
            'core:i/email' => 'fa fa-envelope',
            'core:i/enrolmentsuspended' => 'fa fa-pause',
            'core:i/enrolusers' => 'fa fa-user-plus',
            'core:i/expired' => 'fa fa-exclamation text-warning',
            'core:i/export' => 'fa fa-download',
            'core:i/files' => 'far fa-copy',
            'core:i/filter' => 'fa fa-filter',
            'core:i/flagged' => 'fa fa-flag',
            'core:i/folder' => 'fa fa-folder',
            'core:i/grade_correct' => 'fa fa-check text-success',
            'core:i/grade_incorrect' => 'fas fa-times text-danger',
            'core:i/grade_partiallycorrect' => 'fa fa-check-square',
            'core:i/grades' => 'fa fa-table',
            'core:i/groupevent' => 'fas fa-users',
            'core:i/groupn' => 'fa fa-user',
            'core:i/group' => 'fa fa-users',
            'core:i/groups' => 'fa fa-user-circle',
            'core:i/groupv' => 'far fa-user-circle',
            'core:i/hide' => 'fa fa-eye',
            'core:i/hierarchylock' => 'fa fa-lock',
            'core:i/import' => 'fas fa-level-up-alt',
            'core:i/info' => 'fa fa-info',
            'core:i/invalid' => 'fa fa-times text-danger',
            'core:i/item' => 'fa fa-circle',
            'core:i/loading' => 'fas fa-circle-notch fa-spin',
            'core:i/loading_small' => 'fas fa-circle-notch fa-spin',
            'core:i/lock' => 'fa fa-lock',
            'core:i/log' => 'fa fa-list-alt',
            'core:i/mahara_host' => 'fa fa-id-badge',
            'core:i/manual_item' => 'far fa-square',
            'core:i/marked' => 'fa fa-circle',
            'core:i/marker' => 'far fa-circle',
            'core:i/mean' => 'fa fa-calculator',
            'core:i/menu' => 'fa fa-ellipsis-v',
            'core:i/menubars' => 'fa fa-bars',
            'core:i/mnethost' => 'fas fa-external-link-alt',
            'core:i/moodle_host' => 'fas fa-graduation-cap',
            'core:i/move_2d' => 'fas fa-arrows-alt',
            'core:i/navigationitem' => 'fa fa-fw',
            'core:i/ne_red_mark' => 'fas fa-times',
            'core:i/new' => 'fa fa-bolt',
            'core:i/news' => 'far fa-newspaper',
            'core:i/nosubcat' => 'far fa-plus-square',
            'core:i/notifications' => 'fa fa-bell',
            'core:i/open' => 'fa fa-folder-open',
            'core:i/outcomes' => 'fa fa-tasks',
            'core:i/payment' => 'far fa-money-bill-alt',
            'core:i/permissionlock' => 'fa fa-lock',
            'core:i/permissions' => 'fas fa-pen-square',
            'core:i/persona_sign_in_black' => 'fa fa-male',
            'core:i/portfolio' => 'fa fa-id-badge',
            'core:i/preview' => 'fa fa-search-plus',
            'core:i/progressbar' => 'fa fa-spinner fa-spin',
            'core:i/publish' => 'fa fa-share',
            'core:i/questions' => 'fa fa-question',
            'core:i/reload' => 'fas fa-sync',
            'core:i/report' => 'fas fa-chart-area',
            'core:i/repository' => 'far fa-hdd',
            'core:i/restore' => 'fas fa-level-up-alt',
            'core:i/return' => 'fa fa-arrow-left',
            'core:i/risk_config' => 'fa fa-exclamation text-muted',
            'core:i/risk_managetrust' => 'fa fa-exclamation-triangle text-warning',
            'core:i/risk_personal' => 'fa fa-exclamation-circle text-info',
            'core:i/risk_spam' => 'fa fa-exclamation text-primary',
            'core:i/risk_xss' => 'fa fa-exclamation-triangle text-danger',
            'core:i/role' => 'fa fa-user-md',
            'core:i/rss' => 'fa fa-rss',
            'core:i/rsssitelogo' => 'fas fa-graduation-cap',
            'core:i/scales' => 'fa fa-balance-scale',
            'core:i/scheduled' => 'far fa-calendar-check',
            'core:i/search' => 'fa fa-search',
            'core:i/settings' => 'fa fa-cog',
            'core:i/show' => 'fa fa-eye-slash',
            'core:i/siteevent' => 'fa fa-globe',
            'core:i/star-rating' => 'fa fa-star',
            'core:i/stats' => 'fas fa-chart-line',
            'core:i/switch' => 'fas fa-exchange-alt',
            'core:i/switchrole' => 'fa fa-user-secret',
            'core:i/twoway' => 'fas fa-arrows-alt-h',
            'core:i/unchecked' => 'far fa-square',
            'core:i/unflagged' => 'far fa-flag',
            'core:i/unlock' => 'fa fa-unlock',
            'core:i/up' => 'fa fa-arrow-up',
            'core:i/userevent' => 'fa fa-user',
            'core:i/user' => 'fa fa-user',
            'core:i/users' => 'fa fa-users',
            'core:i/valid' => 'fa fa-check text-success',
            'core:i/warning' => 'fa fa-exclamation text-warning',
            'core:i/withsubcat' => 'fa fa-plus-square',
            'core:m/USD' => 'fa fa-usd',
            'core:t/addcontact' => 'fa fa-address-card',
            'core:t/add' => 'fa fa-plus',
            'core:t/approve' => 'fa fa-thumbs-up',
            'core:t/assignroles' => 'fa fa-user-circle',
            'core:t/award' => 'fa fa-trophy',
            'core:t/backpack' => 'fa fa-shopping-bag',
            'core:t/backup' => 'fa fa-arrow-circle-down',
            'core:t/block' => 'fa fa-ban',
            'core:t/block_to_dock_rtl' => 'fa fa-chevron-right',
            'core:t/block_to_dock' => 'fa fa-chevron-left',
            'core:t/calc_off' => 'fa fa-calculator', // TODO: Change to better icon once we have stacked icon support or more icons.
            'core:t/calc' => 'fa fa-calculator',
            'core:t/check' => 'fa fa-check',
            'core:t/cohort' => 'fa fa-users',
            'core:t/collapsed_empty_rtl' => 'far fa-plus-square',
            'core:t/collapsed_empty' => 'far fa-plus-square',
            'core:t/collapsed_rtl' => 'fa fa-plus-square',
            'core:t/collapsed' => 'fa fa-plus-square',
            'core:t/contextmenu' => 'fa fa-cog',
            'core:t/copy' => 'fa fa-copy',
            'core:t/delete' => 'fa fa-trash',
            'core:t/dockclose' => 'fa fa-window-close',
            'core:t/dock_to_block_rtl' => 'fa fa-chevron-right',
            'core:t/dock_to_block' => 'fa fa-chevron-left',
            'core:t/download' => 'fa fa-download',
            'core:t/down' => 'fa fa-arrow-down',
            'core:t/dropdown' => 'fa fa-cog',
            'core:t/editinline' => 'fas fa-pencil-alt',
            'core:t/edit_menu' => 'fa fa-cog',
            'core:t/editstring' => 'fas fa-pencil-alt',
            'core:t/edit' => 'fa fa-cog',
            'core:t/emailno' => 'fa fa-ban',
            'core:t/email' => 'far fa-envelope',
            'core:t/enrolusers' => 'fa fa-user-plus',
            'core:t/expanded' => 'fa fa-caret-down',
            'core:t/go' => 'fa fa-play',
            'core:t/grades' => 'fa fa-table',
            'core:t/groupn' => 'fa fa-user',
            'core:t/groups' => 'fa fa-user-circle',
            'core:t/groupv' => 'far fa-user-circle',
            'core:t/hide' => 'fa fa-eye',
            'core:t/left' => 'fa fa-arrow-left',
            'core:t/less' => 'fa fa-caret-up',
            'core:t/locked' => 'fa fa-lock',
            'core:t/lock' => 'fa fa-unlock',
            'core:t/locktime' => 'fa fa-lock',
            'core:t/markasread' => 'fa fa-check',
            'core:t/messages' => 'fa fa-comments',
            'core:t/message' => 'fa fa-comment',
            'core:t/more' => 'fa fa-caret-down',
            'core:t/move' => 'fas fa-arrows-alt-v',
            'core:t/passwordunmask-edit' => 'fas fa-pencil-alt',
            'core:t/passwordunmask-reveal' => 'fa fa-eye',
            'core:t/portfolioadd' => 'fa fa-plus',
            'core:t/preferences' => 'fa fa-wrench',
            'core:t/preview' => 'fa fa-search-plus',
            'core:t/print' => 'fa fa-print',
            'core:t/removecontact' => 'fa fa-user-times',
            'core:t/reset' => 'fas fa-redo',
            'core:t/restore' => 'fa fa-arrow-circle-up',
            'core:t/right' => 'fa fa-arrow-right',
            'core:t/show' => 'fa fa-eye-slash',
            'core:t/sort_asc' => 'fas fa-sort-up',
            'core:t/sort_desc' => 'fas fa-sort-down',
            'core:t/sort' => 'fa fa-sort',
            'core:t/stop' => 'fa fa-stop',
            'core:t/switch_minus' => 'fa fa-minus',
            'core:t/switch_plus' => 'fa fa-plus',
            'core:t/switch_whole' => 'far fa-square',
            'core:t/unblock' => 'fas fa-commenting-alt',
            'core:t/unlocked' => 'fa fa-unlock-alt',
            'core:t/unlock' => 'fa fa-lock',
            'core:t/up' => 'fa fa-arrow-up',
            'core:t/user' => 'fa fa-user',
            'core:t/viewdetails' => 'fa fa-list',
        ];
    }

    public function get_core_icon_map() {
        $iconmap = $this->get_updated_core_icon_map();

        // Change from core.
        $iconmap['core:i/navigationitem'] = 'fas fa-chevron-right';

        return $iconmap;
    }

    /**
     * Overridable function to get a mapping of all icons.
     * Default is to do no mapping.
     */
    public function get_icon_name_map() {
        if ($this->map === []) {
            $cache = \cache::make('core', 'fontawesomeiconmapping');

            $this->map = $cache->get('mapping');

            if (empty($this->map)) {
                $this->map = $this->get_core_icon_map();
                $callback = 'get_fontawesome_icon_map';

                if ($pluginsfunction = get_plugins_with_function($callback)) {
                    $toolbox = \theme_shoelace\toolbox::get_instance();
                    foreach ($pluginsfunction as $plugintype => $plugins) {
                        foreach ($plugins as $pluginsubtype => $pluginfunction) {
                            $pluginmap = $pluginfunction();
                            // Convert map from FA 4 to 5.
                            foreach ($pluginmap as $micon => $faicon) {
                                $pluginmap[$micon] = $toolbox->get_fa5_from_fa4($faicon, true);
                            }
                            $this->map += $pluginmap;
                        }
                    }
                }
                $cache->set('mapping', $this->map);
            }

        }
        return $this->map;
    }

    public function get_amd_name() {
        return 'theme_shoelace/icon_system_fontawesome';
    }

    public function render_pix_icon(\renderer_base $output, \pix_icon $icon) {
        $subtype = '\pix_icon_fontawesome';
        $subpix = new $subtype($icon);
        $data = $subpix->export_for_template($output);

        if (!$subpix->is_mapped()) {
            $data['unmappedIcon'] = $icon->export_for_template($output);
        }

        return $output->render_from_template('theme_shoelace/pix_icon_fontawesome', $data);
    }
}
