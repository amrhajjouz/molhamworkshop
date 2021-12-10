function overviewJobTitleControllerInit ($apiRequest, $page) {
    return $apiRequest.config('job_titles/' + $page.routeParams.id).getData();
}

function overviewJobTitleController ($scope, $init) {
    $scope.jobTitle = $init;
}
