(function(){
	'use strict';

  	angular.module('adimovelApp').controller('ChartCtrl', ChartCtrl);

  	function ChartCtrl(){

		var ctx = document.getElementById("myChart").getContext("2d");
		var data = {
		    labels: ["Imóveis Vendidos", "Imóveis Alugados", "Clientes Novos"],
		    datasets: [
		        {
		            label: "Imóveis Vendidos",
		            fillColor: "#09f",
		            strokeColor: "#09f",
		            highlightFill: "#09f",
		            highlightStroke: "rgba(220,220,220,1)",
		            data: [65, 59, 80]
		        },
		        {
		            label: "My Second dataset",
		            fillColor: "#FF4081",
		            strokeColor: "#FF4081",
		            highlightFill: "#FF4081",
		            highlightStroke: "rgba(151,187,205,1)",
		            data: [28, 48, 40]
		        }
		    ]
		};	
		var options = {
		    //Boolean - Whether the scale should start at zero, or an order of magnitude down from the lowest value
		    scaleBeginAtZero : true,

		    //Boolean - Whether grid lines are shown across the chart
		    scaleShowGridLines : true,

		    //String - Colour of the grid lines
		    scaleGridLineColor : "rgba(0,0,0,.05)",

		    //Number - Width of the grid lines
		    scaleGridLineWidth : 1,

		    //Boolean - Whether to show horizontal lines (except X axis)
		    scaleShowHorizontalLines: true,

		    //Boolean - Whether to show vertical lines (except Y axis)
		    scaleShowVerticalLines: true,

		    //Boolean - If there is a stroke on each bar
		    barShowStroke : true,

		    //Number - Pixel width of the bar stroke
		    barStrokeWidth : 2,

		    //Number - Spacing between each of the X value sets
		    barValueSpacing : 5,

		    //Number - Spacing between data sets within X values
		    barDatasetSpacing : 1,

		    //String - A legend template
		    legendTemplate : "<ul class=\"<%=name.toLowerCase()%>-legend\"><% for (var i=0; i<datasets.length; i++){%><li><span style=\"background-color:<%=datasets[i].fillColor%>\"></span><%if(datasets[i].label){%><%=datasets[i].label%><%}%></li><%}%></ul>"

		}
		var myBarChart = new Chart(ctx).Bar(data, options);
		setInterval(function(){
			myBarChart.datasets[0].bars[0].value = Math.floor((Math.random() * 70) + 20);
			myBarChart.datasets[0].bars[1].value = Math.floor((Math.random() * 70) + 20);
			myBarChart.datasets[0].bars[2].value = Math.floor((Math.random() * 70) + 20);
			// Would update the first dataset's value of 'March' to be 50
			myBarChart.update();
		}, 10000);
	};

})();