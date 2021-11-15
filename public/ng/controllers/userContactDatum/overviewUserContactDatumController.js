function overViewUserContactDatumControllerInit ($apiRequest, $page) {
    return $apiRequest.config('user_contact_data/' + $page.routeParams.id).getData();
}

function overviewUserContactDatumController ($scope, $init) {
    $scope.userContactDatum = $init;
}
