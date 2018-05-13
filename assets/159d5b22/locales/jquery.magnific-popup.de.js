$.extend(true, $.magnificPopup.defaults, {
    tClose: 'Schließen (Esc)', // Alt text on close button
    tLoading: 'Wird geladen ...', // Text that is displayed during loading. Can contain %curr% and %total% keys
    gallery: {
        tPrev: 'Zurück', // Alt text on left arrow
        tNext: 'Weiter', // Alt text on right arrow
        tCounter: '%curr% von %total%' // Markup for "1 of 7" counter
    },
    image: {
        tError: '<a href="%url%">Ein Bild</a> nicht geändert werden kann.' // Error message when image could not be loaded
    },
    ajax: {
        tError: '<a href="%url%">Der Inhalt</a> nicht geladen werden kann.' // Error message when ajax request failed
    }
});