jQuery(function ($) {
  $(function () {
    $("#show_menu").dblclick(function () {
      $("#nav-open").show();
    });
  });
  $(function () {
    $("#nav-open").on("click", function () {
      if ($(this).hasClass("active")) {
        $(this).removeClass("active");
        $("#nav-content").removeClass("open").fadeOut(100);
        $("#nav-open").hide();
        $(".gp_chbox").css("z-index", 0);
      } else {
        $(".gp_chbox").css("z-index", -1);
        $(this).addClass("active");
        $("#nav-content").fadeIn(100).addClass("open");
      }
    });
  });
});
