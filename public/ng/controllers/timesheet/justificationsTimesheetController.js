function justificationsTimesheetControllerInit ($page, $datalist) {
    return $datalist('timesheet/justifications', true).load();
}

function justificationsTimesheetController ($scope, $init) {
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
}
