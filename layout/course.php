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
    // Add error message if we have been scheduled for deletion.
    // TODO: move this to Kent notification system.
    $cmenabled = get_config("local_catman", "enable");
    if ($cmenabled &&  \local_catman\core::is_scheduled($COURSE)) {
        $time = \local_catman\core::get_expiration($COURSE);
        $time = strftime("%d/%m/%Y %H:%M", $time);
        $coursecontentheader .= $OUTPUT->notification("<i class=\"fa fa-exclamation-triangle\"></i> This course has been scheduled for deletion on {$time}.", 'notifyproblem');
    }

    if (!$COURSE->visible) {
        $coursecontentheader .= $OUTPUT->notification('<i class="fa fa-exclamation-circle"></i> This course is not currently visible to students.', 'notifyinfo');
    }

    // Grab a list of notifications from local_kent.
    $cobj = new \local_kent\Course($COURSE->id);
    $notifications = $cobj->get_notifications();
    foreach ($notifications as $notification) {
        if ($notification->dismissable && $notification->seen) {
            continue;
        }

        $classes = "alert alert-{$notification->type}";
        $dismiss = '';
        if ($notification->dismissable) {
            $classes .= ' alert-dismissible';
            $dismiss .= <<<HTML5
            <button type="button" class="close cnid-dismiss" data-dismiss="alert" data-id="{$notification->id}" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
HTML5;
        }

        $coursecontentheader .= <<<HTML5
        <div class="{$classes}" role="alert">
            {$dismiss}
            {$notification->message}
        </div>
HTML5;
    }
}

require(dirname(__FILE__) . "/general.php");
