define(['jquery'], function ($) {
    return function (event) {
        var formValid = true;
        this.find(':input').each(function (i, input) {
            if ($(input).hasClass('rv-validator-invalid')) {
                formValid = false;
            }
        });

        if (!formValid) {
            event.preventDefault();
            return false;
        }
    }
});