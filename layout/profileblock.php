<script text/javascript>
function toggle5(showHideDiv, switchImgTag) {
        var ele = document.getElementById(showHideDiv);
        var imageEle = document.getElementById(switchImgTag);
        if(ele.style.display == "block") {
                ele.style.display = "none";
		imageEle.innerHTML = '<img src="<?php echo $OUTPUT->pix_url('profile/down', 'theme')?>">';
        }
        else {
                ele.style.display = "block";
                imageEle.innerHTML = '<img src="<?php echo $OUTPUT->pix_url('profile/up', 'theme')?>">';
        }
}
</script>
<div class="profilepic" id="profilepic">
	<?php
		if (!isloggedin() or isguestuser()) {
			echo '<a href="'.$CFG->wwwroot.'/user/view.php?id='.$USER->id.'&amp;course='.$COURSE->id.'"><img src="'.$CFG->wwwroot.'/user/pix.php?file=/'.$USER->id.'/f1.jpg" width="80px" height="80px" title="Guest" alt="Guest" /></a>';
		}else{
			echo '<a href="'.$CFG->wwwroot.'/user/view.php?id='.$USER->id.'&amp;course='.$COURSE->id.'"><img src="'.$CFG->wwwroot.'/user/pix.php?file=/'.$USER->id.'/f1.jpg" width="80px" height="80px" title="'.$USER->firstname.' '.$USER->lastname.'" alt="'.$USER->firstname.' '.$USER->lastname.'" /></a>';
		}
	?>
</div>

<?php

	function get_content () {
	global $USER, $CFG, $SESSION, $COURSE;
	$wwwroot = '';
	$signup = '';}

	if (empty($CFG->loginhttps)) {
		$wwwroot = $CFG->wwwroot;
	} else {
		$wwwroot = str_replace("http://", "https://", $CFG->wwwroot);
	}

if (!isloggedin() or isguestuser()) {
	echo '<div class="profilelogin" id="profilelogin">';
	echo '<form id="login" method="post" action="'.$wwwroot.'/login/index.php?authldap_skipntlmsso=1">';
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

<a id="imageDivLink" href="javascript:toggle5('profilebar', 'imageDivLink');"><img src="<?php echo $OUTPUT->pix_url('profile/down', 'theme')?>" /></a>

<?php
echo '</div>'; // end of graphicwrap
echo '</div>'; // end of headerwrap
?>
<div id="profilebar-outerwrap">
	<div class="profilebar" id="profilebar" style="display: none;">
		<div id="profilebar-innerwrap">


				<div id="profilebar-block1" class="block-region">
				    <h4><?php echo get_string('myblocks','theme_aardvark_postit');?></h4>
					<?php {
						if ($haspbarpre)
							echo $OUTPUT->blocks_for_region('pbar-pre');
						  }
					 ?>
				</div>


				<div id="profilebar-block2" class="block-region">
				    <h4><?php echo get_string('myblocks','theme_aardvark_postit');?></h4>
					<?php {
						if ($haspbarpost)
							echo $OUTPUT->blocks_for_region('pbar-post');
						  }
					 ?>
				</div>

			<div id="profilebar-account" class="profileoptions">
				<h4><?php echo get_string('myaccount','theme_aardvark_postit');?></h4>
				<ul>
					<li><a href="<?php echo $CFG->wwwroot; ?>/my"><img src="<?php echo $OUTPUT->pix_url('profile/courses', 'theme')?>" />&nbsp;<?php echo get_string('mycourses');?></a></li>
					<li><a href="<?php echo $CFG->wwwroot; ?>/user/profile.php"><img src="<?php echo $OUTPUT->pix_url('profile/profile', 'theme')?>" />&nbsp;<?php echo get_string('myprofile');?></a></li>
				</ul>
			</div>

			<div id="profilebar-mystuff" class="profileoptions">
			<h4><?php echo get_string('mystuff','theme_aardvark_postit');?></h4>
			    <ul>
					<li><a href="<?php echo $CFG->wwwroot; ?>/calendar/view.php?view=month"><img src="<?php echo $OUTPUT->pix_url('profile/calendar', 'theme')?>" />&nbsp;<?php echo get_string('calendar','calendar');?></a></li>

					<li><a href="<?php {
						if ($hasemailurl)
						  echo $PAGE->theme->settings->emailurl;
						} ?>">
						<img src="<?php echo $OUTPUT->pix_url('profile/email', 'theme')?>" />&nbsp;<?php echo get_string('email','theme_aardvark_postit');?></a>
					</li>

					<li><a href="<?php echo $CFG->wwwroot; ?>/login/logout.php"><img src="<?php echo $OUTPUT->pix_url('profile/logout', 'theme')?>" />&nbsp;<?php echo get_string('logout');?></a></li>
				</ul>
			</div>
			</div>
		</div>
	 </div>
  <div class="profilebarclear">
</div>

<?php }?>
