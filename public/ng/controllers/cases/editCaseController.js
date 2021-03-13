// const { initial } = require("lodash");

async function editCaseControllerInit($http, $page, $apiRequest) {
    const object = await $apiRequest
        .config("cases/" + $page.routeParams.id)
        .getData();

    const countries = await $apiRequest.config("countries").getData();

    const init = {
        object: object,
        countries: countries,
    };
    return init;
}

function editCaseController($scope, $page, $apiRequest, $init) {
    $scope.object = $init.object;
    $scope.countries = $init.countries;

    $scope.statuses = [
        { id: "funded", name: "تم كفالتها" },
        { id: "unfunded", name: "غير مكفولة" },
        { id: "canceled", name: "ملغاة" },
        { id: "spent", name: "تم صرفها" },
    ];

    $scope.updateCase = $apiRequest.config(
        {
            method: "PUT",
            url: "cases",
            data: $scope.object,
        },
        function (response, data) {}
    );
}
