define(
    ['jquery', 'mage/url', 'ucfirst', 'rv-input-results'],
    function ($, url, ucfirst, inputResult) {

    return function (config, node) {
        $(node).on('blur', function () {
            var $this = $(this);
            var data = {
                "input": $this.val(),
                "class": ucfirst(config['rule'])
            };

            if (config.hasOwnProperty('args')) {
                data['args'] = config['args'];
            }

            $.ajax({
                url: url.build('rest/v1/rv/validate/'+ JSON.stringify(data)),
                type: "GET",
                success: function (response) {
                    var name = 'Input';
                    if (config.hasOwnProperty('name')) {
                        name = config['name'];
                    }

                    inputResult({"isValid": response, "name": name}, $this);
                }
            });
        });
    }
});
