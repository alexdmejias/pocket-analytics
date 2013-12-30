<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
</head>
<body>
<style>
				path {
				stroke: steelblue;
				stroke-width: 1;
				fill: none;
			}

			.axis {
			  shape-rendering: crispEdges;
			}

			.x.axis line {
			  stroke: lightgrey;
			}

			.x.axis .minor {
			  stroke-opacity: .5;
			}

			.x.axis path {
			  display: none;
			}

			.y.axis line, .y.axis path {
			  fill: none;
			  stroke: #000;
			}
</style>
<ol>
</ol>
	<canvas id="chart" height="700" width="700"></canvas>
	<script src="<?php echo asset('/bower_components/jquery/jquery.js'); ?>"></script>
	<script src="<?php echo asset('/bower_components/chartjs/Chart.js'); ?>"></script>
	<script src="<?php echo asset('/library/js/app.js'); ?>"></script>
</body>
</html>