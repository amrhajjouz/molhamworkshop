function addJobTitleControllerInit () {
}

function addJobTitleController ($scope, $apiRequest, $page) {

    $scope.jobTitle = {};

    $scope.createJobTitle = $apiRequest.config({
        method: 'POST',
        url: 'job_titles',
        data: $scope.jobTitle,
    }, function (response, data) {
        $page.navigate('job_titles.overview', {id: data.id});
    });
}
