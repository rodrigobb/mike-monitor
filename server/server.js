// Create context using rabbit.js (cfr ZMQ),
// io and the subscriber socket.
var context = require('rabbit.js').createContext(),
    io = require('socket.io').listen(8080),
    sub = context.socket('SUB', {routing: 'topic'});

// Set correct encoding.
sub.setEncoding('utf8');

// A websocket is connected (eg: browser).
io.sockets.on('connection', function(socket) {

    // Connect socket to 'mike_monitor' exchange (all topics).
    sub.connect('mike_monitor', '#');

    // Register handler that hanles incoming data when the socket
    // detects new data on our queues.
    // When receiving data, it gets pushed to the connectec websocket.
    sub.on('data', function(data) {
        var message = JSON.parse(data);
        socket.emit(message.socket_id, message.body);
    });
});
