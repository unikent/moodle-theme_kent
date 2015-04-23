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

require(dirname(__FILE__) . "/includes/header.php");

$prespan = 2;
$midspan = 8;
$postspan = 2;

if (!$showsidepre) {
    $prespan = 0;
    $midspan += 2;
}

if (!$showsidepost) {
    $postspan = 0;
    $midspan += 2;
}
?>

<div id="page-header" class="container-fluid">
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
            <?php
            echo "Moodle-" . $CFG->kent->distribution;
            ?>
        </div>
        <div class="col-xs-12 col-sm-6">
            <?php
            echo $OUTPUT->user_menu();
            ?>
        </div>
    </div>
</div>

<?php 
if ($hascustommenu) {
    echo '<div id="menuwrap" class="row">';
    echo '<div class="col-md-12">';
    echo $custommenu;
    echo '</div>';
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
        <?php
        if ($showsidepre) {
            $blocks = $OUTPUT->blocks('side-pre');
            echo <<<HTML5
            <section id="region-pre" class="block-region col-xs-12 col-md-$prespan">
                <div class="region-content">
                    $blocks
                </div>
            </section>
HTML5;
        }

        $maincontent = $OUTPUT->main_content();
        echo <<<HTML5
        <section id="region-main" class="col-xs-12 col-md-$midspan">
            <div class="region-content container-fluid">
                $coursecontentheader
                $maincontent
                $coursecontentfooter
            </div>
        </section>
HTML5;

        if ($showsidepost) {
            $blocks = $OUTPUT->blocks('side-post');
            echo <<<HTML5
            <section id="region-post" class="block-region col-xs-12 col-md-$postspan">
                <div class="region-content">
                    $blocks
                </div>
            </section>
HTML5;
        }
        ?>
     </div>
</div>      

<?php
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

require(dirname(__FILE__) . "/includes/footer.php");
