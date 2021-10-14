function overviewTranslationSocialMediaPostControllerInit($apiRequest, $page) {
  return $apiRequest.config("translation/social_media_posts/" + $page.routeParams.id).getData();
}

function overviewTranslationSocialMediaPostController($scope, $page, $apiRequest, $init) {
  $scope.socialMediaPost = $init;
}
