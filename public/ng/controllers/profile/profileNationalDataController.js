function profileNationalDataControllerInit ($apiRequest) {
    return $apiRequest.config('auth').getData();
}

function profileNationalDataController ($scope, $init, $apiRequest) {

    $scope.auth = $init;

    $scope.profile = {};

    $scope.updateNationalData = $apiRequest.config({
        method : 'POST',
        url : 'profile/national_data',
        data : $scope.profile,
    }, function (response, data) {
        if (data != null && !('error' in data)) {
            alert('تم تحديث البيانات الوطنية !');
            $route.reload();
        }
    });

}