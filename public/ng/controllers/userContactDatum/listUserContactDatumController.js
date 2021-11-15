function listUserContactDatumControllerInit ($page, $datalist) {
    return $datalist('user_contact_data', true).load();
}

function listUserContactDatumController ($scope, $init) {
   $scope.userContactData = $init;
}
