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

require_once($CFG->dirroot . '/question/engine/renderer.php');

/**
 * Overrides a few defaults.
 *
 * @package     theme_kent
 * @copyright   2015 Skylar Kelty <S.Kelty@kent.ac.uk>
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class theme_kent_core_question_renderer extends core_question_renderer
{
    /**
     * Generate the display of a question in a particular state, and with certain
     * display options. Normally you do not call this method directly. Intsead
     * you call {@link question_usage_by_activity::render_question()} which will
     * call this method with appropriate arguments.
     *
     * @param question_attempt $qa the question attempt to display.
     * @param qbehaviour_renderer $behaviouroutput the renderer to output the behaviour
     *      specific parts.
     * @param qtype_renderer $qtoutput the renderer to output the question type
     *      specific parts.
     * @param question_display_options $options controls what should and should not be displayed.
     * @param string|null $number The question number to display. 'i' is a special
     *      value that gets displayed as Information. Null means no number is displayed.
     * @return string HTML representation of the question.
     */
    public function question(question_attempt $qa, qbehaviour_renderer $behaviouroutput,
            qtype_renderer $qtoutput, question_display_options $options, $number) {

        $output = '';
        $output .= html_writer::start_tag('div', array(
            'id' => 'q' . $qa->get_slot(),
            'class' => implode(' ', array(
                'que', 'row',
                $qa->get_question()->qtype->name(),
                $qa->get_behaviour_name(),
                $qa->get_state_class($options->correctness && $qa->has_marks()),
            ))
        ));

        $output .= html_writer::tag('div',
                $this->info($qa, $behaviouroutput, $qtoutput, $options, $number),
                array('class' => 'info col-md-2'));

        $output .= html_writer::start_tag('div', array('class' => 'content col-md-10'));

        $output .= html_writer::tag('div',
                $this->add_part_heading($qtoutput->formulation_heading(),
                    $this->formulation($qa, $behaviouroutput, $qtoutput, $options)),
                array('class' => 'formulation'));
        $output .= html_writer::nonempty_tag('div',
                $this->add_part_heading(get_string('feedback', 'question'),
                    $this->outcome($qa, $behaviouroutput, $qtoutput, $options)),
                array('class' => 'outcome'));
        $output .= html_writer::nonempty_tag('div',
                $this->add_part_heading(get_string('comments', 'question'),
                    $this->manual_comment($qa, $behaviouroutput, $qtoutput, $options)),
                array('class' => 'comment'));
        $output .= html_writer::nonempty_tag('div',
                $this->response_history($qa, $behaviouroutput, $qtoutput, $options),
                array('class' => 'history'));

        $output .= html_writer::end_tag('div');
        $output .= html_writer::end_tag('div');
        return $output;
    }
}

class theme_kent_mod_quiz_edit_renderer extends \mod_quiz\output\edit_renderer
{
    /**
     * Render the edit page
     *
     * @param \quiz $quizobj object containing all the quiz settings information.
     * @param structure $structure object containing the structure of the quiz.
     * @param \question_edit_contexts $contexts the relevant question bank contexts.
     * @param \moodle_url $pageurl the canonical URL of this page.
     * @param array $pagevars the variables from {@link question_edit_setup()}.
     * @return string HTML to output.
     */
    public function edit_page(\quiz $quizobj, \mod_quiz\structure $structure,
            \question_edit_contexts $contexts, \moodle_url $pageurl, array $pagevars) {
        $output = '';

        // Page title.
        $output .= $this->heading_with_help(get_string('editingquizx', 'quiz',
                format_string($quizobj->get_quiz_name())), 'editingquiz', 'quiz', '',
                get_string('basicideasofquiz', 'quiz'), 2);

        // Information at the top.
        $output .= $this->quiz_state_warnings($structure);
        $output .= $this->quiz_information($structure);

        // Show the questions organised into sections and pages.
        $output .= $this->start_section_list();

        foreach ($structure->get_sections() as $section) {
            $output .= $this->start_section($structure, $section);
            $output .= $this->questions_in_section($structure, $section, $contexts, $pagevars, $pageurl);

            if ($structure->is_last_section($section)) {
                $output .= \html_writer::start_div('last-add-menu');
                $output .= \html_writer::tag('span', $this->add_menu_actions($structure, 0,
                        $pageurl, $contexts, $pagevars), array('class' => 'add-menu-outer'));
                $output .= \html_writer::end_div();
            }

            $output .= $this->end_section();
        }

        $output .= $this->end_section_list();

        $output .= $this->repaginate_button($structure, $pageurl);

        $output .= $this->maximum_grade_input($structure, $pageurl);
        $output .= $this->total_marks($quizobj->get_quiz());
        
        // Initialise the JavaScript.
        $this->initialise_editing_javascript($structure, $contexts, $pagevars, $pageurl);

        // Include the contents of any other popups required.
        if ($structure->can_be_edited()) {
            $popups = '';

            $popups .= $this->question_bank_loading();
            $this->page->requires->yui_module('moodle-mod_quiz-quizquestionbank',
                    'M.mod_quiz.quizquestionbank.init',
                    array('class' => 'questionbank', 'cmid' => $structure->get_cmid()));

            $popups .= $this->random_question_form($pageurl, $contexts, $pagevars);
            $this->page->requires->yui_module('moodle-mod_quiz-randomquestion',
                    'M.mod_quiz.randomquestion.init');

            $output .= \html_writer::div($popups, 'mod_quiz_edit_forms');

            // Include the question chooser.
            $output .= $this->question_chooser();
            $this->page->requires->yui_module('moodle-mod_quiz-questionchooser', 'M.mod_quiz.init_questionchooser');
        }

        return $output;
    }

    /**
     * Render the total marks available for the quiz.
     *
     * @param \stdClass $quiz the quiz settings from the database.
     * @return string HTML to output.
     */
    public function total_marks($quiz) {
        $totalmark = \html_writer::span(quiz_format_grade($quiz, $quiz->sumgrades), 'mod_quiz_summarks');
        return \html_writer::tag('div',
                get_string('totalmarksx', 'quiz', $totalmark),
                array('class' => 'totalpoints'));
    }
}
