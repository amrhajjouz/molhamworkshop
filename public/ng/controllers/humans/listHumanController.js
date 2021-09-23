function listHumanControllerInit ($page, $datalist) {
    return $datalist('humans', true).load();
}

function listHumanController ($scope, $apiRequest, $init, $page) {
    $scope.humans = $init;

    //Delete Human
    $scope.deleteHumanController= function (id) {
        $apiRequest.config( {
            method: "DELETE",
            url: "humans/" + id,
        }, function (response, data) {
            $page.reload();
        }).send();
    }
}



