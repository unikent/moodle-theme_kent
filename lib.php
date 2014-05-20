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

/**
 *
 *
 * @param unknown $css
 * @param unknown $theme
 * @return unknown
 */
function kent_process_css($css, $theme) {

    // Set the menu hover color.
    if (!empty($theme->settings->menuhovercolor)) {
        $menuhovercolor = $theme->settings->menuhovercolor;
    } else {
        $menuhovercolor = null;
    }
    $css = kent_set_menuhovercolor($css, $menuhovercolor);

    // Set the background image for the graphic wrap.
    if (!empty($theme->settings->graphicwrap)) {
        $graphicwrap = $theme->settings->graphicwrap;
    } else {
        $graphicwrap = null;
    }
    $css = kent_set_graphicwrap($css, $graphicwrap);

    return $css;
}


/**
 *
 *
 * @param unknown $css
 * @param unknown $menuhovercolor
 * @return unknown
 */
function kent_set_menuhovercolor($css, $menuhovercolor) {
    $tag = '[[setting:menuhovercolor]]';
    $replacement = $menuhovercolor;
    if (is_null($replacement)) {
        $replacement = '#5faff2';
    }
    $css = str_replace($tag, $replacement, $css);
    return $css;
}


/**
 *
 *
 * @param unknown $css
 * @param unknown $graphicwrap
 * @return unknown
 */
function kent_set_graphicwrap($css, $graphicwrap) {
    global $OUTPUT;
    $tag = '[[setting:graphicwrap]]';
    $replacement = $graphicwrap;
    if (is_null($replacement)) {
        $replacement = $OUTPUT->pix_url('graphics/fish', 'theme');
    }
    $css = str_replace($tag, $replacement, $css);
    return $css;
}


/**
 * Returns user information
 *
 * @return unknown
 */
function kent_user_type() {
    global $SESSION;

    // Cant do much if we arent logged in.
    if (!isloggedin() || isguestuser()) {
        return "guest";
    }

    return isset($SESSION->account_type) ? s($SESSION->account_type) : null;
}


/**
 * Function to return google analytics with code, only if the code is set via the config
 */
function kent_set_analytics() {
    global $CFG, $PAGE;

    // Disable analytics if not on live.
    if (empty($CFG->google_analytics_code)) {
        return "";
    }

    // Disable analytics on admin pages.
    $url = substr($PAGE->url, strlen($CFG->wwwroot));
    $path = substr($url, 0, 7);
    if ($path == "/local/" || $path == "/admin/" || $path == "/report") {
        return "";
    }

    return kent_set_universal_analytics();
}


/**
 * Function to return Google universal analytics with code, only if the code is set via the config
 */
function kent_set_universal_analytics() {
    global $CFG, $USER;

    $extras = "";

    // Add current user details to extras.
    $usertype = kent_user_type();
    if ($usertype !== null) {
        $extras .= "ga('set', 'dimension3', '{$usertype}');";
    }

    // Performance stats.
    if (!empty($CFG->kent->starttime)) {
        $pageload = (microtime(true) - $CFG->kent->starttime) * 1000;
        // Filter out odd requests (we could also alert devs here).
        // For now, anything above 3sec reponse is odd.
        if ($pageload <= 3000) {
            $extras .= "ga('set', 'dimension5', '{$pageload}');";
        }
    }

    // Setup user tracking if logged in.
    if (isloggedin()) {
        $extras .= "ga('set', '&uid', {$USER->id});";
    }

    // Grab the GA Code.
    return <<<GACODE
<!-- Start of Google Analytics -->
<script>
    (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
    (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
    m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
    })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

    ga('create', '{$CFG->google_analytics_code}', 'kent.ac.uk');
    ga('require', 'displayfeatures');
    ga('set', 'dimension1', '{$CFG->kent->platform}');
    ga('set', 'dimension2', '{$CFG->kent->distribution}');
    ga('set', 'dimension4', '{$CFG->kent->hostname}');
    {$extras}

</script>
<!-- End of Google Analytics -->
GACODE;
}
