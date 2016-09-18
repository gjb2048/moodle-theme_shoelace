/* jshint ignore:start */
define(['jquery', 'core/log'], function($, log) {

    "use strict"; // jshint ;_;

    log.debug('Shoelace anti gravity AMD initialised');

    $(document).ready(function() {
        var showposition = 480;
        var animateduration = 1200;

        $(window).scroll(function() {
            if ($(this).scrollTop() > showposition) {
                $('.antiGravity').fadeIn();
            } else {
                $('.antiGravity').fadeOut();
            }
        });

        $('.antiGravity').click(function() {
            $('html, body').animate({scrollTop : 0}, animateduration);
            return false;
        });

        $("a[href$='#page-footer']").click(function(e) {
            e.preventDefault();
            var target = $('.form-buttons');
            if (!target.length) {
                target = $('.form-submit');
            }
            if (!target.length) {
                target = $('#page-footer');
            }
            $('html, body').animate({scrollTop : target.offset().top}, animateduration);
            return false;
        });
    });
});
/* jshint ignore:end */
