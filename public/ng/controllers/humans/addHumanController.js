/*async function addHumanControllerInit($apiRequest) {

}*/

function addHumanController ($scope, $location, $apiRequest, $page) {

    $scope.human = {};

    $scope.createHuman = $apiRequest.config({
        method: 'POST',
        url: 'humans',
        data: $scope.human,
    }, function (response, data) {
        $page.navigate('humans.overview', {id: data.id});
    });
}
