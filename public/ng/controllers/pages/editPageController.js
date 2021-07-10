async function editPageControllerInit($http, $page, $apiRequest) {
  return await $apiRequest.config('pages/' + $page.routeParams.id).getData();
}

function editPageController($scope, $page, $apiRequest, $init) {
  $scope.page = $init;
  $scope.contents = $init.contents;

  $scope.updatePage = $apiRequest.config(
    {
      method: 'PUT',
      url: 'pages',
      data: $scope.page,
    },
    function (response, data) {}
  );

  /////////////////////// Contents /////////////////////////

  $scope.titleContent = {};
  $scope.descriptionContent = {};
  $scope.bodyContent = {};

  $scope.createUpdateTitleContent = $apiRequest.config({
    method: 'PUT',
    url: 'pages/' + $page.routeParams.id + '/contents',
    data: $scope.titleContent,
  });

  $scope.createUpdateDescriptionContent = $apiRequest.config({
    method: 'PUT',
    url: 'pages/' + $page.routeParams.id + '/contents',
    data: $scope.descriptionContent,
  });

  $scope.createUpdateBodyContent = $apiRequest.config({
    method: 'PUT',
    url: 'pages/' + $page.routeParams.id + '/contents',
    data: $scope.bodyContent,
  });
}
