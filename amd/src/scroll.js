/* jshint ignore:start */
define(['jquery', 'core/log'], function($, log) {

    "use strict"; // jshint ;_;

    log.debug('Shoelace Scroll AMD.');

    (function( $ ) {
        "use strict";

        $.fn.shoelaceScroll = function(options) {
            var settings = $.extend({}, $.fn.shoelaceScroll.defaults, options);
            settings.elementHeight = settings.theElement.height() + 1;
            var tally = 0;
            var diff = 0;
            var elementTop = 0;
            var elementFullyShown = true;
            var elementFullyHidden = false;
            var down = false;
            var last = $(this).scrollTop();
            var current = last;

            log.debug('shoelaceScroll - Element height + 1 : ' + settings.elementHeight);
            log.debug('shoelaceScroll - Scroll up amount   : ' + settings.scrollupamount);
            log.debug('shoelaceScroll - Current scroll pos : ' + last);

            var setElementTop = function() {
                if (down) {
                    elementTop += diff;
                    if (elementTop > settings.elementHeight) {
                        elementTop = settings.elementHeight;
                        elementFullyHidden = true;
                        elementFullyShown = false;
                        log.debug('SET: Element fully hidden.');
                    } else {
                        elementFullyShown = false;
                        elementFullyHidden = false;
                        log.debug('SET: Element partial (down).');
                    }
                } else {
                    elementTop -= diff;
                    if (elementTop < 0) {
                        elementTop = 0;
                        elementFullyShown = true;
                        elementFullyHidden = false;
                        log.debug('SET: Element fully shown.');
                    } else {
                        elementFullyShown = false;
                        elementFullyHidden = false;
                        log.debug('SET: Element partial (up).');
                    }
                }
                settings.theElement.css('top', '-' + elementTop + 'px');
            }

            this.on('mouseup', function (evt) {
                log.debug('SC: MUP - tally reset.');
                tally = 0;
            });

            this.on('touchend', function (evt) {
                log.debug('SC: TEND - tally reset.');
                tally = 0;
            });

            this.on('keyup', function (evt) {
                log.debug('KEYC ' + evt.which);
                // Key 38 is cursor up and ket 40 is cursor down.
                if ((evt.which == 38) || (evt.which == 40)) {
                    if (evt.target == document.body) {
                        log.debug('KEYC \'isBody\' with up/down cursor key - tally reset.');
                        tally = 0;
                    }
                }
            });

            this.on('resize', function (evt) {
                log.debug('SC: RESZ - tally reset.');
                tally = 0;
            });

            this.scroll(function(evt) {
                current = $(this).scrollTop();
                log.debug('SCTop: ' + current);
                if (current > last) {
                    if (!down) {
                        // Change of direction, reset tally.
                        log.debug('SC was up now down - reset tally.');
                        tally = 0;
                    }
                    down = true;
                    diff = current - last;
                    tally += diff;
                    if (!elementFullyHidden) {
                        setElementTop();
                    }
                } else {
                    if (down) {
                        // Change of direction, reset tally.
                        log.debug('SC was down now up - reset tally.');
                        tally = 0;
                    }
                    down = false;
                    diff = last - current;
                    tally += diff;
                    if ((tally >= settings.scrollupamount) || (current <= settings.elementHeight)) {
                        // Start to show the element if we have moved beyond the tally or getting to the element height at the top.
                        if (!elementFullyShown) {
                            setElementTop();
                        }
                    }
                }
                log.debug('SCDiff: ' + diff);
                log.debug('SCTally: ' + tally);
                last = current;
            });

            if (last > 0) {
                // Down the page on load.
                down = true;
                diff = last;
                setElementTop();
            }

            return this;
        };

        $.fn.shoelaceScroll.defaults = {
            scrollupamount: 250
        };
    }($));

    return {
        init: function(data) {
            log.debug('Shoelace Scroll AMD init.');
            $(document).ready(function($) {
                $(window).shoelaceScroll({
                    theElement: $('.navbar'),
                    scrollupamount: data.navbarscrollupamount
                });
            });
        }
    }
});
/* jshint ignore:end */
