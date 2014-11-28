$(function() {
    $("input[value='Customise this page']").hide().parent().append('<button title="Customise this page"><i class="fa fa-gear"></i></button>');
    $("input[value='Stop customising this page']").hide().parent().append('<button title="Stop customising this page"><i class="fa fa-gears"></i></button>');
    $("input[value='Reset page to default']").hide().parent().append('<button title="Reset page to default"><i class="fa fa-undo"></i></button>');
});