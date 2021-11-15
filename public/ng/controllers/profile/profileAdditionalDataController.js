function profileAdditionalDataControllerInit ($apiRequest) {
    return $apiRequest.config('auth').getData();
}

function profileAdditionalDataController ($scope, $init, $apiRequest) {

    $scope.auth = $init;

    $scope.profile = {};

    $scope.updateAdditionalData = $apiRequest.config({
        method : 'POST',
        url : 'profile/additional_data',
        data : $scope.profile,
    }, function (response, data) {
        if (data != null && !('error' in data)) {
            alert('تم تحديث البيانات الإضافية !');
            $route.reload();
        }
    });

}