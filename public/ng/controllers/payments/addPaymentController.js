async function addPaymentControllerInit($page, $apiRequest) {
    return {
        countries: await $apiRequest.config('countries').getData(),
        currencies: await $apiRequest.config('currencies').getData(),
        languages: await $apiRequest.config('languages').getData()
    }
}

function addPaymentController($scope, $apiRequest, $page, $init) {
    $scope.countries = $init.countries;
    $scope.currencies = $init.currencies;
    $scope.languages = $init.languages;
    $scope.payment = {
        purposes: [
            {}
        ]
    };

    $scope.addNewPurpose = function () {
        $scope.payment.purposes.push({amount: 0,purpose_type:0})
    }

    $scope.calculateTotalAmount = function () {
        $scope.totalAmount =  $scope.payment.purposes.reduce((a, n) => a + Number(n.amount), 0);
    }

    $scope.deletePurpose = function (x) {
        const index = $scope.payment.purposes.indexOf(x);
        $scope.payment.purposes.splice(index, 1);
    }

    $scope.createPayment = $apiRequest.config({
        method: 'POST',
        url: 'payments',
        data: $scope.payment,
    }, function (response, data) {
        //$page.navigate('receivers.overview', {id: data.id}); //todo when we get everything ready from mouhammad
    });
}
