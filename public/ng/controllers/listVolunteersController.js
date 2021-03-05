function listVolunteersControllerInit ($page) {
    $page.set({title : 'قائمة المتطوعين', pretitle : 'المتطوعون'});
    return ;
}

function listVolunteersController ($scope, $http, $location) {
    
    $scope.target = 'sda';
}