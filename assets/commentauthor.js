jQuery(document).ready(function($) {
  $(".comment-form input[name='author']").blur(function() {
    $(this).val($(this).val().replace(/\d+/g, ''));
  });
});
