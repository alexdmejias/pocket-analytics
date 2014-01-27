app = {
	json : '',
 	chartInfo : {},
 	data : {},
 	timer : null,
 	totalData : null,
 	defaultRequestNum : 24,
 	hasCanvas: false,

	prepareData : function(data) {
		app.data.labels = [];
		app.data.totals = [];
		for(var i = 0; i < app.json.length; i++) {
			total = app.json[i].total;

			app.data.labels.push('['+i+'] '+ app.json[i].created_at.substr(5,11) + ' hours ['+total+']');
			app.data.totals.push(total);
		}
	},

    genChartOptions : function(labels, data) {
    	app.chartInfo = {
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

    makeCanvas : function() {
    	$('body').append('<canvas id="chart" height="900" width="700" />');
    	app.hasCanvas = true;
    },

    resizeCanvas : function() {
    	$chart = $('#chart');
    	$chart.attr('width', ($(window).width() - 50));
    	app.renderChart('chart', app.chartInfo);
    },

    renderChart : function(el, data) {
	    return new Chart(document.getElementById(el).getContext("2d")).Line(data.data, data.options);
    },

	showChange: function(el, index1, index2){
		if(!app.totalData) {
			app.getTotalData()
		}

		if((0 > index1) || (0 > index2)) {
			alert('not enough data. index1 = '+index1 + ' index2='+index2);
		} else {
			change = app.data.totals[index1] - app.data.totals[index2];
			if(change > 0) {
				change = '+'+change;
			}
		}
		$('.stats').children(el).children('span').text(change);
		return 'datapoints user were '+index2+'-'+index1;
	},

	getTotalData : function() {
		app.totalData = app.data.totals.length;

		return app.totalData;
	},

	requestComplete : function(data) {
		app.json = data;
		app.prepareData(app.json.reverse());
		app.genChartOptions(app.data.labels, app.data.totals);

		if (!app.hasCanvas) {
			app.makeCanvas();
			app.resizeCanvas();
		}
		app.renderChart('chart', app.chartInfo);
		app.getTotalData();
		$('.stats').children('.total').children('span').text(app.totalData);
		app.showChange('.changeFirstLast', app.totalData - 1, 0);
		app.showChange('.lastTwo', app.totalData - 1, app.totalData - 2);
	},

	makeRequest: function(num) {
		return $.ajax({
			url: '/pocket/counts/'+num,
		}).promise().done(app.requestComplete);

	}

}

app.makeRequest(app.defaultRequestNum);

$(window).on('resize', function() {
	clearTimeout(app.timer);
	app.timer = setTimeout(function() {
		app.resizeCanvas();
	}, 300);
})