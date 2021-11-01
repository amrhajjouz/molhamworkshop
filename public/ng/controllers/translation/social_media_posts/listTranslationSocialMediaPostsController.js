async function listTranslationSocialMediaPostsControllerInit($datalist) {
    return await $datalist('translation/social_media_posts', true).load();
}

function listTranslationSocialMediaPostsController($scope, $init, $apiRequest, $page) {
    $scope.posts = $init;
    $scope.canProofread = (postObject) => {
        let canProofread = true;
        if(postObject.proofreadable['en'] == false) canProofread = false;
        if(postObject.body && postObject.body.en &&postObject.body.en.proofread ) {
            canProofread=false
        };
        return canProofread;
    }
    $scope.proofreadPostRequest = (postId) => {
        $apiRequest
            .config({ method: 'POST', url: `translation/social_media_posts/${postId}/proofread`, data: { id: postId } }, function (response, data) {
                $page.reload();
            }).send();
    };

    


}
