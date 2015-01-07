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
    <link rel="stylesheet" type="text/css" href="../style/fonts.css" />
    <link rel="stylesheet" type="text/css" href="../style/theme.css" />
</head>
<body class="format-site course path-site safari dir-ltr lang-en yui-skin-sam yui3-skin-sam pagelayout-frontpage course-1 context-2 notloggedin kent-future kent-future-theme kent-navbar kent-new-profile-bar side-pre-only has_custom_menu has-region-side-pre used-region-side-pre has-region-side-post empty-region-side-post">
    <div id="page">
        <div id="page-header">
            <div id="headerwrap">
                <div id="logowrap">Oops!</div>
            </div>
        </div>
        <div id="contentwrapper">
            <div>
                <p>Something went wrong, we are most likely aware of the problem and working to resolve it now.<br />
                Please check <a href="http://status.kent.ac.uk">status.kent.ac.uk</a> for updates.</p>
                <p>The reason given was:
                <?php
                $map = array(
                    1 => "We could not find the data directory.",
                    2 => "We could not write to the data directory.",
                    3 => "The database was not reachable"
                );

                if (isset($_GET['r']) && isset($map[$_GET['r']])) {
                    echo $map[$_GET['r']];
                } else {
                    echo "unknown error.";
                }
                ?>
                </p>
            </div>
        </div>
    </div>

    <script type="text/javascript" src="../javascript/navbar.js"></script>
</body>
</html>