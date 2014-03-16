<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
</head>
<body>
<style>
	body {margin:0;}
	g {
		fill: none;
	}
	g text {
		fill : black;
	}
	line {
		stroke: #ddd;
		fill: none;
	}
	.mainLine {
		stroke: red;
		fill: none;
		stroke-width: 2px;
	}

	svg {
		background :#eee;
	}
</style>
<ul class="stats">
	<li class="highest">highest ever {{$highest->total}} on {{$highest->created_at}}</li>
	<li class="lowest">lowest ever {{$lowest->total}} on {{$lowest->created_at}}</li>
	<li class="latest">The last count was {{$latest->total}} and was recorded at {{$latest->created_at}}</li>
	<li class="total">Currently showing <span></span> data points</li>
	<li class="changeFirstLast">change in the first and last points: <span></span></li>
	<li class="changeLastTwo">change in the last two points: <span></span></li>
</ul>

	<script src="<?php echo asset('/bower_components/d3/d3.js'); ?>"></script>
	<script src="<?php echo asset('/library/js/app.js'); ?>"></script>
</body>
</html>