/**
 * Created by rodrigo on 14/8/15.
 */

var myLineChart = null,
    myBarChart = null;

var start_chart = function()
{
    // Get the context of the canvas element we want to select
    var ctx = null; document.getElementById("myLineChart").getContext("2d");
    var options = {};

    ctx = document.getElementById("myLineChart").getContext("2d");
    myLineChart = new Chart(ctx).Line(line_chart_data, options);

    ctx = document.getElementById("myBarChart").getContext("2d");
    myBarChart = new Chart(ctx).Bar(bar_chart_data, options);
};

var line_chart_data = {
    labels: [],
    datasets: [
        {
            label: "Eventos de entrada",
            fillColor: "rgba(151,187,205,0.2)",
            strokeColor: "rgba(151,187,205,1)",
            pointColor: "rgba(151,187,205,1)",
            pointStrokeColor: "#fff",
            pointHighlightFill: "#fff",
            pointHighlightStroke: "rgba(151,187,205,1)",
            data: []
        }
    ]
};

var bar_chart_data = {
    labels: ["PING", "HOMEPAGE"],
    datasets: [
        {
            label: "Totals",
            fillColor: "rgba(220,220,220,0.5)",
            strokeColor: "rgba(220,220,220,0.8)",
            highlightFill: "rgba(220,220,220,0.75)",
            highlightStroke: "rgba(220,220,220,1)",
            data: [0,0]
        }
    ]
};