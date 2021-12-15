function profileJustificationsControllerInit ($datalist, $apiRequest) {
    return $datalist('profile/justifications', true).load();
}

function profileJustificationsController ($scope, $apiRequest, $route, $init) {
    $scope.justifications = $init;
    $scope.status = (status) => {
        let list = {
            pending: 'بانتظار التبرير',
            expired: 'انتهت فترة التبرير',
            needs_approval: 'بانتظار المراجعة',
            approved: 'مقبول',
            rejected: 'مرفوض',
        };

        return list[status];
    }
    $scope.isLoading = false;

    $scope.retriveJustification = (id) => {
        $scope.isLoading = true;
        $apiRequest.config({
            method : 'POST',
            url : 'profile/retriveJustification',
            data : {id},
        }, function (response, data) {
            $scope.isLoading = false;
            console.log(response);
            $scope.justification = response.data;
        }).send();
    }

    $scope.sendJustification = $apiRequest.config({
        method: 'POST',
        url: 'profile/sendJustification',
        data: $scope.justification,
    }, function (response, data) {
        $page.navigate('profile.justifications');
    });
}
