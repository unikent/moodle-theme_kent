<div class="profilepic" id="profilepic">
	<?php
		if (!isloggedin() or isguestuser()) {
		  echo '<a href="'.$CFG->wwwroot.'/user/view.php?id='.$USER->id.'&amp;course='.$COURSE->id.'"><img src="'.$CFG->wwwroot.'/user/pix.php?file=/'.$USER->id.'/f1.jpg" width="80px" height="80px" title="Guest" alt="Guest" /></a>';
		}else{
      		echo $OUTPUT->user_picture($USER, array('size'=>80));
		}	?>
</div>

<?php
if (empty($CFG->loginhttps)) {
	$wwwroot = $CFG->wwwroot;
} else {
	$wwwroot = str_replace("http://", "https://", $CFG->wwwroot);
}

if (!isloggedin() or isguestuser()) {
echo '<div class="profilelogin" id="profilelogin">';
	echo '<form id="login" method="post" action="'.$wwwroot.'/login/index.php">';
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

<a id="imageDivLink" href="javascript:theme_kent_toggle_block('profilebar', 'imageDivLink');">
</a>

<?php
echo '</div>'; // end of graphicwrap
echo '</div>'; // end of headerwrap
?>
<div id="profilebar-outerwrap">
	<div class="profilebar" id="profilebar" style="display: none;">
		<div id="profilebar-innerwrap">
			<div class="profilebar_block">
		        
			</div>

			<div class="profilebar_events">
				<h4><?php echo get_string('upcomingevents','calendar');?></h4>
		        
		        <?php include ('upcoming.php');?>
		        
			</div>

			<div class="profilebar_account">
				<h4><?php echo get_string('mymoodle', 'my');?></h4>
				<div class="profileoptions" id="profileoptions">
					<table width="100%" border="0">
					<tr>
					<td> <ul>
					<li><a href="<?php echo $CFG->wwwroot; ?>/my"><img src="<?php echo $OUTPUT->pix_url('profile/courses', 'theme')?>" />&nbsp;<?php echo get_string('mycourses');?></a></li>
		            			<li><a href="<?php echo $CFG->wwwroot; ?>/user/profile.php"><img src="<?php echo $OUTPUT->pix_url('profile/profile', 'theme')?>" />&nbsp;<?php echo get_string('myprofile');?></a></li>

		            			<li><a href="<?php echo $CFG->wwwroot; ?>/user/files.php"><img src="<?php echo $OUTPUT->pix_url('profile/myfiles', 'theme')?>" />&nbsp;<?php echo get_string('myfiles');?></a></li>

					</ul></td>
					<td><ul>
		           	<li><a href="<?php echo $CFG->wwwroot; ?>/calendar/view.php?view=month"><img src="<?php echo $OUTPUT->pix_url('profile/calendar', 'theme')?>" />&nbsp;<?php echo get_string('calendar','calendar');?></a></li>

					<li><a href="<?php echo $CFG->wwwroot; ?>/message/index.php "><img src="<?php echo $OUTPUT->pix_url('profile/email', 'theme')?>" />&nbsp;Messages</a></li>
					
					<li>
						<form class="loginForm" method="post" action="<?php echo $CFG->wwwroot; ?>/login/logout.php">
							<div>
								<input type="hidden" name="sesskey" value="<?php echo sesskey(); ?>">
								<img src="<?php echo $OUTPUT->pix_url('profile/logout', 'theme')?>" />
								<input type="submit" value="<?php echo get_string('logout');?>" class="login">
							</div>
						</form>
					</li>
					

					</ul></td>
					</tr>
					</table>
				</div>
			</div>
		    <div class="profilebarclear"></div>
	    </div>
	</div>
</div>

<?php }?>
