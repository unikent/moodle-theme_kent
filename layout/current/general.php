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

?>

<div id="page">
        <div id="page-header">
            <div class="headermenu">
<?php 
if (!empty($PAGE->layout_options['langmenu'])) {
    echo $OUTPUT->lang_menu();
}

echo $OUTPUT->page_heading_menu();
?>
            </div>
            <div id="headerwrap">
                <div id="logowrap">
<?php
$logo = $OUTPUT->pix_url($CFG->logo_colour, 'theme');
echo "<img src=\"$logo\" id=\"logo\">";
?>
                </div>
<?php
echo '<div class="profilepic" id="profilepic">';
if (!isloggedin() or isguestuser()) {
    echo '<a href="'.$CFG->wwwroot.'/user/view.php?id='.$USER->id.'&amp;course='.$COURSE->id.'"><img src="'.$CFG->wwwroot.'/user/pix.php?file=/'.$USER->id.'/f1.jpg" width="80px" height="80px" title="Guest" alt="Guest" /></a>';
} else {
    echo $OUTPUT->user_picture($USER, array('size' => 80));
}
echo '</div>';
?>

<?php
if (!isloggedin() or isguestuser()) {
    echo '<div class="profilelogin" id="profilelogin">';
    echo '<form id="login" method="post" action="'.$CFG->wwwroot.'/login/index.php">';
    echo '<ul>';
    echo '<li><input type="submit" value="Log in" id="login_button" /></li>';
    echo '</ul>';
    echo '</form>';
    echo '</div>';
    echo '</div>';
} else {
    echo '<div class="profilename" id="profilename">';
    echo '<a href="'.$CFG->wwwroot.'/user/view.php?id='.$USER->id.'&amp;course='.$COURSE->id.'">'.$USER->firstname.' '.$USER->lastname.'</a>';
?>

            <a id="imageDivLink" href="javascript:theme_kent_toggle_block('profilebar', 'imageDivLink', 'profilechevron');">
                <i class="fa fa-chevron-down" id="profilechevron"></i>
            </a>

            </div>
            </div>

            <div id="profilebar-outerwrap">
                <div class="profilebar" id="profilebar" style="display: none;">
                    <div id="profilebar-innerwrap">
                        <div class="profilebar_block">
                            
                        </div>

<?php
    $events = theme_kent_get_upcoming_events();
    echo <<<HTML
    <div class="profilebar_events">
        <h4>Upcoming Events</h4>
        {$events}
    </div>
HTML;
?>

                        <div class="profilebar_account">
                            <h4>Links</h4>
                            <div class="profileoptions" id="profileoptions">
                                <table width="100%" border="0">
                                <tr>
                                <td>
                                    <ul>
                                        <li>
                                            <a href="<?php echo $CFG->wwwroot; ?>/my" class="profile profile-courses">
                                                <i class="fa fa-graduation-cap"></i>
                                                My courses
                                            </a>
                                        </li>
                                        <li>
                                            <a href="<?php echo $CFG->wwwroot; ?>/user/profile.php" class="profile profile-profile">
                                                <i class="fa fa-user"></i>
                                                My profile
                                            </a>
                                        </li>
                                        <li>
                                            <a href="<?php echo $CFG->wwwroot; ?>/user/files.php" class="profile profile-myfiles">
                                                <i class="fa fa-folder"></i>
                                                My private files
                                            </a>
                                        </li>
                                    </ul>
                                </td>
                                <td>
                                    <ul>
                                        <li>
                                            <a href="<?php echo $CFG->wwwroot; ?>/calendar/view.php?view=month" class="profile profile-calendar">
                                                <i class="fa fa-calendar"></i>
                                                Calendar
                                            </a>
                                        </li>
                                        <li>
                                            <a href="<?php echo $CFG->wwwroot; ?>/message/index.php" class="profile profile-email">
                                                <i class="fa fa-envelope"></i>
                                                Messages
                                            </a>
                                        </li>
                                        <li>
                                            <form class="loginForm profile profile-logout" method="post" action="<?php echo $CFG->wwwroot; ?>/login/logout.php">
                                                <div>
                                                    <i class="fa fa-sign-out"></i>
                                                    <input type="hidden" name="sesskey" value="<?php echo sesskey(); ?>">
                                                    <input type="submit" value="Log out" class="login">
                                                </div>
                                            </form>
                                        </li>
                                    </ul>
                                </td>
                                </tr>
                                </table>
                            </div>
                        </div>
                        <div class="profilebarclear"></div>
                    </div>
                </div>
            </div>
<?php
}
?>
            </div>
        </div>
        
        <div id="menuwrap">
            <div id="homeicon">
                <a href="<?php echo $CFG->wwwroot; ?>"><i class="fa fa-home"></i></a>
            </div>
<?php 
if ($hascustommenu) {
    echo "<div id=\"menuitemswrap\"><div id=\"custommenu\">{$custommenu}</div></div>";
}
?>
        </div>
        <div id="jcontrols_button" class="clearfix">
            <div class="jcontrolsleft">     
            <?php if ($hasnavbar) { ?>
                <div class="navbar clearfix">
                    <div class="breadcrumb"> <?php echo $OUTPUT->navbar();  ?></div>
                </div>
            <?php } ?>
            </div>
<?php
if ($hasnavbar) {
    echo '<div id="ebutton">' . $OUTPUT->page_heading_button() . '</div>';
}
?>

        </div>  
        <?php if ($CFG->kent->distribution == "archive") { ?>
        <div class="archive_bar">
            <p>
                Please note that this version of Moodle is the Kent Archive Moodle. For your current course information, please visit <a href="https://moodle.kent.ac.uk/moodle">https://moodle.kent.ac.uk/moodle</a>.
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
                            <?php
                            echo $coursecontentheader;
                            echo $OUTPUT->main_content();
                            echo $coursecontentfooter;
                            ?>
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

<?php
if (!empty($coursefooter)) {
    echo "<div id=\"course-footer\">{$coursefooter}</div>";
}
?>

<?php
if ($hasfooter) {
?>
<div id="page-footer" class="clearfix">
    <div id="footerwrapper" class="container">
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

<?php
}
?>
    <div class="clearfix"></div>
</div>


</div>
