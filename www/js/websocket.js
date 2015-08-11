window.onload = function()
{
    var socket = io.connect('http://rodri.net:8080');
    socket.on('update', update_log);
}


var update_log = function (data) {
    var time = data.minutes + 'm ' + data.seconds + 's';

    var node = document.createElement("LI");
    var textnode = document.createTextNode(time);
    node.appendChild(textnode);                              // Append the text to <li>
    document.querySelector('#log').appendChild(node);
}