async function listEventStatusesControllerInit(
  $http,
  $page,
  $apiRequest,
  $datalist
) {
  const statuses = await $apiRequest
    .config("events/" + $page.routeParams.id + "/statuses")
    .getData();

  let fakerPaginator = {
    currentPage: 1,
    data: [],
    filtering: false,
    filters: {},
    lastPageUrl: "",
    firstPageUrl: "",
    from: 1,
    lastPage: 1,
    to: 1,
    loaded: true,
    loading: false,
    pages: [1],
    params: {},
    total: 1,
    q: "",
    search: function (q) {},
  };

  fakerPaginator.data = statuses;
  fakerPaginator.total = statuses.length;

  return {
    statuses: fakerPaginator,
  };
}

function listEventStatusesController($scope, $page, $apiRequest, $init) {
  $scope.statuses = $init.statuses;

 $scope.createUpdateStatusContent = $apiRequest.config(
   {
     method: "POST",
     url: `events/${$page.routeParams.id}/statuses`,
     data: $scope.status,
   },
   function (response, data) {
     $("#status-modal").on("hidden.bs.modal", function (e) {
       $page.reload();
     });
    
     $("#status-modal").modal("hide");

     // reinitialize status to default value after create or update
    $scope.status = angular.copy($scope.defaultStatusModel);
   }
 );

 $scope.statusContent = {};
 $scope.contents = {};
 $scope.selectedStatus = {};

 $scope.defaultStatusModel = {
   targetable_id: $page.routeParams.id,
     locale: "ar",
     value: null,
     name: "status",
     id:null,
 };
  $scope.status = angular.copy($scope.defaultStatusModel);




    $scope.showModal = function (action, data = {}) {
      $scope.currentModalAction = action;
      switch (action) {
        case "add":
          $scope.status = angular.copy($scope.defaultStatusModel); //reinitial object , maybu user click on edit then create ,,, to reset Keyword object
          $scope.createUpdateStatusContent.config.method = "POST";
          break;
        case "edit":
          $scope.selectedStatus = data;
              $scope.selectedStatus = data;
              $scope.createUpdateStatusContent.config.method = action = "PUT";
              $scope.createUpdateStatusContent.config.url = `api/events/${$page.routeParams.id}/statuses/${$scope.selectedStatus.id}/contents`;
              $scope.contents = {};
              $scope.contents = data.contents;
          break;

        default:
          break;
      }

          $("#status-modal").modal("show");

    };
}
