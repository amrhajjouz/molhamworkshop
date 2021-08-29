function addSectionController ($scope, $apiRequest, $page) {
    $scope.section = {};
    $scope.createSection = $apiRequest.config({
        method: 'POST',
        url: 'sections',
        data: $scope.section,
    }, function (response, data) {
        $page.navigate('sections.overview', {id: data.id});
    });

}
