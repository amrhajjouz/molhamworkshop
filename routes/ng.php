<?php

return [
    
    // Route structure: {name} => [{url}, {controller_path}, {template_path}]
    
    // Basic Routes
    'home' => ['/', 'homeController', 'home'],
    '404' => ['/404', 'notFoundController', 'basics.404'],
    
    // Profile Routes
    'profile.info' => ['/profile/info', 'profile/profileInfoController', 'profile.info'],
    'profile.password' => ['/profile/password', 'profile/profilePasswordController', 'profile.password'],
    
    // Users Routes
    'users.add' => ['users/add', 'users/addUserController', 'users.add'],
    'users.overview' => ['users/:id', 'users/overviewUserController', 'users.single.overview'],
    'users.edit' => ['users/:id/edit', 'users/editUserController', 'users.single.edit'],
    'users' => ['users', 'users/listUsersController', 'users.list'],
];