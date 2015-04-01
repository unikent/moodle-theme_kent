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

trait theme_kent_bootstrap_notifications {
    /*
     * This renders a notification message.
     * Uses bootstrap compatible html.
     */
    public function notification($message, $classes = 'notifyproblem') {
        $message = clean_text($message);
        $type = '';
        $dismissable = false;

        // Support dismissable notifications.
        if (strpos($classes, ' ') !== false) {
            $classes = explode(' ', $classes);

            if ($classes[1] == 'dismissable') {
                $dismissable = true;
            }

            $classes = $classes[0];
        }

        switch ($classes) {
            case 'notifyproblem':
            case 'notifytiny':
                $type = 'alert alert-danger';
            break;

            case 'notifysuccess':
                $type = 'alert alert-success';
            break;
            
            case 'notifywarning':
                $type = 'alert alert-warning';
            break;
            
            case 'notifymessage':
            case 'redirectmessage':
                $type = 'alert alert-info';
            break;

            default:
                $type = $classes;
            break;
        }

        $button = '';
        if ($dismissable) {
            $type .= ' alert-dismissible';
            $button = '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>';
        }

        return "<div class=\"{$type}\" role=\"alert\">{$button}{$message}</div>";
    }
}
