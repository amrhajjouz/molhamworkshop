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
    
    /////////////////////// Constants /////////////////////////
    'constants.add' => ['constants/add', 'constants/addConstantController', 'constants.add'],
    'constants.overview' => ['constants/:id', 'constants/overviewConstantController', 'constants.single.overview'],
    'constants.edit' => ['constants/:id/edit', 'constants/editConstantController', 'constants.single.edit'],
    'constants' => ['constants', 'constants/listConstantsController', 'constants.list'],

];
