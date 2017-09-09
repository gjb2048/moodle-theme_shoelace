/* jshint ignore:start */
define(['jquery', 'theme_bootstrapbase/bootstrap', 'theme_shoelace/holder', 'core/log'], function($, bootstrap, holder, log) {

    "use strict"; // jshint ;_;

    log.debug('Shoelace Style Guide AMD');

    return {
        init: function() {
            $(document).ready(function($) {
                $("[data-toggle=tooltip]").tooltip();
                $("[data-toggle=popover]").popover().click(function(e) {
                    e.preventDefault()
                });
            });
            log.debug('Shoelace Style Guide AMD init');
        }
    }
});
/* jshint ignore:end */
