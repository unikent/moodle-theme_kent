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

require_once($CFG->dirroot . '/blocks/kent_course_overview/renderer.php');

/**
 * Overrides a few defaults.
 *
 * @package     theme_kent
 * @copyright   2014 Skylar Kelty <S.Kelty@kent.ac.uk>
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class theme_kent_block_kent_course_overview_renderer extends block_kent_course_overview_renderer
{
    /**
     * Render a paging bar.
     */
    public function render_paging_bar($paging, $position) {
        if ($position != 'top' && $paging != '<div class="paging"></div>') {
            return $paging;
        }

        return '';
    }
}