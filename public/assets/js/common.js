$(function() {
    intlPhoneInit();
    $.validator.addMethod('intlPhone', function (value, element) {

        if (value.length === 0) {
            return true;
        }

        return $(element).intlTelInput("isValidNumber");

    }, "Phone number is invalid.");

    jQuery.validator.addClassRules("intl-phone", {
        intlPhone: true
    });

    $(document).on('click', '.btn-remove', function (e) {
        var id = $(this).data('contact');
        window.location = '/delete/' + id;
    });

});

function intlPhoneInit() {
    $.fn.intlTelInput.loadUtils('/assets/lib/intl-tel-input-12.0.0/js/utils.js');
    $(".intl-phone").intlTelInput({
        preferredCountries: ['br', 'us', 'es'],
        initialCountry: "br",
        autoPlaceholder: true
    });

    $(".intl-phone").on('blur', function () {
        var $input = $(this);
        if ($input.val().length > 0) {
            if ($input.intlTelInput("isValidNumber")) {
                $input.val($input.intlTelInput("getNumber", intlTelInputUtils.numberFormat.NATIONAL));
            }
        }
    });
    $(".intl-phone").on("countrychange", function (e, countryData) {
        if ($(e.target).is(":focus") === false) {
            $(e.target).val('');
        }
    });
    $(".intl-phone").attr("maxlength", 20);
    $(".intl-phone").mask('#', {translation: {'#': {pattern: /[\d\-\+\(\)\s]/, recursive: true}}});
}