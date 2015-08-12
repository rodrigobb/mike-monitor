window.onload = function()
{
    var socket = io.connect('http://rodri.net:8080');
    socket.on('push_notification', event_received);
}


var event_received = function (data) {
    console.debug(data);
    var time = data.minutes + 'm ' + data.seconds + 's';
    var text = time+"__"+data.routing_key;

    add_node('general', text);

    if (data.routing_key.indexOf('.homepage.') > 0) {
        add_node('homepage', text);
    }

    if (data.routing_key.indexOf('.ping.') > 0) {
        add_node('ping', text);
    }
}

function add_node(key, text) {
    var node = document.createElement("LI");
    var textnode = document.createTextNode(text);
    node.appendChild(textnode);

    document.querySelector('#'+key+'_log').appendChild(node);
}