async function donationListControllerInit($datalist) {
    return {
        donations: await $datalist(`donations`, true).load()
    }
}

function donationListController($scope, $init) {
    $scope.donations = $init.donations;
}
