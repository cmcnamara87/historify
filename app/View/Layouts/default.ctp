<!DOCTYPE html>
<html lang="en">
<head>
	<title>Historify - History at your fingertips</title>
	<meta charset="utf-8">
	<meta name="description" content="TimelineJS example">
	<meta name="apple-mobile-web-app-capable" content="yes">
	<meta name="apple-touch-fullscreen" content="yes">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
	<?php
		echo $this->Html->meta('icon');
		echo $this->fetch('meta');
		echo $this->fetch('css');
		echo $this->fetch('script');
	?>
	<link rel="stylesheet" type="text/css" href="/css/normalize.css" />
	<link rel="stylesheet" type="text/css" href="/css/bootstrap.min.css" />
	<link rel="stylesheet" type="text/css" href="/css/bootstrap-responsive.min.css" />
	<link rel="stylesheet" type="text/css" href="/css/font-awesome.min.css" />
	<link rel="stylesheet" type="text/css" href="/css/timeline.css" />
	<!--[if lt IE 9]><script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script><![endif]-->
	<script type='text/javascript' src='http://code.jquery.com/jquery-1.10.1.min.js'></script>
</head>


<body>
			<?php echo $this->Session->flash(); ?>

			<?php echo $this->fetch('content'); ?>
</body>
</html>
