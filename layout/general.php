<?php
$hasheading = ($PAGE->heading);
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

$bodyclasses = array();
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

echo $OUTPUT->doctype() ?>
<html <?php echo $OUTPUT->htmlattributes() ?>>
<head>
    <title><?php echo $PAGE->title ?></title>
    <link rel="shortcut icon" href="<?php echo $OUTPUT->pix_url('favicon', 'theme')?>" />
    <?php echo $OUTPUT->standard_head_html() ?>
</head>
<body id="<?php p($PAGE->bodyid) ?>" class="<?php p($PAGE->bodyclasses.' '.join(' ', $bodyclasses)) ?>">
<?php echo $OUTPUT->standard_top_of_body_html() ?>

<div id="page">
        <div id="page-header">
            <div class="headermenu">
                <?php 
                if (!empty($PAGE->layout_options['langmenu'])) {
                    echo $OUTPUT->lang_menu();
                }
                echo $PAGE->headingmenu ?>
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
                <a href="<?php echo $CFG->wwwroot; ?>"><img src="<?php echo $OUTPUT->pix_url('menu/home_icon', 'theme')?>"></a>
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
               <?php if ($hasnavbar) { echo $PAGE->button; } ?>
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

                <?php if ($hassidepre OR (right_to_left() AND $hassidepost)) { ?>
                <div id="region-pre" class="block-region">
                    <div class="region-content">
                            <?php
                        if (!right_to_left()) {
                            echo $OUTPUT->blocks_for_region('side-pre');
                        } elseif ($hassidepost) {
                            echo $OUTPUT->blocks_for_region('side-post');
                    } ?>

                    </div>
                </div>
                <?php } ?>

                <?php if ($hassidepost OR (right_to_left() AND $hassidepre)) { ?>
                <div id="region-post" class="block-region">
                    <div class="region-content">
                           <?php
                       if (!right_to_left()) {
                           echo $OUTPUT->blocks_for_region('side-post');
                       } elseif ($hassidepre) {
                           echo $OUTPUT->blocks_for_region('side-pre');
                    } ?>
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
                    $linkurl = new moodle_url('/theme/switchdevice.php', array('url' => $this->page->url, 'device' => 'mobile', 'sesskey' => sesskey()));
                    $content  = html_writer::start_tag('div', array('id' => 'kent_theme_switch_link'));
                    $content .= html_writer::link($linkurl, 'Switch to Mobile theme');
                    $content .= html_writer::end_tag('div');
                    echo $content;
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
