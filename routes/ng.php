<?php

return [
    
    // Route structure: {name} => [{url}, {controller_path}, {template_path}]
    
    // Basic Routes
    'home' => ['/', 'homeController', 'home'],
    '404' => ['/404', 'notFoundController', '404'],
    
    // Profile Routes
    'profile.info' => ['/profile/info', 'profile/profileInfoController', 'profile.info'],
    'profile.password' => ['/profile/password', 'profile/profilePasswordController', 'profile.password'],
    
    // Volunteers Routes
    'volunteers' => ['/volunteers', 'listVolunteersController', 'volunteers.list'],
    'volunteers.add' => ['/volunteers/add',  'addVolunteerController', 'volunteers.add'],
    
    'users.add' => ['users/add', 'users/addUserController', 'users.add'],
    'users.overview' => ['users/:id', 'users/overviewUserController', 'users.single.overview'],
    'users.edit' => ['users/:id/edit', 'users/editUserController', 'users.single.edit'],
];