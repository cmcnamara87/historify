
historify.directive('timeline', function(){
    return {
        // This HTML will replace the zippy directive.
        scope: {
            'data': '=',
            'selectedData': '=',
            'itemsInRange': '='
        },
        controller: function($scope) {
            console.log("timeline running");

            $scope.$watch('data', function(data) {
                if(data) {
                    $scope.data = data;
                    $scope.itemsInRange = data;
                    console.log("data is now", data);

                    // Clear the items that are there
                    $scope.timeline.deleteAllItems();

                    angular.forEach(data, function(value, index) {
                        $scope.timeline.addItem({
                            'start': new Date(value.date),
                            'content': '<div class="boxcontainer" data-id="'+value.id+'" data-heading="'+value.heading+'" data-title="'+value.title+'" data-date="'+value.date+'" data-snippet="'+escape(value.snippet)+'" data-imageurl="'+value.imageurl+'" data-fulltexturl="'+value.fulltexturl+'" data-latitude="'+value.location.latitude+'" data-longitude="'+ value.location.longitude+'" data-pdfurl="'+ value.pdf+'"><div class="leftItem"><img class="boxImage" src="'+ value.imageurl+'"></img></div><div class="rightItem">'+ value.heading+'</div></div>'
                        });
                    });

                    //alert(timeline.getDataRange().min.toDateString());
                    $scope.timeline.setVisibleChartRangeAuto();
                    $scope.timeline.redraw();


                }
            })

            $scope.itemSelected = function() {
                var sel = $scope.timeline.getSelection();

                $scope.$apply(function() {
                    if (sel && sel.length && sel[0].row != undefined) {
                        $scope.selectedData = $scope.data[sel[0].row];
                    } else {
                        $scope.selectedData = null;
                    }
                });


                console.log($scope.selectedData);

//                if (sel.length) {
//                    if (sel[0].row != undefined) {
//                        var row = sel[0].row;
//                        document.title = "event " + row + " selected";
//                    }
//                }
            }

            $scope.rangeChanging = function onRangeChanged(properties) {
                console.log('rangechanged ' +
                    properties.start + ' - ' + properties.end);
            }

            $scope.timeChanging = function(prop) {

                var coolThings = [];
                angular.forEach($scope.data, function(value, index) {
                    var myDate = new Date(value.date);
                    if(prop.start.getTime() <= myDate.getTime() && myDate.getTime() <= prop.end.getTime()) {
                        coolThings.push(value);
                    }
                });

                $scope.$apply(function() {
                    if(coolThings.length != $scope.itemsInRange.length) {
                        $scope.itemsInRange = coolThings;
                    }
                });
            }
//            timeline.deleteAllItems();
//            oldSearch = searchTerm;
//            console.log(searchTerm);
//
//            $.getJSON("contentsource.php?searchTerm=" + escape(searchTerm))
//                .done(function(json) {
//                    document.getElementById("loadingimg").style.display = "none";
//                    $.each(json, function(index) {
//                        //response.zone[0].records.article[0].date
//                        //addEvent(json[index].date, json[index].heading, json[index].imageurl);
//                        addEvent(json[index]);
//                    });
//                    //alert(timeline.getDataRange().min.toDateString());
//                    console.log("JSON Data: " + json);
//                    timeline.applyRange(timeline.getDataRange(true).min, timeline.getDataRange(true).max);
//                    timeline.redraw();
//                })
//                .fail(function(jqxhr, textStatus, error) {
//                    var err = textStatus + ', ' + error;
//                    console.log("Request Failed: " + err);
//                });
//        }
        },
        // The linking function will add behavior to the template
        link: function($scope, element, attrs) {
            console.log("timeline running 2");

            var options = {
                'width': '100%',
                'height': '200px',
                'editable': false, // enable dragging and editing events
                'style': 'box',
                "min": new Date(1803, 0, 1),                // lower limit of visible range
                "max": new Date(1988, 11, 31),              // upper limit of visible range
                "zoomMin": 1000 * 60 * 60 * 24 * 31,             // one month in milliseconds
                "zoomMax": 1000 * 60 * 60 * 24 * 31 * 12 * 200     // about 200 years in milliseconds
            };

            // Instantiate our timeline object.
//            timeline = new links.Timeline(document.getElementById('timeline'));
            $scope.timeline = new links.Timeline(element[0]);
            $scope.timeline.draw([], options);

            links.events.addListener($scope.timeline, 'select', $scope.itemSelected);
            links.events.addListener($scope.timeline, 'rangechange', $scope.timeChanging);


            // attach an event listener using the links events handler
            //links.events.addListener($scope.timeline, 'rangechanged', $scope.rangeChanging);

            // Draw our timeline with the created data and options
        }
    }
});