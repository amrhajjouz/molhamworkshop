async function reviewsPayoutRequestControllerInit($datalist, $apiRequest,$page) {
    return {
        reviews: await $datalist(`payouts/requests/${$page.routeParams.requestId}/reviews`, true).load(),
        payoutRequest: await $apiRequest.config(`payouts/requests/${$page.routeParams.requestId}/summary`).getData(),

    }
}

function reviewsPayoutRequestController($scope, $init, $page, $apiRequest) {

    $scope.reviews = $init.reviews;
    $scope.payoutRequest = $init.payoutRequest;

    $scope.showApprovalModel = function (data) {
        $scope.selectedReview = angular.copy(data);
        $scope.review = {
            id: data.id,
            notes: null,
        };
        $('#approval-modal').modal('show');
    }
    $scope.addApproveState = function (status) {
        $('#approval-modal').modal('hide');
        if (confirm('هل أنت متأكد من هذه العملية؟')) {
            $scope.review.status = status;
            $apiRequest.config({
                method: 'POST',
                url: `payouts/requests/${$page.routeParams.requestId}/reviews`,
                data: $scope.review,
            }, function () {
                $scope.reviews.load()
            }).send();
        }
    }

    $scope.statusToText = function (text) {
        switch (text) {
            case 'pending':
                return "لم تتم مراجعتها";
            case 'rejected':
                return "تم الرفض";
            case 'approved':
                return "تمت الموافقة";
            default:
                return text;
        }
    }
}
