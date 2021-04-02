async function listCaseAdminsControllerInit(
  $http,
  $page,
  $apiRequest,
  $datalist
) {

  const admins = await $apiRequest.config(
    "cases/" + $page.routeParams.id + "/admins"
  ).getData();

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

  fakerPaginator.data = admins;
  fakerPaginator.total = admins.length;
  
  return {
    admins: fakerPaginator,
  };
}

function listCaseAdminsController($scope, $page, $apiRequest, $init) {
  $scope.admins = $init.admins.data;
  $scope.data = $init.admins;
  $scope.roles = [
    { id: "supervisor", name: "مشرف عام" },
    { id: "field_officer", name: "متطوع ميداني" },
    { id: "media_officer", name: "مسؤول الميديا" },
    { id: "data_entry", name: "إدخال بيانات" },
  ];

  //initial value for admin recors
  $scope.defaultAdminModel = {
    user_id: null,
    role: [],
    adminable_type: "\\App\\Models\\Cases",
    adminable_id: $page.routeParams.id,
  };

  $scope.admin = angular.copy($scope.defaultAdminModel);



/////////////////////// DELETE FUNCTION /////////////////////////
$scope.deleteAdmin = (admin) => {
  if (confirm("هل أنت متأكد من حذف هذا العنصر؟")) {
      $apiRequest.config(
        {
          method: "POST",
          url: `admins/delete`,
          data: admin,
        },
        function (response, data) {
            $page.reload();
        }
      ).send();
  }//end if confirm
};


  $scope.createUpdateCaseAdmins = $apiRequest.config(
    {
      method: "POST",
      url: `admins`,
      data: $scope.admin,
    },
    function (response, data) {
      $("#admin-modal").on("hidden.bs.modal", function (e) {
        $page.reload() 
      });
      $("#admin-modal").modal("hide");

      // reinitialize admin to default value after create or update
      $scope.admin = angular.copy($scope.defaultAdminModel);
    }
  );

  $scope.currentModalAction = "add";

  $scope.showModal = function (action, data = {}) {
    $scope.currentModalAction = action;
    switch (action) {
      case "add":
            $scope.admin = angular.copy($scope.defaultAdminModel); //reinitial object , maybu user click on edit then create ,,, to reset admin object
            $scope.createUpdateCaseAdmins.config.method = "POST";
        break;
      case "edit":
         $scope.createUpdateCaseAdmins.config.method = action = "PUT";
         $scope.admin = angular.copy(data);
        break;
    
      default:
        break;
    }
    $("#admin-modal").modal("show");
  };
}
