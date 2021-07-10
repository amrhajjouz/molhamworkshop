function addBlogController($scope, $location, $apiRequest, $page, $init) {
  $scope.blog = {url:null};
  $scope.createBlog = $apiRequest.config(
    {
      method: "POST",
      url: "blogs",
      data: $scope.blog,
    },
    function (response, data) {
      $page.navigate("blogs.overview", { id: data.id });
    }
  );
}
