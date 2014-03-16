var app = {
	data: null, // global variable to house the data
	width: null,
	height: 600, // height of the graph
	margin: {
		top: 20,
		right: 20,
		bottom: 100,
		left: 50
	},
	body: d3.select('body'),
	svg: null,
	line: null,
	x: null,
	y: null,
	amountOfData: 40, // # of data points to initially show

	/**
	 * sets up various variables for the graph
	 * before the ajax request
	 */
	setup: function() {
		app.width= document.documentElement.clientWidth - app.margin.left - app.margin.right;
		app.height= app.height - app.margin.top - app.margin.bottom;

		app.svg = app.body.append('svg')
			.attr({
				width: app.width + app.margin.left + app.margin.right,
				height: app.height + app.margin.top + app.margin.bottom
			})
			.append("g").attr("transform", "translate(" + app.margin.left + "," + app.margin.top + ")");

		app.parseDate = d3.time.format('%Y-%m-%d %X').parse;

		app.x = d3.scale.linear()
			.range([0, app.width]);

		app.y = d3.scale.linear()
			.range([app.height, 0]);

		app.line = d3.svg.line()
			.x(function (d, i) { return app.x(i)})
			.y(function (d) { return app.y(d.total)});
	},

	/* Draws the main graph line */
	drawMainLine: function() {
		app.svg.append('path')
			.datum(app.data)
			.attr('d', app.line)
			.attr('class', 'mainLine')
	},

	/* Draws both of the axes */
	drawAxis: function () {
		app.xAxis = d3.svg.axis()
			.scale(app.x)
			.tickFormat( function (d, i) { return String(app.data[i].created_at).substr(4,20)})
			.tickSize( -app.height)
			.orient("bottom")

		app.yAxis = d3.svg.axis()
			.scale(app.y)
			.tickSize(-app.width)
			.orient('left')


		app.svg.append('g')
			.attr('transform', 'translate(0,'+app.height+')')
			.attr('class', 'axis')
			.call(app.xAxis)
			.selectAll('text')
				.attr('transform', 'rotate(-45)')
				.attr('dx', '-.8em')
				.style('text-anchor', 'end')
				.style('font-size', '12px')

		app.svg.append('g')
			.call(app.yAxis)
	},

	drawCircles: function() {
		app.svg.append('g')
			.selectAll('circle')
			.data(app.data)
			.enter()
			.append('circle')
			.attr({
				cy: function(d) { return app.y(d.total)},
				cx: function(d, i) { return app.x(i)},
				r: 5,
				fill: 'red'
			})
/*			.on('mouseover', function (d, i) {
				d3.select(this).attr({
					fill: 'blue'
				})
			})*/
	},

	drawOthers: function () {
		// app.svg.append('g')
			// .selectAll
	},

	updateHeaderData: function() {
		var list = document.getElementsByTagName('ul')[0];
		getStatItemSpan = function(elem, text) {
			var span = list.getElementsByClassName(elem)[0].getElementsByTagName('span')[0];
				text = document.createTextNode(text);
			span.appendChild(text);
		}

		var dataLength = app.data.length;
		getStatItemSpan('total', dataLength);
		getStatItemSpan('changeFirstLast', (app.data[dataLength - 1].total - app.data[0].total) );
		getStatItemSpan('changeLastTwo', (app.data[dataLength - 1].total - app.data[dataLength - 2].total) );
	},

	// Callback for when the ajax has been downlaoded
	done: function() {
		app.data.forEach( function(d) {
			d.created_at = app.parseDate(d.created_at);
			d.total = +d.total;
		})

		app.x.domain(d3.extent(app.data, function(d, i) { return i; }));
		app.y.domain(d3.extent(app.data, function(d, i) { return d.total; }));

		app.drawAxis();
		app.drawMainLine();
		app.drawCircles();
		app.drawOthers();

		app.updateHeaderData();

	},

	init: function() {
		app.setup();

		d3.json("pocket/"+app.amountOfData, function(error, json) {

			app.data = json.reverse();
			console.log('done loading data')
			app.done();
		});
	}
};

(function() {
app.init();
})();