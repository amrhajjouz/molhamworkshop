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

    /////////////////////// Places /////////////////////////
    'places.add' => ['places/add', 'places/addPlaceController', 'places.add'],
    'places.overview' => ['places/:id', 'places/overviewPlaceController', 'places.single.overview'],
    'places.edit' => ['places/:id/edit', 'places/editPlaceController', 'places.single.edit'],
    'places' => ['places', 'places/listPlacesController', 'places.list'],

     //////////////////////// Translation Routes //////////////////////
     'translation.social_media_posts' => ['translation/social-media-posts', 'translation/social_media_posts/listTranslationSocialMediaPostsController', 'translation.social_media_posts.list'],
     'translation.social_media_posts.overview' => ['translation/social-media-posts/:id', 'translation/social_media_posts/overviewTranslationSocialMediaPostController', 'translation.social_media_posts.single.overview'],
  
     //////////////////////// Media Routes //////////////////////
     'media.social_media_posts.add' => ['media/social-media-posts/add', 'media/social_media_posts/addSocialMediaPostController', 'media.social_media_posts.add'],
     'media.social_media_posts.overview' => ['media/social-media-posts/:id', 'media/social_media_posts/overviewSocialMediaPostController', 'media/social_media_posts.single.overview'],
     'media.social_media_posts.edit' => ['media/social-media-posts/:id/edit', 'media/social_media_posts/editSocialMediaPostController', 'media/social_media_posts.single.edit'],
     'media.social_media_posts.images' => ['media/social-media-posts/:id/images', 'media/social_media_posts/listSocialMediaPostImagesController', 'media/social_media_posts.single.listSocialMediaPostImages'],
     'media.social_media_posts' => ['media/social-media-posts', 'media/social_media_posts/listSocialMediaPostsController', 'media/social_media_posts.list'],
];
