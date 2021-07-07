<?php

return [

    // Route structure: {name} => [{url}, {controller_path}, {template_path}]

    // Basic Routes
    'home' => ['/', 'homeController', 'home'],
    '404' => ['/404', 'basics/notFoundController', 'basics.404'],

    // Profile Routes
    'profile.info' => ['/profile/info', 'profile/profileInfoController', 'profile.info'],
    'profile.password' => ['/profile/password', 'profile/profilePasswordController', 'profile.password'],
    'profile.notifications' => ['profile/notifications', 'profile/listProfileNotificationsController', 'profile.notifications'],

    // Users Routes
    'users.add' => ['users/add', 'users/addUserController', 'users.add'],
    'users.overview' => ['users/:id', 'users/overviewUserController', 'users.single.overview'],
    'users.edit' => ['users/:id/edit', 'users/editUserController', 'users.single.edit'],
    'users' => ['users', 'users/listUsersController', 'users.list'],
    'users.notifications' => ['users/:id/notifications', 'users/listUserNotificationsController', 'users.single.notifications'],

    //Donors Routes
    'donors' => ['donors', 'donors/listDonorsController', 'donors.list'],
    'donors.add' => ['donors/add', 'donors/addDonorController', 'donors.add'],
    'donors.overview' => ['donors/:id', 'donors/overviewDonorController', 'donors.single.overview'],
    'donors.edit' => ['donors/:id/edit', 'donors/editDonorController', 'donors.single.edit'],

    /////////////////////// Notifications /////////////////////////
    'notifications' => ['notifications', 'notifications/listNotificationsController', 'notifications.list', ['*']],
    'notifications.add' => ['notifications/add', 'notifications/addNotificationController', 'notifications.add', ['*']],
    'notifications.overview' => ['notifications/:id', 'notifications/overviewNotificationController', 'notifications.single.overview', ['*']],
    'notifications.edit' => ['notifications/:id/edit', 'notifications/editNotificationController', 'notifications.single.edit', ['*']],


];
