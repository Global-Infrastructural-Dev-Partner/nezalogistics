/*
 --------------------------------
 Ajax Contact Form
 --------------------------------
 + https://github.com/mehedidb/Ajax_Contact_Form
 + A Simple Ajax Contact Form developed in PHP with HTML5 Form validation.
 + Has a fallback in jQuery for browsers that do not support HTML5 form validation.
 + version 1.0.1
 + Copyright 2016 Mehedi Hasan Nahid
 + Licensed under the MIT license
 + https://github.com/mehedidb/Ajax_Contact_Form
 */

(function ($, window, document, undefined) {
    'use strict';

    var $form = $('#quote-form');
    $form.submit(function (e) {
        // remove the error class
        $('.form-group').removeClass('has-error');
        $('.help-block').remove();

        // get the form data
        var formData = {
            'name': $('input[name="quote_name"]').val(),
            'email': $('input[name="quote_email"]').val(),
            'phone': $('input[name="quote_phone"]').val(),
            'type': $('input[name="quote_type"]').val(),
            'quantity': $('input[name="quote_quantity"]').val(),
            'pickup': $('input[name="quote_pickup"]').val(),
            'delivery': $('input[name="quote_delivery"]').val(),
            'message': $('textarea[name="quote_message"]').val()
        };
        $.ajax({
            type: 'POST',
            url: './assets/email/quote.php',
            data: formData,
            dataType: 'json',
            encode: true
        }).done(function (data) {
            // handle errors
            if (!data.success) {
                if (data.errors.name) {
                    $('#quote_name').addClass('has-error');
                    $('#quote_name').find('.form-input').append('<span class="help-block">' + data.errors.name + '</span>');
                }

                if (data.errors.email) {
                    $('#quote_email').addClass('has-error');
                    $('#quote_email').find('.form-input').append('<span class="help-block">' + data.errors.email + '</span>');
                }

                if (data.errors.type) {
                    $('#quote_type').addClass('has-error');
                    $('#quote_type').find('.form-input').append('<span class="help-block">' + data.errors.phone + '</span>');
                }

                if (data.errors.quantity) {
                    $('#quote_quantity').addClass('has-error');
                    $('#quote_quantity').find('.form-input').append('<span class="help-block">' + data.errors.phone + '</span>');
                }

                if (data.errors.pickup) {
                    $('#quote_pickup').addClass('has-error');
                    $('#quote_pickup').find('.form-input').append('<span class="help-block">' + data.errors.phone + '</span>');
                }

                if (data.errors.delivery) {
                    $('#quote_delivery').addClass('has-error');
                    $('#quote_delivery').find('.form-input').append('<span class="help-block">' + data.errors.phone + '</span>');
                }

                if (data.errors.phone) {
                    $('#phone-field').addClass('has-error');
                    $('#phone-field').find('.form-input').append('<span class="help-block">' + data.errors.phone + '</span>');
                }

                if (data.errors.message) {
                    $('#message-field').addClass('has-error');
                    $('#message-field').find('.form-input').append('<span class="help-block">' + data.errors.message + '</span>');
                }
            } else {
                // display success message
                $form.html('<div class="alert alert-success">' + data.message + '</div>');
            }
        }).fail(function (data) {
            // for debug
            alert(JSON.stringify(data));
            console.log(data);
        });

        e.preventDefault();
    });
}(jQuery, window, document));