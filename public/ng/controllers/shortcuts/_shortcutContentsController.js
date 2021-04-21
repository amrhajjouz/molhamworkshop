async function shortcutContentsControllerInit($http, $page, $apiRequest) {
  return {
    contents: await $apiRequest.config("shortcuts/" + $page.routeParams.id + '/contents').getData(),
  };
}

function shortcutContentsController($scope, $page, $apiRequest, $init) {
      $scope.contents = $init.contents;
      $scope.defaultKey = {
        shortcut_id:$page.routeParams.id,
        content:{
          contentable_type:"\\App\Models\\ShortcutKey",
          contentable_id:null,
          locale:"ar",
          value:null,
        }
      };

      $scope.key = angular.copy($scope.defaultKey);
      

      $scope.titleContent = {};
      $scope.descriptionContent = {};

      $scope.createUpdateTitleContent = $apiRequest.config({
        method: "PUT",
        url: "shortcuts/" + $page.routeParams.id + "/contents",
        data: $scope.titleContent,
      });

      $scope.createUpdateDescriptionContent = $apiRequest.config({
        method: "PUT",
        url: "shortcuts/" + $page.routeParams.id + "/contents",
        data: $scope.descriptionContent,
      });
    
}
