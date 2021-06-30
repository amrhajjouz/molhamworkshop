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
    'users.add' => ['users/add', 'users/addUserController', 'users.add' , ['*']],
    'users.overview' => ['users/:id', 'users/overviewUserController', 'users.single.overview' , ['*']],
    'users.edit' => ['users/:id/edit', 'users/editUserController', 'users.single.edit' , ['*']],
    'users' => ['users', 'users/listUsersController', 'users.list' , ['*']],
    'users.permissions' => ['users/:id/permissions', 'users/listUserPermissionsController', 'users.single.permissions' , ['*']],
    'users.roles' => ['users/:id/roles', 'users/listUserRolesController', 'users.single.roles' , ['*']],
    'users.logs' => ['users/:id/logs', 'users/listUserLogsController', 'users.single.logs', ['*']],
    'users.activities' => ['users/:id/activities', 'users/listUserActivitiesController', 'users.single.activities', ['*']],

    //Donors Routes
    'donors' => ['donors', 'donors/listDonorsController', 'donors.list' , ['donors.view']],
    'donors.add' => ['donors/add', 'donors/addDonorController', 'donors.add' , ['donors.create']],
    'donors.overview' => ['donors/:id', 'donors/overviewDonorController', 'donors.single.overview' , ['donors.view']],
    'donors.edit' => ['donors/:id/edit', 'donors/editDonorController', 'donors.single.edit' , ['donors.update']],
    'donors.logs' => ['donors/:id/logs', 'donors/listDonorLogsController', 'donors.single.logs' , ['donors.view']],

    /////////////////////// Roles /////////////////////////
    'roles' => ['roles', 'roles/listRolesController', 'roles.list' , ['*']],
    'roles.add' => ['roles/add', 'roles/addRoleController', 'roles.add' , ['*']],
    'roles.overview' => ['roles/:id', 'roles/overviewRoleController', 'roles.single.overview' , ['*']],
    'roles.edit' => ['roles/:id/edit', 'roles/editRoleController', 'roles.single.edit' , ['*']],
    'roles.permissions' => ['roles/:id/permissions', 'roles/listRolePermissionsController', 'roles.single.permissions' , ['*']],

    /////////////////////// Permissions /////////////////////////
    'permissions' => ['permissions', 'permissions/listPermissionsController', 'permissions.list' , ['*']],
    'permissions.add' => ['permissions/add', 'permissions/addPermissionController', 'permissions.add' , ['*']],
    'permissions.overview' => ['permissions/:id', 'permissions/overviewPermissionController', 'permissions.single.overview' , ['*']],
    'permissions.edit' => ['permissions/:id/edit', 'permissions/editPermissionController', 'permissions.single.edit' , ['*']],

    /////////////////////// Activities /////////////////////////
    'activities' => ['activities', 'activities/listActivitiesController', 'activities.list' , ['*']],
    'activities.add' => ['activities/add', 'activities/addActivityController', 'activities.add' , ['*']],
    'activities.overview' => ['activities/:id', 'activities/overviewActivityController', 'activities.single.overview' , ['*']],
    'activities.edit' => ['activities/:id/edit', 'activities/editActivityController', 'activities.single.edit' , ['*']],


];
