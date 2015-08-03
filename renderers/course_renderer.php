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

require_once($CFG->dirroot . '/course/renderer.php');
require_once($CFG->dirroot . '/course/classes/management_renderer.php');
require_once($CFG->dirroot . '/course/format/weeks/renderer.php');
require_once($CFG->dirroot . '/course/format/topics/renderer.php');

/**
 * Overrides a few defaults.
 *
 * @package     theme_kent
 * @copyright   2015 Skylar Kelty <S.Kelty@kent.ac.uk>
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class theme_kent_core_course_renderer extends core_course_renderer
{
    /**
     * Renders html to display a course search form
     *
     * @param string $value default value to populate the search field
     * @param string $format display format - 'plain' (default), 'short' or 'navbar'
     * @return string
     */
    public function course_search_form($value = '', $format = 'plain') {
        static $count = 0;
        $formid = 'coursesearch';
        if ((++$count) > 1) {
            $formid .= $count;
        }

        switch ($format) {
            case 'navbar' :
                $formid = 'coursesearchnavbar';
                $inputid = 'navsearchbox';
                $inputsize = 20;
                break;
            case 'short' :
                $inputid = 'shortsearchbox';
                $inputsize = 12;
                break;
            default :
                $inputid = 'coursesearchbox';
                $inputsize = 30;
        }

        $strsearchcourses = get_string("searchcourses");
        $searchurl = new moodle_url('/course/search.php');

        $output = html_writer::start_tag('form', array('id' => $formid, 'action' => $searchurl, 'method' => 'get'));
        $output .= html_writer::start_tag('fieldset', array('class' => 'coursesearchbox invisiblefieldset'));

        $output .= html_writer::start_tag('div', array('class' => 'input-group'));
            $output .= html_writer::empty_tag('input', array(
                'type' => 'text',
                'id' => $inputid,
                'size' => $inputsize,
                'name' => 'search',
                'value' => s($value),
                'class' => 'form-control',
                'placeholder' => $strsearchcourses
            ));

            $output .= html_writer::start_tag('span', array('class' => 'input-group-btn'));
                $output .= html_writer::tag('button', '<i class="fa fa-search"></i>', array(
                    'class' => 'btn btn-default',
                    'type' => 'submit'
                ));
            $output .= html_writer::end_tag('span');
        $output .= html_writer::end_tag('div');

        $output .= html_writer::end_tag('fieldset');
        $output .= html_writer::end_tag('form');

        return $output;
    }
}


/**
 * Overrides a few defaults.
 *
 * @package     theme_kent
 * @copyright   2015 Skylar Kelty <S.Kelty@kent.ac.uk>
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class theme_kent_core_course_management_renderer extends core_course_management_renderer
{
    /**
     * Renders html to display a course search form
     *
     * @param string $value default value to populate the search field
     * @param string $format display format - 'plain' (default), 'short' or 'navbar'
     * @return string
     */
    public function course_search_form($value = '', $format = 'plain') {
        static $count = 0;
        $formid = 'coursesearch';
        if ((++$count) > 1) {
            $formid .= $count;
        }

        switch ($format) {
            case 'navbar' :
                $formid = 'coursesearchnavbar';
                $inputid = 'navsearchbox';
                $inputsize = 20;
                break;
            case 'short' :
                $inputid = 'shortsearchbox';
                $inputsize = 12;
                break;
            default :
                $inputid = 'coursesearchbox';
                $inputsize = 30;
        }

        $strsearchcourses = get_string("searchcourses");
        $searchurl = new moodle_url('/course/management.php');

        $output = html_writer::start_tag('form', array('id' => $formid, 'action' => $searchurl, 'method' => 'get'));
        $output .= html_writer::start_tag('fieldset', array('class' => 'coursesearchbox invisiblefieldset'));

        $output .= html_writer::start_tag('div', array('class' => 'input-group'));
            $output .= html_writer::empty_tag('input', array(
                'type' => 'text',
                'id' => $inputid,
                'size' => $inputsize,
                'name' => 'search',
                'value' => s($value),
                'class' => 'form-control',
                'placeholder' => $strsearchcourses
            ));

            $output .= html_writer::start_tag('span', array('class' => 'input-group-btn'));
                $output .= html_writer::tag('button', '<i class="fa fa-search"></i>', array(
                    'class' => 'btn btn-default',
                    'type' => 'submit'
                ));
            $output .= html_writer::end_tag('span');
        $output .= html_writer::end_tag('div');

        $output .= html_writer::end_tag('fieldset');
        $output .= html_writer::end_tag('form');

        return $output;
    }
}

