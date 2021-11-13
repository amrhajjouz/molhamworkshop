function editBoardControllerInit($page, $apiRequest) {
    return $apiRequest.config("boards/" + $page.routeParams.id).getData();
}

function editBoardController($scope, $apiRequest, $init, $page) {
    $scope.board = $init;

    $scope.updateBoard = $apiRequest.config(
        {
            method: "PUT",
            url: "boards",
            data: $scope.board,
        },
        function (response, data) {
            $page.reload();
        }
    );
    $scope.oldLabel = {};
    $scope.newLabel = { board_id: $scope.board.id };
    $scope.createLabel = $apiRequest.config(
        {
            method: "POST",
            url: "labels",
            data: $scope.newLabel,
        },
        function (response, data) {
            $("#addLabelModal").modal("hide");
            $page.reload();
        }
    );

    $scope.setLabel = function (id, name, color) {
        $scope.oldLabel.id = id;
        $scope.oldLabel.color = color;
        $scope.oldLabel.name = name;
    };
    $scope.updateLabel = $apiRequest.config(
        {
            method: "PUT",
            url: "labels",
            data: $scope.oldLabel,
        },
        function (response, data) {
            $("#updateLabelModal").modal("hide");
            $page.reload();
        }
    );
    $scope.deleteLabel = () => {
        $apiRequest
            .config(
                {
                    method: "DELETE",
                    url: "labels/" + $scope.oldLabel.id,
                },
                function (response, data) {
                    $("#deleteLabelModal").modal("hide");
                    $page.reload();
                }
            )
            .send();
    };
}
