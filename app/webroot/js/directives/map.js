
historify.directive('map', function(){
    return {
        // This HTML will replace the zippy directive.
        scope: {
            'data': '='
        },
        controller: function($scope) {
            console.log("map running");

            $scope.mapLoaded = function() {

            }
            $scope.circleArray = [];

            $scope.$watch('data', function(value) {
                if(value) {
                    while($scope.circleArray[0]){
                        $scope.circleArray.pop().setMap(null);
                    }

                    angular.forEach(value, function(item, index) {
                        if(angular.isDefined(item.location)) {
                            var populationOptions = {
                                strokeColor: '#ED2D2E',
                                strokeOpacity: 0.5,
                                strokeWeight: 1,
                                fillColor: '#ED2D2E',
                                fillOpacity: 0.475,
                                map: $scope.map,
                                center:  new google.maps.LatLng(item.location.latitude, item.location.longitude),
                                radius: 100000
                            };
                            var cityCircle = new google.maps.Circle(populationOptions);
                            $scope.circleArray.push(cityCircle);
                        }
                    });

                }
            });
        },
        // The linking function will add behavior to the template
        link: function($scope, element, attrs) {

            var circleArray=[];
            var map;
            var australia = new google.maps.LatLng(-25.498321, 135.369703);
/*
            var citymap = {};
            citymap['sydney'] = {
                center: new google.maps.LatLng(-33.867487, 151.20699),
                population: 25
            };
            citymap['brisbane'] = {
                center: new google.maps.LatLng(-27.471011, 153.023449),
                population: 50
            };
            citymap['melbourne'] = {
                center: new google.maps.LatLng(-37.814107, 144.96328),
                population: 75
            }
            var cityCircle;
            */


            console.log("i am loading the map");

            $scope.map = new google.maps.Map(element[0], {
                zoom: 4,
                maxZoom: 4,
                minZoom: 4,
                scrollWheel: false,
                center: australia,
                mapTypeId: google.maps.MapTypeId.SATELLITE,
                mapTypeControl: false,
                panControl: false,
                zoomControl: false,
                scaleControl: false,
                streetViewControl: false
            });


            console.log("mappppp");

            var mapStyle = [
                {
                    "featureType": "administrative.neighborhood",
                    "stylers": [
                        { "visibility": "off" }
                    ]
                },{
                    "featureType": "landscape",
                    "stylers": [
                        { "visibility": "off" }
                    ]
                },{
                    "featureType": "poi",
                    "stylers": [
                        { "visibility": "off" }
                    ]
                },{
                    "featureType": "road",
                    "stylers": [
                        { "visibility": "off" }
                    ]
                },{
                    "featureType": "transit",
                    "stylers": [
                        { "visibility": "off" }
                    ]
                },{
                    "featureType": "landscape.natural",
                    "stylers": [
                        { "visibility": "on" },
                        { "weight": 0.1 },
                        { "hue": "#00ff11" },
                        { "lightness": -32 },
                        { "saturation": -26 },
                        { "gamma": 0.69 }
                    ]
                },{
                    "featureType": "water",
                    "stylers": [
                        { "visibility": "on" },
                        { "hue": "#FFFFFF" },
                        { "lightness": 1000 },
                        { "saturation": 0 }
                    ]}
            ];



            var styledMapOptions = {
                name: 'US Road Atlas'
            };

            var usRoadMapType = new google.maps.StyledMapType(mapStyle, styledMapOptions);

            $scope.map.mapTypes.set('usroadatlas', usRoadMapType);
            $scope.map.setMapTypeId('usroadatlas');


/*            $(".time_tag").mouseover(function(){
                clearMap_makers();
                var lng = $(this).data('lng');
                var lat = $(this).data('lat');
                var populationOptions = {
                    strokeColor: '#ED2D2E',
                    strokeOpacity: 0.5,
                    strokeWeight: 1,
                    fillColor: '#ED2D2E',
                    fillOpacity: 0.475,
                    map: map,
                    center:  new google.maps.LatLng(lat,lng),
                    radius: 100000
                };
                cityCircle = new google.maps.Circle(populationOptions);
                circleArray.push(cityCircle);
            });*/

            /*function clearMap_makers(){
                while(circleArray[0]){
                    circleArray.pop().setMap(null);
                }
            }*/
        }
    }
});