function profileJobDataControllerInit ($apiRequest) {
    return $apiRequest.config('auth').getData();
}

function profileJobDataController ($scope, $init, $apiRequest) {

    $scope.auth = $init;

    $scope.profile = {};

    $scope.updateJobData = $apiRequest.config({
        method : 'POST',
        url : 'profile/job_data',
        data : $scope.profile,
    }, function (response, data) {
        if (data != null && !('error' in data)) {
            alert('تم تحديث البيانات الوظيفية !');
            $route.reload();
        }
    });

}