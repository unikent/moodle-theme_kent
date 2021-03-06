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

require_once('renderers/components.php');
require_once('renderers/bootstrap.php');

require_once('renderers/core_renderer_base.php');
if (!\theme_kent\core::is_future()) {
    require_once('renderers/core_renderer.php');
} else {
    require_once('renderers/future_renderer.php');
}

require_once('renderers/maintenance_renderer.php');
require_once('renderers/quiz_renderer.php');
require_once('renderers/ouwiki_renderer.php');
require_once('renderers/course_renderer.php');
require_once('renderers/block_renderers.php');
