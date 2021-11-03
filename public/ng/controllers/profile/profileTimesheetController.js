function profileTimesheetControllerInit ($datalist, $apiRequest) {
          return $datalist('profile/timesheet', true).load();
          // const data = $apiRequest.config('profile/timesheet').getData();
          // return data;
}

function profileTimesheetController ($scope, $apiRequest, $route, $init) {

          $scope.timesheet = $init;

          let data = $apiRequest.config('profile/generate-qr-code').getData();

          console.log(data);

          $scope.qr = data;

          $scope.dateFormatter = (dateValue) => {
                    const date = new Date(dateValue);
                    return ((date.getMonth() > 8) ? (date.getMonth() + 1) : ('0' + (date.getMonth() + 1))) + '/' + ((date.getDate() > 9) ? date.getDate() : ('0' + date.getDate())) + '/' + date.getFullYear() + ' ' + date.getHours() + ':' + date.getMinutes();
          }

}
