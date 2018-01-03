define(['jquery'], function ($) {
    return function (config, node) {
        var message = '';
        var isValid = config['isValid'];
        var name = config['name'];
        var invalidClass = 'rv-validator-invalid';

        if (isValid) {
            message = name + ' is valid';
            node.css("border", "2px solid green");
            if (node.hasClass(invalidClass)) {
                node.removeClass(invalidClass);
            }
        } else {
            message = name + ' is not valid';
            node.css("border", "2px solid red");
            node.addClass(invalidClass);

        }
        var className = node.attr('id') + '-msg';
        var $msg = $('.' + className);

        if ($msg.text().length > 0) {
            $msg.remove();
        }
        $msg = $('<span>'+ message + '</span>').addClass(className);
        var color = isValid ? 'green': 'red';
        $msg.css('color', color);
        $msg.insertBefore(node);
    }
});