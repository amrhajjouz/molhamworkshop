async function listCaseNotesControllerInit(
  $http,
  $page,
  $apiRequest,
  $datalist
) {
  const notes = await $apiRequest
    .config("cases/" + $page.routeParams.id + "/notes")
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

  fakerPaginator.data = notes;
  fakerPaginator.total = notes.length;

  return {
    notes: fakerPaginator,
  };
}

function listCaseNotesController($scope, $page, $apiRequest, $init) {
  $scope.notes = $init.notes;

  $scope.createUpdateNote = $apiRequest.config(
    {
      method: "POST",
      url: `cases/${$page.routeParams.id}/notes`,
      data: $scope.selectedNote,
    },
    function (response, data) {
      $("#note-modal").on("hidden.bs.modal", function (e) {
        $page.reload();
      });

      $("#note-modal").modal("hide");

      // reinitialize note to default value after create or update
      $scope.selectedNote = angular.copy($scope.defaultNoteModel);
    }
  );

  $scope.selectedNote = {};

  $scope.defaultNoteModel = {
    noteable_id: $page.routeParams.id,
    noteable_type: "cases",
    content: null,
    id: null,
  };

  $scope.selectedNote = angular.copy($scope.defaultNoteModel);

  $scope.showModal = function (action, data = {}) {
    $scope.currentModalAction = action;
    switch (action) {
      case "add":
        $scope.selectedNote = angular.copy($scope.defaultNoteModel); //reinitial object , maybu user click on edit then create ,,, to reset Keyword object
        $scope.createUpdateNote.config.method = "POST";
        $scope.createUpdateNote.config.url = `api/cases/${$page.routeParams.id}/notes`;
        break;
      case "edit":
        $scope.selectedNote = angular.copy(data);
        $scope.createUpdateNote.config.method = action = "PUT";
        $scope.createUpdateNote.config.url = `api/cases/${$page.routeParams.id}/notes/${$scope.selectedNote.id}`;
        break;
      default:
        break;
    }
    $scope.createUpdateNote.config.data = $scope.selectedNote;

    $("#note-modal").modal("show");
  };

  $scope.addDeleteReview = (note) => {
    const reviewUrl = `cases/${$page.routeParams.id}/notes/${note.id}/review`;
    
    //TODO : if cuttent user exists in who make review send request to  deferent route
    $scope.reviewNoteRequest = $apiRequest
      .config(
        {
          method: "POST",
          url: reviewUrl,
          data: note,
        },
        function (response, data) {
          $page.reload();
        }
      )
      .getData();
  };
}
