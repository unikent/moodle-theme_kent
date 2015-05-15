$(function() {
    var overrides = {
        'Turn editing on': ['fa-pencil-square-o', ' Edit'],
        'Turn editing off': ['fa-pencil-square', ' Edit Off'],
        'Blocks editing on': ['fa-gear', ''],
        'Blocks editing off': ['fa-gears', ''],
        'Customise this page': ['fa-gear', ''],
        'Stop customising this page': ['fa-gears', ''],
        'Reset page to default': ['fa-undo', ''],
        'Search forums': ['fa-search', ''],
        'Edit questions': ['fa-gear', ''],
        'Edit page contents': ['fa-gear', ''],
        'Search': ['fa-search', ''],
        'Preferences': ['fa-gear', ''],
        'Manage modules': ['fa-gear', '']
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
            $(e).hide().parent().append('<button title="' + text + '"><i class="fa ' + fa_class[0] + '">' + fa_class[1] + '</i></button>');
        }
    });

    $("#menuwrap .dropdown").on('show.bs.dropdown', function() {
        var link = $(this).children(".dropdown-toggle");
        var menu = $(this).children(".dropdown-menu");

        var offset = (menu.outerWidth() - link.outerWidth()) / 2.0;
        $(this).children(".dropdown-menu").css("margin-left", "-" + offset + "px");
    });
});
