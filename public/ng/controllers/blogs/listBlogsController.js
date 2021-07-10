async function listBlogsControllerInit($datalist) {
  return await $datalist("blogs", true).load();
}

function listBlogsController($scope, $init) {
  $scope.blogs = $init;
}
