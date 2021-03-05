function homeControllerInit ($page) {
    return 'ControllerInit';
}

function homeController ($scope, $http, $location, $init) {
    
    $scope.target = $init;
    $scope.fn = function () {
        alert('fnfn!');
    }
}