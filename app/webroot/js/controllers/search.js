
function SearchCtrl($scope, $http) {

    $scope.init = function() {

    }
    console.log("SEARCH CONTROLLER BITCHES!");

    $scope.model.results = null;
    $scope.model.selectedResult = {};
    $scope.model.currentTime = {};
    $scope.model.itemsInRange = [];


    $scope.$watch('model.selectedResult', function(value) {
        if(value) {
            $http.get(value.fulltexturl).success(function(data) {
                value.fulltext = data;
            });
        }
    })
    $scope.doSearch = function(query) {
        $scope.model.isLoading = true;
        $scope.model.results = [];
        $scope.model.selectedResult = {};
        $http.get("/api/search/" + encodeURIComponent(query)).success(function(data) {
            $scope.model.isLoading = false;
            $scope.model.results = data;
        });
    }
//    $.getJSON("contentsource.php?searchTerm=" + escape(searchTerm))
//        .done(function(json) {
//            document.getElementById("loadingimg").style.display = "none";
//            $.each(json, function(index) {
//                //response.zone[0].records.article[0].date
//                //addEvent(json[index].date, json[index].heading, json[index].imageurl);
//                addEvent(json[index]);
//            });
//            //alert(timeline.getDataRange().min.toDateString());
//            console.log("JSON Data: " + json);
//            timeline.applyRange(timeline.getDataRange(true).min, timeline.getDataRange(true).max);
//            timeline.redraw();
//        })
//        .fail(function(jqxhr, textStatus, error) {
//            var err = textStatus + ', ' + error;
//            console.log("Request Failed: " + err);
//        });

}