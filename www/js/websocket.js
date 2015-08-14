var start_websocket = function()
{
    var socket = io.connect('http://rodri.net:8080');
    socket.on('push_notification', event_received);
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