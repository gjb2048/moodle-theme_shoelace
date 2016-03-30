/* jshint ignore:start */
define(['jquery', 'core/log'], function($, log) {

    "use strict"; // jshint ;_;

    log.debug('Shoelace Scroll AMD.');

(function( $ ) {
    "use strict";
 
    $.fn.shoelaceScroll = function(options) {
        var settings = $.extend({}, $.fn.shoelaceScroll.defaults, options);
        settings.elementHeight = settings.theElement.height();
        var tally = 0;
        var diff = 0;
        var down = false;
        var last = $(this).scrollTop();
        var current = last;

        var inspect = function(object) {
            for (var key in object) {
                log.debug('K: ' + key + ' V: ' + object[key]);
            }
        };

        var setElementTop = function(pixels) {
            if (pixels > settings.elementHeight) {
                pixels = settings.elementHeight;
            }
            settings.theElement.css('top', '-' + pixels + 'px');
        }

        this.on('mouseup', function (evt) {
            log.debug('MUP');
            tally = 0;
            //log.debug('MUP ' + evt.pageX);
        });

        this.on('touchend', function (evt) {
            log.debug('TEND');
            tally = 0;
            //log.debug('TENDP ' + evt.pageX);
        });

        this.on('keyup', function (evt) {
            //log.debug('KEYP ' + evt.pageX);
            //log.debug('KEYC ' + evt.keyCode);
            log.debug('KEYC ' + evt.which);
            // Key 38 is cursor up and ket 40 is cursor down.
            if ((evt.which == 38) || (evt.which == 40)) {
                if (evt.target == document.body) {
                    log.debug('KEYC isBody');
                    tally = 0;
                }
            }
            //inspect(evt);
        });

        this.on('resize', function (evt) {
            log.debug('RESZ');
            tally = 0;
            //inspect(evt);
        });

        this.scroll(function(evt) {
            log.debug('SC');
            //log.debug('SC EVT:');
            //inspect(evt.originalEvent);
            current = $(this).scrollTop();
            log.debug('SCT: ' + current);
            if (current > last) {
                down = true;
                diff = current - last;
            } else {
                down = false;
                diff = last - current;
            }
            tally += diff;
            log.debug('SCDf: ' + diff);
            log.debug('SCTa: ' + tally);
            last = current;
        });

        return this;
    };
    
    $.fn.shoelaceScroll.defaults = {
        move: 20
    };
}($));

    return {
        init: function() {
            log.debug('Shoelace Scroll AMD init.');
            $(document).ready(function($) {
                
                $(window).shoelaceScroll({theElement: $('.navbar')});
            });
        }
    }
});
/* jshint ignore:end */
