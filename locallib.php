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
 * Theme NCM Campus - Locallib file
 *
 * @package   theme_ncmboost
 * @copyright 2018 Nicolas Jourdain
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

 defined('MOODLE_INTERNAL') || die();



/**
 * Returns a modified flat_navigation object.
 *
 * @param flat_navigation $flatnav The flat navigation object.
 * @return flat_navigation.
 */
function theme_ncmboost_process_flatnav(flat_navigation $flatnav) {
    global $USER;
    // Only proceed processing if we are in a course context.
    if (($coursehomenode = $flatnav->find('coursehome', global_navigation::TYPE_CUSTOM)) != false) {
        // If the site home is set as the deafult homepage by the admin.
        if (get_config('core', 'defaulthomepage') == HOMEPAGE_SITE) {
            // Return the modified flat_navigtation.
            $flatnavreturn = theme_ncmboost_set_node_on_top($flatnav, 'home', $coursehomenode);
        } else if (get_config('core', 'defaulthomepage') == HOMEPAGE_MY) { // If the dashboard is set as the default homepage
            // by the admin.
            // Return the modified flat_navigtation.
            $flatnavreturn = theme_ncmboost_set_node_on_top($flatnav, 'myhome', $coursehomenode);
        } else if (get_config('core', 'defaulthomepage') == HOMEPAGE_USER) { // If the admin defined that the user can set
            // the default homepage for himself.
            // Site home.
            if (get_user_preferences('user_home_page_preference', $USER) == 0) {
                // Return the modified flat_navigtation.
                $flatnavreturn = theme_ncmboost_set_node_on_top($flatnav, 'home', $coursehomenode);
            } else if (get_user_preferences('user_home_page_preference', $USER) == 1 || // Dashboard.
                get_user_preferences('user_home_page_preference', $USER) == false) { // If no user preference is set,
                // use the default value of core setting default homepage (Dashboard).
                // Return the modified flat_navigtation.
                $flatnavreturn = theme_ncmboost_set_node_on_top($flatnav, 'myhome', $coursehomenode);
            } else { // Should not happen.
                // Return the passed flat navigation without changes.
                $flatnavreturn = $flatnav;
            }
        } else { // Should not happen.
            // Return the passed flat navigation without changes.
            $flatnavreturn = $flatnav;
        }
    } else { // Not in course context.
        // Return the passed flat navigation without changes.
        $flatnavreturn = $flatnav;
    }
    $flatnavreturn = $flatnav;

    // If the setting 'navdrawericonssetting' is enabled.
    // Adding icons to flatnav nodes.
    // Dashboard node.
    if ($myhomenode = $flatnav->find('myhome', global_navigation::TYPE_SYSTEM)) {
        $myhomenode->icon = new pix_icon('i/dashboard', '');
    }
    // Site home node.
    if ($homenode = $flatnav->find('home', global_navigation::TYPE_SETTING)) {
        $homenode->icon = new pix_icon('i/home', '');
    }
    // Site administration node.
    if (($sitesettingsnode = $flatnav->find('sitesettings', global_navigation::TYPE_SITE_ADMIN))) {
        $sitesettingsnode->icon = new pix_icon('t/preferences', '');
    }
    // Participants node.
    if ($participantsnode = $flatnav->find('participants', global_navigation::TYPE_CONTAINER)) {
        $participantsnode->icon = new pix_icon('i/users', '');
    }
    // Course section nodes.
    if ($allsectionnodes = $flatnav->type(global_navigation::TYPE_SECTION)) {
        foreach ($allsectionnodes as $n) {
            $n->icon = new pix_icon('i/section', '');
        }
    }
    // Calendar node.
    if ($calendarnode = $flatnav->find('calendar', global_navigation::TYPE_CUSTOM)) {
        $calendarnode->icon = new pix_icon('i/calendar', '');
    }
    // Private files node.
    if ($privatefilesnode = $flatnav->find('privatefiles', global_navigation::TYPE_SETTING)) {
        $privatefilesnode->icon = new pix_icon('i/privatefiles', '');
    }
    // My courses nodes.
    if ($mycourses = $flatnav->type(global_navigation::TYPE_COURSE)) {
        foreach ($mycourses as $n) {
            $n->icon = new pix_icon('i/course', '');
            // Remove existing indent to align these nodes' icons with the other nodes' icons.
            $n->set_indent(false);
        }
    }
    return $flatnavreturn;
}

/**
 * Modifies the flat_navigation to add the node on top.
 *
 * @param flat_navigation $flatnav The flat navigation object.
 * @param string $nodename The name of the node that is to modify.
 * @param navigation_node $beforenode The node before which the to be modified node shall be added.
 * @return flat_navigation.
 */
function theme_ncmboost_set_node_on_top(flat_navigation $flatnav, $nodename, $beforenode) {
    // Get the node for which the sorting shall be changed.
    $pageflatnav = $flatnav->find($nodename, global_navigation::TYPE_SYSTEM);
    // Set the showdivider of the new top node to false that no empty nav-element will be created.
    $pageflatnav->set_showdivider(false);
    // Add the showdivider to the coursehome node as this is the next one and this will add a margin top to it.
    $beforenode->set_showdivider(true);
    // Remove the site home navigation node that it does not appear twice in the menu.
    $flatnav->remove($nodename);
    // Add the saved site home node before the $beforenode.
    $flatnav->add($pageflatnav, $beforenode->key);

    // Return the modified changes.
    return $flatnav;
}

