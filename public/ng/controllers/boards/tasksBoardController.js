function tasksBoardControllerInit($apiRequest, $page) {
    return $apiRequest
        .config("boards/" + $page.routeParams.id + "/tasks")
        .getData();
}

function tasksBoardController($scope, $init, $page, $apiRequest) {
    $scope.priorityColors = (priority) => {
        return {
            none: "#F8F9FA",
            low: "#28A745",
            medium: "#17A2B8",
            high: "#FFC107",
            urgent: "#DC3545",
        }[priority];
    };
    $scope.priorityTranslations = (priority) => {
        return {
            none: "لا اولوية",
            low: "ضئيلة",
            medium: "متوسطة",
            high: "عالية",
            urgent: "عاجل",
        }[priority];
    };
    $scope.statusColors = (status) => {
        return {
            backlog: "#F8F9FA",
            open: "#6C757D",
            "in progress": "#007BFF",
            done: "#28A745",
            returned: "#FFC107",
            verified: "#007BFF",
            canceled: "#343A40",
        }[status];
    };
    $scope.statusTranslations = (status) => {
        return {
            backlog: "تاركم",
            open: "مفتوحة",
            "in progress": "في تقدم",
            done: "تم",
            returned: "مرجعة",
            verified: "مؤكدة",
            canceled: "مبطلة",
        }[status];
    };
    $scope.board = $init;
    $scope.board.labels.forEach((label) => {
        $scope["labelStyle" + label.id] = {
            "background-color": "whitesmoke",
            "border-radius": "10px",
            padding: "5px 10px",
        };
    });
    $scope.task = { labels: [], board_id: $scope.board.id };
    $scope.toggleLabel = (label) => {
        if ($scope.task.labels.includes(label.id)) {
            $scope.task.labels = $scope.task.labels.filter(
                (labelId) => labelId !== label.id
            );
            $scope["labelStyle" + label.id]["background-color"] = "whitesmoke";
        } else {
            $scope.task.labels = [...$scope.task.labels, label.id];
            $scope["labelStyle" + label.id]["background-color"] = label.color;
        }
    };
    $scope.createTask = $apiRequest.config(
        {
            method: "POST",
            url: "tasks",
            data: $scope.task,
        },
        function (response, data) {
            $("#addTaskModal").modal("hide");
            $page.reload();
        }
    );
    $scope.oldTask = { labels: [] };
    $scope.board.labels.forEach((label) => {
        $scope["oldLabelStyle" + label.id] = {
            "background-color": "whitesmoke",
            "border-radius": "10px",
            padding: "5px 10px",
        };
    });
    $scope.setTask = (task) => {
        $scope.oldTask.id = task.id;
        $scope.oldTask.title = task.title;
        $scope.oldTask.description = task.description;
        if (Array.isArray(task.labels)) {
            labels = task.labels.map((label) => label.id);

            $scope.oldTask.labels = labels;
        } else {
            $scope.oldTask.labels = [];
        }
        $scope.oldTask.asignee_id = task.asignee_id;
        $scope.oldTask.reporter_id = task.reporter_id;
        $scope.oldTask.status = task.status;
        $scope.oldTask.priority = task.priority;
        $scope.oldTask.start_date = task.start_date;
        $scope.oldTask.due_date = task.due_date;
        $scope.board.labels.forEach((label) => {
            $scope["oldLabelStyle" + label.id]["background-color"] =
                labels.includes(label.id) ? label.color : "whitesmoke";
        });
        console.log($scope.oldTask);
    };
    $scope.toggleOldLabel = (label) => {
        if ($scope.oldTask.labels.includes(label.id)) {
            $scope.oldTask.labels = $scope.oldTask.labels.filter(
                (labelId) => labelId !== label.id
            );
            $scope["oldLabelStyle" + label.id]["background-color"] =
                "whitesmoke";
        } else {
            $scope.oldTask.labels = [...$scope.oldTask.labels, label.id];
            $scope["oldLabelStyle" + label.id]["background-color"] =
                label.color;
        }
    };
    $scope.updateTask = $apiRequest.config(
        {
            method: "PUT",
            url: "tasks",
            data: $scope.oldTask,
        },
        function (response, data) {
            $("#updateTaskModal").modal("hide");
            $page.reload();
        }
    );
    $scope.deleteTask = () => {
        $apiRequest
            .config(
                {
                    method: "DELETE",
                    url: "tasks/" + $scope.oldTask.id,
                },
                function (response, data) {
                    $("#updateTaskModal").modal("hide");
                    $("#deleteTaskModal").modal("hide");
                    $page.reload();
                }
            )
            .send();
    };
}
