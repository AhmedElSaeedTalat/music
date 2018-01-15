var http = require('http').Server();
var io = require('socket.io')(http);
var Redis = require('ioredis');
var redis = new Redis();

redis.subscribe('eve');

redis.on('message',function(channel,message){
	var data = JSON.parse(message);
	console.log(message);
	io.emit('info',data.name);
});

http.listen(3000);
