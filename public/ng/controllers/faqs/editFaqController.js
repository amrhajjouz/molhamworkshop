async function editFaqControllerInit($http, $page, $apiRequest) {
  return {
    faq: await $apiRequest.config("faqs/" + $page.routeParams.id).getData(),
    categories: await $apiRequest
      .config("categories?created_for=faqs")
      .getData(),
  };
}

function editFaqController($scope, $page, $apiRequest, $init) {
  $scope.faq = $init.faq;
  $scope.categories = $init.categories;

  $scope.updateFaq = $apiRequest.config(
    {
      method: "PUT",
      url: "faqs",
      data: $scope.faq,
    },
    function (response, data) {}
  );
}
