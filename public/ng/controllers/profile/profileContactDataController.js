function profileContactDataControllerInit ($apiRequest) {
    return $apiRequest.config('auth').getData();
}

function profileContactDataController ($scope, $init, $apiRequest) {

    $scope.auth = $init;

    $scope.profile = {};

    $scope.updateContactData = $apiRequest.config({
        method : 'POST',
        url : 'profile/contact_data',
        data : $scope.profile,
    }, function (response, data) {
        if (data != null && !('error' in data)) {
            alert('تم تحديث بيانات التواصل !');
            $route.reload();
        }
    });

}