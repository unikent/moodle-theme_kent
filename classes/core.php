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
	 * Are we in fullscreen mode?
	 */
	public static function is_fullscreen() {
		static $result = null;
		if ($result === null) {
		    $result = \local_kent\User::get_beta_preference("theme_fullscreen", false);
		}

		return $result;
	}
}
