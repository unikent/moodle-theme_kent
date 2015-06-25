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
        $coursecontentheader .= $OUTPUT->notification('<i class="fa fa-exclamation-circle"></i> This course is not currently visible to students.', 'notifyinfo');
    }

    // Grab a list of notifications from local_kent.
    $notifications = \local_notifications\core::get_notifications($COURSE->id);
    foreach ($notifications as $notification) {
        if (!$notification->is_visible()) {
            continue;
        }

        $classes = "alert " . $notification->get_level();
        $dismiss = '';
        if ($notification->is_dismissble()) {
            $id = $notification->get_id();
            $classes .= ' alert-dismissible';
            $dismiss .= <<<HTML5
            <button type="button" class="close cnid-dismiss" data-dismiss="alert" data-id="{$id}" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
HTML5;
        }

        $icon = \html_writer::tag('i', '', array(
            'class' => 'fa ' . $notification->get_icon()
        ));
        $message = $notification->render();

        $coursecontentheader .= <<<HTML5
        <div class="{$classes}" role="alert">
            {$dismiss}
            {$icon} {$message}
        </div>
HTML5;
    }
}

require(dirname(__FILE__) . "/general.php");
