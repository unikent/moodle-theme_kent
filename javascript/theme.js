$(function() {
    var overrides = {
        'Turn editing on': ['fa-pencil-square-o', 'Edit'],
        'Turn editing off': ['fa-pencil-square', 'Edit Off'],
        'Blocks editing on': ['fa-pencil-square-o', ''],
        'Blocks editing off': ['fa-pencil-square', ''],
        'Customise this page': ['fa-pencil-square-o', ''],
        'Stop customising this page': ['fa-pencil-square', ''],
        'Reset page to default': ['fa-undo', ''],
        'Search forums': ['fa-search', ''],
        'Edit questions': ['fa-pencil-square-o', ''],
        'Edit page contents': ['fa-pencil-square', ''],
        'Search': ['fa-search', ''],
        'Preferences': ['fa-pencil-square-o', ''],
        'Manage modules': ['fa-pencil-square-o', '']
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

            var span = '';
            if(fa_class[1].length > 0) {
                span = '<span>' + fa_class[1] + '</span>';
            }

            $(e).hide().parent().append('<button title="' + text + '"><i class="fa ' + fa_class[0] + '"></i>' + span + '</button>');
        }
    });

    $("#menuwrap .dropdown").on('show.bs.dropdown', function() {
        var link = $(this).children(".dropdown-toggle");
        var menu = $(this).children(".dropdown-menu");

        var offset = (menu.outerWidth() - link.outerWidth()) / 2.0;
        $(this).children(".dropdown-menu").css("margin-left", "-" + offset + "px");
    });
});
