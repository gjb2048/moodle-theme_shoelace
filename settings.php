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

defined('MOODLE_INTERNAL') || die;
$settings = null;
if (is_siteadmin()) {

    $ADMIN->add('themes', new admin_category('theme_shoelace', 'Shoelace'));

    // General settings.
    $temp = new admin_settingpage('theme_shoelace_generic', get_string('generalsettings', 'theme_shoelace'));

    $temp->add(new admin_setting_heading('theme_shoelace_generalheading',
        get_string('generalheadingsub', 'theme_shoelace'),
        format_text(get_string('generalheadingdesc', 'theme_shoelace'), FORMAT_MARKDOWN)));

    // Theme colour setting.
    $name = 'theme_shoelace/themecolour';
    $title = get_string('themecolour', 'theme_shoelace');
    $description = get_string('themecolourdesc', 'theme_shoelace');
    $default = '#ffd974';
    $previewconfig = null;
    $setting = new admin_setting_configcolourpicker($name, $title, $description, $default, $previewconfig);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);

    // Text colour setting.
    $name = 'theme_shoelace/textcolour';
    $title = get_string('textcolour', 'theme_shoelace');
    $description = get_string('textcolourdesc', 'theme_shoelace');
    $default = '#653cae';
    $previewconfig = null;
    $setting = new admin_setting_configcolourpicker($name, $title, $description, $default, $previewconfig);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);

    // Navbar text colour setting.
    $name = 'theme_shoelace/navbartextcolour';
    $title = get_string('navbartextcolour', 'theme_shoelace');
    $description = get_string('navbartextcolourdesc', 'theme_shoelace');
    $default = '#ffffff';
    $previewconfig = null;
    $setting = new admin_setting_configcolourpicker($name, $title, $description, $default, $previewconfig);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);

    /* CDN Fonts - 1 = no, 2 = yes. */
    $name = 'theme_shoelace/cdnfonts';
    $title = get_string('cdnfonts', 'theme_shoelace');
    $description = get_string('cdnfonts_desc', 'theme_shoelace');
    $default = 1;
    $choices = array(
        1 => new lang_string('no'),   // No.
        2 => new lang_string('yes')   // Yes.
    );
    $temp->add(new admin_setting_configselect($name, $title, $description, $default, $choices));

    // Invert Navbar to dark background.
    $name = 'theme_shoelace/invert';
    $title = get_string('invert', 'theme_shoelace');
    $description = get_string('invertdesc', 'theme_shoelace');
    $setting = new admin_setting_configcheckbox($name, $title, $description, 0);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);

    // Logo file setting.
    $name = 'theme_shoelace/logo';
    $title = get_string('logo', 'theme_shoelace');
    $description = get_string('logodesc', 'theme_shoelace');
    $setting = new admin_setting_configstoredfile($name, $title, $description, 'logo');
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);

    // Number of marketing blocks.
    $name = 'theme_shoelace/nummarketingblocks';
    $title = get_string('nummarketingblocks', 'theme_shoelace');
    $description = get_string('nummarketingblocksdesc', 'theme_shoelace');
    $choices = array(
        1 => new lang_string('one', 'theme_shoelace'),
        2 => new lang_string('two', 'theme_shoelace'),
        3 => new lang_string('three', 'theme_shoelace'),
        4 => new lang_string('four', 'theme_shoelace')
    );
    $default = 2;
    $setting = new admin_setting_configselect($name, $title, $description, $default, $choices);
    $temp->add($setting);

    // Number of footer blocks.
    $name = 'theme_shoelace/numfooterblocks';
    $title = get_string('numfooterblocks', 'theme_shoelace');
    $description = get_string('numfooterblocksdesc', 'theme_shoelace');
    $choices = array(
        1 => new lang_string('one', 'theme_shoelace'),
        2 => new lang_string('two', 'theme_shoelace'),
        3 => new lang_string('three', 'theme_shoelace'),
        4 => new lang_string('four', 'theme_shoelace')
    );
    $default = 2;
    $setting = new admin_setting_configselect($name, $title, $description, $default, $choices);
    $temp->add($setting);

    // Footnote setting.
    $name = 'theme_shoelace/footnote';
    $title = get_string('footnote', 'theme_shoelace');
    $description = get_string('footnotedesc', 'theme_shoelace');
    $default = '';
    $setting = new admin_setting_confightmleditor($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);

    // Custom CSS file.
    $name = 'theme_shoelace/customcss';
    $title = get_string('customcss', 'theme_shoelace');
    $description = get_string('customcssdesc', 'theme_shoelace');
    $default = '';
    $setting = new admin_setting_configtextarea($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);

    $ADMIN->add('theme_shoelace', $temp);

    // Style guide.
    if (file_exists("{$CFG->dirroot}/theme/shoelace/shoelace_admin_setting_styleguide.php")) {
        require_once($CFG->dirroot . '/theme/shoelace/shoelace_admin_setting_styleguide.php');
    } else if (!empty($CFG->themedir) && file_exists("{$CFG->themedir}/shoelace/shoelace_admin_setting_styleguide.php")) {
        require_once($CFG->themedir . '/shoelace/shoelace_admin_setting_styleguide.php');
    }
    $temp = new admin_settingpage('theme_shoelace_styleguide', get_string('styleguide', 'theme_shoelace'));
    $temp->add(new shoelace_admin_setting_styleguide('theme_shoelace_styleguide',
        get_string('styleguidesub', 'theme_shoelace'),
        get_string('styleguidedesc', 'theme_shoelace',
            array(
                'origcodelicenseurl' => html_writer::link('http://www.apache.org/licenses/LICENSE-2.0', 'Apache License v2.0',
                    array('target' => '_blank')),
                'thiscodelicenseurl' => html_writer::link('http://www.gnu.org/copyleft/gpl.html', 'GPLv3',
                    array('target' => '_blank')),
                'compatible' => html_writer::link('http://www.gnu.org/licenses/license-list.en.html#apache2', 'compatible',
                    array('target' => '_blank')),
                'contentlicenseurl' => html_writer::link('http://creativecommons.org/licenses/by/3.0/', 'CC BY 3.0',
                    array('target' => '_blank')),
                'globalsettings' => html_writer::link('http://getbootstrap.com/2.3.2/scaffolding.html#global', 'Global settings',
                    array('target' => '_blank'))
            )
        )
    ));
    $ADMIN->add('theme_shoelace', $temp);
}
