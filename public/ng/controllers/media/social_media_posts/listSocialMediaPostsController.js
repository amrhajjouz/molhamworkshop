async function listSocialMediaPostsControllerInit($datalist) {
   return await $datalist('media/social_media_posts', true).load();
}

function listSocialMediaPostsController($scope, $init, $apiRequest, $page, $datalist) {
   $scope.posts = $init;
   $scope.selectedSocialMediaPost = { publishing: [] };
   $scope.filters = [
      { title: 'جاهز للنشر', key: 'ready_to_publish', value: false },
      { title: 'مؤرشفة', key: 'archived_at', value: false },
      { title: 'تم النشر على فيسبوك', key: 'published_on_facebook_at', value: false },
      { title: 'تم النشر على تويتر', key: 'published_on_twitter_at', value: false },
      { title: 'تم النشر على انستغرام', key: 'published_on_instagram_at', value: false },
      { title: 'تم النشر على يوتيوب', key: 'published_on_youtube_at', value: false },
      { title: 'تم المزامنة على فيسبوك', key: 'scheduled_on_facebook_at', value: false },
      { title: 'تم المزامنة على تويتر', key: 'scheduled_on_twitter_at', value: false },
      { title: 'تم المزامنة على انستغرام', key: 'scheduled_on_instagram_at', value: false },
      { title: 'تم المزامنة على يوتيوب', key: 'scheduled_on_youtube_at', value: false },
      { title: 'تم تدقيقها', key: 'proofread', value: false },
   ];

   $scope.statuses = [
       {title : "الكل" , key:"status" , value:"all" } ,
       {title : "تم قبولها" , key:"status" , value:"approved" } ,
       {title : "تم رفضها" , key:"status" , value:"rejected" } ,
       {title : "الحالة الإفتراضية" , key:"status" , value:"pending" } ,
   ];

   $scope.canProofread = (postObject) => {
      let canProofread = true;
      if (postObject.proofreadable['ar'] == false) canProofread = false;
      if (postObject.body && postObject.body.ar.proofread) {
         canProofread = false;
      }
      return canProofread;
   };

   $scope.proofreadPostRequest = (postId) => {
      if(!confirm('هل تريد التأكيد على تعيين هذا المنشور كتم تدقيقه ؟ ')) return;
      $apiRequest
         .config({ method: 'POST', url: `media/social_media_posts/${postId}/proofread`, data: { id: postId } }, function (response, data) {
            $page.reload();
         })
         .send();
   };

   $scope.archivePostRequest = (postId) => {
      if(!confirm('هل تريد التأكيد على تعيين هذا المنشور كتم أرشفته ؟ ')) return;
      $apiRequest
         .config({ method: 'POST', url: `media/social_media_posts/${postId}/archive`, data: { id: postId } }, function (response, data) {
            $page.reload();
         })
         .send();
   };
   $scope.approvePostRequest = (postId) => {
      if(!confirm('هل تريد التأكيد على قبول هذا المنشور ؟ ')) return;
      $apiRequest
         .config({ method: 'POST', url: `media/social_media_posts/${postId}/approve`, data: { id: postId } }, function (response, data) {
            $page.reload();
         })
         .send();
   };

   $scope.rejectPostRequest = (postId) => {
      if(!confirm('هل تريد التأكيد على رفض هذا المنشور ؟ ')) return;
      $apiRequest
         .config({ method: 'POST', url: `media/social_media_posts/${postId}/reject`, data: { id: postId } }, function (response, data) {
            $page.reload();
         })
         .send();
   };

   $scope.openPublishingModalOptions = (post) => {
      $('#publish-modal').modal('show');
      post.publishing = {
         published_on_facebook_at: post.published_on_facebook_at != null,
         published_on_twitter_at: post.published_on_twitter_at != null,
         published_on_youtube_at: post.published_on_youtube_at != null,
         published_on_instagram_at: post.published_on_instagram_at != null,
      };
      post.isScheduled = {
         scheduled_on_facebook_at: post.scheduled_on_facebook_at != null,
         scheduled_on_twitter_at: post.scheduled_on_twitter_at != null,
         scheduled_on_youtube_at: post.scheduled_on_youtube_at != null,
         scheduled_on_instagram_at: post.scheduled_on_instagram_at != null,
      };
      (post.scheduled_on_facebook_at = post.scheduled_on_facebook_at ? new Date(post.scheduled_on_facebook_at) : null), (post.scheduled_on_twitter_at = post.scheduled_on_twitter_at ? new Date(post.scheduled_on_twitter_at) : null), (post.scheduled_on_youtube_at = post.scheduled_on_youtube_at ? new Date(post.scheduled_on_youtube_at) : null), (post.scheduled_on_instagram_at = post.scheduled_on_instagram_at ? new Date(post.scheduled_on_instagram_at) : null), ($scope.updatePublishingOptionsRequest.config.url = `dashboard/api/media/social_media_posts/${post.id}/publishing`);
      $scope.updatePublishingOptionsRequest.config.data = post;

      $scope.selectedSocialMediaPost = post;
   };

   $scope.updatePublishingOptionsRequest = $apiRequest.config(
      {
         method: 'PUT',
         url: `media/social_media_posts/${$scope.selectedSocialMediaPost.id}/publishing`,
         data: $scope.selectedSocialMediaPost,
      },
      function (response, data) {
         $('#publish-modal').on('hidden.bs.modal', function (e) {
            $page.reload();
         });

         $('#publish-modal').modal('hide');

         $scope.selectedSocialMediaPost = { publishing: [] };
      }
   );

   $scope.handleChangeInput = (name, action) => {
      if (action == 'published') {
         // $scope.selectedSocialMediaPost.isScheduled['scheduled_on_'+name+'_at'] = null;
         // $scope.selectedSocialMediaPost['scheduled_on_'+name+'_at'] = null;
      } else {
         $scope.selectedSocialMediaPost.publishing['published_on_' + name + '_at'] = false;
      }
   };

   ///////////////////// Filters /////////////////////

   $scope.openFilterModal = () => {
      $('#filter-modal').modal('show');
   };

   $scope.filterRequest = async () => {
      let url = 'media/social_media_posts?status='+$scope.filters.status.value;
      $scope.filters.map((filter) => {
         if (filter.value == true) {
            url += `&${filter.key}=true`;
         }
      });


      $scope.posts = await $datalist(url, true).load();
      $scope.$evalAsync();
   };
}
