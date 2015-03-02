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

$prespan = 2;
$midspan = 8;
$postspan = 2;

if (!$hassidepre) {
    $prespan = 0;
    $midspan += 2;
}

if (!$hassidepost) {
    $postspan = 0;
    $midspan += 2;
}
?>

<div id="page" class="container">

<div id="page-header" class="row">
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
        <div class="col-xs-12 col-md-6 brand">
            <?php
            echo "Moodle-" . $CFG->kent->distribution;
            ?>
        </div>
        <div class="col-xs-12 col-md-6">
            <?php
            echo $OUTPUT->user_menu();
            ?>
        </div>
    </div>
</div>
        
<div id="menuwrap" class="row">
    <?php 
    if ($hascustommenu) {
        echo $custommenu;
    }
    ?>
</div>

<?php if ($hasnavbar) { ?>
<div class="navbar row">
    <?php echo $OUTPUT->navbar();  ?>
</div>
<?php } ?>

<div id="contentwrapper" class="row">
    <div id="page-content">
        <?php
        if ($hassidepre) {
            $blocks = $OUTPUT->blocks('side-pre');
            echo <<<HTML5
            <div id="region-pre" class="block-region col-xs-12 col-md-$prespan">
                <div class="region-content">
                    $blocks
                </div>
            </div>
HTML5;
        }

        $maincontent = $OUTPUT->main_content();
        echo <<<HTML5
        <div id="main-region" class="col-xs-12 col-md-$midspan">
            <div id="main-padder" class="region-content">
                $coursecontentheader
                $maincontent
                $coursecontentfooter
            </div>
        </div>
HTML5;

        if ($hassidepost) {
            $blocks = $OUTPUT->blocks('side-post');
            echo <<<HTML5
            <div id="region-post" class="block-region col-xs-12 col-md-$postspan">
                <div class="region-content">
                    $blocks
                </div>
            </div>
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
    <div id="footerwrapper">
        <div class="row">
            <div class="col-md-3 text-left">
                <a href="mailto:helpdesk@kent.ac.uk?subject=Moodle help">Contact Helpdesk</a>
            </div>
            <div class="col-md-6 text-center">
                <p style="text-align: center;">
                    <a target="_blank" href="http://www.kent.ac.uk/elearning/privacy/">Privacy and Data Protection</a>
                    <br />
                    <a target="_blank" href="https://www.kent.ac.uk/itservices/forms/moodle/notice.html">Report this Content</a>
                </p>
            </div>
            <div class="col-md-3 text-right">
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
?>

</div>
