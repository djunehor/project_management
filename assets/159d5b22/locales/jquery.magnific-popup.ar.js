$.extend(true, $.magnificPopup.defaults, {
    tClose: 'إغلاق (خروج)', // Alt text on close button
    tLoading: 'جار التحميل...', // Text that is displayed during loading. Can contain %curr% and %total% keys
    gallery: {
        tPrev: 'سابق', // Alt text on left arrow
        tNext: 'التالى', // Alt text on right arrow
        tCounter: '%curr% من %total%' // Markup for "1 of 7" counter
    },
    image: {
        tError: '<a href="%url%">صورة</a> لا يمكن تغييرها.' // Error message when image could not be loaded
    },
    ajax: {
        tError: '<a href="%url%">محتوى</a> لا يمكن تحميل.' // Error message when ajax request failed
    }
});