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

require_once(dirname(__FILE__) . "/../../../config.php");
?>
<!DOCTYPE html>
<html dir="ltr" lang="en" xml:lang="en">
<head>
    <title>Oops!</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link rel="stylesheet" type="text/css" href="<?php echo $CFG->wwwroot; ?>/theme/kent/style/theme.css" />
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css" />
</head>
<body>
    <div class="container text-center" style="margin-top: 10px;">
        <div role="main">
            <i class="fa fa-warning" style="font-size: 75px;"></i>
            <h1>Sorry, we'll be back soon!</h1>
            <p>We have had to take Moodle offline to perform maintenance.<br />Please check our <a href="http://status.kent.ac.uk" target="_blank">status page</a> for updates.</p>
        </div>
    </div>

    <script src="//static.kent.ac.uk/navbar/kent-header-light.min.js" type="text/javascript" async="async"></script>
</body>
</html>
