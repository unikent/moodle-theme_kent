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

$hasheading = $OUTPUT->page_heading();
$hasnavbar = (empty($PAGE->layout_options['nonavbar']) && $PAGE->has_navbar());
$hasfooter = (empty($PAGE->layout_options['nofooter']));
$hassidepre = $PAGE->blocks->region_has_content('side-pre', $OUTPUT);
$hassidepost = $PAGE->blocks->region_has_content('side-post', $OUTPUT);
$showsidepre = $hassidepre && !$PAGE->blocks->region_completely_docked('side-pre', $OUTPUT);
$showsidepost = $hassidepost && !$PAGE->blocks->region_completely_docked('side-post', $OUTPUT);

$custommenu = empty($PAGE->layout_options['nocustommenu']) ? $OUTPUT->custom_menu() : '';

$haslogo = (!empty($PAGE->theme->settings->logo));

$coursecontentheader = isset($coursecontentheader) ? $coursecontentheader : '';

$courseheader = $coursecontentfooter = $coursefooter = '';
if (empty($PAGE->layout_options['nocourseheaderfooter'])) {
    $courseheader = $OUTPUT->course_header();
    $coursecontentheader .= $OUTPUT->course_content_header();
    if (empty($PAGE->layout_options['nocoursefooter'])) {
        $coursecontentfooter = $OUTPUT->course_content_footer();
        $coursefooter = $OUTPUT->course_footer();
    }
}

if (!isset($bodyclasses)) {
    $bodyclasses = array();
}

$bodyclasses[] = 'kent-env-' . $CFG->kent->environment;
$bodyclasses[] = 'kent-dist-' . $CFG->kent->distribution;
$bodyclasses[] = 'kent-navbar';
$bodyclasses[] = 'bootstrap';
$bodyclasses[] = 'kent-future-theme';

if (\theme_kent\core::is_contrast()) {
    $bodyclasses[] = 'kent-contrast';
}

if (\theme_kent\core::is_menu_text_hidden()) {
    $bodyclasses[] = 'kent-hidemenutext';
}

if (\theme_kent\core::is_future()) {
    $bodyclasses[] = 'kent-future';
}

if (\theme_kent\core::has_light_menu()) {
    $bodyclasses[] = 'light-menu';
}

if ($showsidepre && !$showsidepost) {
    if (!right_to_left()) {
        $bodyclasses[] = 'side-pre-only';
    } else {
        $bodyclasses[] = 'side-post-only';
    }
} else if ($showsidepost && !$showsidepre) {
    if (!right_to_left()) {
        $bodyclasses[] = 'side-post-only';
    } else {
        $bodyclasses[] = 'side-pre-only';
    }
} else if (!$showsidepost && !$showsidepre) {
    $bodyclasses[] = 'content-only';
}

if (!empty($custommenu)) {
    $bodyclasses[] = 'has_custom_menu';
}

$bodyclasses = array_unique($bodyclasses);

echo $OUTPUT->doctype();
?>

<html <?php echo $OUTPUT->htmlattributes() ?>>
<head>
    <title><?php echo $OUTPUT->page_title(); ?></title>
    <link rel="shortcut icon" href="<?php echo $OUTPUT->favicon(); ?>" />
    <?php
    echo $OUTPUT->standard_head_html();
    ?>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body <?php echo $OUTPUT->body_attributes($bodyclasses); ?>>

<?php

echo $OUTPUT->standard_top_of_body_html();

echo \html_writer::start_tag('div', array(
    'class' => 'container-fluid container-responsive-pad'
));

echo \html_writer::start_tag('div', array(
    'id' => 'page'
));