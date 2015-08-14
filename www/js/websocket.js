var start_websocket = function()
{
    var socket = io.connect('http://rodri.net:8080');
    socket.on('push_notification', event_received);
};


var event_received = function (data) {
    console.debug(data);
    var date = new Date(data.timestamp * 1000);
    var text = date + " " + JSON.stringify(data);

    add_node('general', text);

    if (data.routing_key.indexOf('.homepage.') > 0) {
        add_node('homepage', text);
        myBarChart.datasets[0].bars[0].value += data.total;
        myBarChart.update();
    }

    if (data.routing_key.indexOf('.ping.') > 0) {
        add_node('ping', text);
        myBarChart.datasets[0].bars[1].value += data.total;
        myBarChart.update();
    }

    if (myLineChart.datasets[0].points.length > 10) {
        myLineChart.removeData();
    }

    myLineChart.addData([data.total], date.getHours() + ":" + date.getMinutes() + ":" + date.getSeconds());
};

function add_node(key, text) {
    var list = document.querySelector('#'+key+'_log');

    if (list == undefined) {
        return;
    }

    var node = document.createElement("LI");
    var textnode = document.createTextNode(text);
    node.appendChild(textnode);

    list.insertBefore(node, list.childNodes[0]);
}