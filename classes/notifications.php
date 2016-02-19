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
 * Theme Kent notifications utils.
 */
class notifications
{
    /**
     * Parse notifications string.
     */
    public static function parse($notification) {
        global $USER;

        // Make sure there is substance.
        $notification = trim($notification);
        if (empty($notification)) {
            return null;
        }

        $data = new \stdClass();
        $data->audience = 'all';
        $data->type = 'error';
        $data->message = $notification;

        // Split up!
        $parts = explode('|', $notification, 3);
        if (count($parts) <= 0) {
            return $data;
        }

        // Check through parts.
        foreach ($parts as $part) {
            $part = trim($part);

            switch ($part) {
                case 'student':
                case 'staff':
                    $data->audience = $part;
                break;

                case 'danger':
                case 'warning':
                case 'info':
                case 'success':
                    $data->type = $part;
                break;

                default:
                    $data->message = $part;
                break 2; // Exit the foreach too.
            }
        }

        return $data;
    }
}
