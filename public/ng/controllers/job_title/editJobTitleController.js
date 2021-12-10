function editJobTitleControllerInit ($page, $apiRequest) {
    return $apiRequest.config('job_titles/' + $page.routeParams.id).getData();
}

function editJobTitleController ($scope, $apiRequest, $init) {
   $scope.jobTitle = $init;
      $scope.updateJobTitle = $apiRequest.config({
          method : 'PUT',
          url : 'job_titles',
          data : $scope.jobTitle,
      }, function (response, data) {

      });
}
