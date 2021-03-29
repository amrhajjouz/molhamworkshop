function listsSponsorshipsControllerInit($apiRequest) {
  return $apiRequest.config("sponsorships").getData();
}

function listsSponsorshipsController($scope, $init) {
  $scope.sponsorships = $init;
}
