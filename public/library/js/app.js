project = {
	jsonData : '',
 	chartInfo : {},
 	chartLabels : [],
 	chartData : [],

	extractData : function(data) {
		project.chartLabels = [];
		project.chartData = [];
		for(var i = 0; i < project.jsonData.length; i++) {
			project.chartLabels.push(project.jsonData[i].created_at);
			project.chartData.push(project.jsonData[i].total);
		}

		// project.chartData.splice(0,1);
		// project.chartLabels.splice(0,1);
	},

    genChartOptions : function(labels, data) {
    	project.chartInfo = {
			data: {
				labels : labels,
				datasets : [
					{
						fillColor : "rgba(220,220,220,0.5)",
						strokeColor : "rgba(220,220,220,1)",
						pointColor : "rgba(220,220,220,1)",
						pointStrokeColor : "#fff",
						data : data
					}
				]
		    },
			options : {
				pointDotRadius : 3,
				scaleOverride : true,
				scaleSteps : Math.max.apply(null, data) - Math.min.apply(null, data),
				scaleStepWidth : 1,
				scaleStartValue : Math.min.apply(null, data)
			}
		}
    },

    makeChart : function(el, data) {
	    return new Chart(document.getElementById(el).getContext("2d")).Line(data.data, data.options);
    },

	dataLoaded : function(data) {
		project.jsonData = data;
		project.extractData(project.jsonData.reverse());
		project.genChartOptions(project.chartLabels, project.chartData);
		project.makeChart('chart', project.chartInfo);
	},

	makeRequest : function(entries) {
		$.get('/pocket/counts/'+entries, function(data) {
			project.dataLoaded(data);
		}, 'json');
	}

}

project.makeRequest();