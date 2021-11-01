async function listDonationControllerInit($datalist) {
    return {
        donations: await $datalist(`donations`, true).load()
    }
}

function listDonationController($scope, $init) {
    $scope.donations = $init.donations;
}
