$(function() {
    var overrides = {
        'Turn editing on': 'fa-gear',
        'Turn editing off': 'fa-gears',
        'Blocks editing on': 'fa-gear',
        'Blocks editing off': 'fa-gears',
        'Customise this page': 'fa-gear',
        'Stop customising this page': 'fa-gears',
        'Reset page to default': 'fa-undo',
        'Search forums': 'fa-search'
    };

    $(".kent-future-theme #editbuttons input[type=submit]").each(function (k, e) {
        var text = e.value;

        if (text.substring(0, 11) == 'Update this') {
            overrides[text] = 'fa-gear';
        }

        if (text in overrides) {
            var fa_class = overrides[text];
            $(e).hide().parent().append('<button title="' + text + '"><i class="fa ' + fa_class + '"></i></button>');
        }
    });
});