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

/*
 * @package    theme_kent
 * @copyright  2015 Skylar Kelty <S.Kelty@kent.ac.uk>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

 /**
  * @module theme_kent/theme
  */
define([], function() {
    return {
        init: function() {
		    var overrides = {
		        'Turn editing on': 'fa-pencil-square-o',
		        'Turn editing off': 'fa-pencil-square',
		        'Blocks editing on': 'fa-pencil-square-o',
		        'Blocks editing off': 'fa-pencil-square',
		        'Customise this page': 'fa-pencil-square-o',
		        'Stop customising this page': 'fa-pencil-square',
		        'Reset page to default': 'fa-undo',
		        'Search forums': 'fa-search',
		        'Edit questions': 'fa-pencil-square-o',
		        'Edit page contents': 'fa-pencil-square',
		        'Search': 'fa-search',
		        'Preferences': 'fa-pencil-square-o',
		        'Manage modules': 'fa-pencil-square-o'
		    };

		    $("#menuwrap input[type=submit], #menuwrap #ousearch_searchbutton").each(function (k, e) {
		        var text = e.value;

		        if (e.title.length > 0) {
		            text = e.title
		        }

		        if (text.substring(0, 11) == 'Update this') {
		            overrides[text] = 'fa-gear';
		        }

		        if (text in overrides) {
		            var fa_class = overrides[text];

		            $(e).hide().parent().append('<button title="' + text + '" class="navicon"><i class="fa ' + fa_class + '"></i><span class="icontext">' + text + '</span></button>');
		        }
		    });

		    $("#menuwrap .navbar .singlebutton").show();

		    $("#menuwrap .dropdown").on('show.bs.dropdown', function() {
		        var link = $(this).children(".dropdown-toggle");
		        var menu = $(this).children(".dropdown-menu");

		        var offset = (menu.outerWidth() - link.outerWidth()) / 2.0;
		        $(this).children(".dropdown-menu").css("margin-left", "-" + offset + "px");
		    });

		    $("select,textarea,input[type=text],input[type=password],input[type=datetime],input[type=datetime-local],input[type=date],input[type=month],input[type=time],input[type=week],input[type=number],input[type=email],input[type=url],input[type=search],input[type=tel],input[type=color]").addClass("form-control");

            if ($('code:not(.nohighlight)').length > 0) {
                $('code:not(.nohighlight)').each(function() {
                    $(this).html($(this).html().trim()).wrap("<pre>");
                });

                require(['theme_kent/hljs'], function(hljs) {
                	$('code:not(.nohighlight)').each(function(i, block) {
						window.hljs.highlightBlock(block);
					});
                });
            }
        }
    }
});
