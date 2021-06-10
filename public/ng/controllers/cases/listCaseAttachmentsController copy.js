async function listCaseAttachmentsControllerInit(
  $http,
  $page,
  $apiRequest,
  $datalist
) {}

function listCaseAttachmentsController($scope, $page, $apiRequest, $init) {
  $scope.attachmentSource = "";
  $scope.loadingBoards = false;
  $scope.loadingCards = false;
  $scope.loadingAttachments = false;
  $scope.trelloInitialized = false;
  $scope.boardLists = [];

  const TRELLO = window.Trello;

  // Authenticate with Trello ;

  $scope.initTrello = () => {
    if ($scope.trelloInitialized) {
      $scope.getBoards();
      $scope.selectedCard = {};
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
  };

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

  ///////////////////// Get Board List /////////////////////////

  $scope.getBoardLists = (boardId) => {
    TRELLO.get(
      `/boards/${boardId}/lists`,
      (res) => {
        $scope.boardLists = res;
        // $scope.loadingBoards = false;
        $scope.$evalAsync();
      },
      (err) => {
        alert(err.responseText);
        $scope.loadingBoards = false;
        console.log(err);
      }
    );
  };

  ///////////////////// End Get Board List /////////////////////////

  /////////////////////// Get Board Cards /////////////////////////

  $scope.getBoardCards = (boardId) => {
    if (!$scope.boards.length) return;

    $scope.boardLists = [];
    $scope.getBoardLists(boardId);

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
    $scope.boardLists = [];
    $scope.cards = [];

    switch ($scope.attachmentSource) {
      case "trello":
        $scope.initTrello();
        break;
      case "googleDrive":
        $scope.initGoogleDrive();
        break;

      default:
        break;
    }
  };

  $scope.getListName = (card) => {
    let name = null;
    $scope.boardLists.map((list) => {
      if (list.id == card.idList) {
        name = list.name;
        return list.name;
      }
    });

    if (name) return name;
    else return null;
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

  /////////////////////////// Google drive /////////////////////////

  // client id
  // 120230772858-lg8cb520vnjn9gfcle83l90v4kqo3d5g.apps.googleusercontent.com
  // client secret
  // 3Tfp11gTFVxE3tr50VpCZ7zc

  var PROJECT_ID = "test-api-project-314916";
  var CLIENT_ID =
    "120230772858-lg8cb520vnjn9gfcle83l90v4kqo3d5g.apps.googleusercontent.com";
  var API_KEY = "AIzaSyBqzy_qnXlJbHr6pExKeow1NYJX4d2oTXY";
  var SCOPES = "https://www.googleapis.com/auth/drive.appdata";

  $scope.driveFiles = [];
  $scope.drivePathes = [];
  $scope.selectedDriveFiles = [];
  $scope.driveFileLoading = false;

  var CLIENT_ID = "120230772858-lg8cb520vnjn9gfcle83l90v4kqo3d5g.apps.googleusercontent.com";
  var API_KEY = "AIzaSyBqzy_qnXlJbHr6pExKeow1NYJX4d2oTXY";
  var DISCOVERY_DOCS = [
    "https://www.googleapis.com/discovery/v1/apis/drive/v3/rest",
  ];
  // var SCOPES = "https://www.googleapis.com/auth/drive.metadata.readonly";
  // var SCOPES = "https://www.googleapis.com/auth/drive.file";
  var SCOPES = "https://www.googleapis.com/auth/drive";

  window.gapi = gapi;

  $scope.initGoogleDrive = ()=> {
    gapi.load("client:auth2", initClient);
  }

  function initClient() {
    gapi.client
      .init({
        apiKey: API_KEY,
        clientId: CLIENT_ID,
        discoveryDocs: DISCOVERY_DOCS,
        scope: SCOPES,
      })
      .then(
        function () {
          // Listen for sign-in state changes.
          let isSignIn = gapi.auth2.getAuthInstance().isSignedIn.get();

          // if not sign in show popup to sign in
          if (!isSignIn) {
            $scope.signInGoogleDrive();
          }


            gapi.auth2.getAuthInstance().isSignedIn.listen(updateSigninStatus);
          // Handle the initial sign-in state.
          updateSigninStatus(isSignIn);
        },
        function (error) {
          //TODO : HANDLE ERROR
        }
      );
  }

  $scope.signOutGoogleDrive= () =>{
    gapi.auth2.getAuthInstance().signOut();
    $scope.driveFiles =[];
    $scope.drivePathes =[];
     $scope.isGoogleDriveSignedIn = false;
  }

  function updateSigninStatus(isSignedIn) {
    if (isSignedIn) {
      $scope.listDriveRootFolder();
      $scope.isGoogleDriveSignedIn = true;
    } else {
      $scope.isGoogleDriveSignedIn = false;
    }
    $scope.$evalAsync();
  }

   $scope.signInGoogleDrive = ()=> {
    gapi.auth2.getAuthInstance().signIn();
  }

  $scope.fetchDriveFolder = (q) => {
    $scope.drivePathes.push({ data: $scope.driveFiles });
    $scope.driveFiles = [];

    return new Promise((resolve, reject) => {
      gapi.client.drive.files
        .list({
          q: q,
        })
        .then(async function (response) {
          resolve(response.result.files);
          //  return response.result;
        });
      //todo:catch and reject promise
    });
  };

  $scope.listDriveRootFolder = () => {
    // "0AK-4shZBKhfWUk9PVA";//root folder
    // q = `mimeType = "application/vnd.google-apps.root"`; //view just in root folder
    // q = `mimeType = "application/vnd.google-apps.folder"`; //view just folders
    gapi.client.drive.files
      .list({
        q: "'root' in parents",
        // q: `'0AK-4shZBKhfWUk9PVA' in parents`,
      })
      .then(function (response) {
        $scope.driveFiles = response.result.files;

        /////////////////////// get single file /////////////////////////

        $scope.driveFiles.forEach((file) => {
          gapi.client.drive.files
            .get({
              fileId: file.id,
              fields:
                "id, name, webContentLink, webViewLink , parents , iconLink , hasThumbnail , thumbnailLink , shared , viewersCanCopyContent , permissions , thumbnailLink ",
            })
            .then((res) => {
              file.fileDetails = res.result;
              $scope.$evalAsync();
            });
        }); //end foreach
      });
  }

  $scope.handleOpenDriveFolder = async (file) => {
    const clickableFiles = ["application/vnd.google-apps.folder"];
    if (!clickableFiles.includes(file.mimeType)) return;

    $scope.driveFileLoading = true;

    $scope.driveFiles = await $scope.fetchDriveFolder(
      `'${file.id}' in parents`
    );

    // get single file 

    $scope.driveFiles.forEach((file) => {
      gapi.client.drive.files
        .get({
          fileId: file.id,
          // responseType: 'stream',
           alt: 'media' ,
          //  mimeType : 'text/plain',
          fields:
            "id, name, webContentLink, webViewLink , parents , iconLink , hasThumbnail , thumbnailLink , shared , viewersCanCopyContent , permissions , thumbnailLink ",
        })
        .then( async (res) => {
          console.log({res})
//           const readableStream = await gapi.client.drive.files.get({
//   fileId: file.id,
//   alt: 'media'
// });
// console.log({readableStream})




          file.fileDetails = res.result;
          console.log({res})
          $scope.$evalAsync();
        });
    }); //end foreach

    $scope.driveFileLoading = false;
    $scope.$evalAsync();
  };

  $scope.getPrevData = () => {
    if (!$scope.drivePathes.length) return;

    $scope.driveFiles = $scope.drivePathes[$scope.drivePathes.length - 1].data;
    $scope.drivePathes.pop();
  };

  /////////////////////// Add Or delete file
  $scope.handleAddDriveFile = (file) => {
    if (!file.fileDetails.webContentLink) return;

    if ($scope.selectedDriveFiles.includes(file.fileDetails.webContentLink)) {
      $scope.selectedDriveFiles.splice(
        $scope.selectedDriveFiles.indexOf(file.fileDetails.webContentLink),
        1
      );
    } else {
      $scope.selectedDriveFiles.push(file.fileDetails.webContentLink);
    }
    $scope.$evalAsync();
  };
}
