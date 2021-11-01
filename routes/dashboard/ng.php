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

    /////////////////////// Places /////////////////////////
    'places.add' => ['places/add', 'places/addPlaceController', 'places.add'],
    'places.overview' => ['places/:id', 'places/overviewPlaceController', 'places.single.overview'],
    'places.edit' => ['places/:id/edit', 'places/editPlaceController', 'places.single.edit'],
    'places' => ['places', 'places/listPlacesController', 'places.list'],

    //account Routes
    'account-branches.main' => ['account-branches/main', 'account_branch/listAccountBranchesController', 'account_branch.list'],
    'account-branches.overview' => ['account-branches/:id/overview', 'account_branch/overviewAccountBranchesController', 'account_branch.single.overview'],

    'accounts' => ['accounts', 'accounts/listAccountsController', 'accounts.list'],
    'accounts.overview' => ['accounts/:id/overview', 'accounts/overviewAccountsController', 'accounts.single.overview'],

    //deduction Ratios Routes
    'deduction-ratios' => ['deduction-ratios', 'deduction_ratios/listDeductionRatiosController', 'deduction_ratios.list'],
    'deduction-ratios.add' => ['deduction-ratios/add', 'deduction_ratios/addDeductionRatiosController', 'deduction_ratios.add'],
    'deduction-ratios.edit' => ['deduction-ratios/:id/edit', 'deduction_ratios/editDeductionRatiosController', 'deduction_ratios.single.edit'],

    //payment
    'transactions.list' => ['transactions/:account_id', 'transaction/listTransactionsController', 'transaction.list'],
    'payments' => ['payments', 'payment/listPaymentController', 'payment.list'],
    'donations' => ['donations', 'payment/listDonationController', 'payment.list-donations'],
    'payments.add' => ['payments/add', 'payment/addPaymentController', 'payment.add'],
    //  'payments.overview' => ['payments/:id', 'payment/overviewPaymentController', 'payment.single.overview'],//'payments.edit' => ['payments/:id/edit', 'payment/editPaymentController', 'payment.single.edit'],
];
