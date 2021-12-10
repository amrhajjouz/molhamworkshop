function listJobTitleControllerInit ($page, $datalist) {
    return $datalist('job_titles', true).load();
}

function listJobTitleController ($scope, $init) {
   $scope.jobTitles = $init;
}
