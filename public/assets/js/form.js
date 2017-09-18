$(function() {
    $(document).on('click', '.btn-add', function(e) {
        e.preventDefault();

        var form = $('.contact-form form:first'),
            currentItem = $(this).parents('.number-input:first'),
            lastItem = $(this).parents('.number-input:last'),
            newItem = $(currentItem.clone()).insertAfter(lastItem);
        newItem.find('div.intl-tel-input').remove();
        var newInput = $('<input class="form-control intl-phone" name="number[]" type="text" placeholder="Phone" required="required" aria-required="true" />');
        newInput.insertBefore(newItem.find('select'));
        newItem.find('input').val('');
        newItem.find('select').val('cell');
        form.find('.number-input:not(:last) .btn-add')
            .removeClass('btn-add').addClass('btn-remove')
            .removeClass('btn-success').addClass('btn-danger')
            .html('<span class="glyphicon glyphicon-minus"></span>');

        intlPhoneInit();
    }).on('click', '.btn-remove', function(e) {
        $(this).parents('.number-input:first').remove();
        e.preventDefault();
        return false;
    });

    $("#form-contact").validate({
        submitHandler: function (form) {
            $('input.intl-phone').each(function () {
                var $input = $(this);
                if ($input.intlTelInput("isValidNumber")) {
                    $input.val($input.intlTelInput("getNumber", intlTelInputUtils.numberFormat.INTERNATIONAL));
                }
            });
            form.submit();
        }
    });

    $(document).on('click', '.btn-cancel', function () {
        window.location = '/';
    });

});