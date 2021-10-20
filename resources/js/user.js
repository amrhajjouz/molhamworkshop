//
// user.js
// Use this to write your custom JS
//

/* Solving table & dropdown cut off */
$(".table-responsive .dropdown").on("show.bs.dropdown", function () {
  $(".table-responsive").css("overflow-x", "inherit");
});

$(".table-responsive .dropdown").on("hide.bs.dropdown", function () {
  $(".table-responsive").css("overflow-x", "auto");
});
