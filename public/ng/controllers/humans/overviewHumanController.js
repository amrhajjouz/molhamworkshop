function overviewHumanControllerInit ($apiRequest, $page) {
    return $apiRequest.config('humans/' + $page.routeParams.id).getData();
}

function overviewHumanController ($scope, $page, $apiRequest, $init) {



    $scope.human = $init;

    $scope.updateHuman = $apiRequest.config({
        method : 'POST',
        url : 'humans',
        data : $scope.human,
    }, function (response, data) {

    });
}
