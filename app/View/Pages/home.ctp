<link rel='stylesheet' href='/css/style3.css' />
<link rel='stylesheet' href='/css/style_home.css' />
<div class="navbar navbar-static-top">
	<div class="navbar-inner">
		<button class="btn btn-large btn-block btn-success" id="createbutton" onclick="window.location='/pages/create';">Create</button>
		<a class="brand" href="http://historify.ensense.net/"></a>
	</div>
</div>
<script src="http://code.angularjs.org/1.0.6/angular.min.js"></script>
	<div ng-app>
	<div class="container">
        <div class="row">
            <div class="span12">
                    <div id="search">
                            <input type="text" id="searchtext" placeholder="Search..." ng-model="searchText"/>
                            <button class="btn-primary" id="searchbutton">Search</button>
                    </div>
            </div>
            <div class="span12 offset1">
            <div ng-init='stories = <?php echo json_encode($stories); ?>'></div>
		<div ng-repeat="story in stories | filter:searchText">
			<a href="/pages/create#/story/{{story.Story.id}}"><div class="story span3"><div class="entry"><h3>{{story.Story.name}}</h3><p>{{story.Story.slugline}}</p><p class="author">by {{story.Story.author}}</p></div><div class="bottom">{{story.Story.articlelength}} articles</div></div></a>
			
		</div>
            </div>
        </div>
	</div>