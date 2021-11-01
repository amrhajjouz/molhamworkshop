function addSocialMediaPostController($scope, $location, $apiRequest, $page, $init) {
    $scope.socialMediaPost = { body: null, description:""};
    $scope.createSocialMediaPostRequest = $apiRequest.config(
        {
            method: 'POST',
            url: 'media/social_media_posts',
            data: $scope.socialMediaPost,
        },
        function (response, data) {
            $page.navigate('media.social_media_posts.overview', { id: data.id });
        }
    );
}
