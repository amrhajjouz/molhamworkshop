function overviewTranslationSocialMediaPostControllerInit($apiRequest, $page) {
  return $apiRequest.config("translation/social_media_posts/" + $page.routeParams.id).getData();
}

function overviewTranslationSocialMediaPostController($scope, $page, $apiRequest, $init) {
  $scope.socialMediaPost = $init;
  $scope.updateableSocialMediaPost = angular.copy($init);



$scope.openUpdateModal = (lang)=>{
  $scope.lang =lang;
  $scope.$evalAsync();
  $('#edit-modal').modal('show');
  
}




$scope.updateSocialMediaPostRequest = $apiRequest.config(
  {
      method: 'PUT',
      url: 'translation/social_media_posts',
      data: $scope.updateableSocialMediaPost,
  },
  function (response, data) {
    $("#edit-modal").on("hidden.bs.modal", function (e) {
      $page.reload();
    });

    $("#edit-modal").modal("hide");
  }
);

}
