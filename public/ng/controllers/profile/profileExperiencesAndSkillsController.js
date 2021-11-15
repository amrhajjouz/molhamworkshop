function profileExperiencesAndSkillsControllerInit ($apiRequest) {
    return $apiRequest.config('auth').getData();
}

function profileExperiencesAndSkillsController ($scope, $init, $apiRequest) {

    $scope.auth = $init;

    $scope.profile = {};

    $scope.updateExperiencesAndSkills = $apiRequest.config({
        method : 'POST',
        url : 'profile/experiences_and_skills',
        data : $scope.profile,
    }, function (response, data) {
        if (data != null && !('error' in data)) {
            alert('تم تحديث الخبرات و المهارات !');
            $route.reload();
        }
    });

}