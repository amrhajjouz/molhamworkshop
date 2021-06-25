<?php

return [

    // Route structure: {name} => [{url}, {controller_path}, {template_path}, {permissions:array}]

    // Basic Routes
    'home' => ['/', 'homeController', 'home'],
    '404' => ['/404', 'basics/notFoundController', 'basics.404'],

    // Profile Routes
    'profile.info' => ['/profile/info', 'profile/profileInfoController', 'profile.info'],
    'profile.password' => ['/profile/password', 'profile/profilePasswordController', 'profile.password'],

    // Users Routes
    'users.add' => ['users/add', 'users/addUserController', 'users.add' , ['super_admin']],
    'users.overview' => ['users/:id', 'users/overviewUserController', 'users.single.overview' , ['super_admin']],
    'users.edit' => ['users/:id/edit', 'users/editUserController', 'users.single.edit' , ['super_admin']],
    'users' => ['users', 'users/listUsersController', 'users.list' , ['super_admin']],
    'users.permissions' => ['users/:id/permissions', 'users/listUserPermissionsController', 'users.single.permissions' , ['super_admin']],
    'users.roles' => ['users/:id/roles', 'users/listUserRolesController', 'users.single.roles' , ['super_admin']],

    //Donors Routes
    'donors' => ['donors', 'donors/listDonorsController', 'donors.list' , ['donors.view']],
    'donors.add' => ['donors/add', 'donors/addDonorController', 'donors.add' , ['donors.create']],
    'donors.overview' => ['donors/:id', 'donors/overviewDonorController', 'donors.single.overview' , ['donors.view']],
    'donors.edit' => ['donors/:id/edit', 'donors/editDonorController', 'donors.single.edit' , ['donors.update']],

    /////////////////////// Roles /////////////////////////
    'roles' => ['roles', 'roles/listRolesController', 'roles.list' , ['super_admin']],
    'roles.add' => ['roles/add', 'roles/addRoleController', 'roles.add' , ['super_admin']],
    'roles.overview' => ['roles/:id', 'roles/overviewRoleController', 'roles.single.overview' , ['super_admin']],
    'roles.edit' => ['roles/:id/edit', 'roles/editRoleController', 'roles.single.edit' , ['super_admin']],
    'roles.permissions' => ['roles/:id/permissions', 'roles/listRolePermissionsController', 'roles.single.permissions' , ['super_admin']],

    /////////////////////// Permissions /////////////////////////
    'permissions' => ['permissions', 'permissions/listPermissionsController', 'permissions.list' , ['super_admin']],
    'permissions.add' => ['permissions/add', 'permissions/addPermissionController', 'permissions.add' , ['super_admin']],
    'permissions.overview' => ['permissions/:id', 'permissions/overviewPermissionController', 'permissions.single.overview' , ['super_admin']],
    'permissions.edit' => ['permissions/:id/edit', 'permissions/editPermissionController', 'permissions.single.edit' , ['super_admin']],


];
