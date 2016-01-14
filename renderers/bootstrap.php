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

        // Support dismissable notifications.
        $dismissable = false;
        if (strpos($classes, ' ') !== false) {
            $parts = explode(' ', $classes);
            $classes = array();
            foreach ($parts as $part) {
                if ($part == 'dismissable') {
                    $dismissable = true;
                } else {
                    switch ($part) {
                        case 'notifydanger':
                        case 'notifyerror':
                        case 'notifyproblem':
                        case 'notifytiny':
                            $classes[] = 'alert';
                            $classes[] = 'alert-danger';
                        break;

                        case 'notifysuccess':
                            $classes[] = 'alert';
                            $classes[] = 'alert-success';
                        break;
                        
                        case 'notifywarning':
                            $classes[] = 'alert';
                            $classes[] = 'alert-warning';
                        break;
                        
                        case 'notifyinfo':
                        case 'notifymessage':
                        case 'redirectmessage':
                            $classes[] = 'alert';
                            $classes[] = 'alert-info';
                        break;

                        default:
                            $classes[] = $part;
                        break;
                    }
                }
            }
            $classes = implode(' ', $classes);
        }

        $button = '';
        if ($dismissable) {
            $classes .= ' alert-dismissible';
            $button = '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>';
        }

        return "<div class=\"{$classes}\" role=\"alert\">{$button}{$message}</div>";
    }
}
