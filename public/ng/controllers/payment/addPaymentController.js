async function addPaymentControllerInit($apiRequest) {
    return {
        countries: await $apiRequest.config("countries").getData(),
        deduction_ratios: await $apiRequest.config('deduction_ratios').getData()
    };
}

function addPaymentController($scope, $apiRequest, $page, $init) {
//todo : move all snake case scope to camelCase :/
    $scope.countries = $init.countries;
    $scope.deductionRatios = $init.deduction_ratios;

    function init() {
        $scope.selectedAccount = {};
        $scope.completionPercent = 1;
        $scope.purposeItem = {
            section_name: '-',
            account_name: '-',
            program_name: '-',
            name: '-',
            title: '-',
            amount: 0,
            ratio: 0,
            purpose_id: 0,
            deduction_ratio_amount: 0,
            deduction_ratio_id: 0,
        };

        $scope.payment = {
            fx_rate: 0,
            expectedTotalAmount: 0,
            totalAmountDeductionRatio: 0,
            totalAmountWithoutDeductionRatio: 0,
            calculatedTotalAmount: 0,
            purposes: [],
        };
    }

    init();

    $scope.onAnyAmountChange = function(){
        $scope.payment.expectedTotalAmount = $scope.payment.expectedTotalAmountInFx * $scope.payment.fx_rate
        $scope.totalCalculation();
        $scope.updatePercentage();
    }

    $scope.totalCalculation = function () {
        $scope.payment.calculatedTotalAmount = $scope.payment.purposes.reduce((a, n) => a + Number(n.amount), 0);
        $scope.payment.calculatedDeductionRatio = $scope.payment.purposes.reduce((a, n) => a + (n.amount * n.ratio / 100), 0);
        $scope.payment.totalAmountWithoutDeductionRatio = $scope.payment.calculatedTotalAmount - $scope.payment.totalAmountDeductionRatio;
    }

    $scope.onAccountSelection = function (selections) {
        $scope.selectedAccount = selections[0];
        $scope.payment.fx_rate = selections[0].fx_rate;
        $scope.onAnyAmountChange();
    }

    $scope.onDeductionRatioSelection = function (item, selections) {
        const selected = selections[0];
        item.ratio = selected.ratio
        calculateDeductionRatio(item);
        $scope.onAnyAmountChange();
    }

    $scope.onItemAmountChange = function (item) {
        if (item.amount === undefined) {
            return;
        }
        calculateDeductionRatio(item)
        $scope.onAnyAmountChange();
    }

    $scope.onFxCurrencyChange = function () {
        $scope.onAnyAmountChange();
    }

    $scope.onExpectedTotalAmountChange = function () {
        $scope.onAnyAmountChange();
    }

    $scope.updatePercentage = function () {
        if ($scope.payment.expectedTotalAmount > 0)
            $scope.completionPercent = ($scope.payment.calculatedTotalAmount * 100) / $scope.payment.expectedTotalAmount
        colorSelection();
    }

    $scope.onPurposeSelection = function (item, index, selections) {
        const selected = selections[0];
        item.title = selected.title;
        item.name = selected.name;
        item.currency = selected.currency;
        item.program_name = selected.program_name;
        item.account_name = selected.account_name;
        item.section_name = selected.section_name;
        item.deduction_ratio = selected.deductionRatio;
        item.ratio = item.deduction_ratio.ratio;
        $('#deduction_ratios_' + index).empty()
            .append($("<option/>") //add option tag in select
                .val(item.deduction_ratio.id) //set value for option to post it
                .text(item.deduction_ratio.title)) //set a text for show in select
            .val(item.deduction_ratio.id) //select option of select2
            .trigger("change"); //apply to select2
        calculateDeductionRatio(item)
        $scope.onAnyAmountChange();
    }

    $scope.updateFxCurrency = function () {
        const selectedCurrencyCode = $scope.selectedAccount.currency;

        if (selectedCurrencyCode === undefined) {
            return;
        }

        $apiRequest.config({
            method: 'get',
            url: `currencies/${selectedCurrencyCode}/rate`,
        }, function (response, data) {
            $scope.payment.fx_rate = data;
            $scope.onAnyAmountChange();
        }).send();
    }

    $scope.addNewPurpose = function () {
        const item = angular.copy($scope.purposeItem);
        $scope.payment.purposes.push(item)
        const amount = $scope.payment.expectedTotalAmount - $scope.payment.calculatedTotalAmount;
        if (amount >= 0) {
            item.amount = amount;
            $scope.onAnyAmountChange();
        }
    }

    $scope.deletePurpose = function (x) {
        const index = $scope.payment.purposes.indexOf(x);
        $scope.payment.purposes.splice(index, 1);
        $scope.onAnyAmountChange();
    }

    function calculateDeductionRatio(item) {
        item.deduction_ratio_amount = (item.amount * item.ratio / 100);
    }

    function colorSelection() {
        let percentage = Number($scope.completionPercent);
        switch (true) {
            case percentage > 100 :
                $scope.selectedColor = "#e63757"
                break;
            case percentage === 100 :
                $scope.selectedColor = "#28a745"
                break;
            case percentage >= 80 :
                $scope.selectedColor = "#2c7be5"
                break;
            case percentage >= 35 :
                $scope.selectedColor = "#f6c343"
                break;
            case percentage >= 0 :
                $scope.selectedColor = "#e63757"
                break;
        }
    }

    $scope.addNewPurpose();

    $scope.createPayment = $apiRequest.config({
        method: 'POST',
        url: 'payments',
        data: $scope.payment,
    }, function (response, data) {
        alert("done")
        //    init($scope); //reset everything
    });

    $scope.navigateToPaymentList = function () {
        $page.navigate('payments');
    }
}
