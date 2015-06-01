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
 * Returns variables for LESS.
 *
 * We will inject some LESS variables from the settings that the user has defined
 * for the theme. No need to write some custom LESS for this.
 *
 * @param theme_config $theme The theme config object.
 * @return array of LESS variables without the @.
 */
function theme_kent_less_variables($theme) {
    return array();
}

/**
 * Future theme requires jQuery everywhere.
 */
function theme_kent_page_init(moodle_page $page) {
    global $CFG;

    $page->requires->jquery();

    $page->requires->css('/theme/kent/style/font-awesome.min.css?rev=' . $CFG->themerev);
    $page->requires->css('/theme/kent/style/kent-header-light.css?rev=' . $CFG->themerev);

    if (\core_useragent::is_ie() && !\core_useragent::check_ie_version('9.0')) {
        $page->requires->css('/theme/kent/style/kent-header-font-ie8.css?rev=' . $CFG->themerev);
    }

    if (isset($CFG->local_tutorials_enabled) && $CFG->local_tutorials_enabled) {
        \local_tutorials\Page::on_load();
    }
}
