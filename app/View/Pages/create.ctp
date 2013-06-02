<script type="text/javascript" src="/js/lib/angular.js"></script>
<script type="text/javascript" src="/js/app.js"></script>
<script type="text/javascript" src="/js/controllers/create.js"></script>
<script type="text/javascript" src="/js/controllers/search.js"></script>
<script type="text/javascript" src="/js/controllers/story.js"></script>
<script type="text/javascript" src="/js/directives/timeline.js"></script>
<script type="text/javascript" src="/js/directives/map.js"></script>
<script type="text/javascript" src="/js/services/services.js"></script>
<script type="text/javascript" src="/js/filters/filters.js"></script>

<link rel='stylesheet' href='/css/style3.css' />

<div ng-app="historify">
	<div class="navbar navbar-static-top">
		<div class="navbar-inner">
			<a class="brand" href="/"></a>
		</div>
	</div>
    <ng-view></ng-view>
	
	<!-- Content -->
	<div id="content">
		
	<!-- JQuery -->
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
	<script>
		if (!window.jQuery) {
	   		document.write('<script src="/js/lib/jquery-1.9.1.min.js"><\/script>');
	   	}
	</script>
    <script type="text/javascript" src="/js/lib/timeline.js"></script>
	<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false"></script>

	<script type="text/javascript" src="/js/lib/google-maps.js"></script>
        
</div>