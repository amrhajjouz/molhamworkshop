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

    /////////////////////// Boards /////////////////////////
    'boards.add' => ['boards/add', 'boards/addBoardController', 'boards.add'],
    'boards.overview' => ['boards/:id', 'boards/overviewBoardController', 'boards.single.overview'],
    'boards.tasks' => ['boards/:id/tasks', 'boards/tasksBoardController', 'boards.single.tasks'],
    'boards.edit' => ['boards/:id/edit', 'boards/editBoardController', 'boards.single.edit'],
    'boards' => ['boards', 'boards/listBoardsController', 'boards.list'],

    /////////////////////// Labels /////////////////////////
    'labels.add' => ['labels/add', 'labels/addLabelController', 'labels.add'],
    'labels.overview' => ['labels/:id', 'labels/overviewLabelController', 'labels.single.overview'],
    'labels.edit' => ['labels/:id/edit', 'labels/editLabelController', 'labels.single.edit'],
    'labels' => ['labels', 'labels/listLabelsController', 'labels.list'],

];
