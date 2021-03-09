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
    
    // Cases Routes
    'cases.add' => ['cases/add', 'cases/addCaseController', 'cases.add'],
    'cases.overview' => ['cases/:id', 'cases/overviewCasesController', 'cases.single.overview'],
    'cases.edit' => ['cases/:id/edit', 'cases/editCaseController', 'cases.single.edit'],
    'cases' => ['cases', 'cases/listCasesController', 'cases.list'],
    
    // // Campaign Routes
    // 'cases.add' => ['Campaigns/add', 'Campaigns/addCampaignController', 'Campaigns.add'],
    // 'Campaigns.overview' => ['Campaigns/:id', 'Campaigns/overviewCampaignsController', 'Campaigns.single.overview'],
    // 'Campaigns.edit' => ['Campaigns/:id/edit', 'Campaigns/editCampaignController', 'Campaigns.single.edit'],
    // 'Campaigns' => ['Campaigns', 'Campaigns/listCampaignsController', 'Campaigns.list'],
];