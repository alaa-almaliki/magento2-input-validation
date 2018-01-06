define([
        'jquery',
        'mage/url',
        'ucfirst',
        'rv-input-results',
        'rv-form-validator'
    ],
    function ($,
              url,
              ucfirst,
              inputResult,
              validator) {

        return function (config, node) {
            $(node).on('blur', function () {
                var $this = $(this);
                var data = {"input": $this.val()};
                var rules = config['rules'];

                if ($.isArray(rules)) {
                    $.each(rules, function (i, rule) {
                        rule['class'] = ucfirst(rule['rule']);
                    });
                    data['rules'] = rules;
                } else {
                    rules['class'] = ucfirst(rules['rule']);
                    data['rules'] = [rules];
                }

                $.ajax({
                    url: url.build('rest/v1/rv/validate/' + JSON.stringify(data)),
                    type: "GET",
                    success: function (response) {
                        var name = 'Input';
                        if (config.hasOwnProperty('name')) {
                            name = config['name'];
                        }

                        inputResult({"isValid": response, "name": name}, $this);
                    }
                });

                var $form = $(this).closest('form');
                $form.unbind('submit')
                    .bind('submit', validator.bind($form));
            });
        }
    });
