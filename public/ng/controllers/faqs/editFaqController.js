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
  $scope.contents = $init.faq.contents;

  $scope.categories = $init.categories;

  $scope.updateFaq = $apiRequest.config(
    {
      method: "PUT",
      url: "faqs",
      data: $scope.faq,
    },
    function (response, data) {}
  );




  // Contents

   $scope.questionContent = {};
   $scope.answerContent = {};
   $scope.bodyContent = {};

   $scope.createUpdateQuestionContent = $apiRequest.config({
     method: "PUT",
     url: "faqs/" + $page.routeParams.id + "/contents",
     data: $scope.questionContent,
   });

   $scope.createUpdateAnswerContent = $apiRequest.config({
     method: "PUT",
     url: "faqs/" + $page.routeParams.id + "/contents",
     data: $scope.answerContent,
   });
}
