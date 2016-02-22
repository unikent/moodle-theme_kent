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

defined('MOODLE_INTERNAL') || die;

if ($ADMIN->fulltree) {
    $name = 'theme_kent/global_notification';
    $title = 'Global Notifications';
    $description = 'One message per line, HTML permitted.
    You can prefix with "student|" or "staff|" to send to those specific groups.
    You can also prefix with "info|", "warning|", "danger|" and "success|" to show different coloured warnings.
    E.g. "student|danger|You are a student!" would display the message "You are a student!" to all students, in a red box.';
    $setting = new admin_setting_configtextarea($name, $title, $description, 0);
    $settings->add($setting);
}
