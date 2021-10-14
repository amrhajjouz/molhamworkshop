async function editTranslationSocialMediaPostControllerInit($http, $page, $apiRequest) {
    return await $apiRequest.config('translation/social_media_posts/' + $page.routeParams.id).getData();
}

function editTranslationSocialMediaPostController($scope, $page, $apiRequest, $init) {
    $scope.socialMediaPost = $init;

    // temporary just for test contents with en lang
    $scope.socialMediaPost.locale = 'en'; 
    $scope.socialMediaPost.body = $scope.socialMediaPost.body.en ? $scope.socialMediaPost.body.en.value : '';

    $scope.updateSocialMediaPostTranslationRequest = $apiRequest.config(
        {
            method: 'PUT',
            url: 'translation/social_media_posts',
            data: $scope.socialMediaPost,
        },
        function (response, data) {}
    );
}
