jQuery(document).ready(function ($) {
    $('form.ajax_contact').on('submit', function (e) {
        e.preventDefault();
        var that = $(this);
        url = that.attr('action');
        type = that.attr('method');
        var name = $('.name').val();
        var mail = $('.mail').val();
        var message = $('.message').val();
        $.ajax({
            url: contact_object.ajax_url,
            type: "POST",
            dataType: 'text',
            data: {
                action: 'set_form_contact',
                name: name,
                mail: mail,
                message: message,
            },
            success: function (response) {
                $(".success_form").css("display", "block");
            },
            error: function (data) {
                $(".error_form").css("display", "block");
            }
        });
        $('.ajax_contact')[0].reset();
    });
});
