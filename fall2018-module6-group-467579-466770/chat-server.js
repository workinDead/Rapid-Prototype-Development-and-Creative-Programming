// Require the packages we will use:
var http = require("http"),
	socketio = require("socket.io"),
	fs = require("fs");

// Listen for HTTP connections.  This is essentially a miniature static file server that only serves our one file, client.html:
// with css
var app = http.createServer(function (request, response) {
    if (request.url === "/main.css") { // important to run locally
      fs.readFile("main.css", function(err, data){
        if (err) return response.writeHead(500);
        response.writeHead(200, {"Content-Type": "text/css"});
        response.end(data);
      })
    }
    else {
      response.writeHead(200, {"Content-Type": "text/html"});
      fs.readFile("client.html", function(err, data){
        if(err) return response.writeHead(500);
        response.writeHead(200);
        response.end(data);
      });
    }
  })
  app.listen(3456);
  // app.listen(3000);

// global variables
var io = socketio.listen(app);
var clients = {};
var rooms = {};
var num_of_client = 0;
var colors = ["#D50000","#F6BF26","#E67C73","#33B679","#F4511E","#0B8043","#039BE5","#3F51B5","#8E24AA","#616161"];
if(isNaN(rooms['default'])){
  rooms['default'] = {isPrivate:false,roompwd:NaN,members:new Set([]),desc:"This is created by server and cannot be edited by any client"};
}else{
}


