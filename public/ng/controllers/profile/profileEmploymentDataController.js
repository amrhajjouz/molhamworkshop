function profileEmploymentDataControllerInit ($apiRequest) {
    return $apiRequest.config('auth').getData();
}

function profileEmploymentDataController ($scope, $init, $apiRequest) {

    $scope.auth = $init;

    $scope.profile = {};

    $scope.updateEmploymentData = $apiRequest.config({
        method : 'POST',
        url : 'profile/employment_data',
        data : $scope.profile,
    }, function (response, data) {
        if (data != null && !('error' in data)) {
            alert('تم تحديث البيانات الوظيفية !');
            $route.reload();
        }
    });

}