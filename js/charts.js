// Load the Visualization API and the piechart package.
google.load(
	'visualization', 
	'1.0', 
	{
		'packages': [
			'corechart'
		]
	}
);

google.setOnLoadCallback(makeChartsFromTables);

function makeChartsFromTables() {
	if (window.jQuery) {
		jQuery(
			function ($) {
				$('table.chart').each(
					function () {
						// Create the data table.
						var data,
							t = [],
							i, 
							l,
							options = {
								title: $('caption', this).text(),
								width: '100%',
								height: 600,
								hAxis: {
									title: $(this).attr('data-xaxis')
								},
								vAxis: {
									title: $(this).attr('data-yaxis')
								},
								isStacked: $(this).attr('data-stacked') === '1'
							},
							$div = $('<div></div>'),
							chart,
							charttype = {vbar: 'ColumnChart', hbar: 'BarChart', pie: 'PieChart', line: 'LineChart', combo: 'ComboChart'}[$(this).attr('data-charttype')] || 'ColumnChart',
							combolinepos = [],
							series = {};
							
						if (charttype === 'ComboChart') {
							combolinepos = $(this).attr('data-combo-linepos');
							combolinepos = combolinepos.length > 0 ? combolinepos.split(/, ?/) : [];
					    	options.seriesType = "bars";
					    	for (i = 0, l = combolinepos.length; i < l; i++) {
					    		series[combolinepos[i]] = {type: "line"};
							}
							options.series = series;
						}
						$('tr', this).each(
							function (i) {
								t[i] = [];
								$('th, td', this).each(
									function (j) {
										t[i].push(i === 0 || j === 0 ? $(this).text() : $(this).text() | 0);
									}
								);
							}
						);
						data = google.visualization.arrayToDataTable(
							t,
							false // first column is a label column.
						);
						// Instantiate and draw our chart, passing in some options.
						$(this)
							.before($div)
							.hide();
						chart = new google.visualization[charttype]($div[0]);
						chart.draw(data, options);
					}
				);
			}
		);
	}
}
