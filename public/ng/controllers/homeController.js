function homeController ($scope, $init) {
    $("#modeBtn").on("click", function (e) {
        e.preventDefault();
        $("body").toggleClass("dark-mode");
        if ($("body").hasClass("dark-mode")) {
            var styleLink = $("#styleMode")
                .attr("href")
                .replace("theme-rtl", "theme-rtl-dark");
            $("#styleMode").attr("href", styleLink);
            $("#modeBtn").html(
                '<i class="fe fe-sun"></i> الوضع النهاري'
            );
        } else {
            var styleLink = $("#styleMode")
                .attr("href")
                .replace("theme-rtl-dark", "theme-rtl");
            $("#styleMode").attr("href", styleLink);
            $("#modeBtn").html(
                '<i class="fe fe-moon"></i> الوضع الليلي'
            );
        }
    });
}