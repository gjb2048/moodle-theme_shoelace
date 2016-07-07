require(['core/first'], function() {
    require(['theme_bootstrapbase/bootstrap', 'theme_shoelace/anti_gravity', 'core/log'], function(bootstrap, ag, log) {
        log.debug('Shoelace JavaScript initialised');
    });
});
