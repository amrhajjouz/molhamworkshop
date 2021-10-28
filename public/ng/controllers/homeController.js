function homeController ($scope, $init) {
    $("#darkModeBtn").on("click", function (e) {
        e.preventDefault();
        $("body").toggleClass("dark-mode");
        if ($("body").hasClass("dark-mode")) {
            var styleLink = $("#styleMode")
                .attr("href")
                .replace("theme-rtl", "theme-rtl-dark");
            $("#styleMode").attr("href", styleLink);
            $("#darkModeBtn").html(
                '<i class="fe fe-sun"></i> الوضع النهاري'
            );
        } else {
            var styleLink = $("#styleMode")
                .attr("href")
                .replace("theme-rtl-dark", "theme-rtl");
            $("#styleMode").attr("href", styleLink);
            $("#darkModeBtn").html(
                '<i class="fe fe-moon"></i> الوضع الليلي'
            );
        }
    });
    $("#pinkModeBtn").on("click", function (e) {
        e.preventDefault();
        $("body").toggleClass("pink-mode");
        if ($("body").hasClass("pink-mode")) {
            var styleLink = $("#styleMode")
                .attr("href")
                .replace("theme-rtl", "theme-rtl-pink");
            $("#styleMode").attr("href", styleLink);
            $("#pinkModeBtn").html(
                '<i class="fe fe-check-circle"></i> الوضع الشبابي الرائع'
            );
        } else {
            var styleLink = $("#styleMode")
                .attr("href")
                .replace("theme-rtl-pink", "theme-rtl");
            $("#styleMode").attr("href", styleLink);
            $("#pinkModeBtn").html(
                '<i class="fe fe-alert-triangle"></i> الوضع النسواني'
            );
        }
    });
}