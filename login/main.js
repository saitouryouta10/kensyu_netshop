$(function() {
    $('#submit').prop('disabled', true);

    $('#doui').on('click', function() {
        if ($(this).prop('checked') == false) {
            $('#submit').prop('disabled', true);
        } else {
            $('#submit').prop('disabled', false);
        }
    });
});