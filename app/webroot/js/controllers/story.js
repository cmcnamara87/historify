function StoryCtrl($scope, $routeParams, StoryService, $http) {
    console.log(StoryService);
    
    $scope.init = function() {
    
    	$scope.model = {};
    	$scope.model.selectedItem = {};
    	$scope.model.itemsInRange = [];
    	//$scope.model.story = StoryService.story;
    
	  	console.log($routeParams.storyId);  
	  	
	  	$http.get('/api/story/'+$routeParams.storyId).success(function(data) {
		  	console.log(data);
		  	$scope.model.story = data;
	  	});
    };

    $scope.showMoreText = function(item) {
        item.isShowingText = true;
    }
    $scope.showLessText = function(item) {
        item.isShowingText = false;
    }
    $scope.showImage = function(item) {
        item.isShowingImage = true;
    }
    $scope.hideImage = function(item) {
        item.isShowingImage = false;
    }
}