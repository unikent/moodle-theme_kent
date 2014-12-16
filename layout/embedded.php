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

$bodyclasses = array(
    'kent-env-' . $CFG->kent->environment,
    'kent-dist-' . $CFG->kent->distribution
);

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

echo $OUTPUT->doctype();

?>
<html <?php echo $OUTPUT->htmlattributes() ?>>
<head>
    <title><?php echo $OUTPUT->page_title() ?></title>
    <link rel="shortcut icon" href="<?php echo $OUTPUT->pix_url('favicon', 'theme')?>" />
    <?php echo $OUTPUT->standard_head_html() ?>
</head>
<body <?php echo $OUTPUT->body_attributes($bodyclasses); ?>>
<?php echo $OUTPUT->standard_top_of_body_html() ?>

<div id="page">

<!-- END OF HEADER -->

    <div id="content" class="clearfix">
        <?php echo $OUTPUT->main_content() ?>
    </div>

<!-- START OF FOOTER -->
</div>
<?php echo $OUTPUT->standard_end_of_body_html() ?>
</body>
</html>