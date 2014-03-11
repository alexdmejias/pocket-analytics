<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
</head>
<body>
<style>
	body {margin:0;}
</style>
<ul class="stats">
	<li class="highest">highest {{$highest->total}} on {{$highest->created_at}}</li>
	<li class="lowest">lowest {{$lowest->total}} on {{$lowest->created_at}}</li>
	<li class="total">Currently showing <span></span> data points</li>
	<li class="latest">The last count was {{$latest->total}} and was recorded at {{$latest->created_at}}</li>
	<li class="changeFirstLast">change in the first and last points: <span></span></li>
	<li class="lastTwo">change in the last two points: <span></span></li>
</ul>

	<script src="<?php echo asset('/bower_components/jquery/jquery.js'); ?>"></script>
	<script src="<?php echo asset('/bower_components/chartjs/Chart.js'); ?>"></script>
	<script src="<?php echo asset('/library/js/app.js'); ?>"></script>
</body>
</html>