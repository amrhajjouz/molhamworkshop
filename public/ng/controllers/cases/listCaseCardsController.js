async function listCaseCardsControllerInit($http, $page, $apiRequest, $datalist) {
  const cards = await $apiRequest.config('cases/' + $page.routeParams.id + '/cards').getData();

  let fakerPaginator = {
    currentPage: 1,
    data: [],
    filtering: false,
    filters: {},
    lastPageUrl: '',
    firstPageUrl: '',
    from: 1,
    lastPage: 1,
    to: 1,
    loaded: true,
    loading: false,
    pages: [1],
    params: {},
    total: 1,
    q: '',
    search: function (q) {},
  };

  fakerPaginator.data = cards;
  fakerPaginator.total = cards.length;

  return {
    cards: fakerPaginator,
  };
}

function listCaseCardsController($scope, $page, $apiRequest, $init) {
  $scope.cards = $init.cards;

  $scope.comments = [];
  $scope.newComment = {};
  $scope.selectedComment = {};
  $scope.currentCommentAction = 'add';
  $scope.loadingComments = false;

  $scope.selectedCard = {};

  $scope.createUpdateCard = $apiRequest.config(
    {
      method: 'POST',
      url: `cases/${$page.routeParams.id}/cards`,
      data: $scope.selectedCard,
    },
    function (response, data) {
      $('#card-modal').on('hidden.bs.modal', function (e) {
        $page.reload();
      });

      $('#card-modal').modal('hide');

      // reinitialize card to default value after create or update
      $scope.selectedCard = angular.copy($scope.defaultCardModel);
    }
  );

  $scope.defaultCardModel = {
    cardable_id: $page.routeParams.id,
    cardable_type: 'cases',
    name: null,
    description: null,
    id: null,
  };

  $scope.selectedCard = angular.copy($scope.defaultCardModel);

  $scope.showModal = function (action, data = {}) {
    $scope.currentModalAction = action;
    switch (action) {
      case 'add':
        $scope.createUpdateCard.config.method = 'POST';
        break;
      case 'edit':
        $scope.createUpdateCard.config.method = action = 'PUT';
        $scope.selectedCard = angular.copy(data);
        $scope.getComments();
        break;
      default:
        break;
    }

    $scope.selectedCard = angular.copy(data);

    $scope.createUpdateCard.config.data = $scope.selectedCard;

    $('#card-modal').modal('show');
  };

  ///////////////////////  Comments /////////////////////////
  $scope.getComments = async () => {
    if ($scope.comments.length) return;
    $scope.loadingComments = true;

    const card = await $apiRequest.config(`cases/${$page.routeParams.id}/cards/${$scope.selectedCard.id}`).getData();
    $scope.selectedCard = card;

    $scope.loadingComments = false;
    $scope.comments = card.comments;
    $scope.$evalAsync();
  };

  $scope.createUpdateComment = $apiRequest.config(
    {
      method: 'POST',
      url: `cases/${$page.routeParams.id}/cards/${$scope.selectedCard.id}/comments`,
      data: $scope.newComment,
    },
    function (response, data) {
      $scope.selectedComment = {};

      $scope.newComment = {};

      if ($scope.currentCommentAction == 'add') $scope.comments.push(data);
    }
  );

  $scope.switchCommentMode = function (action = 'add', data = {}) {
    $scope.currentCommentAction = action;
    switch (action) {
      case 'add':
        $scope.createUpdateComment.config.method = 'POST';
        $scope.createUpdateComment.config.url = `api/cases/${$page.routeParams.id}/cards/${$scope.selectedCard.id}/comments`;
        break;
      case 'edit':
        $scope.selectedComment = data;
        $scope.createUpdateComment.config.method = action = 'PUT';
        $scope.createUpdateComment.config.url = `api/cases/${$page.routeParams.id}/cards/${$scope.selectedCard.id}/comments`;
        break;

      case 'delete':
        $scope.selectedComment = data;
        if (confirm('هل تريد التأكيد على حذف هذا التعليق ؟ ')) {
          $apiRequest
            .config(
              {
                method: 'DELETE',
                url: `cases/${$page.routeParams.id}/cards/${$scope.selectedCard.id}/comments/${$scope.selectedComment.id}`,
                data: $scope.selectedComment,
              },
              function (response, data) {
                $scope.comments = $scope.comments.filter((e) => e.id != data.id);
                $scope.selectedComment = null;
              }
            )
            .getData();
        }
        break;

      default:
        break;
    }
    $scope.$evalAsync();
  };

  $scope.$watch('selectedComment.body', function (body) {
    $scope.createUpdateComment.config.data = $scope.selectedComment;
    $scope.createUpdateComment.config.method = action = 'PUT';
    $scope.createUpdateComment.config.url = `api/cases/${$page.routeParams.id}/cards/${$scope.selectedCard.id}/comments`;
  });

  $scope.$watch('newComment.body', function (body) {
    $scope.createUpdateComment.config.data = $scope.newComment;
    $scope.createUpdateComment.config.method = 'POST';
  });
}
