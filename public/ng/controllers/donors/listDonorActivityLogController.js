async function listDonorActivityLogControllerInit($datalist, $location , $apiRequest , $page) {
    // return $datalist("roles", true).load();

    let activities = await $apiRequest
        .config(`donors/${$page.routeParams.id}/activity_logs`, true)
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
    
    
    fakerPaginator.total = activities.length;
    fakerPaginator.data = [];

  activities.forEach((el) => {
    el.created_at = el.created_at.split('T')[0];
      fakerPaginator.data.push(el);
      return el;
  });
  return fakerPaginator;


}

function listDonorActivityLogController($scope, $init, $page, $apiRequest) {
    

    $scope.activityLogs = $init;


}
