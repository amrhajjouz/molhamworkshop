function profileEducationRecordControllerInit ($apiRequest) {
    return $apiRequest.config('auth').getData();
}

function profileEducationRecordController ($scope, $init, $apiRequest) {

    $scope.auth = $init;

    $scope.profile = {};

    $scope.updateEducationRecord = $apiRequest.config({
        method : 'POST',
        url : 'profile/education_record',
        data : $scope.profile,
    }, function (response, data) {
        if (data != null && !('error' in data)) {
            alert('تم تحديث السجل التعليمي !');
            $route.reload();
        }
    });

}