trait theme_kent_course_edit_options
{
    /**
     * Generate the content to displayed on the right part of a section
     * before course modules are included
     *
     * @param stdClass $section The course_section entry from DB
     * @param stdClass $course The course entry from DB
     * @param bool $onsectionpage true if being printed on a section page
     * @return string HTML to output.
     */
    protected function section_right_content($section, $course, $onsectionpage) {
        if ($section->section != 0) {
            $controls = $this->section_edit_controls($course, $section, $onsectionpage);
            if (!empty($controls)) {
                return implode('', $controls);
            }
        }

        return '';
    }

    /**
     * Generate the content to displayed on the left part of a section
     * before course modules are included
     *
     * @param stdClass $section The course_section entry from DB
     * @param stdClass $course The course entry from DB
     * @param bool $onsectionpage true if being printed on a section page
     * @return string HTML to output.
     */
    protected function section_left_content($section, $course, $onsectionpage) {
        return '';
    }

    /**
     * Generate the edit controls of a section
     *
     * @param stdClass $course The course entry from DB
     * @param stdClass $section The course_section entry from DB
     * @param bool $onsectionpage true if being printed on a section page
     * @return array of links with edit controls
     */
    protected function section_edit_controls($course, $section, $onsectionpage = false) {
        global $PAGE;

        if (!$PAGE->user_is_editing()) {
            return array();
        }

        $coursecontext = context_course::instance($course->id);
        $isstealth = isset($course->numsections) && ($section->section > $course->numsections);

        if ($onsectionpage) {
            $baseurl = course_get_url($course, $section->section);
        } else {
            $baseurl = course_get_url($course);
        }
        $baseurl->param('sesskey', sesskey());

        $controls = array();

        $url = clone($baseurl);
        if (!$isstealth && has_capability('moodle/course:sectionvisibility', $coursecontext)) {
            if ($section->visible) { // Show the hide/show eye.
                $strhidefromothers = get_string('hidefromothers', 'format_'.$course->format);
                $url->param('hide', $section->section);
                $controls[] = html_writer::link($url,
                    html_writer::tag('i', '', array('class' => 'fa fa-eye-slash icon hide')),
                    array('title' => $strhidefromothers, 'class' => 'editing_showhide'));
            } else {
                $strshowfromothers = get_string('showfromothers', 'format_'.$course->format);
                $url->param('show',  $section->section);
                $controls[] = html_writer::link($url,
                    html_writer::tag('i', '', array('class' => 'fa fa-eye icon hide')),
                    array('title' => $strshowfromothers, 'class' => 'editing_showhide'));
            }
        }

        if (course_can_delete_section($course, $section)) {
            if (get_string_manager()->string_exists('deletesection', 'format_'.$course->format)) {
                $strdelete = get_string('deletesection', 'format_'.$course->format);
            } else {
                $strdelete = get_string('deletesection');
            }
            $url = new moodle_url('/course/editsection.php', array('id' => $section->id,
                'sr' => $onsectionpage ? $section->section : 0, 'delete' => 1));
            $controls[] = html_writer::link($url,
                html_writer::tag('i', '', array('class' => 'fa fa-times icon delete')),
                array('title' => $strdelete));
        }

        if (!$isstealth && !$onsectionpage && has_capability('moodle/course:movesections', $coursecontext)) {
            $url = clone($baseurl);
            if ($section->section > 1) { // Add a arrow to move section up.
                $url->param('section', $section->section);
                $url->param('move', -1);
                $strmoveup = get_string('moveup');

                $controls[] = html_writer::link($url,
                    html_writer::tag('i', '', array('class' => 'fa fa-sort-up icon up')),
                    array('title' => $strmoveup, 'class' => 'moveup'));
            }

            $url = clone($baseurl);
            if ($section->section < $course->numsections) { // Add a arrow to move section down.
                $url->param('section', $section->section);
                $url->param('move', 1);
                $strmovedown = get_string('movedown');

                $controls[] = html_writer::link($url,
                    html_writer::tag('i', '', array('class' => 'fa fa-sort-down icon down')),
                    array('title' => $strmovedown, 'class' => 'movedown'));
            }
        }

        return $controls;
    }
}

class theme_kent_format_weeks_renderer extends format_weeks_renderer
{
    use theme_kent_course_edit_options;
}

class theme_kent_format_topics_renderer extends format_topics_renderer
{
    use theme_kent_course_edit_options;
}