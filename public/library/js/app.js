(function($) {
	$.get('/pocket/counts/30', function(data) {
		dataLoaded(data);
	}, 'json');

	var jsonData,
		chartLabels,
		chartData,
		chartOptions;

	extractData = function(data) {
		chartLabels = [];
		chartData = [];
		for(var i = 0; i < jsonData.length; i++) {
			chartLabels.push(jsonData[i].created_at);
			chartData.push(jsonData[i].total);
		}
		console.log(chartLabels, chartData);
	}

    function genChartOptions(labels, points) {
    	chartOptions = {
			labels : labels,
			datasets : [
				{
					fillColor : "rgba(220,220,220,0.5)",
					strokeColor : "rgba(220,220,220,1)",
					pointColor : "rgba(220,220,220,1)",
					pointStrokeColor : "#fff",
					data : points
				}
			],
	    }
    };

	function dataLoaded(data) {
		jsonData = data;

		extractData(jsonData.reverse());
		genChartOptions(chartLabels, chartData);
		makeChart('chart', chartOptions);
	}

	options = {
		pointDotRadius : 3,
		// scaleOverride : true,
		//Number - The number of steps in a hard coded scale
		// scaleSteps : 30,
		//Number - The value jump in the hard coded scale
		// scaleStepWidth : 5,
		//Number - The scale starting value
		// scaleStartValue : 400,
	};

    function makeChart(el, data) {
	    return new Chart(document.getElementById(el).getContext("2d")).Line(data, options);
    }

})(jQuery)