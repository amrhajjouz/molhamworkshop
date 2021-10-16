async function listSocialMediaPostsControllerInit($datalist) {
    return await $datalist('media/social_media_posts', true).load();
}

function listSocialMediaPostsController($scope, $init, $apiRequest, $page) {
    $scope.posts = $init;
    $scope.selectedSocialMediaPost = {publishing:[]};

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
   
    $scope.approvePostRequest = (postId) => {
        $apiRequest
            .config({ method: 'POST', url: `media/social_media_posts/${postId}/approve`, data: { id: postId } }, function (response, data) {
                $page.reload();
            }).send();
    };
   
    $scope.rejectPostRequest = (postId) => {
        $apiRequest
            .config({ method: 'POST', url: `media/social_media_posts/${postId}/reject`, data: { id: postId } }, function (response, data) {
                $page.reload();
            }).send();
    };
  

    $scope.openPublishingModalOptions = (post)=>{
        $('#publish-modal').modal('show');
        post.publishing = {
            published_facebook_at:post.published_facebook_at != null ,
            published_twitter_at:post.published_twitter_at != null ,
            published_youtube_at:post.published_youtube_at != null ,
            published_instagram_at:post.published_instagram_at != null ,
        };
        $scope.updatePublishingOptionsRequest.config.url = `dashboard/api/media/social_media_posts/${post.id}/publishing`;
        $scope.updatePublishingOptionsRequest.config.data = post;

        $scope.selectedSocialMediaPost = post;
        
    }

    $scope.updatePublishingOptionsRequest = $apiRequest.config(
        {
          method: "PUT",
          url:  `media/social_media_posts/${$scope.selectedSocialMediaPost.id}/publishing`,
          data: $scope.selectedSocialMediaPost,
        },
        function (response, data) {
          $("#publish-modal").on("hidden.bs.modal", function (e) {
            $page.reload();
          });
    
          $("#publish-modal").modal("hide");
    
          $scope.selectedSocialMediaPost = {publishing:[]};
        }
      );
}
