async function addFaqControllerInit($apiRequest) {
  return {
    categories: await $apiRequest
      .config("categories/?created_for=faqs")
      .getData(),
  };
}

function addFaqController($scope, $location, $apiRequest, $page, $init) {

  $scope.categories = $init.categories
  $scope.faq = {
    category_id: null,
    contents: {
      question: {
        value: null,
        locale: "ar",
        name: "question",
      },
      answer: {
        value: null,
        locale: "ar",
        name: "answer",
      },
    },
  };

  $scope.createFaq = $apiRequest.config(
    {
      method: "POST",
      url: "faqs",
      data: $scope.faq,
    },
    function (response, data) {
      $page.navigate("faqs.overview", { id: data.id });
    }
  );
}
