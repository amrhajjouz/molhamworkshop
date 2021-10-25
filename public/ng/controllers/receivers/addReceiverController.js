function addReceiverControllerInit ($page, $apiRequest) {
    return $apiRequest.config('countries').getData();
}

function addReceiverController ($scope, $apiRequest, $page, $init) {
    $scope.countries = $init;
    $scope.receiver = {};
    $scope.createReceiver = $apiRequest.config({
        method: 'POST',
        url: 'receivers',
        data: $scope.receiver,
    }, function (response, data) {
        $page.navigate('receivers.overview', {id: data.id});
    });
}
