/*function editHumanControllerInit ($page, $apiRequest) {
    return $apiRequest.config('humans/' + $page.routeParams.id).getData();
}*/

function deleteHumanController ($scope, $apiRequest, $init) {

    var result = confirm("Are you sure delete this item?");

    if (result) {

        $scope.human = $init;
        $scope.deleteHuman = $apiRequest.config({
            method : 'PUT',
            url : 'humans',
            data : $scope.human,
        }, function (response, data) {

        });
    }
}
