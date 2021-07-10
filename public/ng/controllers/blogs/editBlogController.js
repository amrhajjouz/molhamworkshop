async function editBlogControllerInit($http, $page, $apiRequest) {
  return await $apiRequest.config('blogs/' + $page.routeParams.id).getData();
}

function editBlogController($scope, $page, $apiRequest, $init) {
  $scope.blog = $init;
  $scope.contents = $init.contents;
  $scope.updateBlog = $apiRequest.config(
    {
      method: 'PUT',
      url: 'blogs',
      data: $scope.blog,
    },
    function (response, data) {}
  );
  /////////////////////// Content /////////////////////////
  $scope.titleContent = {};
  $scope.descriptionContent = {};
  $scope.bodyContent = {};

  $scope.createUpdateTitleContent = $apiRequest.config({
    method: 'PUT',
    url: 'blogs/' + $page.routeParams.id + '/contents',
    data: $scope.titleContent,
  });

  $scope.createUpdateDescriptionContent = $apiRequest.config({
    method: 'PUT',
    url: 'blogs/' + $page.routeParams.id + '/contents',
    data: $scope.descriptionContent,
  });

  $scope.createUpdateBodyContent = $apiRequest.config({
    method: 'PUT',
    url: 'blogs/' + $page.routeParams.id + '/contents',
    data: $scope.bodyContent,
  });
}
