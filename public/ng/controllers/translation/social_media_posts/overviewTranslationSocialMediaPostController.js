function overviewTranslationSocialMediaPostControllerInit($apiRequest, $page) {
    return $apiRequest.config("translation/social_media_posts/" + $page.routeParams.id).getData();
}

function overviewTranslationSocialMediaPostController($scope, $page, $apiRequest, $init) {
    
    $scope.socialMediaPost = $init;
    $scope.updateableSocialMediaPostContent = {};
    
    $scope.showUpdateSocialMediaContentModal = (locale, field) => {
        $scope.updateableSocialMediaPostContent = {
            field_name: field,
            locale: locale,
            value: $scope.socialMediaPost[field][locale] ? $scope.socialMediaPost[field][locale].value : "",
            id: $init.id
        }
        $scope.updateSocialMediaPostRequest.config.data = $scope.updateableSocialMediaPostContent;
        $('#edit-modal').modal('show');
    }
    
    $scope.updateSocialMediaPostRequest = $apiRequest.config({
        method: 'PUT',
        url: 'translation/social_media_posts',
        data: $scope.updateableSocialMediaPostContent,
    }, function (response, data) {
        $("#edit-modal").on("hidden.bs.modal", function (e) {
            $page.reload();
        });
        $("#edit-modal").modal("hide");
    });


    $scope.proofreadPostRequest = (postId , language) => {
        $apiRequest
            .config({ method: 'POST', url: `translation/social_media_posts/${postId}/proofread`, data: { id: postId , language } }, function (response, data) {
                $page.reload();
            }).send();
    };
   
    $scope.unproofreadPostRequest = (postId , language) => {
        $apiRequest
            .config({ method: 'POST', url: `translation/social_media_posts/${postId}/unproofread`, data: { id: postId , language } }, function (response, data) {
                $page.reload();
            }).send();
    };
}