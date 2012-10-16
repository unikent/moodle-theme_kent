<?php echo $OUTPUT->doctype() ?>
<html <?php echo $OUTPUT->htmlattributes() ?>>
<head>
    <title><?php echo $PAGE->title ?></title>
    <?php
    //Nasty fix to force SCORM into IE7 mode due to a flash bug.  Blame Moodle
    if (substr_count($_SERVER['SCRIPT_FILENAME'], 'scorm/player.php') && isset($_GET['scoid'])){
        echo '<meta http-equiv="X-UA-Compatible" content="IE=7" />';
    } ?>
    <link rel="shortcut icon" href="<?php echo $OUTPUT->pix_url('favicon', 'theme')?>" />
    <?php echo $OUTPUT->standard_head_html() ?>
</head>
<body id="<?php echo $PAGE->bodyid ?>" class="<?php echo $PAGE->bodyclasses ?>">
<?php echo $OUTPUT->standard_top_of_body_html() ?>

<div id="page">
<!-- END OF HEADER -->
    <div id="content" class="clearfix">
        <?php echo core_renderer::MAIN_CONTENT_TOKEN ?>
    </div>

<!-- START OF FOOTER -->
</div>
<?php echo $OUTPUT->standard_end_of_body_html() ?>
<?php echo kent_set_analytics() ?>
</body>
</html>
