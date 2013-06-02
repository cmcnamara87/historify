var timeline;
var data;
var oldSearch = "";

// Called when the Visualization API is loaded.
function drawVisualization() {
    // Create a JSON data table


    // specify options
    var options = {
        'width': '100%',
        'height': '200px',
        'editable': false, // enable dragging and editing events
        'style': 'box'
    };

    // Instantiate our timeline object.
    timeline = new links.Timeline(document.getElementById('timeline'));

    

    // attach an event listener using the links events handler
    //links.events.addListener(timeline, 'rangechanged', onRangeChanged);

    // Draw our timeline with the created data and options
    timeline.draw(data, options);
}

function search() {
    
    drawVisualization();
    
    //AJAX
    var searchTerm = $('#searchtext').val();
    if (searchTerm == oldSearch) {
        return;
    }
    document.getElementById("loadingimg").style.display = "block";
    timeline.deleteAllItems();
    oldSearch = searchTerm;
    console.log(searchTerm);
    
    $.getJSON("contentsource.php?searchTerm=" + escape(searchTerm))
            .done(function(json) {
        document.getElementById("loadingimg").style.display = "none";
        $.each(json, function(index) {
            //response.zone[0].records.article[0].date
            //addEvent(json[index].date, json[index].heading, json[index].imageurl);
            addEvent(json[index]);
        });
        //alert(timeline.getDataRange().min.toDateString());
        console.log("JSON Data: " + json);
        timeline.applyRange(timeline.getDataRange(true).min, timeline.getDataRange(true).max);
        timeline.redraw();
    })
            .fail(function(jqxhr, textStatus, error) {
        var err = textStatus + ', ' + error;
        console.log("Request Failed: " + err);
    });
}

//function addEvent(start, content, img) {
//    timeline.addItem({
//        'start': new Date(start),
//        'content': '<div class="leftItem"><img class="boxImage" src="'+img+'"></img></div><div class="rightItem">'+content+'</div>'
//    });
//}

function addEvent(e) {
    timeline.addItem({
        'start': new Date(e.date),
        'content': '<div class="boxcontainer" data-id="'+e.id+'" data-heading="'+e.heading+'" data-title="'+e.title+'" data-date="'+e.date+'" data-snippet="'+escape(e.snippet)+'" data-imageurl="'+e.imageurl+'" data-fulltexturl="'+e.fulltexturl+'" data-latitude="'+e.location.latitude+'" data-longitude="'+e.location.longitude+'" data-pdfurl="'+e.pdf+'"><div class="leftItem"><img class="boxImage" src="'+e.imageurl+'"></img></div><div class="rightItem">'+e.heading+'</div></div>'
    });
}

window.onresize = function(event) {
    console.log("blah");
    timeline.redraw();
}

$(document).ready(function() {

    
    $('#toggle-search').click(function(){
    	$('.post').hide();
    	/* $('#timeline').hide(); */
    	$('#search').show();
    	$('.story').show();
	}); 
	
	$('#toggle-post').click(function(){
    	$('.post').show();
    	$('#timeline').show();
    	$('#search').hide();
    	$('.story').hide();
	}); 
	
	$('#toggle-map').click(function(){
    	$('.post').hide();
    	$('#timeline').show();
    	$('#search').hide();
    	$('.story').hide();
	});  
	           
	/*
$('.share').click(function(){
    	console.log('Share');
	});
	
	$('.timeline-help').click(function(){
    	console.log('Help');
	});
	
	$('.timeline-zoom-in').click(function(){
    	console.log('Zoom In');
	});
	
	$('.timeline-zoom-out').click(function(){
    	console.log('Zoom Out');
	});
*/
	
});