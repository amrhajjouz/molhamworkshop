async function faqContentsControllerInit($http, $page, $apiRequest) {
  return {
    contents: await $apiRequest.config("faqs/" + $page.routeParams.id + '/contents').getData(),
  };
}

function faqContentsController($scope, $page, $apiRequest, $init) {
    
  $scope.contents = $init.contents;

   $scope.contents = $init.contents;

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
