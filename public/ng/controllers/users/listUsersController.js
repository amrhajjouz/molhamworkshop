function listUsersControllerInit ($datalist, $location) {
    return $datalist('users', true).load();
}

function listUsersController ($scope, $init, $datalist) {

    $scope.users = $init;

          $scope.deleteUserDevice = (id) => {
                    if(confirm('Are you sure about deleting user timesheet device?')) {
                              $apiRequest.config({
                                        method: 'DELETE',
                                        url: 'users/delete-user-device/' + id,
                              }, function (response, data) {
                                        $page.reload();
                              }).send();
                    }
          }

}
