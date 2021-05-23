async function listSponsorshipCardsControllerInit(
  $http,
  $page,
  $apiRequest,
  $datalist
) {
  const cards = await $apiRequest
    .config("sponsorships/" + $page.routeParams.id + "/cards")
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

  fakerPaginator.data = cards;
  fakerPaginator.total = cards.length;

  return {
    cards: fakerPaginator,
  };
}

function listSponsorshipCardsController($scope, $page, $apiRequest, $init) {
  $scope.cards = $init.cards;

  $scope.createUpdateCard = $apiRequest.config(
    {
      method: "POST",
      url: `sponsorships/${$page.routeParams.id}/cards`,
      data: $scope.selectedCard,
    },
    function (response, data) {
      $("#card-modal").on("hidden.bs.modal", function (e) {
        $page.reload();
      });

      $("#card-modal").modal("hide");

      // reinitialize card to default value after create or update
      $scope.selectedCard = angular.copy($scope.defaultCardModel);
    }
  );

  $scope.selectedCard = {};

  $scope.defaultCardModel = {
    cardable_id: $page.routeParams.id,
    cardable_type: "sponsorships",
    name: null,
    description: null,
    id: null,
  };

  $scope.selectedCard = angular.copy($scope.defaultCardModel);

  $scope.showModal = function (action, data = {}) {
    $scope.currentModalAction = action;
    switch (action) {
      case "add":
        $scope.createUpdateCard.config.method = "POST";
        break;
      case "edit":
        $scope.createUpdateCard.config.method = action = "PUT";
        break;
        default:
          break;
        }
    
    $scope.selectedCard = angular.copy(data);

    $scope.createUpdateCard.config.data = $scope.selectedCard;

    $("#card-modal").modal("show");
  };

}
