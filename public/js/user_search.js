// $(function() {
//   $('.search_sort').click(function() {
//     $(this).toggleClass('search_sort_toggle').children('.submenu').slideToggle();
//   });
// });

$(function () {
  $('.search_conditions').click(function () {
    $('.search_conditions_inner').slideToggle();
  });

  $('.subject_edit_btn').click(function () {
    $('.subject_inner').slideToggle();
  });
});