io.sockets.on("connection", function(socket){
  
  // This callback runs when a new Socket.IO connection is established.
  var useradded = false;
  var cur_roomname = 'default';
  // when connected, add user lists first
  socket.on('add_client',function(data){
    if(!(clients.hasOwnProperty(data.username))){

      socket.username = data.username;
      clients[ data.username] = {"socket":socket.id}; 
      num_of_client = num_of_client + 1 ;
      const color = colors[(num_of_client%(colors.length))];
      socket.color = color;

      useradded = true;
      // join to default chat plaza
      socket.join(cur_roomname);
      
      socket.cur_roomname = cur_roomname;
      rooms[cur_roomname]['members'].add(data.username);
      socket.emit("loginmsg_to_client",true);
      socket.broadcast.to(socket.cur_roomname).emit("logmsg_to_client",{msg:true,username:socket.username}); // true: in ; false: out
      io.to(socket.cur_roomname).emit("show_curmembers",{isCreator:false,members:Array.from(rooms[socket.cur_roomname].members)});
      io.to(socket.cur_roomname).emit("show_roomdesc",{desc:rooms[socket.cur_roomname].desc});


      io.sockets.emit("show_roomlist",rooms);
      io.sockets.emit("show_clientlist",clients);
      }else{
        socket.emit("loginmsg_to_client",false);
      }
  });

  // add a new chat room
  socket.on('add_chatroom',function(roomname,roompwd,blacklist,desc){  
      if(!(rooms.hasOwnProperty(roomname))){
        socket.emit("roommsg_to_client",{msg:true,dialogtype:"add"});
        if(roompwd.length>0){
          var isPrivate = true;
          rooms[roomname] = {creator:socket.username,isPrivate:isPrivate,roompwd:roompwd,members:new Set([]),blacklist:new Set(blacklist),desc:desc};
          io.sockets.emit("show_roomlist",rooms);
        }else{
          var isPrivate = false;
          rooms[roomname] = {creator:socket.username,isPrivate:isPrivate,roompwd:NaN,members:new Set([]),blacklist:new Set(blacklist),desc:desc};
          io.sockets.emit("show_roomlist",rooms);
        }
      }else{
        //wheather add chatroom successfully
        socket.emit("roommsg_to_client",{msg:false,dialogtype:"add"});
      }
  });

    // Edit a chat room
    socket.on('edit_chatroom',function(prev_roomname,roomname,roompwd,blacklist,desc){  
      if((rooms.hasOwnProperty(prev_roomname))){
        // members in previous room
        const prev_members = rooms[prev_roomname]['members'];

        delete rooms[prev_roomname];
        
        socket.emit("roommsg_to_client",{msg:true,dialogtype:"edit"});
        if(roompwd.length>0){
          var isPrivate = true;
          // console.log(rooms[roomname]);
          rooms[roomname] = {creator:socket.username,isPrivate:isPrivate,roompwd:roompwd,members:new Set([]),blacklist:new Set(blacklist),desc:desc};
          // console.log(rooms[roomname].roompwd);
        }else{
          var isPrivate = false;
          rooms[roomname] = {creator:socket.username,isPrivate:isPrivate,roompwd:NaN,members:new Set([]),blacklist:new Set(blacklist),desc:desc};
        }
        Array.from(blacklist).forEach(member => {
          io.to(clients[member].socket).emit("kick_to_client","default");
        });
        if(prev_roomname!=roomname){ // indicates roomname has changed
          Array.from(prev_members).forEach(member => {
            io.to(clients[member].socket).emit("kick_to_client",roomname);
          });
        }
        io.sockets.emit("show_roomlist",rooms);
        io.to(roomname).emit("show_roomdesc",{desc:rooms[roomname].desc});
      }else{
        socket.emit("roommsg_to_client",{msg:false,dialogtype:"edit"});

      }  
    });

  // update chatroom info when someone joins
  socket.on("switch_chatroom",function(data){

    var roomname = data.roomname;
    // check whether client join new room
    if(roomname!=socket.cur_roomname){
    if(roomname=="default"){
      if(rooms.hasOwnProperty(socket.cur_roomname)){
        // leave room
        socket.leave(socket.cur_roomname);
        // update room info
        rooms[socket.cur_roomname]['members'].delete(socket.username);
        socket.broadcast.to(socket.cur_roomname).emit("logmsg_to_client",{msg:false,username:socket.username}); // true: in ; false: out
        io.to(socket.cur_roomname).emit("show_curmembers",{creator:rooms[socket.cur_roomname].creator,members:Array.from(rooms[socket.cur_roomname].members)});
        io.to(socket.cur_roomname).emit("show_roomdesc",{desc:rooms[socket.cur_roomname].desc});
      }

      socket.join(roomname);
      cur_roomname = roomname;
      socket.cur_roomname = roomname;
      rooms[roomname]['members'].add(socket.username);
      // broadcast to everyone
      io.sockets.emit("show_roomlist",rooms);
  
      const curmembers = Array.from(rooms[socket.cur_roomname].members);
      socket.broadcast.to(socket.cur_roomname).emit("logmsg_to_client",{msg:true,username:socket.username}); // true: in ; false: out
      io.to(socket.cur_roomname).emit("show_curmembers",{creator:rooms[socket.cur_roomname].creator,members:curmembers});
      io.to(socket.cur_roomname).emit("show_roomdesc",{desc:rooms[socket.cur_roomname].desc});
      socket.emit("switchmsg_to_client",{msg:true,roomname:roomname});
      
    }else{
      if(!rooms[roomname]['blacklist'].has(socket.username)){

      if(rooms.hasOwnProperty(socket.cur_roomname)){
        // leave room
        socket.leave(socket.cur_roomname);
        // update room info
        rooms[socket.cur_roomname]['members'].delete(socket.username);
        socket.broadcast.to(socket.cur_roomname).emit("logmsg_to_client",{msg:false,username:socket.username}); // true: in ; false: out
        io.to(socket.cur_roomname).emit("show_curmembers",{creator:rooms[socket.cur_roomname].creator,members:Array.from(rooms[socket.cur_roomname].members)});
        io.to(socket.cur_roomname).emit("show_roomdesc",{desc:rooms[socket.cur_roomname].desc});
      }
      
      socket.join(roomname);
      cur_roomname = roomname;
      socket.cur_roomname = roomname;
      rooms[roomname]['members'].add(socket.username);
      // broadcast to everyone
      io.sockets.emit("show_roomlist",rooms);
  
      const curmembers = Array.from(rooms[socket.cur_roomname].members);
      socket.broadcast.to(socket.cur_roomname).emit("logmsg_to_client",{msg:true,username:socket.username}); // true: in ; false: out
      io.to(socket.cur_roomname).emit("show_curmembers",{creator:rooms[socket.cur_roomname].creator,members:curmembers});
      io.to(socket.cur_roomname).emit("show_roomdesc",{desc:rooms[socket.cur_roomname].desc});
      socket.emit("switchmsg_to_client",{msg:true,roomname:roomname});
      }else{
        socket.emit("switchmsg_to_client",{msg:false});
      }
    }
    }else{
      socket.emit("stayroom_switch",{roomname:socket.cur_roomname});
    }

  });

  // function require priority
  socket.on("kick_to_server",function(member){
    // send leaving room msg to client
    io.to(clients[member].socket).emit("kick_to_client","default");

  });

  socket.on("pwd_to_server",function(data){
    const roomname = data.roomname;
    const password = data.password;

    if(rooms[roomname].roompwd==password){
      socket.emit("pwdmsg_to_client",{roomname:roomname,msg:true});
    }else{
      socket.emit("pwdmsg_to_client",{msg:false});
    }
  });

  // send messages
  socket.on('private_message',function(person,msg){
    if(person!=socket.username){
    socket.emit("message_to_client",{username:socket.username,message:msg,color:socket.color}); // send back to sender 
    }
    io.to(clients[person].socket).emit("message_to_client",{username:socket.username,message:msg,color:socket.color}); // private messsage to reader only 
  });
  socket.on('public_message',function(room,msg){
    io.to(room).emit("message_to_client",{username:socket.username,message:msg,color:socket.color}); // to everyone including the sender
  }); 


  // when client is typing, broadcast to each room
  socket.on('start_typing', function () {
      socket.broadcast.to(socket.cur_roomname).emit('start_typing', {
        username: socket.username
      });
    });
  
  // when client stops typing, broadcast to each room
  socket.on('stop_typing', function () {
    socket.broadcast.to(socket.cur_roomname).emit('stop_typing', {
        username: socket.username
      });
    });

  socket.on('disconnect',function(){  // logout link 
    if(useradded){
      num_of_client = num_of_client -1;
      rooms[socket.cur_roomname]['members'].delete(socket.username); // delete disconnected client from current room
      delete clients[socket.username]; //delete from clients
      useradded = false; // initialize
      socket.leave(cur_roomname);
      io.sockets.emit("show_roomlist",rooms); // broadcast to all
      io.sockets.emit("show_clientlist",clients); // broadcast to all
      io.to(socket.cur_roomname).emit("show_curmembers",{creator:rooms[socket.cur_roomname].creator,members:Array.from(rooms[socket.cur_roomname].members)});

    }
  }
  );

  // called from client
  socket.on("call_roomlist",function(){
    io.sockets.emit("show_roomlist",rooms);
  });

  // called from client 
  socket.on("call_clientlist",function(){
    io.sockets.emit("show_clientlist",clients);
  });

    // called from client
    socket.on("call_editroom",function(data){
      socket.emit("show_editroom",{roomname:data.roomname,roompwd:rooms[data.roomname].roompwd,blacklist:Array.from(rooms[data.roomname]['blacklist']),desc:rooms[data.roomname].desc});
  
    });
  
    //called from client
    socket.on("call_deleteroom",function(data){
      io.to(data.roomname).emit("kick_to_client","default");
      delete rooms[data.roomname];
      io.sockets.emit("show_roomlist",rooms);
    });
  
});


