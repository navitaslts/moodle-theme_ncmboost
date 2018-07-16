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
 * Renderers to align Moodle's HTML with that expected by Bootstrap
 *
 * @package   theme_ncmboost
 * @copyright 2018 Nicolas Jourdain
 *            copyright based on code from theme_boost by Bas Brands
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace theme_ncmboost\output;

use coding_exception;
use html_writer;
use tabobject;
use tabtree;
use custom_menu_item;
use custom_menu;
use block_contents;
use navigation_node;
use action_link;
use stdClass;
use moodle_url;
use preferences_groups;
use action_menu;
use help_icon;
use single_button;
use single_select;
use paging_bar;
use url_select;
use context_course;
use pix_icon;

defined('MOODLE_INTERNAL') || die;


/**
 * Extending the core_renderer interface.
 *
 * @copyright 2018 Nicolas Jourdain
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @package theme_ncmboost
 * @category output
 */
class core_renderer extends \theme_boost\output\core_renderer {

    /**
     * Override to display an edit button again by calling the parent function
     * in core/core_renderer because theme_boost's function returns an empty
     * string and therefore displays nothing.
     * @param moodle_url $url The current course url.
     * @return \core_renderer::edit_button Moodle edit button.
     */
    public function edit_button(moodle_url $url) {
        // MODIFICATION START.
        // If setting editbuttonincourseheader ist checked give out the edit on / off button in course header.
        if (get_config('theme_ncmboost', 'courseeditbutton') == '1') {
            return \core_renderer::edit_button($url);
        }
        // MODIFICATION END.
        /* ORIGINAL START.
        return '';
        ORIGINAL END. */
    }

    /**
     * Override to be able to use uploaded images from admin_setting as well.
     *
     * Returns the URL for the favicon.
     *
     * @since Moodle 2.5.1 2.6
     * @return string The favicon URL
     */
    public function favicon() {
        global $PAGE;
        // MODIFICATION START.
        if (!empty($PAGE->theme->settings->favicon)) {
            return $PAGE->theme->setting_file_url('favicon', 'favicon');
        } else {
            return $this->image_url('favicon', 'theme');
        }
        // MODIFICATION END.
        /* ORIGINAL START.
        return $this->image_url('favicon', 'theme');
        ORIGINAL END. */
    }


    /**
     * Whether we should display the logo in the navbar.
     *
     * We will when there are no main logos, and we have compact logo.
     *
     * @return bool
     */
    public function should_display_navbar_logo() {
        $logo = $this->get_compact_logo_url();
        return !empty($logo);
    }

    /**
     * Override to use theme_ncmboost login template
     * Renders the login form.
     *
     * @param \core_auth\output\login $form The renderable.
     * @return string
     */
    public function render_login(\core_auth\output\login $form) {
        global $SITE;

        $context = $form->export_for_template($this);

        // Override because rendering is not supported in template yet.
        $context->cookieshelpiconformatted = $this->help_icon('cookiesenabled');
        $context->errorformatted = $this->error_text($context->error);
        $url = $this->get_logo_url();
        if ($url) {
            $url = $url->out(false);
        }

        $context->logourl = $url;
        // MODIFICATION START.
        $context->sitename = format_string($SITE->fullname, true,
            ['context' => context_course::instance(SITEID), "escape" => false]
        );

        // Get the Login Page Type.
        $loginpagetype = get_config('theme_ncmboost', 'loginpagetype');
        if ($loginpagetype == 'SAMLAUTHFIRST') {
            $context->manualaccounttitle = get_string('manualaccounttitle', 'theme_ncmboost');
            return $this->render_from_template('theme_ncmboost/loginform_samlauthfirst', $context);
        } else if ($loginpagetype == 'CLASSIC') {
            return $this->render_from_template('theme_ncmboost/loginform_classic', $context);
        } else if ($loginpagetype == 'ADVANCED') {
            return $this->render_from_template('theme_ncmboost/loginform_advanced', $context);
        } else {
            return $this->render_from_template('core/loginform', $context);
        }
        // MODIFICATION END.
        /* ORIGINAL START.
        return $this->render_from_template('core/loginform', $context);
        ORIGINAL END. */
    }
}
