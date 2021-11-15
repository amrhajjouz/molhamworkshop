<?php

return [

    // Route structure: {name} => [{url}, {controller_path}, {template_path}]

    // Basic Routes
    'home' => ['/', 'homeController', 'home'],
    '404' => ['/404', 'basics/notFoundController', 'basics.404'],

    // Profile Routes
    'profile.info' => ['/profile/info', 'profile/profileInfoController', 'profile.info'],
    'profile.password' => ['/profile/password', 'profile/profilePasswordController', 'profile.password'],
    'profile.employment-data' => ['/profile/employment-data', 'profile/profileEmploymentDataController', 'profile.employment_data'],
    'profile.residence-data' => ['/profile/residence-data', 'profile/profileResidenceDataController', 'profile.residence_data'],
    'profile.contact-data' => ['/profile/contact-data', 'profile/profileContactDataController', 'profile.contact_data'],
    'profile.experiences-and-skills' => ['/profile/experiences-and-skills', 'profile/profileExperiencesAndSkillsController', 'profile.experiences_and_skills'],
    'profile.additional-data' => ['/profile/additional-data', 'profile/profileAdditionalDataController', 'profile.additional_data'],
    'profile.education' => ['/profile/education', 'profile/profileEducationController', 'profile.education'],

    // Users Routes
    'users' => ['users', 'users/listUsersController', 'users.list'],
    'users.add' => ['users/add', 'users/addUserController', 'users.add'],
    'users.overview' => ['users/:id', 'users/overviewUserController', 'users.single.overview'],
    'users.edit' => ['users/:id/edit', 'users/editUserController', 'users.single.edit'],

    //Donors Routes
    'donors' => ['donors', 'donors/listDonorsController', 'donors.list'],
    'donors.add' => ['donors/add', 'donors/addDonorController', 'donors.add'],
    'donors.overview' => ['donors/:id', 'donors/overviewDonorController', 'donors.single.overview'],
    'donors.edit' => ['donors/:id/edit', 'donors/editDonorController', 'donors.single.edit'],

    /////////////////////// Places /////////////////////////
    'places' => ['places', 'places/listPlacesController', 'places.list'],
    'places.add' => ['places/add', 'places/addPlaceController', 'places.add'],
    'places.overview' => ['places/:id', 'places/overviewPlaceController', 'places.single.overview'],
    'places.edit' => ['places/:id/edit', 'places/editPlaceController', 'places.single.edit'],

    //Member Routes
    'members' => ['members', 'members/listMembersController', 'members.list'],
    'members.add' => ['members/add', 'members/addMemberController', 'members.add'],
    'members.overview' => ['members/:id', 'members/overviewMemberController', 'members.single.overview'],
    'members.edit' => ['members/:id/edit', 'members/editMemberController', 'members.single.edit'],

    //Loan Requests
    'loan-requests' => ['loan-requests', 'loanRequest/listLoanRequestController', 'loanRequest.list'],
    'loan-requests.add' => ['loan-requests/add', 'loanRequest/addLoanRequestController', 'loanRequest.add'],
    'loan-requests.overview' => ['loan-requests/:id', 'loanRequest/overviewLoanRequestController', 'loanRequest.single.overview'],
    'loan-requests.edit' => ['loan-requests/:id/edit', 'loanRequest/editLoanRequestController', 'loanRequest.single.edit'],

    //Advance Payment Requests
    'advance-payment-requests' => ['advance-payment-requests', 'advancePaymentRequest/listAdvancePaymentRequestController', 'advancePaymentRequest.list'],
    'advance-payment-requests.add' => ['advance-payment-requests/add', 'advancePaymentRequest/addAdvancePaymentRequestController', 'advancePaymentRequest.add'],
    'advance-payment-requests.overview' => ['advance-payment-requests/:id', 'advancePaymentRequest/overviewAdvancePaymentRequestController', 'advancePaymentRequest.single.overview'],
    'advance-payment-requests.edit' => ['advance-payment-requests/:id/edit', 'advancePaymentRequest/editAdvancePaymentRequestController', 'advancePaymentRequest.single.edit'],

    //Travel Requests
    'travel-requests' => ['travel-requests', 'travelRequest/listTravelRequestController', 'travelRequest.list'],
    'travel-requests.add' => ['travel-requests/add', 'travelRequest/addTravelRequestController', 'travelRequest.add'],
    'travel-requests.overview' => ['travel-requests/:id', 'travelRequest/overviewTravelRequestController', 'travelRequest.single.overview'],
    'travel-requests.edit' => ['travel-requests/:id/edit', 'travelRequest/editTravelRequestController', 'travelRequest.single.edit'],

    //User Family Members
    'user-family-members' => ['user-family-members', 'userFamilyMember/listUserFamilyMemberController', 'userFamilyMember.list'],
    'user-family-members.add' => ['user-family-members/add', 'userFamilyMember/addUserFamilyMemberController', 'userFamilyMember.add'],
    'user-family-members.overview' => ['user-family-members/:id', 'userFamilyMember/overviewUserFamilyMemberController', 'userFamilyMember.single.overview'],
    'user-family-members.edit' => ['user-family-members/:id/edit', 'userFamilyMember/editUserFamilyMemberController', 'userFamilyMember.single.edit'],

    //User Contracts
    'user-contracts' => ['user-contracts', 'userContract/listUserContractController', 'userContract.list'],
    'user-contracts.add' => ['user-contracts/add/:id', 'userContract/addUserContractController', 'userContract.add'],
    'user-contracts.overview' => ['user-contracts/:id', 'userContract/overviewUserContractController', 'userContract.single.overview'],
    'user-contracts.edit' => ['user-contracts/:id/edit', 'userContract/editUserContractController', 'userContract.single.edit'],

];
