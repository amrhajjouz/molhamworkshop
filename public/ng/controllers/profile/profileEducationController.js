function profileEducationControllerInit ($apiRequest) {
    return $apiRequest.config('auth').getData();
}

function profileEducationController ($scope, $init, $apiRequest) {

    $scope.auth = $init;

    $scope.profile = {};

    $scope.updateEducation = $apiRequest.config({
        method : 'POST',
        url : 'profile/education',
        data : $scope.profile,
    }, function (response, data) {
        if (data != null && !('error' in data)) {
            alert('تم تحديث السجل التعليمي !');
            $route.reload();
        }
    });

}