function addCaseController($scope, $location, $apiRequest, $page, $init) {
    $scope.case = { beneficiary_name: null, place_id: null, target: { beneficiaries_count: 1, hidden: false, required: 1 } };
    $scope.createCaseRequest = $apiRequest.config(
        {
            method: 'POST',
            url: 'cases',
            data: $scope.case,
        },
        function (response, data) {
            $page.navigate('cases.overview', { id: data.id });
        }
    );
}
