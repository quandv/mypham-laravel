<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Document</title>
    <link href="http://netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css" rel="stylesheet">
    <script src="http://code.jquery.com/jquery-1.11.1.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/vue/2.0.5/vue.min.js"></script>  
    <script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/1.5.1/socket.io.min.js"></script>
    <style>
      * { margin: 0; padding: 0; box-sizing: border-box; }
      body { font: 13px Helvetica, Arial; }
      form { background: #000; padding: 3px; position: fixed; bottom: 0; width: 100%; }
      form input { border: 0; padding: 10px; width: 90%; margin-right: .5%; }
      form button { width: 9%; background: rgb(130, 224, 255); border: none; padding: 10px; }
      #messages { list-style-type: none; margin: 0; padding: 0; }
      #messages li { padding: 5px 10px; }
      #messages li:nth-child(odd) { background: #eee; }
    </style>
</head>
<body>

<script>
  var socket = io('http://192.168.50.104:3000');
   socket.on('test-channel:event1', function (data) {
    console.log(data);
     $('#messages').append($('<li>').text(data.message));
    //socket.emit('test-channel:event1', { my: 'data' });
  });
   $(document).ready(function(){
        $("#chat").submit(function(e){
            e.preventDefault();
            e.stopPropagation();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
             $.post('{{ route('admin.redis') }}', {
                message: $('#m').val(),

            });
        });
   });
 
  
</script>
<script>
    //var socket = io();
     /* var socket = io('http://192.168.50.104:3000');
      new Vue({
        el: '#app',

        data: {
            users:[], 
        },
        ready: function(){
            socket.on('test-channel:event1',function(data){
                this.users.push(data.username); 
                console.log(data);
            }).bind(this);
        },

      });
*/
  </script>

    <ul id="messages"></ul>
    <form id="chat" action="{{route('admin.redis')}}" method="POST">
      <input id="m" autocomplete="off" name="message" ><button type="submit">Send</button>
      {!! csrf_field() !!}
    </form>




</body>
</html>