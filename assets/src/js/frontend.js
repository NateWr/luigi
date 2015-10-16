/*
 * Front-end Javascript for Luigi
 */

/**
 * Counter to throttle events when the window is being resized
 *
 * @since 0.0.1
 */
var luigi_resize_throttle_timer;

jQuery(document).ready(function ($) {

    /**
     * Open and close navigation menu
     *
     * @since 0.0.1
     */
    var body = $( 'body' );
    var nav_control = $( '#luigi-primary-nav-control' );
    nav_control.click( function() {
        body.toggleClass( 'luigi-menu-open' );
        return false;
    } );

    /**
     * Remove open menu class is window size is bigger now
     *
     * @since 0.0.1
     */
    function window_resized() {
        if( $(window).width() >= 480 ) {
            body.removeClass( 'luigi-menu-open' );
        }
    }

    window.onresize = function() {
        clearTimeout( luigi_resize_throttle_timer );
        luigi_resize_throttle_timer = setTimeout( window_resized, 500 );
    };

});
