var historify = angular.module('historify', []);


historify.config(function($routeProvider) {

    $routeProvider.
        // Login
        when('/', {
            controller: 'CreateCtrl',
            templateUrl: '/partials/create.html'
        }).
        when('/create', {
            controller: 'CreateCtrl',
            templateUrl: '/partials/create.html'
        }).
            when('/story/:storyId', {
            controller: 'StoryCtrl',
            templateUrl: '/partials/story.html'
        });
//        when('/game', {
//            controller: 'GameCtrl',
//            templateUrl: 'partials/game.html'
//        });
    // Register
//        when('/register', {
//            controller: 'RegisterCtrl',
//            templateUrl: 'partials/register.html'
//        }).
//        // User Details (height age)
//        when('/details', {
//            controller: 'DetailsCtrl',
//            templateUrl: 'partials/details.html'
//        }).
//        // View Day
//        when('/day/:dayId', {
//            controller: 'DayCtrl',
//            templateUrl: 'partials/day.html'
//        }).
//        // Enter weights
//        when('/weights', {
//            controller: 'WeightsCtrl',
//            templateUrl: 'partials/weights.html'
//        });
});
