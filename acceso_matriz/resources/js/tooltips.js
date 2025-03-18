


window.onload = function() {

    if (typeof tippy !== 'undefined')
        tippy('[title]', {
            content: (reference) => {
                const title = reference.getAttribute('title');
                reference.removeAttribute('title');
                return title;
            },
            theme: 'light',
            arrow: true,
            animation: 'scale',
            delay: [500, 100],
        });

    else
        console.error("Tippy.js undefinded");

};
