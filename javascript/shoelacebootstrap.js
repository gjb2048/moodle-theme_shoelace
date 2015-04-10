
require(['core/first'], function() {
    require(['theme_shoelace/bootstrap', 'core/log'], function(bootstrap, log) {
        log.debug('Shoelace Bootstrap initialised');
    });
});
