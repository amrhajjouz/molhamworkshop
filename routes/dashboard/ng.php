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

    //////////////////////// Cases Routes //////////////////////
    'programs.medical.cases.add' => ['programs/medical/cases/add', 'cases/addCaseController', 'cases.add'],
    'programs.medical.cases.overview' => ['programs/medical/cases/:id', 'cases/overviewCaseController', 'cases.single.overview'],
    'programs.medical.cases.edit' => ['programs/medical/cases/:id/edit', 'cases/editCaseController', 'cases.single.edit'],
    'programs.medical.cases.contents' => ['programs/medical/cases/:id/contents', 'cases/contentCaseController', 'cases.single.contents'],
    'programs.medical.cases' => ['programs/medical/cases', 'cases/listCasesController', 'cases.list'],
    
    // Places
    'places.add' => ['places/add', 'places/addPlaceController', 'places.add'],
    'places.overview' => ['places/:id', 'places/overviewPlaceController', 'places.single.overview'],
    'places.edit' => ['places/:id/edit', 'places/editPlaceController', 'places.single.edit'],
    'places' => ['places', 'places/listPlacesController', 'places.list'],


    //////////////////////// Translation Routes //////////////////////
    'translation.cases' => ['translation/cases', 'translation/cases/listCasesTranslationController', 'translation.cases.list'],
    'translation.cases.overview' => ['translation/cases/:id', 'translation/cases/overviewCaseTranslationController', 'translation.cases.single.overview'],
    'translation.cases.edit' => ['translation/cases/:id/edit', 'translation/cases/editCaseTranslationController', 'translation.cases.single.edit'],
  
    //////////////////////// Publishing Routes //////////////////////
    'publishing.cases' => ['publishing/cases', 'publishing/cases/listCasesPublishingController', 'publishing.cases.list'],
    // 'publishing.cases.overview' => ['publishing/cases/:id', 'publishing/cases/overviewCaseTranslationController', 'publishing.cases.single.overview'],
    // 'publishing.cases.edit' => ['publishing/cases/:id/edit', 'publishing/cases/editCaseTranslationController', 'publishing.cases.single.edit'],
];
