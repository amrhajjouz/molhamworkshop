function profileHousingDataControllerInit ($apiRequest) {
    return $apiRequest.config('auth').getData();
}

function profileHousingDataController ($scope, $init, $apiRequest) {

    $scope.auth = $init;

    $scope.profile = {};

    $scope.updateHousingData = $apiRequest.config({
        method : 'POST',
        url : 'profile/housing_data',
        data : $scope.profile,
    }, function (response, data) {
        if (data != null && !('error' in data)) {
            alert('تم تحديث البيانات السكن !');
            $route.reload();
        }
    });

}