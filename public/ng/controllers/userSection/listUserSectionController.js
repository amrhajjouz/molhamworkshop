function listUserSectionControllerInit ($page, $datalist) {
    return $datalist('user_sections', true).load();
}

function listUserSectionController ($scope, $init) {
   $scope.userSections = $init;
}
