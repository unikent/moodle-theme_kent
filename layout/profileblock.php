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

<div class="profilepic" id="profilepic">
<?php
if (!isloggedin() or isguestuser()) {
    echo '<a href="'.$CFG->wwwroot.'/user/view.php?id='.$USER->id.'&amp;course='.$COURSE->id.'"><img src="'.$CFG->wwwroot.'/user/pix.php?file=/'.$USER->id.'/f1.jpg" width="80px" height="80px" title="Guest" alt="Guest" /></a>';
} else {
    echo $OUTPUT->user_picture($USER, array('size' => 80));
}
?>
</div>

<?php
if (!isloggedin() or isguestuser()) {
    echo '<div class="profilelogin" id="profilelogin">';
    echo '<form id="login" method="post" action="'.$CFG->wwwroot.'/login/index.php">';
    echo '<ul>';
    echo '<li><input type="submit" value="&nbsp;&nbsp;'.get_string('login').'&nbsp;&nbsp;" /></li>';
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

            <div class="profilebar_events">
                <?php
                echo \html_writer::tag('h4', get_string('upcomingevents', 'calendar'));
                echo theme_kent_get_upcoming_events();
                ?>
            </div>

            <div class="profilebar_account">
                <h4><?php echo get_string('mymoodle', 'my');?></h4>
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
