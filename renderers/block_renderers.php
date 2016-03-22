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

require_once($CFG->dirroot . '/blocks/settings/renderer.php');

/**
 * Overrides a few defaults.
 *
 * @package     theme_kent
 * @copyright   2015 Skylar Kelty <S.Kelty@kent.ac.uk>
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class theme_kent_block_settings_renderer extends block_settings_renderer
{
    public function search_form(moodle_url $formtarget, $searchvalue) {
        $content = html_writer::start_tag('form', array('class'=>'adminsearchform', 'method'=>'get', 'action'=>$formtarget, 'role' => 'search'));
        $content .= html_writer::start_tag('div');

        $content .= html_writer::start_tag('div', array('class' => 'input-group input-group-sm'));
            $content .= html_writer::empty_tag('input', array(
                'type' => 'text',
                'id' => 'adminsearchquery',
                'name' => 'query',
                'value' => s($searchvalue),
                'class' => 'form-control',
                'placeholder' => s(get_string('searchinsettings', 'admin'))
            ));

            $content .= html_writer::start_tag('span', array('class' => 'input-group-btn'));
                $content .= html_writer::tag('button', '<i class="fa fa-search"></i>', array(
                    'class' => 'btn btn-default',
                    'type' => 'submit'
                ));
            $content .= html_writer::end_tag('span');
        $content .= html_writer::end_tag('div');

        $content .= html_writer::end_tag('div');
        $content .= html_writer::end_tag('form');
        return $content;
    }
}
