<?php

function kent_process_css($css, $theme) {

    // Set the menu hover color
    if (!empty($theme->settings->menuhovercolor)) {
        $menuhovercolor = $theme->settings->menuhovercolor;
    } else {
        $menuhovercolor = null;
    }
    $css = kent_set_menuhovercolor($css, $menuhovercolor);
    
    // Set the background image for the graphic wrap 
    if (!empty($theme->settings->graphicwrap)) {
        $graphicwrap = $theme->settings->graphicwrap;
    } else {
        $graphicwrap = null;
    }
    $css = kent_set_graphicwrap($css, $graphicwrap);
    
    return $css;
}

function kent_set_menuhovercolor($css, $menuhovercolor) {
    $tag = '[[setting:menuhovercolor]]';
    $replacement = $menuhovercolor;
    if (is_null($replacement)) {
        $replacement = '#5faff2';
    }
    $css = str_replace($tag, $replacement, $css);
    return $css;
}

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
 */
function kent_user_type() {
  global $USER, $SESSION;

  // Cant do much if we arent logged in
  if (!isloggedin() || isguestuser()) {
    return "guest";
  }

  return isset($USER->account_type) ? $USER->account_type : NULL;
}

/*
 * Function to return google analytics with code, only if the code is set via the config
 */
function kent_set_analytics() {
    global $CFG, $PAGE;

    // Disable analytics if not on live
    if (empty($CFG->google_analytics_code)) {
        return "";
    }

    // Disable analytics on admin pages.
    $page_url = substr($PAGE->url, strlen($CFG->wwwroot));
    $page_part = substr($page_url, 0, 7);
    if ($page_part == "/local/" || $page_part == "/admin/" || $page_part == "/report") {
        return "";
    }

    // Should we be doing universal analytics?
    if (isset($CFG->google_analytics_type) && $CFG->google_analytics_type === 'universal') {
        return kent_set_universal_analytics();
    }

    // Nope, do standard
    return kent_set_standard_analytics();
}

/*
 * Function to return google analytics with code, only if the code is set via the config
 */
function kent_set_standard_analytics() {
    global $CFG;

    $ga_code = "";

$ga_code = <<<GACODE
<!-- Start of Google Analytics -->
<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', '{$CFG->google_analytics_code}']);
  _gaq.push(['_setCustomVar', 1, 'os', '{$CFG->kent->platform}']);
  _gaq.push(['_setCustomVar', 1, 'distribution', '{$CFG->kent->distribution}']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://' : 'http://') + 'stats.g.doubleclick.net/dc.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>
<!-- End of Google Analytics -->
GACODE;

    return $ga_code;
}


/*
 * Function to return Google universal analytics with code, only if the code is set via the config
 */
function kent_set_universal_analytics() {
    global $CFG;

    // Build dimensions
    $dimensions = array(
      "'dimension1': '{$CFG->kent->platform}'",
      "'dimension2': '{$CFG->kent->distribution}'"
    );

    // Add current user details to dimensions
    $usertype = kent_user_type();
    if ($usertype !== NULL) {
      $dimensions[] = "'dimension3': '{$usertype}'";
    }

    // Add hostname
    $dimensions[] = "'dimension4': '{$CFG->kent->hostname}'";

    // Join it up
    $dimensions = join(",", $dimensions);

    // Grab the GA Code
$ga_code = <<<GACODE
<!-- Start of Google Analytics -->
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', '{$CFG->google_analytics_code}', 'kent.ac.uk');
  ga('require', 'displayfeatures');
  ga('send', 'pageview', {
    {$dimensions}
  });

</script>
<!-- End of Google Analytics -->
GACODE;

    return $ga_code;

}
