async function listSocialMediaPostsControllerInit($datalist) {
    return await $datalist('media/social_media_posts', true).load();
}

function listSocialMediaPostsController($scope, $init, $apiRequest, $page) {
    $scope.posts = $init;

    $scope.canProofread = (postObject) => {
        let canProofread = true;
        if(postObject.proofreadable['ar'] == false) canProofread = false;
        if(postObject.body && postObject.body.ar.proofread ) {
            canProofread=false
        };
        return canProofread;
    }

    
    $scope.proofreadPostRequest = (postId) => {
        $apiRequest
            .config({ method: 'POST', url: `media/social_media_posts/${postId}/proofread`, data: { id: postId } }, function (response, data) {
                $page.reload();
            }).send();
    };

}
