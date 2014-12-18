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

$custommenu = $OUTPUT->custom_menu();
$hascustommenu = (empty($PAGE->layout_options['nocustommenu']) && !empty($custommenu));
$haslogo = (!empty($PAGE->theme->settings->logo));

$courseheader = $coursecontentheader = $coursecontentfooter = $coursefooter = '';
if (empty($PAGE->layout_options['nocourseheaderfooter'])) {
    $courseheader = $OUTPUT->course_header();
    $coursecontentheader = $OUTPUT->course_content_header();
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

$isfuture = $CFG->kent->distribution == 'future' || $CFG->kent->distribution == 'future-demo';
if ($isfuture) {
    $bodyclasses[] = 'kent-future';
}

$hasfuture = \local_kent\User::get_user_preference("enablefuturetheme", $isfuture ? "1" : "0");
if ($hasfuture === "1") {
    $bodyclasses[] = 'kent-future-theme';
}

$haskentnavbar = \local_kent\User::get_user_preference("enablekentnavbar", $isfuture ? "1" : "0");
if ($CFG->theme_kent_enable_navbar && $haskentnavbar === "1") {
    $bodyclasses[] = 'kent-navbar';
}

$hasnewprofilebar = $hasfuture && $CFG->branch == 28;
if ($hasnewprofilebar) {
    $bodyclasses[] = 'kent-new-profile-bar';
}

// Custom CSS (if set).
$customcolor = \local_kent\User::get_user_preference("themecustomcolor");
if ($customcolor) {
    $customcolor = clean_param($customcolor, PARAM_ALPHANUM);
    $customcolor = substr($customcolor, 0, 6);
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
if ($hascustommenu) {
    $bodyclasses[] = 'has_custom_menu';
}

$bodyclasses = array_unique($bodyclasses);

echo $OUTPUT->doctype();
?>

<html <?php echo $OUTPUT->htmlattributes() ?>>
<head>
    <title><?php echo $OUTPUT->page_title(); ?></title>
    <link rel="shortcut icon" href="<?php echo $OUTPUT->favicon()?>" />
<?php
echo $OUTPUT->standard_head_html();

echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"{$CFG->wwwroot}/theme/kent/style/fonts.css\" />";

if ($customcolor) {
    echo "<style>#menuwrap { background-color: #{$customcolor} !important; }</style>";
}
?>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body <?php echo $OUTPUT->body_attributes($bodyclasses); ?>>

<?php echo $OUTPUT->standard_top_of_body_html(); ?>