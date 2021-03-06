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
 * @package   theme_ncmboost
 * @copyright 2017 Nicolas Jourdain
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

// This line protects the file from being accessed by a URL directly.
defined('MOODLE_INTERNAL') || die();

// This is used for performance, we don't need to know about these settings on every page in Moodle, only when
// we are looking at the admin settings pages.
if ($ADMIN->fulltree) {

    // Boost provides a nice setting page which splits settings onto separate tabs. We want to use it here.
    $settings = new theme_boost_admin_settingspage_tabs('themesettingncmboost', get_string('configtitle', 'theme_ncmboost'));

    // Each page is a tab - the first is the "General" tab.
    $page = new admin_settingpage('theme_ncmboost_general', get_string('generalsettings', 'theme_ncmboost'));

    // Replicate the preset setting from boost.
    $name = 'theme_ncmboost/preset';
    $title = get_string('preset', 'theme_ncmboost');
    $description = get_string('preset_desc', 'theme_ncmboost');
    $default = 'default.scss';

    // We list files in our own file area to add to the drop down. We will provide our own function to
    // load all the presets from the correct paths.
    $context = context_system::instance();
    $fs = get_file_storage();
    $files = $fs->get_area_files($context->id, 'theme_ncmboost', 'preset', 0, 'itemid, filepath, filename', false);

    $choices = [];
    foreach ($files as $file) {
        $choices[$file->get_filename()] = $file->get_filename();
    }
    // These are the built in presets from Boost.
    $choices['default.scss'] = 'default.scss';
    $choices['plain.scss'] = 'plain.scss';

    $setting = new admin_setting_configselect($name, $title, $description, $default, $choices);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    // Preset files setting.
    $name = 'theme_ncmboost/presetfiles';
    $title = get_string('presetfiles', 'theme_ncmboost');
    $description = get_string('presetfiles_desc', 'theme_ncmboost');

    $setting = new admin_setting_configstoredfile($name, $title, $description, 'preset', 0,
        array('maxfiles' => 20, 'accepted_types' => array('.scss')));
    $page->add($setting);

    // Variable $ncmbrand-color.
    // We use an empty default value because the default colour should come from the preset.
    $name = 'theme_ncmboost/ncmbrandcolor';
    $title = get_string('ncmbrandcolor', 'theme_ncmboost');
    $description = get_string('ncmbrandcolor_desc', 'theme_ncmboost');
    $setting = new admin_setting_configcolourpicker($name, $title, $description, '');
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    // Variable $ncmkeytxt-color.
    $name = 'theme_ncmboost/ncmkeytxtcolor';
    $title = get_string('ncmkeytxtcolor', 'theme_ncmboost');
    $description = get_string('ncmkeytxtcolor_desc', 'theme_ncmboost');
    $setting = new admin_setting_configcolourpicker($name, $title, $description, '');
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    // Variable $ncmbtn-primary.
    $name = 'theme_ncmboost/ncmbtnprimarycolor';
    $title = get_string('ncmbtnprimarycolor', 'theme_ncmboost');
    $description = get_string('ncmbtnprimarycolor_desc', 'theme_ncmboost');
    $setting = new admin_setting_configcolourpicker($name, $title, $description, '');
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    // Variable $ncmkeytxt-color.
    $name = 'theme_ncmboost/ncmlinkcolor';
    $title = get_string('ncmlinkcolor', 'theme_ncmboost');
    $description = get_string('ncmlinkcolor_desc', 'theme_ncmboost');
    $defaut = '#03A53E';
    $setting = new admin_setting_configcolourpicker($name, $title, $description, $defaut);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    // Settings title to group favicon related settings together with a common heading. We don't want a description here.
    $name = 'theme_ncmboost/faviconheading';
    $title = get_string('faviconheadingsetting', 'theme_ncmboost', null, true);
    $setting = new admin_setting_heading($name, $title, null);
    $page->add($setting);

    // Favicon upload.
    $name = 'theme_ncmboost/favicon';
    $title = get_string('faviconsetting', 'theme_ncmboost', null, true);
    $description = get_string('faviconsetting_desc', 'theme_ncmboost', null, true);
    $setting = new admin_setting_configstoredfile($name, $title, $description, 'favicon', 0,
        array('maxfiles' => 1, 'accepted_types' => array('.ico', '.png')));
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    // Settings title to group footnote settings together with a common heading and description.
    $name = 'theme_ncmboost/footnoteheading';
    $title = get_string('footnoteheadingsetting', 'theme_ncmboost', null, true);
    $description = get_string('footnoteheadingsetting_desc', 'theme_ncmboost', null, true);
    $setting = new admin_setting_heading($name, $title, $description);
    $page->add($setting);

    // Footnote setting.
    $name = 'theme_ncmboost/footnote';
    $title = get_string('footnotesetting', 'theme_ncmboost', null, true);
    $description = get_string('footnotesetting_desc', 'theme_ncmboost', null, true);
    $default = get_string('footnotesetting_default', 'theme_ncmboost', null, true);
    $setting = new admin_setting_confightmleditor($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    // Settings title to group footnote settings together with a common heading and description.
    $name = 'theme_ncmboost/courseeditheading';
    $title = get_string('courseeditheadingsetting', 'theme_ncmboost', null, true);
    $description = get_string('courseeditbuttonsetting_desc', 'theme_ncmboost', null, true);
    $setting = new admin_setting_heading($name, $title, $description);
    $page->add($setting);

    // Setting for displaying edit on / off button addionally in course header.
    $name = 'theme_ncmboost/courseeditbutton';
    $title = get_string('courseeditbuttonsetting', 'theme_ncmboost', null, true);
    $description = get_string('courseeditbuttonsetting_desc', 'theme_ncmboost', null, true);
    $setting = new admin_setting_configcheckbox($name, $title, $description, 0);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    // Login Page Type Heading.
    $name = 'theme_ncmboost/loginpagetypeheading';
    $title = get_string('loginpagetypeheading', 'theme_ncmboost', null, true);
    $description = get_string('loginpagetype_desc', 'theme_ncmboost', null, true);
    $setting = new admin_setting_heading($name, $title, $description);
    $page->add($setting);

    $options = array(
        'CORE' => get_string('core', 'theme_ncmboost'),
        'CLASSIC' => get_string('classic', 'theme_ncmboost'),
        'SAMLAUTHFIRST' => get_string('samlauthfirst', 'theme_ncmboost'),
    );

    $setting = new admin_setting_configselect('theme_ncmboost/loginpagetype',
        get_string('loginpagetype', 'theme_ncmboost'),
        null,
        'C',
        $options
    );
    $page->add($setting);


    // Must add the page after defining all the settings!
    $settings->add($page);

    // Each page is a tab - the second is the "Backgrounds" tab.
    $page = new admin_settingpage('theme_ncmboost_backgrounds', get_string('backgrounds', 'theme_ncmboost'));

    // Default background setting.
    // We use variables for readability.
    $name = 'theme_ncmboost/defaultbackgroundimage';
    $title = get_string('defaultbackgroundimage', 'theme_ncmboost');
    $description = get_string('defaultbackgroundimage_desc', 'theme_ncmboost');
    // This creates the new setting.
    $setting = new admin_setting_configstoredfile($name, $title, $description, 'defaultbackgroundimage');
    // This function will copy the image into the data_root location it can be served from.
    $setting->set_updatedcallback('theme_ncmboost_update_settings_images');
    // We always have to add the setting to a page for it to have any effect.
    $page->add($setting);

    // Login page background setting.
    // We use variables for readability.
    $name = 'theme_ncmboost/loginbackgroundimage';
    $title = get_string('loginbackgroundimage', 'theme_ncmboost');
    $description = get_string('loginbackgroundimage_desc', 'theme_ncmboost');
    // This creates the new setting.
    $setting = new admin_setting_configstoredfile($name, $title, $description, 'loginbackgroundimage');
    // This function will copy the image into the data_root location it can be served from.
    $setting->set_updatedcallback('theme_ncmboost_update_settings_images');
    // We always have to add the setting to a page for it to have any effect.
    $page->add($setting);

    // Frontpage page background setting.
    // We use variables for readability.
    $name = 'theme_ncmboost/frontpagebackgroundimage';
    $title = get_string('frontpagebackgroundimage', 'theme_ncmboost');
    $description = get_string('frontpagebackgroundimage_desc', 'theme_ncmboost');
    // This creates the new setting.
    $setting = new admin_setting_configstoredfile($name, $title, $description, 'frontpagebackgroundimage');
    // This function will copy the image into the data_root location it can be served from.
    $setting->set_updatedcallback('theme_ncmboost_update_settings_images');
    // We always have to add the setting to a page for it to have any effect.
    $page->add($setting);

    // Dashboard page background setting.
    // We use variables for readability.
    $name = 'theme_ncmboost/dashboardbackgroundimage';
    $title = get_string('dashboardbackgroundimage', 'theme_ncmboost');
    $description = get_string('dashboardbackgroundimage_desc', 'theme_ncmboost');
    // This creates the new setting.
    $setting = new admin_setting_configstoredfile($name, $title, $description, 'dashboardbackgroundimage');
    // This function will copy the image into the data_root location it can be served from.
    $setting->set_updatedcallback('theme_ncmboost_update_settings_images');
    // We always have to add the setting to a page for it to have any effect.
    $page->add($setting);

    // In course page background setting.
    // We use variables for readability.
    $name = 'theme_ncmboost/incoursebackgroundimage';
    $title = get_string('incoursebackgroundimage', 'theme_ncmboost');
    $description = get_string('incoursebackgroundimage_desc', 'theme_ncmboost');
    // This creates the new setting.
    $setting = new admin_setting_configstoredfile($name, $title, $description, 'incoursebackgroundimage');
    // This function will copy the image into the data_root location it can be served from.
    $setting->set_updatedcallback('theme_ncmboost_update_settings_images');
    // We always have to add the setting to a page for it to have any effect.
    $page->add($setting);

    // Must add the page after defining all the settings!
    $settings->add($page);

    // Advanced settings.
    $page = new admin_settingpage('theme_ncmboost_advanced', get_string('advancedsettings', 'theme_ncmboost'));

    // Raw SCSS to include before the content.
    $setting = new admin_setting_configtextarea('theme_ncmboost/scsspre',
        get_string('rawscsspre', 'theme_ncmboost'), get_string('rawscsspre_desc', 'theme_ncmboost'), '', PARAM_RAW);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    // Raw SCSS to include after the content.
    $setting = new admin_setting_configtextarea('theme_ncmboost/scss', get_string('rawscss', 'theme_ncmboost'),
        get_string('rawscss_desc', 'theme_ncmboost'), '', PARAM_RAW);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    $settings->add($page);
}
