$.extend(true, $.magnificPopup.defaults, {
    tClose: 'Cerrar (Esc)', // Alt text on close button
    tLoading: 'Cargando...', // Text that is displayed during loading. Can contain %curr% and %total% keys
    gallery: {
        tPrev: 'Anterior', // Alt text on left arrow
        tNext: 'Siguiente', // Alt text on right arrow
        tCounter: '%curr% de %total%' // Markup for "1 of 7" counter
    },
    image: {
        tError: '<a href="%url%">Una imagen</a> no puede ser cambiado.' // Error message when image could not be loaded
    },
    ajax: {
        tError: '<a href="%url%">Contenido</a> no se ha cargado.' // Error message when ajax request failed
    }
});