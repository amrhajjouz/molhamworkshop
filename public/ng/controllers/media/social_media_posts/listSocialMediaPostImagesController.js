async function listSocialMediaPostImagesControllerInit($datalist, $page) {
	return await $datalist('media/social_media_posts/' + $page.routeParams.id + '/images', false).load();
}

function listSocialMediaPostImagesController($scope, $init, $apiRequest, $page) {
	$scope.socialMediaPostsImages = $init;
	$scope.selectedImages = [];

	$scope.toggleCheckSelectedImage = (imageId) => {
		if ($scope.selectedImages.indexOf(imageId) === -1) {
			$scope.selectedImages.push(imageId);
		} else {
			$scope.selectedImages.splice($scope.selectedImages.indexOf(imageId), 1);
		}
	};

	$scope.downloadSelectedImagesRequest = () => {
		$apiRequest
			.config({ method: 'POST', url: 'media/social_media_posts/'+ $page.routeParams.id +'/images/download' , 
					data:{
						images : $scope.selectedImages 
					} }, function (response, data) {
				window.open(data.url )
				$page.reload();
			})
			.send();
	};


	$scope.openCreateModal = () => $('#create-image-modal').modal('show');

	$scope.createSocialMediaPostImageRequest = () => {
		$apiRequest
			.config({ method: 'POST', url: 'media/social_media_posts/' + $page.routeParams.id + '/images', data: $scope.images, headers: { 'Content-Type': undefined }, file: $scope.images, transformRequest: angular.identity }, function (response, data) {
				$('#create-image-modal').on('hidden.bs.modal', function (e) {
					$page.reload();
				});
				$('#create-image-modal').modal('hide');
			})
			.send();
	};

	$scope.handleChangeFile = (files) => {
		$scope.images = new FormData();
		for (let i in files) {
			$scope.images.append('images[]', files[i]);
		}

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
