define([
    "jquery"
], function($) {
    "use strict";
    $.widget('weather.provider', {
        options: {
            url: 'weather/weather/data',
            method: 'post',
            triggerEvent: 'click'
        },

        _create: function() {
            this._ajaxSubmit();
        },

        _ajaxSubmit: function() {
            var self = this;
            $.ajax({
                url: self.options.url,
                type: self.options.method,
                dataType: 'json',
                beforeSend: function() {
                    console.log('beforeSend');
                    $('body').trigger('processStart');
                },
                success: function(res) {
                    console.log('success');
                    console.log((res));
                    for (let elem in res) {
                        $('#weather-parameters').append($('<p>').html(elem + ": " + res[elem]));
                    }
                    $('body').trigger('processStop');

                }
            });
        },

    });

    return $.weather.provider;
});
