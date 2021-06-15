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

    /////////////////////// Roles /////////////////////////
    'roles' => ['roles', 'roles/listRolesController', 'roles.list'],
    'roles.add' => ['roles/add', 'roles/addRoleController', 'roles.add'],
    'roles.overview' => ['roles/:id', 'roles/overviewRoleController', 'roles.single.overview'],
    'roles.edit' => ['roles/:id/edit', 'roles/editRoleController', 'roles.single.edit'],
    'roles.permissions' => ['roles/:id/permissions', 'roles/listRolePermissionsController', 'roles.single.permissions'],

    /////////////////////// Permissions /////////////////////////
    'permissions' => ['permissions', 'permissions/listPermissionsController', 'permissions.list'],
    'permissions.add' => ['permissions/add', 'permissions/addPermissionController', 'permissions.add'],
    'permissions.overview' => ['permissions/:id', 'permissions/overviewPermissionController', 'permissions.single.overview'],
    'permissions.edit' => ['permissions/:id/edit', 'permissions/editPermissionController', 'permissions.single.edit'],


];
