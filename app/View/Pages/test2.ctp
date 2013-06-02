<div id='gallery'><div id='internal'>
<?php
	$i=0;
	foreach($photos as $photo) {
		echo '<div class="photo">';
		echo '<h2>'.$photo[1].'</h2>';
		echo '<p>';
		print_r($photo[4].$photo[5].$photo[6]);
		echo '</p>';
		echo '<img src="/files/myouseum150-images/'.$photo[0].'.jpg" />';
		echo '</div>';
		if($i > 100) {
			break;
		}
		$i++;
	}
?>
</div>
</div>
<script>
	function moveForward() {
		console.log("MOVIN");
		var currentX = $('#internal').css('margin-left');
		currentX = parseInt(currentX, 10)-1;
		$('#internal').css({'margin-left':currentX});
	}
	window.setInterval(moveForward,30);
</script>

<style>
	div#gallery {
		height:600px;
		border:1px solid red;
		overflow:scroll;
		width:100000px;
	}
	div#gallery div.photo {
		float:left;
		width:300px;
		border:1px solid #333;
		text-align:center;
		margin:10px;
	}
	div#gallery h2 {
		height:60px;
		font-size:140%;
		color:#999;
		line-height:1.2em;
	}
</style>