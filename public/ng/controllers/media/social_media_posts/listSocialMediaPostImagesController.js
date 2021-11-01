async function listSocialMediaPostImagesControllerInit($datalist, $page) {
	return await $datalist('media/social_media_posts/' + $page.routeParams.id + '/images', false).load();
}

function listSocialMediaPostImagesController($scope, $init, $apiRequest, $page) {
	$scope.socialMediaPostsImages = $init;

	$scope.openCreateModal = () => $('#create-image-modal').modal('show');

	$scope.createSocialMediaPostImageRequest = () => {
		$apiRequest
			.config({ method: 'POST', url: 'media/social_media_posts/' + $page.routeParams.id + '/images', data: $scope.image, headers: { 'Content-Type': undefined }, file: $scope.image, transformRequest: angular.identity }, function (response, data) {
            $("#create-image-modal").on("hidden.bs.modal", function (e) {
               $page.reload();
             });
				$('#create-image-modal').modal('hide');
			})
			.send();
	};

	$scope.handleChangeFile = (file) => {
		$scope.image = new FormData();
		$scope.image.append('image', file);
		$scope.$evalAsync();
	};

	$scope.deleteSocialMediaPostImageRequest = (img) => {
		$apiRequest
			.config({ method: 'DELETE', url: 'media/social_media_posts/' + $page.routeParams.id + '/images/' + img.id }, function (response, data) {
				$page.reload();
			})
			.send();
	};
}
