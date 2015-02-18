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

    $isfuture = $CFG->kent->distribution == 'future' || $CFG->kent->distribution == 'future-demo';
    $hasfuture = \local_kent\User::get_beta_preference("theme", $isfuture ? "1" : "0");
    if ($hasfuture) {
        $page->requires->js('/theme/kent/javascript/navbuttons.js');

        $page->theme->larrow = '&lt;';
        $page->theme->rarrow = '&gt;';
    }

    if (isset($CFG->local_tutorials_enabled) && $CFG->local_tutorials_enabled) {
        \local_tutorials\Page::on_load();
    }
}


/**
 * Returns a list of upcoming events.
 */
function theme_kent_get_upcoming_events() {
    global $CFG, $PAGE;

    $calm = optional_param( 'cal_m', 0, PARAM_INT );
    $caly = optional_param( 'cal_y', 0, PARAM_INT );

    $cache = cache::make('theme_kent', 'kent_theme');
    $cachekey = "upcoming-" . $calm . "-" . $caly;
    $content = $cache->get($cachekey);

    // Regen Cache?
    if ($content === false) {
        require_once($CFG->dirroot . '/calendar/lib.php');

        // Being displayed at site level. This will cause the filter to fall back to auto-detecting
        // the list of courses it will be grabbing events from.
        $filtercourse = calendar_get_default_courses();

        list($courses, $group, $user) = calendar_set_filters($filtercourse);

        $defaultlookahead = CALENDAR_DEFAULT_UPCOMING_LOOKAHEAD;
        if (isset($CFG->calendar_lookahead)) {
            $defaultlookahead = intval($CFG->calendar_lookahead);
        }

        $lookahead = get_user_preferences('calendar_lookahead', $defaultlookahead);

        $defaultmaxevents = CALENDAR_DEFAULT_UPCOMING_MAXEVENTS;
        if (isset($CFG->calendar_maxevents)) {
            $defaultmaxevents = intval($CFG->calendar_maxevents);
        }

        $maxevents = get_user_preferences('calendar_maxevents', 3);
        $events = calendar_get_upcoming($courses, $group, $user, $lookahead, $maxevents);
        $content = calendar_get_block_upcoming($events, 'view.php?view=day');

        if (empty($content)) {
            $content = '<div class="event"><p>No upcoming events!</p></div>';
        }

        $cache->set($cachekey, $content);
    }

    return $content;
}