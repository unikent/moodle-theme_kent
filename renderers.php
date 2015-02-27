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

$isfuture = $CFG->kent->distribution == 'future' || $CFG->kent->distribution == 'future-demo';
$hasfuture = \local_kent\User::get_beta_preference("theme", $isfuture ? "1" : "0");
if ($hasfuture) {
	require_once('renderers/bootstrap.php');
	require_once('renderers/future_renderer.php');
	require_once('renderers/future_maintenance_renderer.php');
	require_once('renderers/future_quiz_renderer.php');
} else {
	require_once('renderers/current_renderer.php');
}
