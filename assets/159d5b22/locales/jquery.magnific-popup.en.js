$.extend(true, $.magnificPopup.defaults, {
    tClose: 'Close (Esc)', // Alt text on close button
    tLoading: 'Loading...', // Text that is displayed during loading. Can contain %curr% and %total% keys
    gallery: {
        tPrev: 'Previous', // Alt text on left arrow
        tNext: 'Next', // Alt text on right arrow
        tCounter: '%curr% of %total%' // Markup for "1 of 7" counter
    },
    image: {
        tError: '<a href="%url%">An image</a> can not be changed.' // Error message when image could not be loaded
    },
    ajax: {
        tError: '<a href="%url%">Content</a> can not be loaded.' // Error message when ajax request failed
    }
});