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
require_once($CFG->dirroot . '/course/format/standardweeks/renderer.php');
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

    /**
     * Renders HTML for displaying the sequence of course module editing buttons
     *
     * @see course_get_cm_edit_actions()
     *
     * @param action_link[] $actions Array of action_link objects
     * @param cm_info $mod The module we are displaying actions for.
     * @param array $displayoptions additional display options:
     *     ownerselector => A JS/CSS selector that can be used to find an cm node.
     *         If specified the owning node will be given the class 'action-menu-shown' when the action
     *         menu is being displayed.
     *     constraintselector => A JS/CSS selector that can be used to find the parent node for which to constrain
     *         the action menu to when it is being displayed.
     *     donotenhance => If set to true the action menu that gets displayed won't be enhanced by JS.
     * @return string
     */
    public function course_section_cm_edit_actions($actions, cm_info $mod = null, $displayoptions = array()) {
        global $CFG, $OUTPUT;

        if (empty($actions)) {
            return '';
        }

        if (isset($displayoptions['ownerselector'])) {
            $ownerselector = $displayoptions['ownerselector'];
        } else if ($mod) {
            $ownerselector = '#module-'.$mod->id;
        } else {
            debugging('You should upgrade your call to '.__FUNCTION__.' and provide $mod', DEBUG_DEVELOPER);
            $ownerselector = 'li.activity';
        }

        if (isset($displayoptions['constraintselector'])) {
            $constraint = $displayoptions['constraintselector'];
        } else {
            $constraint = '.course-content';
        }

        $menu = new action_menu();
        $menu->set_owner_selector($ownerselector);
        $menu->set_constraint($constraint);
        $menu->set_alignment(action_menu::TR, action_menu::BR);
        $menu->set_menu_trigger($OUTPUT->pix_icon('t/edit', 'Edit Settings'));
        if (isset($CFG->modeditingmenu) && !$CFG->modeditingmenu || !empty($displayoptions['donotenhance'])) {
            $menu->do_not_enhance();

            // Swap the left/right icons.
            // Normally we have have right, then left but this does not
            // make sense when modactionmenu is disabled.
            $moveright = null;
            $tmpactions = array();
            foreach ($actions as $key => $value) {
                if ($key === 'moveright') {

                    // Save moveright for later.
                    $moveright = $value;
                } else if ($moveright) {

                    // This assumes that the order was moveright, moveleft.
                    // If we have a moveright, then we should place it immediately after the current value.
                    $tmpactions[$key] = $value;
                    $tmpactions['moveright'] = $moveright;

                    // Clear the value to prevent it being used multiple times.
                    $moveright = null;
                } else {

                    $tmpactions[$key] = $value;
                }
            }
            $actions = $tmpactions;
            unset($tmpactions);
        }
        foreach ($actions as $k => $action) {
            if ($action instanceof action_menu_link) {
                $action->add_class('cm-edit-action');
            }

            $menu->add($action);
        }
        $menu->attributes['class'] .= ' section-cm-edit-actions commands';

        // Prioritise the menu ahead of all other actions.
        $menu->prioritise = true;

        return $this->render($menu);
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
        $controls = $this->section_edit_control_items($course, $section, $onsectionpage);
        return $this->section_edit_control_menu($controls, $course, $section);
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
}

class theme_kent_format_standardweeks_renderer extends format_standardweeks_renderer
{
    use theme_kent_course_edit_options;
}

class theme_kent_format_weeks_renderer extends format_weeks_renderer
{
    use theme_kent_course_edit_options;
}

class theme_kent_format_topics_renderer extends format_topics_renderer
{
    use theme_kent_course_edit_options;
}