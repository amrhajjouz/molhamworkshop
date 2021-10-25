async function editReceiverControllerInit ($page, $apiRequest) {
  return {
      receiver:await $apiRequest.config('receivers/' + $page.routeParams.id).getData(),
      countries:await $apiRequest.config('countries').getData()
  }
}

function editReceiverController ($scope, $page, $apiRequest, $init) {
    $scope.receiver = $init.receiver;
    $scope.countries = $init.countries;
    $scope.statuses = ['active', 'suspended', 'closed'];
    $scope.updateReceiver = $apiRequest.config({
        method : 'PUT',
        url : 'receivers',
        data : $scope.receiver,
    }, function (response, data) {

    });
}
