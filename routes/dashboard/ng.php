<?php

return [

    // Route structure: {name} => [{url}, {controller_path}, {template_path}]

    // Basic Routes
    'home' => ['/', 'homeController', 'home'],
    '404' => ['/404', 'basics/notFoundController', 'basics.404'],

    // Profile Routes
    'profile.info' => ['/profile/info', 'profile/profileInfoController', 'profile.info'],
    'profile.password' => ['/profile/password', 'profile/profilePasswordController', 'profile.password'],

    // Users Routes
    'users.add' => ['users/add', 'users/addUserController', 'users.add'],
    'users.overview' => ['users/:id', 'users/overviewUserController', 'users.single.overview'],
    'users.edit' => ['users/:id/edit', 'users/editUserController', 'users.single.edit'],
    'users' => ['users', 'users/listUsersController', 'users.list'],

    //Donors Routes
    'donors' => ['donors', 'donors/listDonorsController', 'donors.list'],
    'donors.add' => ['donors/add', 'donors/addDonorController', 'donors.add'],
    'donors.overview' => ['donors/:id', 'donors/overviewDonorController', 'donors.single.overview'],
    'donors.edit' => ['donors/:id/edit', 'donors/editDonorController', 'donors.single.edit'],

    //Receivers Routes
    'receivers' => ['receivers', 'receivers/listReceiverController', 'receivers.list'],
    'receivers.add' => ['receivers/add', 'receivers/addReceiverController', 'receivers.add'],
    'receivers.overview' => ['receivers/:id', 'receivers/overviewReceiverController', 'receivers.single.overview'],
    'receivers.edit' => ['receivers/:id/edit', 'receivers/editReceiverController', 'receivers.single.edit'],
    'receivers.accounts' => ['receivers/:id/accounts', 'receivers/accounts/listAccountsController', 'receivers.single.accounts'],
    'receivers.transactions' => ['receivers/:id/transactions', 'receivers/transactions/listTransactionsController', 'receivers.single.transactions'],

    //payments Routes
    'payments.add' => ['payments/add', 'payments/addPaymentController', 'payments.add'],
    'payments.transfer' => ['payments/transfer', 'payments/transferPaymentController', 'payments.transfer'],

    'transactions.general_fund' => ['general_fund/transactions/', 'general_fund/generalFundTransactionController', 'general_fund.list'],
    'transactions.admin_support' => ['admin_support/transactions/', 'admin_support/adminSupportTransactionController', 'admin_support.list'],
    'payments.received.list' => ['donations/received', 'payments/received/receivedPaymentListController', 'payments.received.list'],
    'payments.spent.list' => ['donations/spent', 'payments/spent/spentPaymentListController', 'payments.spent.list'],
    'donations.list' => ['donations', 'donations/donationListController', 'donations.list'],

    'payouts.requests.list' => ['payouts/requests/list', 'payouts/requests/listPayoutRequestController', 'payouts.requests.list'],
    'payouts.requests.add' => ['payouts/requests/add', 'payouts/requests/addPayoutRequestController', 'payouts.requests.add'],
    'payouts.requests.reviews' => ['payouts/requests/:requestId/reviews', 'payouts/requests/reviewsPayoutRequestController', 'payouts.requests.reviews'],

    'payouts.vouchers.list' => ['payouts/vouchers/list', 'payouts/voucher/listPayoutVoucherController', 'payouts.voucher.list'],
    'agreements.list' => ['agreements/list', 'agreements/listAgreementController', 'agreements.list'],
    'agreements.add' => ['agreements/add', 'agreements/addAgreementController', 'agreements.add'],
    'agreements.edit' => ['agreements/:id/edit', 'agreements/editAgreementController', 'agreements.single.edit'],
    'agreements.assign.vouchers' => ['agreements/:id/assigned-vouchers', 'agreements/assignVouchersController', 'agreements.assign-vouchers']
];
