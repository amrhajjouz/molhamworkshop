<?php

return [
    
    // Route structure: {name} => [{url}, {controller_path}, {template_path}]
    
    // Basic Routes
    'home' => ['/', 'homeController', 'home'],
    '404' => ['/404', 'basics/notFoundController', 'basics.404'],
    
    //////////////////////// Profile Routes //////////////////////
    'profile.info' => ['/profile/info', 'profile/profileInfoController', 'profile.info'],
    'profile.password' => ['/profile/password', 'profile/profilePasswordController', 'profile.password'],
    
    ////////////////////// Users Routes //////////////////////
    'users.add' => ['users/add', 'users/addUserController', 'users.add'],
    'users.overview' => ['users/:id', 'users/overviewUserController', 'users.single.overview'],
    'users.edit' => ['users/:id/edit', 'users/editUserController', 'users.single.edit'],
    'users' => ['users', 'users/listUsersController', 'users.list'],
    
    //////////////////////// Cases Routes //////////////////////
    'cases.add' => ['cases/add', 'cases/addCaseController', 'cases.add'],
    'cases.overview' => ['cases/:id', 'cases/overviewCasesController', 'cases.single.overview'],
    'cases.edit' => ['cases/:id/edit', 'cases/editCaseController', 'cases.single.edit'],
    'cases' => ['cases', 'cases/listCasesController', 'cases.list'],
    
    ////////////////////// Campaign Routes    ///////////////////
    'campaigns.add' => ['campaigns/add', 'campaigns/addCampaignController', 'campaigns.add'],
    'campaigns.overview' => ['campaigns/:id', 'campaigns/overviewCampaignsController', 'campaigns.single.overview'],
    'campaigns.edit' => ['campaigns/:id/edit', 'campaigns/editCampaignController', 'campaigns.single.edit'],
    'campaigns' => ['campaigns', 'campaigns/listCampaignsController', 'campaigns.list'],
 
    ////////////////////// SponsorShip Routes    ///////////////////
  
    'sponsor_ships.add' => ['sponsor_ships/add', 'sponsor_ships/addSponsorShipsController', 'sponsor_ships.add'],
    'sponsor_ships.overview' => ['sponsor_ships/:id', 'sponsor_ships/overviewSponsorShipsController', 'sponsor_ships.single.overview'],
    'sponsor_ships.edit' => ['sponsor_ships/:id/edit', 'sponsor_ships/editSponsorShipsController', 'sponsor_ships.single.edit'],
    'sponsor_ships' => ['sponsor_ships', 'sponsor_ships/listsSponsorShipsController', 'sponsor_ships.list'],
   ];

