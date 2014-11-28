$(function() {
    // For /my.
    $("input[value='Customise this page']").hide().parent().append('<button title="Customise this page"><i class="fa fa-gear"></i></button>');
    $("input[value='Stop customising this page']").hide().parent().append('<button title="Stop customising this page"><i class="fa fa-gears"></i></button>');
    $("input[value='Reset page to default']").hide().parent().append('<button title="Reset page to default"><i class="fa fa-undo"></i></button>');

    // For /course/view.php.
    $("input[value='Turn editing on']").hide().parent().append('<button title="Turn editing on"><i class="fa fa-gear"></i></button>');
    $("input[value='Turn editing off']").hide().parent().append('<button title="Turn editing off"><i class="fa fa-gears"></i></button>');
});