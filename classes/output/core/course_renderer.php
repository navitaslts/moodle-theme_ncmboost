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
 * Renderer for use with the course section and all the goodness that falls
 * within it.
 *
 * This renderer should contain methods useful to courses, and categories.
 *
 * @package   theme_ncmboost
 * @copyright 2018 Nicolas Jourdain
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
namespace theme_ncmboost\output\core;
defined('MOODLE_INTERNAL') || die;

require_once($CFG->dirroot.'/course/renderer.php');
/**
 * Extending the core_course_renderer interface.
 *
 * @copyright 2018 Nicolas Jourdain
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @package theme_ncmboost
 * @category output
 */
class course_renderer extends \core_course_renderer {
        /**
     * Renders the activity navigation.
     *
     * Defer to template.
     *
     * @param \core_course\output\activity_navigation $page
     * @return string html for the page
     */
    public function render_activity_navigation(\core_course\output\activity_navigation $page) {
        $data = $page->export_for_template($this->output);
        $data->prevlink->classes = "btn btn-default";
        $data->nextlink->classes = "btn btn-default";
        return $this->output->render_from_template('core_course/activity_navigation', $data);
    }
}
