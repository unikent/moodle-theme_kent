<?php


defined('MOODLE_INTERNAL') || die;

if ($ADMIN->fulltree) {

    // NavBar Setting.
    $settings->add(new admin_setting_configcheckbox(
        'theme_kent_enable_navbar',
        'Enable Navbar',
        'Enable Kent Navbar',
        0
    ));

// Graphic Wrap (Background Image)
$name = 'theme_kent/graphicwrap';
$title=get_string('graphicwrap','theme_kent');
$description = get_string('graphicwrapdesc', 'theme_kent');
$setting = new admin_setting_configtext($name, $title, $description, '', PARAM_URL);
$settings->add($setting);

// Logo file setting
$name = 'theme_kent/logo';
$title = get_string('logo','theme_kent');
$description = get_string('logodesc', 'theme_kent');
$setting = new admin_setting_configtext($name, $title, $description, '', PARAM_URL);
$settings->add($setting);

// Menu select background colour setting
$name = 'theme_kent/menuhovercolor';
$title = get_string('menuhovercolor','theme_kent');
$description = get_string('menuhovercolordesc', 'theme_kent');
$default = '#fd7f11';
$previewconfig = NULL;
$setting = new admin_setting_configcolourpicker($name, $title, $description, $default, $previewconfig);
$settings->add($setting);

// Email url setting

$name = 'theme_kent/emailurl';
$title = get_string('emailurl','theme_kent');
$description = get_string('emailurldesc', 'theme_kent');
$default = '';
$setting = new admin_setting_configtext($name, $title, $description, $default);
$settings->add($setting);


// Foot note setting
$name = 'theme_kent/footnote';
$title = get_string('footnote','theme_kent');
$description = get_string('footnotedesc', 'theme_kent');
$default = '';
$setting = new admin_setting_confightmleditor($name, $title, $description, $default);
$settings->add($setting);

}