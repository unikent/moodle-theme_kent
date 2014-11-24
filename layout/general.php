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

if (isset($CFG->local_tutorials_enabled) && $CFG->local_tutorials_enabled) {
    \local_tutorials\Page::on_load();
}

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

$bodyclasses = array(
    'kent-env-' . $CFG->kent->environment,
    'kent-dist-' . $CFG->kent->distribution
);

// Custom CSS (if set).
$customcolor = null;
if (isloggedin() && !isguestuser()) {
    global $DB, $USER, $SESSION;

    if (!isset($SESSION->theme_kent_custom_color)) {
        $customcolor = $DB->get_field_sql('
            SELECT data
            FROM {user_info_data} uid
            INNER JOIN {user_info_field} uif
                ON uif.id = uid.fieldid
            WHERE uid.userid = :userid AND uif.shortname = :shortname
        ', array(
            'userid' => $USER->id,
            'shortname' => 'themecolor'
        ));

        if ($customcolor) {
            $customcolor = clean_param($customcolor, PARAM_ALPHANUM);
            $customcolor = substr($customcolor, 0, 6);
        }

        $SESSION->theme_kent_custom_color = $customcolor;
    }

    $customcolor = $SESSION->theme_kent_custom_color;
    if ($customcolor) {
        $bodyclasses[] = 'kent-custom';
    }
}

if ($showsidepre && !$showsidepost) {
    if (!right_to_left()) {
        $bodyclasses[] = 'side-pre-only';
    }else{
        $bodyclasses[] = 'side-post-only';
    }
} else if ($showsidepost && !$showsidepre) {
    if (!right_to_left()) {
        $bodyclasses[] = 'side-post-only';
    }else{
        $bodyclasses[] = 'side-pre-only';
    }
} else if (!$showsidepost && !$showsidepre) {
    $bodyclasses[] = 'content-only';
}
if ($hascustommenu) {
    $bodyclasses[] = 'has_custom_menu';
}

if (isset($CFG->theme_kent_enable_navbar) && $CFG->theme_kent_enable_navbar) {
    $bodyclasses[] = 'kent-navbar';
}

echo $OUTPUT->doctype() ?>
<html <?php echo $OUTPUT->htmlattributes() ?>>
<head>
    <title><?php echo $OUTPUT->page_title(); ?></title>
    <link rel="shortcut icon" href="<?php echo $OUTPUT->favicon(); ?>" />
    <?php
    echo $OUTPUT->standard_head_html();

    if ($customcolor) {
        echo "<style>#menuwrap { background-color: #{$customcolor} !important; }</style>";
    }
    ?>
</head>
<body id="<?php p($PAGE->bodyid) ?>" class="<?php p($PAGE->bodyclasses.' '.join(' ', $bodyclasses)) ?>">
<?php echo $OUTPUT->standard_top_of_body_html(); ?>

<div id="page">
        <div id="page-header">
            <div class="headermenu">
                <?php 
                if (!empty($PAGE->layout_options['langmenu'])) {
                    echo $OUTPUT->lang_menu();
                }
                echo $OUTPUT->page_heading_menu() ?>
            </div>
            <div id="headerwrap">
                <div id="logowrap">
                    <img src="<?php echo $OUTPUT->pix_url($CFG->logo_colour, 'theme')?>" id="logo"> 
                </div>
                <?php include('profileblock.php') ?>
            </div>
        </div>
        
        <div id="menuwrap">
            <div id="homeicon">
                <a href="<?php echo $CFG->wwwroot; ?>"><i class="fa fa-home"></i></a>
            </div>
            <?php 
            if ($hascustommenu) { ?>
                <div id="menuitemswrap"><div id="custommenu"><?php echo $custommenu; ?></div></div>
            <?php } ?>
        </div>
        <div id="jcontrols_button" class="clearfix">
            <div class="jcontrolsleft">     
            <?php if ($hasnavbar) { ?>
                <div class="navbar clearfix">
                    <div class="breadcrumb"> <?php echo $OUTPUT->navbar();  ?></div>
                </div>
            <?php } ?>
            </div>
            <div id="ebutton">
               <?php if ($hasnavbar) { echo $OUTPUT->page_heading_button(); } ?>
           </div>

        </div>  
        <?php if ($CFG->kent->distribution == "archive") { ?>
        <div class="archive_bar">
            <p>
                Please note that this version of Moodle is the Kent Archive Moodle.  For your current course information, please visit <a href="https://moodle.kent.ac.uk/moodle">https://moodle.kent.ac.uk/moodle</a>.
            </p>
        </div>
        <?php } ?>
<div id="contentwrapper">   
    <!-- start OF moodle CONTENT -->
    <div id="page-content">
        <div id="region-main-box">
            <div id="region-post-box">
                <div id="region-main-wrap">
                    <div id="region-main">
                        <div id="mainpadder" class="region-content">
                            <?php echo $coursecontentheader; ?>
                            <?php echo $OUTPUT->main_content() ?>
                            <?php echo $coursecontentfooter; ?>
                        </div>
                    </div>
                </div>

                <?php if ($hassidepre) { ?>
                <div id="region-pre" class="block-region">
                    <div class="region-content">
                           <?php echo $OUTPUT->blocks('side-pre'); ?>
                    </div>
                </div>
                <?php } ?>

                <?php if ($hassidepost) { ?>
                <div id="region-post" class="block-region">
                    <div class="region-content">
                           <?php echo $OUTPUT->blocks('side-post'); ?>
                    </div>
                </div>
                <?php } ?>
            </div>
        </div>
     </div>
    <!-- END OF CONTENT --> 
</div>      

<?php if (!empty($coursefooter)) { ?>
    <div id="course-footer"><?php echo $coursefooter; ?></div>
<?php } ?>
 <?php if ($hasfooter) { ?>
<div id="page-footer" class="clearfix">
    <div id="footerwrapper">
        <div id="footerinner">
            <div id="right_footer">
                <?php
                    echo $OUTPUT->login_info();
                    echo $OUTPUT->theme_switch_links();
                ?>
            </div>
            <div id="left_footer">
                <a href="mailto:helpdesk@kent.ac.uk?subject=Moodle help">Contact Helpdesk</a>
            </div>
            <?php echo $PAGE->theme->settings->footnote; ?>
            <div class="clearfix"></div>
            <div class="moodle-extra">
                <?php
                    if(has_capability('moodle/site:config', context_system::instance())) {
                        echo $OUTPUT->standard_footer_html();
                    }
                ?>
            </div>
        </div>
</div>

 <?php } ?>
        <div class="clearfix"></div>
    </div>
</div>

<?php echo $OUTPUT->standard_end_of_body_html() ?>
</body>
</html>
