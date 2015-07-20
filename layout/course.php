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

$coursecontentheader = "";
if (has_capability('moodle/course:update', \context_course::instance($COURSE->id))) {
    if (!$COURSE->visible) {
        $link = new \moodle_url('/course/edit.php', array(
            'id' => $COURSE->id
        ));

        $link = \html_writer::link($link, '<i class="fa fa-pencil"></i>', array(
            'class' => 'alert-link alert-dropdown close'
        ));

        $i = '<i class="fa fa-exclamation-circle"></i>';
        $coursecontentheader .= $OUTPUT->notification("{$i} This course is not currently visible to students. {$link}", 'notifyinfo');
    }

    // Grab a list of notifications from local_kent.
    $notifications = \local_notifications\core::get_notifications($COURSE->id);
    foreach ($notifications as $notification) {
        $coursecontentheader .= $notification->render();
    }

    if (!empty($coursecontentheader)) {
        $coursecontentheader = \html_writer::div($coursecontentheader, 'course-alerts');
    }
}

require(dirname(__FILE__) . "/general.php");
