async function listCaseAttachmentsControllerInit(
  $http,
  $page,
  $apiRequest,
  $datalist
) {}

function listCaseAttachmentsController($scope, $page, $apiRequest, $init) {

  $scope.attachmentSource = "google";
  $scope.loadingBoards = false;
  $scope.loadingCards = false;
  $scope.loadingAttachments = false;
  $scope.trelloInitialized = false;


  const TRELLO = window.Trello;

  // Authenticate with Trello ;

$scope.initTrello=()=>{

  if($scope.trelloInitialized){
    $scope.getBoards();
    return;
  }

    const authenticationSuccess = function () {
      console.log("Successful authentication");
      $scope.trelloInitialized = true;
      $scope.getBoards();
    };

    const authenticationFailure = function () {
      console.log("Failed authentication");
    };

    TRELLO.authorize({
      type: "popup",
      persist: true,
      expiration: "never",
      name: "فريق ملهم التطوعي",
      return_url: "",
      success: authenticationSuccess,
      error: authenticationFailure,
      scope: {
        read: true,
        write: true,
      },
    });

    
}

  // End  Authenticate with Trello ;

  /////////////////////// Get Boards /////////////////////////

  $scope.getBoards = async () => {
    $scope.loadingBoards = true;
    TRELLO.get(
      "/members/me/boards",
      (res) => {
        $scope.boards = res;
        $scope.loadingBoards = false;
        $scope.$evalAsync();
      },
      (err) => {
        alert(err.responseText);
        $scope.loadingBoards = false;
        console.log(err);
      }
    );
  };

  /////////////////////// End  Boards /////////////////////////

  /////////////////////// Get Board Cards /////////////////////////

  $scope.getBoardCards = (boardId) => {
    if (!$scope.boards.length) return;

    $scope.loadingCards = true;
    $scope.cards = [];
    $scope.selectedCard = null;
    $scope.$evalAsync();

    $scope.boards.map((board) => {
      TRELLO.get(
        `/boards/${boardId}/cards`,
        (res) => {
          res.map((card) => {
            card.attachments = [];
            $scope.cards.push(angular.copy(card));
            $scope.loadingCards = false;
            $scope.$evalAsync();
          });
        },
        (err) => {
          console.log(err.responseText);
          $scope.loadingCards = false;
          //  if (status == 400 || 401) reinitializeAuth();
          console.log(err);
        }
      );
    });
  };

  /////////////////////// End Get Board Cards /////////////////////////

  /////////////////////// Get Card Attachments /////////////////////////

  $scope.getCardAttachments = (card) => {
    $scope.loadingAttachments = true;
    card.attachments = [];
    $scope.selectedCard = card;
    TRELLO.get(
      `/cards/${card.id}/attachments`,
      (success) => {
        $scope.selectedCard.attachments = success;
        $scope.loadingAttachments = false;
        $scope.$evalAsync();
      },
      (error) => {
        $scope.loadingAttachments = false;
        console.log({ error });
      }
    );
  };
  /////////////////////// End Get Card Attachments /////////////////////////

  /////////////////////// Select Attachments /////////////////////////
  $scope.selectAttachment = (attachment) => {
    console.log({ attachment });
    alert("attachment url is : " + attachment.url);
  };
  /////////////////////// End Select Attachments /////////////////////////

  $scope.showModal = function (action, data = {}) {
    $scope.currentModalAction = action;
    switch (action) {
      case "add":
        $scope.createUpdateAttachments.config.method = "POST";
        break;
      case "edit":
        $scope.createUpdateAttachments.config.method = action = "PUT";
        break;
      default:
        break;
    }

    $scope.selectedCard = angular.copy(data);

    $scope.createUpdateAttachments.config.data = $scope.selectedCard;

    $("#attachment-modal").modal("show");
  };

  $scope.createUpdateAttachments = $apiRequest.config(
    {
      method: "POST",
      url: `cases/${$page.routeParams.id}/cards`,
      data: $scope.selectedCard,
    },
    function (response, data) {
      $("#attachment-modal").on("hidden.bs.modal", function (e) {
        $page.reload();
      });

      $("#attachment-modal").modal("hide");

      // reinitialize card to default value after create or update
      $scope.selectedCard = angular.copy($scope.defaultCardModel);
    }
  );

  $scope.handleChangeAttachmentSource = (val) => {
    $scope.attachmentSource = val.attachmentSource;
    console.log({ val });

    switch ($scope.attachmentSource) {
      case "trello":
        console.log("selected is trello");
        // getBoards();
        $scope.initTrello();

        break;

      default:
        break;
    }
  };












  
  // 478a021e0eee1bc54f97f29c1e6149f6

  // var onAuthorize = function () {
  //   updateLoggedIn();
  //   $("#output").empty();

  //   Trello.members.get("me", function (member) {
  //     $("#fullName").text(member.fullName);

  //     var $cards = $("<div>").text("Loading Cards...").appendTo("#output");

  //     // Output a list of all of the cards that the member
  //     // is assigned to

  //     Trello.get("/boards/60abc6c2eec7c447135da7da/cards", function (cards) {
  //       $cards.empty();
  //       $.each(cards, function (ix, card) {
  //         Trello.get(
  //           "/cards/" + card.id + "/actions?filter=updateCard",
  //           function (change_card) {
  //             console.log({ change_card });
  //             ago = moment(change_card[0].date.substr(0, 10), "YYYY-MM-DD")
  //               .fromNow()
  //               .split(" ")[0];

  //             if (ago == "a") {
  //               ago = 30;
  //             }

  //             $("<div>").text(ago).appendTo("#output");
  //             debugger;
  //             Trello.post("cards/" + card.id + "/actions/comments", {
  //               token: Trello.token(),
  //               key: Trello.key(),
  //               text: "This card has been in this list for " + ago + " days.",
  //             });

  //             //Trello.put("cards/" + card.id + "/name", "(" + ago + ") " + card.name);
  //           }
  //         );
  //         //Trello.get("/cards/" + card.id + "/actions?filter=createCard", function(change_card) {
  //         //    $("<div>").text(moment(change_card[0].date.substr(0,10), "YYYY-MM-DD").fromNow()).appendTo("#output");
  //         //});
  //       });
  //     });
  //   });
  // };

  // var updateLoggedIn = function () {
  //   var isLoggedIn = Trello.authorized();
  //   $("#loggedout").toggle(!isLoggedIn);
  //   $("#loggedin").toggle(isLoggedIn);
  // };

  // var logout = function () {
  //   Trello.deauthorize();
  //   updateLoggedIn();
  // };

  // Trello.authorize({
  //   interactive: false,
  //   success: onAuthorize,
  // });

  // $("#connectLink").click(function () {
  //   Trello.authorize({
  //     type: "popup",
  //     success: onAuthorize,
  //   });
  // });

  // $("#disconnect").click(logout);

  // const reinitializeAuth = ()=>{
  //   localStorage.removeItem('trello_token');
  // }

  // const cards = await Trello.get("/members/me/boards");
  // var t = window.TrelloPowerUp.iframe();

  //   window.TrelloPowerUp.initialize({
  //   'board-buttons': function (t, opts) {
  //     console.log({t} , {ops})
  //   },
  //   'card-buttons': function (t, opts) {
  //     console.log({ t }, { ops });
  //   },
  // });

  //  const boards = await window.Trello.get("/members/me/boards");
  //  console.log({ boards }, boards.responseJSON, boards);

  // free Vbic

  //  $("#connectLink").click(function () {
  //  Trello.authorize({
  //  type: "popup",
  //  success: onAuthorize,
  //  });
  //  });

  // getBoards();

  // const trello = Trello.cards.get(id[ params], success =>{
  //   console.log({success})
  // }, error=>{
  //   console.log({error})
  // });
}
