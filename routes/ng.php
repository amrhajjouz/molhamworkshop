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
    'sponsorships.add' => ['sponsorships/add', 'sponsorships/addSponsorShipsController', 'sponsorships.add'],
    'sponsorships.overview' => ['sponsorships/:id', 'sponsorships/overviewSponsorShipsController', 'sponsorships.single.overview'],
    'sponsorships.edit' => ['sponsorships/:id/edit', 'sponsorships/editSponsorShipsController', 'sponsorships.single.edit'],
    'sponsorships' => ['sponsorships', 'sponsorships/listsSponsorShipsController', 'sponsorships.list'],
 
    ////////////////////// Students Routes    ///////////////////
    'students.add' => ['students/add', 'students/addStudentsController', 'students.add'],
    'students.overview' => ['students/:id', 'students/overviewStudentsController', 'students.single.overview'],
    'students.edit' => ['students/:id/edit', 'students/editStudentsController', 'students.single.edit'],
    'students' => ['students', 'students/listStudentsController', 'students.list'],
 
    /////////////////////////// Events Routes    ///////////////////
    'events.add' => ['events/add', 'events/addEventsController', 'events.add'],
    'events.overview' => ['events/:id', 'events/overviewEventsController', 'events.single.overview'],
    'events.edit' => ['events/:id/edit', 'events/editEventsController', 'events.single.edit'],
    'events' => ['events', 'events/listEventsController', 'events.list'],
  
    /////////////////////////// Fundraisers Routes    ///////////////////
    'fundraisers.add' => ['fundraisers/add', 'fundraisers/addFundraisersController', 'fundraisers.add'],
    'fundraisers.overview' => ['fundraisers/:id', 'fundraisers/overviewFundraisersController', 'fundraisers.single.overview'],
    'fundraisers.edit' => ['fundraisers/:id/edit', 'fundraisers/editFundraisersController', 'fundraisers.single.edit'],
    'fundraisers' => ['fundraisers', 'fundraisers/listFundraisersController', 'fundraisers.list'],
   
    /////////////////////// Places /////////////////////////
    
    'places.add' => ['places/add', 'places/addPlacesController', 'places.add'],
    'places.overview' => ['places/:id', 'places/overviewPlacesController', 'places.single.overview'],
    'places.edit' => ['places/:id/edit', 'places/editPlacesController', 'places.single.edit'],
    'places' => ['places', 'places/listPlacesController', 'places.list'],
    
   ];

