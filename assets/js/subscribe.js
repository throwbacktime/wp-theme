jQuery(document).ready(function ($) {
    $('form.ajax').on('submit', function (e) {
        e.preventDefault();
        var that = $(this);
        url = that.attr('action');
        type = that.attr('method');
        var email = $('.email').val();
        $.ajax({
            url: cpm_object.ajax_url,
            type: "POST",
            dataType: 'text',
            data: {
                action: 'set_form',
                email: email,
            },
            success: function (response) {
                $(".success_msg").css("display", "block");
            },
            error: function (data) {
                $(".error_msg").css("display", "block");
            }
        });
        $('.ajax')[0].reset();
    });
});