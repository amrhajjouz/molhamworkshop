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

    /////////////////////// Constants /////////////////////////
    'constants.add' => ['constants/add', 'constants/addConstantController', 'constants.add'],
    'constants.overview' => ['constants/:id', 'constants/overviewConstantController', 'constants.single.overview'],
    'constants.edit' => ['constants/:id/edit', 'constants/editConstantController', 'constants.single.edit'],
    'constants' => ['constants', 'constants/listConstantsController', 'constants.list'],

    /////////////////////// Shortcuts /////////////////////////
    'shortcuts.add' => ['shortcuts/add', 'shortcuts/addShortcutController', 'shortcuts.add'],
    'shortcuts.overview' => ['shortcuts/:id', 'shortcuts/overviewShortcutController', 'shortcuts.single.overview'],
    'shortcuts.edit' => ['shortcuts/:id/edit', 'shortcuts/editShortcutController', 'shortcuts.single.edit'],
    'shortcuts.keys' => ['shortcuts/:id/keys', 'shortcuts/listShortcutKeysController', 'shortcuts.single.keys'],
    'shortcuts' => ['shortcuts', 'shortcuts/listShortcutsController', 'shortcuts.list'],

    /////////////////////////// Pages Routes    ///////////////////
    'pages.add' => ['pages/add', 'pages/addPageController', 'pages.add'],
    'pages.overview' => ['pages/:id', 'pages/overviewPageController', 'pages.single.overview'],
    'pages.edit' => ['pages/:id/edit', 'pages/editPageController', 'pages.single.edit'],
    'pages' => ['pages', 'pages/listPagesController', 'pages.list'],

    /////////////////////////// Blogs Routes    ///////////////////
    'blogs.add' => ['blogs/add', 'blogs/addBlogController', 'blogs.add'],
    'blogs.overview' => ['blogs/:id', 'blogs/overviewBlogController', 'blogs.single.overview'],
    'blogs.edit' => ['blogs/:id/edit', 'blogs/editBlogController', 'blogs.single.edit'],
    'blogs' => ['blogs', 'blogs/listBlogsController', 'blogs.list'],
    
];
