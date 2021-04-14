function listBlogsControllerInit($datalist) {
  return $datalist("blogs", true).load();
}

function listBlogsController($scope, $init) {
  $scope.blogs = $init;
}
