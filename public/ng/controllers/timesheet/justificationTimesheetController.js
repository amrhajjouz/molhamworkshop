function justificationTimesheetControllerInit ($page, $apiRequest) {
    return $apiRequest.config('timesheet/justifications/' + $page.routeParams.id).getData();
}

function justificationTimesheetController ($scope, $init, $swal, $swalConfirmWithInput, $swalConfirm) {
   $scope.justification = $init;
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

    $scope.approve = (id) => {
        $swalConfirm('تأكيد القبول', 'هل تريد تأكيد قبول التبرير؟', 'timesheet/justification/approve', {id});
    }

    $scope.reject = (id) => {
        $swalConfirmWithInput('تأكيد الرفض', 'هل تريد تأكيد رفض التبرير؟', 'timesheet/justification/reject', {id});
    }
}
