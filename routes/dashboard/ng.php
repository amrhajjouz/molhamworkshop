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

    /////////////////////// Humans /////////////////////////
    'humans.add' => ['humans/add', 'humans/addHumanController', 'humans.add'],
    'humans.overview' => ['humans/:id', 'humans/overviewHumanController', 'humans.single.overview'],
    'humans.edit' => ['humans/:id/edit', 'humans/editHumanController', 'humans.single.edit'],
    'humans' => ['humans', 'humans/listHumanController', 'humans.list'],

    /////////////////////// Loan Requests /////////////////////////
    'loan-requests.add' => ['loan-requests/add', 'loanRequest/addLoanRequestController', 'loanRequest.add'],
    'loan-requests.overview' => ['loan-requests/:id', 'loanRequest/overviewLoanRequestController', 'loanRequest.single.overview'],
    'loan-requests.edit' => ['loan-requests/:id/edit', 'loanRequest/editLoanRequestController', 'loanRequest.single.edit'],
    'loan-requests' => ['loan-requests', 'loanRequest/listLoanRequestController', 'loanRequest.list'],

    /////////////////////// Advance Payment Requests /////////////////////////
    'advance-payment-requests.add' => ['advance-payment-requests/add', 'advancePaymentRequest/addAdvancePaymentRequestController', 'advancePaymentRequest.add'],
    'advance-payment-requests.overview' => ['advance-payment-requests/:id', 'advancePaymentRequest/overviewAdvancePaymentRequestController', 'advancePaymentRequest.single.overview'],
    'advance-payment-requests.edit' => ['advance-payment-requests/:id/edit', 'advancePaymentRequest/editAdvancePaymentRequestController', 'advancePaymentRequest.single.edit'],
    'advance-payment-requests' => ['advance-payment-requests', 'advancePaymentRequest/listAdvancePaymentRequestController', 'advancePaymentRequest.list'],

];
