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

require_once(dirname(__FILE__) . '/../../config.php');

$PAGE->set_context(\context_system::instance());
$PAGE->set_url('/theme/kent/index.php');
$PAGE->set_title('University of Kent');
$PAGE->set_pagelayout('embedded');

echo $OUTPUT->header();

echo <<<HTML5
<div id="loginbox">
	<h1>Kent's Moodle Theme</h1>
</div>


<script src="https://cdnjs.cloudflare.com/ajax/libs/trianglify/0.2.0/trianglify.min.js"></script>
<script>
var colorsets = Array('YlGnBu', 'YlOrRd', 'GnBu', 'YlOrBr', 'Purples', 'Blues', 'Oranges', 'Reds', 'PuRd');
var colorset = colorsets[Math.floor(Math.random() * colorsets.length)];

function regenBackground() {
    var pattern = Trianglify({
        width: window.innerWidth,
        height: window.innerHeight,
    	variance: 1,
    	cell_size: 40,
    	x_colors: colorset
    });
    pattern.canvas(document.getElementById('background'));
}

$(function() {
	$('body').prepend($('<canvas id="background"></canvas>'));

	regenBackground();

	$(window).on('resize', regenBackground);
});
</script>
<style>
#background {
	position: absolute;
	top: 0;
	left: 0;
}

#loginbox {
	background: rgba(255, 255, 255, 0.6);
	width: 100%;
	min-height: 40px;
	margin-top: 100px;
	border: 1px solid #FFF;
	border-radius: 30px;
}

#loginbox h1 {
	display: block;
	margin: 40px 0;
	color: #fff;
	text-align: center;
}
</style>
HTML5;

echo $OUTPUT->footer();