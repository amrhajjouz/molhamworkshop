function addUserWorkExperienceControllerInit () {
    return [];
}

function addUserWorkExperienceController ($scope, $apiRequest, $page) {

    $scope.userWorkExperience = {};

    $scope.createUserWorkExperience = $apiRequest.config({
        method: 'POST',
        url: 'user_work_experiences',
        data: $scope.userWorkExperience,
    }, function (response, data) {
        $page.navigate('user_work_experiences.overview', {id: data.id});
    });
}
