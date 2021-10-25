async function listAgreementControllerInit($datalist) {
    return {
        agreements: await $datalist(`agreements`, true).load()
    }
}

function listAgreementController($scope, $init,$apiRequest) {
    $scope.agreements = $init.agreements;
    $scope.statusToText = function(status){
        switch (status){
            case "pending":
                return "جارية";
            case "completed":
                return "جاهزة";
            case "canceled":
                return "ملغية";
        }
    }

    $scope.updateAgreementState = function(state,item){
        if (!confirm('هل أنت متأكد من العملية؟')) {
            return;
        }
        $apiRequest.config({
            method: 'POST',
            url: `agreements/${item.id}/update-state`,
            data: {status:state},
        }, function () {
            $scope.agreements.load();
        }).send();
    }
}
