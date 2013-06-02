<?php
	foreach($data->response->zone[0]->records->article as $article) {
		echo '<h2>'.$article->title->value.'</h2>';
		echo '<img src="'.$article->imageurl.'" />';
		echo '<p>'.$article->fulltext.'</p>';
	}
?>