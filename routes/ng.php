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

    // Profile Routes
    'profile.info' => ['/profile/info', 'profile/profileInfoController', 'profile.info'],
    'profile.password' => ['/profile/password', 'profile/profilePasswordController', 'profile.password'],

    // Users Routes
    'users.add' => ['users/add', 'users/addUserController', 'users.add'],
    'users.overview' => ['users/:id', 'users/overviewUserController', 'users.single.overview'],
    'users.edit' => ['users/:id/edit', 'users/editUserController', 'users.single.edit'],
    'users' => ['users', 'users/listUsersController', 'users.list'],

    //////////////////////// Cases Routes //////////////////////
    'cases.add' => ['cases/add', 'cases/addCaseController', 'cases.add'],
    'cases.overview' => ['cases/:id', 'cases/overviewCaseController', 'cases.single.overview'],
    'cases.edit' => ['cases/:id/edit', 'cases/editCaseController', 'cases.single.edit'],
    'cases' => ['cases', 'cases/listCasesController', 'cases.list'],
    // 'cases.admins' => ['cases/:id/admins', 'cases/listCaseAdminsController', 'cases.single.admins'],
    'cases.contents' => ['cases/:id/contents', 'cases/caseContentsController', 'cases.single.contents'],

    ////////////////////// Campaign Routes    ///////////////////
    'campaigns.add' => ['campaigns/add', 'campaigns/addCampaignController', 'campaigns.add'],
    'campaigns.overview' => ['campaigns/:id', 'campaigns/overviewCampaignController', 'campaigns.single.overview'],
    'campaigns.edit' => ['campaigns/:id/edit', 'campaigns/editCampaignController', 'campaigns.single.edit'],
    'campaigns' => ['campaigns', 'campaigns/listCampaignsController', 'campaigns.list'],
    'campaigns.contents' => ['campaigns/:id/contents', 'campaigns/campaignContentsController', 'campaigns.single.contents'],

    ////////////////////// SponsorShip Routes    ///////////////////
    'sponsorships.add' => ['sponsorships/add', 'sponsorships/addSponsorshipController', 'sponsorships.add'],
    'sponsorships.overview' => ['sponsorships/:id', 'sponsorships/overviewSponsorshipController', 'sponsorships.single.overview'],
    'sponsorships.edit' => ['sponsorships/:id/edit', 'sponsorships/editSponsorshipController', 'sponsorships.single.edit'],
    'sponsorships.sponsors' => ['sponsorships/:id/sponsors', 'sponsorships/listSponsorshipSponsorsController', 'sponsorships.single.sponsors'],
    'sponsorships' => ['sponsorships', 'sponsorships/listsSponsorshipsController', 'sponsorships.list'],
    'sponsorships.contents' => ['sponsorships/:id/contents', 'sponsorships/sponsorshipContentsController', 'sponsorships.single.contents'],
    
    ////////////////////// Students Routes    ///////////////////
    'students.add' => ['students/add', 'students/addStudentController', 'students.add'],
    'students.overview' => ['students/:id', 'students/overviewStudentController', 'students.single.overview'],
    'students.edit' => ['students/:id/edit', 'students/editStudentController', 'students.single.edit'],
    'students.sponsors' => ['students/:id/sponsors', 'students/listStudentSponsorsController', 'students.single.sponsors'],
    'students' => ['students', 'students/listStudentsController', 'students.list'],
    'students.contents' => ['students/:id/contents', 'students/studentContentsController', 'students.single.contents'],
    
    /////////////////////////// Events Routes    ///////////////////
    'events.add' => ['events/add', 'events/addEventController', 'events.add'],
    'events.overview' => ['events/:id', 'events/overviewEventController', 'events.single.overview'],
    'events.edit' => ['events/:id/edit', 'events/editEventController', 'events.single.edit'],
    'events' => ['events', 'events/listEventsController', 'events.list'],
    'events.contents' => ['events/:id/contents', 'events/eventContentsController', 'events.single.contents'],

    /////////////////////////// Fundraisers Routes    ///////////////////
    'fundraisers.add' => ['fundraisers/add', 'fundraisers/addFundraiserController', 'fundraisers.add'],
    'fundraisers.overview' => ['fundraisers/:id', 'fundraisers/overviewFundraiserController', 'fundraisers.single.overview'],
    'fundraisers.edit' => ['fundraisers/:id/edit', 'fundraisers/editFundraiserController', 'fundraisers.single.edit'],
    'fundraisers' => ['fundraisers', 'fundraisers/listFundraisersController', 'fundraisers.list'],
    'fundraisers.contents' => ['fundraisers/:id/contents', 'fundraisers/fundraiserContentsController', 'fundraisers.single.contents'],


    /////////////////////// Places /////////////////////////

    'places.add' => ['places/add', 'places/addPlaceController', 'places.add'],
    'places.overview' => ['places/:id', 'places/overviewPlaceController', 'places.single.overview'],
    'places.edit' => ['places/:id/edit', 'places/editPlaceController', 'places.single.edit'],
    'places' => ['places', 'places/listPlacesController', 'places.list'],
    
    
    /////////////////////// Constants /////////////////////////
    'constants.add' => ['constants/add', 'constants/addConstantController', 'constants.add'],
    'constants.overview' => ['constants/:id', 'constants/overviewConstantController', 'constants.single.overview'],
    'constants.edit' => ['constants/:id/edit', 'constants/editConstantController', 'constants.single.edit'],
    'constants' => ['constants', 'constants/listConstantsController', 'constants.list'],

    /////////////////////// FAQS /////////////////////////
    'faqs.add' => ['faqs/add', 'faqs/addFaqController', 'faqs.add'],
    'faqs.overview' => ['faqs/:id', 'faqs/overviewFaqController', 'faqs.single.overview'],
    'faqs.edit' => ['faqs/:id/edit', 'faqs/editFaqController', 'faqs.single.edit'],
    'faqs' => ['faqs', 'faqs/listFaqsController', 'faqs.list'],


    //Donors Routes
    'donors' => ['donors', 'donors/listDonorsController', 'donors.list'],
    'donors.add' => ['donors/add', 'donors/addDonorController', 'donors.add'],
    'donors.overview' => ['donors/:id', 'donors/overviewDonorController', 'donors.single.overview'],
    'donors.edit' => ['donors/:id/edit', 'donors/editDonorController', 'donors.single.edit'],


];
