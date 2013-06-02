
function CreateCtrl($scope, $location, StoryService, $http) {

    $scope.init = function() {

    }

    $scope.model = {};
    $scope.model.story = {'items': []};  /*
        'title': "yo yo yo",
        'slugline': 'hey hey hey',
        'description': 'cheese',
        'author': 'Unknown Author',
        'items': []
    };*/

    $scope.addToStory = function(result) {
        $scope.model.story.items.push(result);
        $scope.model.selectedResult = {};
    }

    $scope.publishStory = function(story) {
        // post story
        $http.post('/api/newstory',story).success(function(data) {
	        $location.path("/story/"+data);
	        console.log("GOING TO /story/"+data);
        });

        StoryService.story = story;

        console.log("my story is ", StoryService);
        // redirect story

    }
}