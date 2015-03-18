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

    /**
     * Print teachers.
     */
    public function render_teachers($teachers) {
    	static $tid = 0;

    	$id = 'teacherscollapse' . ($tid++);

        $stafftoggle = '<i class="fa fa-chevron-down"></i> ' . get_string('staff_toggle', 'block_kent_course_overview');
        $showhide = \html_writer::tag('a', $stafftoggle, array(
            'data-toggle' => 'collapse',
            'href' => '#' . $id,
            'aria-expanded' => 'false',
            'aria-controls' => $id,
        ));

        $staff = '';
        foreach ($teachers as $teacher) {
            $staff .= \html_writer::tag('span', $teacher);
        }

        $staffwell = \html_writer::tag('div', $staff, array(
            'class' => 'well'
        ));

        return $showhide . \html_writer::tag('div', $staffwell, array(
        	'id' => $id,
            'class' => 'collapse'
        ));
    }

    /**
     * Returns search box.
     */
    public function render_search_box() {
        global $CFG;

        return <<<HTML5
            <div class="form_container">
                <form id="module_search" action="{$CFG->wwwroot}/course/search.php" method="GET">
                    <div class="input-group input-group-sm">
                        <input class="form-control" type="text" name="search" placeholder="Module search" />
                        <span class="input-group-btn">
                            <button class="btn btn-default" type="button"><i class="fa fa-search"></i></button>
                        </span>
                    </div>
                </form>
            </div>
HTML5;
    }
}
