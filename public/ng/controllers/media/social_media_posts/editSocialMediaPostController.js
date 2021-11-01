async function editSocialMediaPostControllerInit($http, $page, $apiRequest) {
    return {
        socialMediaPost: await $apiRequest.config('media/social_media_posts/' + $page.routeParams.id).getData(),
    };
}

function editSocialMediaPostController($scope, $page, $apiRequest, $init) {
    $scope.socialMediaPost = $init.socialMediaPost;

    $scope.updateSocialMediaPostRequest = $apiRequest.config(
        {
            method: 'PUT',
            url: 'media/social_media_posts',
            data: $scope.socialMediaPost,
        },
        function (response, data) {}
    );
}
