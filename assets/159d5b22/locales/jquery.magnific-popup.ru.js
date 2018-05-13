$.extend(true, $.magnificPopup.defaults, {
    tClose: 'Закрыть (Esc)', // Alt text on close button
    tLoading: 'Загрузка...', // Text that is displayed during loading. Can contain %curr% and %total% keys
    gallery: {
        tPrev: 'Пред.', // Alt text on left arrow
        tNext: 'След.', // Alt text on right arrow
        tCounter: '%curr% из %total%' // Markup for "1 of 7" counter
    },
    image: {
        tError: '<a href="%url%">Изображение</a> не может быть изменено' // Error message when image could not be loaded
    },
    ajax: {
        tError: '<a href="%url%">The content</a> can not be loaded.' // Error message when ajax request failed
    }
});