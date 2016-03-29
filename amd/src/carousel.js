/* jshint ignore:start */
define(['jquery', 'theme_shoelace/bootstrap', 'core/log'], function($, bootstrap, log) {

    "use strict"; // jshint ;_;

    log.debug('Shoelace carousel AMD');

    return {
        init: function(data) {
            log.debug('Shoelace carousel AMD init on #' + data.id + ', slide interval: ' + data.slideinterval);
            $(document).ready(function($) {
                $('#' + data.id).carousel({
                    interval: data.slideinterval
                });
            });
        }
    }
});
/* jshint ignore:end */
