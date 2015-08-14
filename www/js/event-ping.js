var event_received = function (data) {
    console.debug(data);
    var date = new Date(data.timestamp * 1000);
    var text = date + " " + JSON.stringify(data);

    add_node('general', text);

    if (data.routing_key.indexOf('.ping.') > 0) {
        add_node('ping', text);
        //myBarChart.datasets[0].bars[0].value += data.total;
        //myBarChart.update();
    }

    if (myLineChart.datasets[0].points.length > 40) {
        myLineChart.removeData();
    }

    myLineChart.addData([data.ping], date.getHours() + ":" + date.getMinutes() + ":" + date.getSeconds());
};
