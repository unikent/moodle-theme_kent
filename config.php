<?php$THEME->name = 'kent';////////////////////////////////////////////////////// Name of the theme. Most likely the name of// the directory in which this file resides.////////////////////////////////////////////////////$THEME->parents = array('base','canvas');/////////////////////////////////////////////////////// Which existing theme(s) in the /theme/ directory// do you want this theme to extend. A theme can// extend any number of themes. Rather than// creating an entirely new theme and copying all// of the CSS, you can simply create a new theme,// extend the theme you like and just add the// changes you want to your theme.////////////////////////////////////////////////////switch($CFG->theme_colour) {    case "cyan":        $THEME->sheets = array('core', 'cyan');        break;    case "green":        $THEME->sheets = array('core', 'green');        break;    case "red":        $THEME->sheets = array('core', 'red');        break;    case "blue":    default:        $THEME->sheets = array('core', 'print');}////////////////////////////////////////////////////// Name of the stylesheet(s) you've including in// this theme's /styles/ directory.////////////////////////////////////////////////////$THEME->enable_dock = true;////////////////////////////////////////////////////// Do you want to use the new navigation dock?////////////////////////////////////////////////////$THEME->editor_sheets = array('editor');////////////////////////////////////////////////////// An array of stylesheets to include within the// body of the editor.////////////////////////////////////////////////////$THEME->layouts = array(    'base' => array(        'file' => 'general.php',        'regions' => array('side-pre', 'side-post'),        'defaultregion' => 'side-post',    ),    'general' => array(        'file' => 'general.php',        'regions' => array('side-pre', 'side-post'),        'defaultregion' => 'side-post',    ),    'course' => array(        'file' => 'course.php',        'regions' => array('side-pre','main-pre', 'side-post'),        'defaultregion' => 'side-post'    ),    'coursecategory' => array(        'file' => 'general.php',        'regions' => array('side-pre', 'side-post'),        'defaultregion' => 'side-post',    ),    'incourse' => array(        'file' => 'general.php',        'regions' => array('side-pre', 'side-post'),        'defaultregion' => 'side-post',    ),    'frontpage' => array(        'file' => 'general.php',        'regions' => array('side-pre', 'side-post'),        'defaultregion' => 'side-post',    ),    'admin' => array(        'file' => 'general.php',        'regions' => array('side-pre'),        'defaultregion' => 'side-pre',    ),    'mydashboard' => array(        'file' => 'general.php',        'regions' => array('side-pre', 'side-post'),        'defaultregion' => 'side-post',        'options' => array('langmenu'=>true),    ),    'mypublic' => array(        'file' => 'general.php',        'regions' => array('side-pre', 'side-post'),        'defaultregion' => 'side-post',    ),    'login' => array(        'file' => 'general.php',        'regions' => array(),        'options' => array('langmenu'=>true),    ),    'popup' => array(        'file' => 'embedded.php',        'regions' => array(),        'options' => array('nofooter'=>true, 'noblocks'=>true, 'nonavbar'=>true),    ),    'frametop' => array(        'file' => 'general.php',        'regions' => array(),        'options' => array('nofooter'=>true),    ),    'maintenance' => array(        'file' => 'general.php',        'regions' => array(),        'options' => array('nofooter'=>true, 'nonavbar'=>true),    ),    'embedded' => array(    	'theme'=>'canvas',        'file' => 'embedded.php',        'regions' => array(),        'options' => array('nofooter'=>true, 'nonavbar'=>true),    ),    // Should display the content and basic headers only.    'print' => array(        'file' => 'general.php',        'regions' => array(),        'options' => array('noheader'=>true, 'nofooter'=>true, 'nonavbar'=>true, 'noblocks'=>true),    ),    'report' => array(        'file' => 'general.php',        'regions' => array('side-pre'),        'defaultregion' => 'side-pre',    ),);$THEME->csspostprocess = 'kent_process_css';