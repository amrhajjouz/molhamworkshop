function overviewDonorControllerInit($apiRequest, $page) {
          return $apiRequest.config("donors/" + $page.routeParams.id).getData();
}
function overviewDonorController($scope, $page, $apiRequest, $init) {
          $scope.donor = $init;
}
