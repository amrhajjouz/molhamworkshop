async function editBlogControllerInit($http, $page, $apiRequest) {
  const blog = await $apiRequest
    .config("blogs/" + $page.routeParams.id)
    .getData();

  return {
    blog: blog,
  };
}

function editBlogController($scope, $page, $apiRequest, $init) {
  $scope.blog = $init.blog;

  $scope.updateBlog = $apiRequest.config(
    {
      method: "PUT",
      url: "blogs",
      data: $scope.blog,
    },
    function (response, data) {}
  );
}
