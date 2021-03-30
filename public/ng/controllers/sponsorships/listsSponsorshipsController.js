async function listsSponsorshipsControllerInit($datalist) {
  return await $datalist("sponsorships", true).load();
}

function listsSponsorshipsController($scope, $init) {
  $scope.sponsorships = $init;
}
