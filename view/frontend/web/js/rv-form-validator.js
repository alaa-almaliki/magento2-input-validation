define(['jquery'], function ($) {
    return function (config, node) {
        var $form = $(node);
        $form.on('submit', function (e) {
            var formValid = true;
            $form.find(':input').each(function (i, input) {
                if ($(input).hasClass('rv-validator-invalid')) {
                    formValid = false;
                }
            });

            if (!formValid) {
                e.preventDefault();
                return false;
            }
        });
    }
});