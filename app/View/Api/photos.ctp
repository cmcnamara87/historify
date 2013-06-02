<?php
	foreach($photos as $photo) {
		print_r($photo);
	}
?>
<img class='ceeq' src='http://www.jhrs.org/Resources/Pictures/Jun%20Face%20Pic.jpg' />
<script type='text/javascript' src='/js/photo_ceeqapi.js'></script>
<script type='text/javascript'>
	$(document).ready(function() {
		$('img.ceeq').each(function() {
			upload($(this));
		});
	})
</script>

<style>
.PhotoCell--photoWrapper {
	position:absolute;
	top:0;
	bottom:0;
	left:0;
	right:0;
}
.PhotoCell--tag {
	position: absolute;
	border: 10px solid red;
}
</style>