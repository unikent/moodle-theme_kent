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

require_once(dirname(__FILE__) . "/../../config.php");

$PAGE->set_context(\context_system::instance());
$PAGE->set_url('/theme/kent/404.php');
$PAGE->set_pagelayout('standalone');

echo $OUTPUT->header();

// Build menu.
$list = '';
$custommenu = new custom_menu($CFG->custommenuitems, current_language());
foreach ($custommenu->get_children() as $menunode) {
    if ($menunode->has_children()) {
        $list .= '<li role="presentation" class="dropdown">
        <a class="dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">';
        $list .= $menunode->get_text();
        $list .= '<span class="caret"></span></a>';
        $list .= '<ul class="dropdown-menu">';
        foreach ($menunode->get_children() as $childnode) {
            $link = html_writer::link(
                $childnode->get_url(),
                $childnode->get_text(),
                array('title' => $childnode->get_title())
            );
            $list .= '<li role="presentation">' . $link . '</li>';
        }
        $list .= '</ul>';
        $list .= '</li>';

    } else {
        $link = html_writer::link(
            $menunode->get_url(),
            $menunode->get_text(),
            array('title' => $menunode->get_title())
        );
        $list .= '<li role="presentation">' . $link . '</li>';
    }
}

echo \html_writer::tag('ul', $list, array('class' => 'nav nav-pills nav-justified'));
echo \html_writer::empty_tag('br');
echo \html_writer::tag('i', '', array('class' => 'fa fa-exclamation-circle', 'style' => 'font-size: 50px;'));
echo $OUTPUT->heading('Page Not Found', 1);
echo \html_writer::tag('p', 'We\'re sorry, but the page you requested can\'t be found.');

echo $OUTPUT->footer();
