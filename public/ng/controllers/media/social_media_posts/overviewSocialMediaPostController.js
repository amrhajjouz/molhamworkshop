function overviewSocialMediaPostControllerInit($apiRequest, $page) {
  return $apiRequest.config("media/social_media_posts/" + $page.routeParams.id).getData();
}

function overviewSocialMediaPostController($scope, $page, $apiRequest, $init) {
  $scope.socialMediaPost = $init;
}
