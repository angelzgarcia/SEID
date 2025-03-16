



// <--!     M O S T R A R   A C C I O N E S   D E   C A D A   R E G I S T R O       !-->
$(document).on('click', '.menu-toggle', function() {
    const $container = $(this).closest('.register-actions-menu-container');
    const $frame = $container.closest('.register-frame');
    $container.toggleClass('active');
    $frame.toggleClass('active');

    $('.register-actions-menu-container').not($container).removeClass('active');
    $('.register-frame').not($frame).removeClass('active');

    const windowWidth = $(window).width();
    const containerPos = $container.offset().left + $container.outerWidth();

    if (containerPos > windowWidth - 100)
        $container.addClass('inverted');
    else
        $container.removeClass('inverted');
});
