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

if (\theme_kent\core::is_global_nav_enabled()) {

require(dirname(__FILE__) . "/globalnav.php");

} else {

require(dirname(__FILE__) . "/includes/header.php");

echo \html_writer::start_tag('div', array(
    'class' => 'container-fluid container-responsive-pad'
));

echo \html_writer::start_tag('div', array(
    'id' => 'page'
));

$regions = theme_kent_grid($hassidepre, $hassidepost);
?>

<div id="page-header">
    <?php
    $out = '';
    if (!empty($PAGE->layout_options['langmenu'])) {
        $out .= $OUTPUT->lang_menu();
    }

    $out .= $OUTPUT->page_heading_menu();
    if (!empty($out)) {
        echo '<div class="headermenu row">' . $out . '</div>';
    }
    ?>
    <div id="headerwrap" class="row">
        <div class="col-xs-12 col-sm-6 brand">
            <span class="kf-moodle"></span>
            <?php
            echo $CFG->fullname;
            ?>
        </div>
        <div class="col-xs-12 col-sm-6 user">
            <?php
            if (empty($PAGE->layout_options['nousermenu'])) {
                echo $OUTPUT->user_menu();
            }
            ?>
        </div>
    </div>
</div>

<?php
if (!empty($custommenu)) {
    echo '<div id="menuwrap" class="row">';
    echo $custommenu;
    echo '</div>';
}

if ($hasnavbar) {
    echo '<div class="navbar row">';
    echo '<div class="col-md-12">';
    echo $OUTPUT->navbar();
    echo '</div>';
    echo '</div>';
}

echo \html_writer::start_tag('div', array(
    'id' => 'contentwrapper',
    'class' => $hasnavbar ? 'row' : 'row spacer'
));
?>

<div id="page-content">
    <div id="region-main-box">
        <section id="region-main" class="<?php echo $regions['content']; ?>">
            <?php
            echo $coursecontentheader;
            echo $OUTPUT->main_content();
            echo $coursecontentfooter;
            ?>
        </section>
        <?php echo $OUTPUT->blocks('side-pre', $regions['pre']); ?>
        <?php echo $OUTPUT->blocks('side-post', $regions['post']); ?>
    </div>
</div>

<?php
echo \html_writer::end_tag('div');

if (!empty($coursefooter)) {
    echo "<div id=\"course-footer\">{$coursefooter}</div>";
}
?>

<?php
if ($hasfooter) {
?>
<div id="page-footer" class="row">
    <div id="footerwrapper" class="container-fluid">
        <div class="row">
            <div class="col-xs-12 col-sm-3 text-left">
                <a href="mailto:helpdesk@kent.ac.uk?subject=Moodle help">Contact Helpdesk</a>
            </div>
            <div class="col-xs-12 col-sm-6 text-center">
                <a target="_blank" href="http://www.kent.ac.uk/elearning/privacy/">Privacy and Data Protection</a>
                <br />
                <a target="_blank" href="https://www.kent.ac.uk/itservices/forms/moodle/notice.html">Report this Content</a>
            </div>
            <div class="col-xs-12 col-sm-3 text-right">
                <?php
                echo $OUTPUT->login_info();
                echo $OUTPUT->theme_switch_links();
                ?>
            </div>
        </div>
        <?php
        if (has_capability('moodle/site:config', context_system::instance())) {
            echo '<div class="moodle-extra row">';
            echo $OUTPUT->standard_footer_html();
            echo '</div>';
        }
        ?>
    </div>
    <div class="clearfix"></div>
</div>
<?php
}

echo \html_writer::end_tag('div');
echo \html_writer::end_tag('div');

require(dirname(__FILE__) . "/includes/footer.php");
}