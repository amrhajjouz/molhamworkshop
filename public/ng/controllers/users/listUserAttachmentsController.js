async function listUserAttachmentsControllerInit(
    $http,
    $page,
    $apiRequest,
    $datalist
) {
    const attachments = await $apiRequest.config("users/" + $page.routeParams.id + "/attachments").getData();
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
        search: function (q) { },
    };

    fakerPaginator.data = attachments;
    fakerPaginator.total = attachments.length;

    return {
        attachments: fakerPaginator,
    };
}

function listUserAttachmentsController($scope, $page, $apiRequest, $init) {
    $scope.attachments = $init.attachments;
    $scope.attachmentSource = "";
    $scope.loadingBoards = false;
    $scope.loadingCards = false;
    $scope.loadingAttachments = false;
    $scope.trelloInitialized = false;
    $scope.boardLists = [];
    $scope.selectedTrelloAttachments = [];

    $scope.createUpdateAttachments = () => {
        let data = {};

        /*
        * if source is google drive we have to pass google drive user access token beecause is reauired field
         */
        if ($scope.attachmentSource == "googleDrive") {
            data.attachments = $scope.selectedDriveFiles;
            data.accessToken = gapi.client.getToken().access_token;
        } else if ($scope.attachmentSource == "trello") {
            data.accessToken = TRELLO.token();
            data.attachments = $scope.selectedTrelloAttachments;
        }
        /*
         * define fileable_type & fileable_id because are required fields
         * define source that maybe (googleDrive , Trello , ...etc) 
         */
        data.fileable_type = "user";
        data.fileable_id = $page.routeParams.id;
        data.source = $scope.attachmentSource;

        $apiRequest.config({method: "POST",url: `files`,data: data,},
                function (response, data) {
                    $("#attachment-modal").on("hidden.bs.modal", function (e) {
                        $page.reload();
                    });
                    $("#attachment-modal").modal("hide");
                }
            ).send();
    };

    $scope.showModal = function (action, data = {}) {
        $scope.currentModalAction = action;
        $("#attachment-modal").modal("show");
    };

    $scope.handleChangeAttachmentSource = (val) => {
        $scope.attachmentSource = val.attachmentSource;
        $scope.boardLists = [];
        $scope.cards = [];
        $scope.selectedTrelloAttachments = [];
        
        switch ($scope.attachmentSource) {
            case "trello": $scope.initTrello();break;
            case "googleDrive":$scope.initGoogleDrive();break;
            default: alert('unrecognized type');break;
        }
    };
    
    //////////////////////////////////// TRELLO /////////////////////////

    // {Boardss} => {Cards} => {Attachments}

    /*
     * Reference to use window.Trello
     */

    const TRELLO = window.Trello;

    $scope.initTrello = () => {
        if ($scope.trelloInitialized) {
            $scope.getBoards();
            $scope.selectedCard = {};
            return;
        }

        //callback when authentication successed
        const authenticationSuccess = function () {
            console.log("Successful authentication");
            $scope.trelloInitialized = true;
            $scope.getBoards();
        };

        //callback when authentication failed
        const authenticationFailure = function () {
            console.log("Failed authentication");
        };

        /*
         * Select authorization config
         */
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

    /*
     *  Get Boards
     * Get Boards From Trello To select file from it
     */

    $scope.getBoards = async () => {
        $scope.loadingBoards = true;
        TRELLO.get("/members/me/boards",
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
                    console.log({ res });
                    console.log({ card: $scope.cards });

                    res.map((card) => {
                        card.attachments = [];
                        let cardExists = false;
                        $scope.cards.map(c => {
                            if (c.id == card.id) cardExists = true;
                        })
                        if (!cardExists) $scope.cards.push(angular.copy(card));
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
        TRELLO.get(`/cards/${card.id}/attachments`,
            (success) => {

                success = success.map(e => {
                    e.cardId = card.id;
                    return e;
                });


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
        let alreadyExists = false;
        $scope.selectedTrelloAttachments.map((e) => {
            if (e.id == attachment.id) {
                alreadyExists = true;
                return;
            }
        });
        //delete attachment
        if (alreadyExists) {
            $scope.selectedTrelloAttachments = $scope.selectedTrelloAttachments.filter((el) => el.id != attachment.id);
        }
        else $scope.selectedTrelloAttachments.push(attachment);


        //   $scope.selectedTrelloAttachments.push(attachment);
    };
    /////////////////////// End Select Attachments /////////////////////////

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

    /*
     *  ///////////////////////////////////////// Google drive /////////////////////////
     */

    // client id
    // 120230772858-lg8cb520vnjn9gfcle83l90v4kqo3d5g.apps.googleusercontent.com
    // client secret
    // 3Tfp11gTFVxE3tr50VpCZ7zc

    var PROJECT_ID = "test-api-project-314916";
    var CLIENT_ID =
        "120230772858-lg8cb520vnjn9gfcle83l90v4kqo3d5g.apps.googleusercontent.com";
    var API_KEY = "AIzaSyBqzy_qnXlJbHr6pExKeow1NYJX4d2oTXY";

    $scope.driveFiles = [];
    $scope.drivePathes = [];
    $scope.selectedDriveFiles = [];
    $scope.driveFileLoading = false;

    var CLIENT_ID =
        "120230772858-lg8cb520vnjn9gfcle83l90v4kqo3d5g.apps.googleusercontent.com";
    var API_KEY = "AIzaSyBqzy_qnXlJbHr6pExKeow1NYJX4d2oTXY";
    var DISCOVERY_DOCS = [
        "https://www.googleapis.com/discovery/v1/apis/drive/v3/rest",
    ];
    // var SCOPES = "https://www.googleapis.com/auth/drive.metadata.readonly";
    // var SCOPES = "https://www.googleapis.com/auth/drive.file";
    var SCOPES = "https://www.googleapis.com/auth/drive";

    /*
     * On select type is google drive
     * initialize google drive connection
     *  initClient is call back function that connect with google drive api
     */
    $scope.initGoogleDrive = () => {
        gapi.load("client:auth2", initClient);
    };

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
                    let isSignIn = gapi.auth2
                        .getAuthInstance()
                        .isSignedIn.get();

                    // if not sign in show popup to sign in
                    if (!isSignIn) {
                        $scope.signInGoogleDrive();
                    }

                    gapi.auth2
                        .getAuthInstance()
                        .isSignedIn.listen(updateSigninStatus);
                    // Handle the initial sign-in state.
                    updateSigninStatus(isSignIn);
                },
                function (error) {
                    //TODO : HANDLE ERROR
                }
            );
    }

    /*
     * signout from existing account and remove all selected files and clicled files from memory
     */

    $scope.signOutGoogleDrive = () => {
        gapi.auth2.getAuthInstance().signOut();
        $scope.driveFiles = [];
        $scope.drivePathes = [];
        $scope.isGoogleDriveSignedIn = false;
    };

    /*
     * Signin google frivr handler
     * open api modal to check if user authorized or no and ask for required permissions
     */

    $scope.signInGoogleDrive = () => {
        gapi.auth2.getAuthInstance().signIn();
    };

    /*
     *  called from initClient function
     *   on response cames we check if user authorize or no
     * $scope.isGoogleDriveSignedIn is reference for html file to load google drive section
     *  $scope.listDriveRootFolder() to get files in root folder first once on open modal and user are authorized
     */

    function updateSigninStatus(isSignedIn) {
        if (isSignedIn) {
            $scope.listDriveRootFolder();
            $scope.isGoogleDriveSignedIn = true;
        } else {
            $scope.isGoogleDriveSignedIn = false;
        }
        $scope.$evalAsync();
    }

    /*
     *  on click on any folder and user want to open it , $scope.handleOpenDriveFolder will be handler for click
     * and $scope.fetchDriveFolder() used inside that function to get file data
     * q is query that has which filter we want
     */

    $scope.fetchDriveFolder = (q) => {
        //save current fetched files as reference before load new files , when user click back load previous files
        $scope.drivePathes.push({ data: $scope.driveFiles });

        //set current files that appears in views as empty until arrive response
        $scope.driveFiles = [];

        return new Promise((resolve, reject) => {
            gapi.client.drive.files
                .list({
                    q: q,
                })
                .then(async function (response) {
                    resolve(response.result.files);
                });
            //todo:catch and reject promise
        });
    };

    /*
     * this function will execute on open authenticate modal and we want to load data for first time
     */
    $scope.listDriveRootFolder = () => {
        // "0AK-4shZBKhfWUk9PVA";//root folder
        // q = `mimeType = "application/vnd.google-apps.root"`; //view just in root folder
        // q = `mimeType = "application/vnd.google-apps.folder"`; //view just folders

        gapi.client.drive.files
            .list({
                q: "'root' in parents", // mean get only files in root directory
                // q: `'0AK-4shZBKhfWUk9PVA' in parents`, // mean get only files that has specific parentId , unused
            })
            .then(function (response) {
                /*
                 * $scope.driveFiles is array that has fetched files and load to view and iterate on it
                 */
                $scope.driveFiles = response.result.files;

                /*
                 * get single file data
                 * the data that comes from the $scope.listDriveRootFolder() function of each file is not enough,
                 *  so we need to call this function to fetch the full data for each file like type and name
                 */
                $scope.driveFiles.forEach((file) => {
                    gapi.client.drive.files
                        .get({
                            fileId: file.id,
                            fields: "id, name, webContentLink, webViewLink , parents , iconLink , hasThumbnail , thumbnailLink , shared , viewersCanCopyContent , permissions , thumbnailLink ",
                        })
                        .then((res) => {
                            file.fileDetails = res.result; //add response to file object as property called fileDetails
                            $scope.$evalAsync();
                        });
                }); //end foreach
            });
    };

    /*
     * handler for click on any folder
     */
    $scope.handleOpenDriveFolder = async (file) => {
        const clickableFiles = ["application/vnd.google-apps.folder"]; // define folder clickable

        if (!clickableFiles.includes(file.mimeType)) return;

        $scope.driveFileLoading = true; //show spinner
        /*
         *  $scope.fetchDriveFolder() to get folder files
         */
        $scope.driveFiles = await $scope.fetchDriveFolder(
            `'${file.id}' in parents`
        );

        /*
         *  get single file
         *  get each file details like icon and type ...etc
         */
        $scope.driveFiles.forEach((file) => {
            gapi.client.drive.files
                .get({
                    fileId: file.id,
                    fields: "id, name, webContentLink, webViewLink , parents , iconLink , hasThumbnail , thumbnailLink , shared , viewersCanCopyContent , permissions , thumbnailLink ",
                })
                .then(async (res) => {
                    file.fileDetails = res.result;
                    $scope.$evalAsync();
                });
        }); //end foreach

        $scope.driveFileLoading = false; //hide spinner
        $scope.$evalAsync();
    };

    /*
     * when user clicks on any folder, we keep the current data as a reference in case he wants to return so that we do not send a request
     *  $scope.drivePathes array has all click time data to return for it when user click on back button
     */
    $scope.getPrevData = () => {
        if (!$scope.drivePathes.length) return;
        $scope.driveFiles =
            $scope.drivePathes[$scope.drivePathes.length - 1].data;
        $scope.drivePathes.pop(); // remove last item from array because already user close it
    };

    /*
     * Add Or delete file to $scope.selectedDriveFiles
     */
    $scope.handleAddDriveFile = (file) => {
        let alreadyExists = false;

        $scope.selectedDriveFiles.map((e) => {
            if (e.id == file.id) {
                alreadyExists = true;
                return;
            }
        });

        //delete file
        if (alreadyExists) {
            $scope.selectedDriveFiles = $scope.selectedDriveFiles.filter(
                (el) => el.id != file.id
            );
        } else {
            //add file  ,
            //take id , name and mime type because we required those in backend
            $scope.selectedDriveFiles.push({
                id: file.id,
                name: file.name,
                mimeType: file.mimeType,
            });
        }
        $scope.$evalAsync();
    };

    /*
     * just for show button title on file (add or delete)
     * iterate on $scope.selectedDriveFiles and check if file params exists in array
     */
    $scope.isFileDriveExistsInSelectedFiles = (file) => {
        let exists = false;
        $scope.selectedDriveFiles.map((e) => {
            if (e.id == file.id) {
                exists = true;
                return;
            }
        });

        return exists;
    };
}
