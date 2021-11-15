function profileResidenceDataControllerInit ($apiRequest) {
    return $apiRequest.config('auth').getData();
}

function profileResidenceDataController ($scope, $init, $apiRequest) {

    $scope.auth = $init;

    $scope.profile = {};

    $scope.updateResidenceData = $apiRequest.config({
        method : 'POST',
        url : 'profile/residence_data',
        data : $scope.profile,
    }, function (response, data) {
        if (data != null && !('error' in data)) {
            alert('تم تحديث بيانات السكن !');
            $route.reload();
        }
    });

}