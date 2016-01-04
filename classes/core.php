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

namespace theme_kent;

defined('MOODLE_INTERNAL') || die();

/**
 * Theme Kent core utils.
 */
class core
{
    /**
     * Are we a future dist?
     */
    public static function is_future() {
        global $CFG;
        return $CFG->kent->distribution == 'future' || $CFG->kent->distribution == 'future-demo';
    }

    /**
     * Are we in contrast mode?
     */
    public static function is_contrast() {
        static $result = null;
        if ($result === null) {
            $result = \local_kent\User::get_preference("theme_contrast", false);
        }

        return $result;
    }

    /**
     * Are we hiding menu text?
     */
    public static function is_menu_text_hidden() {
        static $result = null;
        if ($result === null) {
            $result = \local_kent\User::get_preference("theme_menu_hide_text", true);
        }

        return $result;
    }
}
