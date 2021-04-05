async function caseContentsControllerInit($http, $page, $apiRequest) {
  return {
    contents: await $apiRequest.config("cases/" + $page.routeParams.id + '/contents').getData(),
  };
}

function caseContentsController($scope, $page, $apiRequest, $init) {
    
  $scope.contents = $init.contents;

  $scope.newContents = [
    { 
      contentable_id:$page.routeParams.id,
      contentable_type:"\\App\\Models\Cases",
      locale:"ar",
      name:"العنوان",
      value:null,
    },
    { 
      contentable_id:$page.routeParams.id,
      contentable_type:"\\App\\Models\Cases",
      locale:"ar",
      name:"التفاصيل",
      value:null,
    },
  ];

  $scope.updateCase = $apiRequest.config(
    {
      method: "PUT",
      url: "cases",
      data: $scope.object,
    },
    function (response, data) {}
  );
}
