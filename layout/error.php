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

<!DOCTYPE html>
<html dir="ltr" lang="en" xml:lang="en">
<head>
    <title>Oops!</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link rel="stylesheet" type="text/css" href="<?php echo $CFG->wwwroot; ?>/theme/kent/style/theme.css" />
</head>
<body>
    <div class="container text-center" style="margin-top: 10px;">
        <p>Oops!</p>
        <p>Something went wrong, we are most likely aware of the problem and working to resolve it now.<br />
        Please check <a href="http://status.kent.ac.uk">status.kent.ac.uk</a> for updates.</p>
        <p>The reason given was:
        <?php
        if (!empty($errormessage)) {
            echo $errormessage;
        } else {
            echo "unknown error.";
        }
        ?>
        </p>
    </div>

    <script src="//static.kent.ac.uk/navbar/kent-header-light.min.js" type="text/javascript" async="async"></script>
</body>
</html>