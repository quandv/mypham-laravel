<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="shortcut icon" href="facivon.ico">

    <title>Gengar Gaming Giao tiếp</title>
    <link href="{{ asset("/css/chat.css") }}" rel="stylesheet" type="text/css" />
    <script src="{!! asset('bower_components/AdminLTE/plugins/jQuery/jquery-2.2.3.min.js') !!}" type="text/javascript"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/1.5.1/socket.io.min.js"></script>
    <script type="text/javascript">
    	var route = "{{route('admin.redis.room')}}";
    	var route2 = "{{route('admin.redis.private')}}";
    </script>
    <script src="{!! asset('js/chat.js') !!}" type="text/javascript"></script>
  </head>
  <body>
  <div class="room-wrapper panel" id="chat-room">
			<div class="panel-heading">
				<h3>Giao tiếp nhóm</h3>
			</div>
			<div class="panel-body">
				<div class="scrollableArea">
					<div class="scrollableAreaWrap">
						<div class="scrollableAreaContent">
							<ul class="message-room-list">
							</ul>
						</div>
					</div>
				</div>
				<div class="send-message-form">
					<div class="body-form">
						<form id="room-form" name="room-form" action="" method="post" >
							<div class="textarea">
								<textarea placeholder="Write your message..." name="room_message_content" id="room_message_content" rows="5"></textarea>
							</div>
							<div class="btn">
								<button type="submit" class="btn" id="roomSendBtn" >Gửi</button>
							</div>
							 {!! csrf_field() !!}
						</form>
					</div>
				</div>
			</div>
  </div>
  <div class="friends-wrapper panel chat_box">
	<div class="chat_head"> Chat Box</div>
	<div class="chat_body"> 
		<ul class="users-list" id="friendsList"> 
		    @if($users)
				@foreach($users as $user)
				   @if($user->isOnline())
				      @if(empty(Auth::user()->id))
						<li class="user{!! $user->id !!}">
							<a data-id="{!!$user->id !!}" class="online">
								<span class="img"> <img alt="{!!$user->name!!}" src="{{ asset("images/1.jpg") }}"> </span> 
								<span class="name">{!!$user->name!!}</span> 	
							</a>
						</li>
					  @elseif(Auth::user()->id != $user->id)
					    <li class="user{!! $user->id !!}">
							<a data-id="{!!$user->id !!}" class="online">
								<span class="img"> <img alt="{!!$user->name!!}" src="{{ asset("images/1.jpg") }}"> </span> 
								<span class="name">{!!$user->name!!}</span> 	
							</a>
						</li>
					  @endif
					@endif
				@endforeach
		    @endif
			
			<!-- <li class="user2">
				<a data-id="2" class="offline">
					<span class="img"> <img alt="" src="{{ asset("images/1.jpg") }}"> </span> 
					<span class="name">Di Maria 2</span> 
					
				</a>
			</li>
			<li class="user3">
				<a data-id="3" class="online">
					<span class="img"> <img alt="" src="{{ asset("images/1.jpg") }}"> </span> 
					<span class="name">Di Maria 3</span> 
					
				</a>
			</li>
			<li class="user4">
				<a data-id="4" class="offline">
					<span class="img"> <img alt="" src="{{ asset("images/1.jpg") }}"> </span> 
					<span class="name">Di Maria 4</span> 
					
				</a>
			</li> -->
			
			
		</ul>
	    
	</div>
    <div class="chat_footer"><a id="chat_footer_room" href="javascript:void(0)"> Giao tiếp nhóm </a></div>
  </div>

	<!-- Windows Chat -->
	<div class="windows-wrapper">
		<div class="container">
			<div class="ChatTabsPagelet">
				<ul class="windowsChat" id="windowsChat">
					
				</ul>
			</div>
		</div>
	</div>
<script id="templateChatMessageFriend" type="text/x-handlebars-template">
<div class="message clearfix" data-id="{ID}">
	<div class="avatar">
		<img src="images/avatars/{AVATAR}" alt="{NAME}" width="32" height="32">
	</div>
	<div class="msg-body">
		<div class="kso">
			<span>{MESSAGE}</span>
		</div>
	</div>
</div>
</script>	
	
<script id="templateChatMessageMe" type="text/x-handlebars-template">
<div class="message clearfix me">
	<div class="msg-body">
		<div class="kso">
			<span>{MESSAGE}</span>
		</div>
	</div>
</div>	
</script>

<script id="templateChatWindow" type="text/x-handlebars-template">
<li id="chat{ID}" data-id="{ID}">
	<div class="layoutInner">
		<div class="titleBar clearfix ">
			<h4>{NAME}</h4>
			<i class="close"></i>
		</div>
		<div class="layoutBody">
			<div class="conversation">

			</div>
			<div class="typing" style="display: none;">
				<div class="message clearfix">
					<div class="avatar">
						<img src="{AVATAR}" alt="{NAME}" width="32" height="32">
					</div>
					<div class="bg"></div>
				</div>
			</div>
			<div class="viewed">
				<i></i> Đã xem lúc <span></span>
			</div>
		</div>
		<div class="layoutSubmit">
			<input name="message" class="input">
			<div class="iconWrap">
				<div class="emoticonsPanel">
					<a title="Choose a sticker" class="toggleIcon"><i class="emoteToggler"></i></a>
					<div class="iconLayout">
						<div class="iconLists">
							<div class="iconItem">
								<a class="icon icon_smile" title="smile"></a>
							</div>
							<div class="iconItem">
								<a class="icon icon_frown" title="frown"></a>
							</div>
							<div class="iconItem">
								<a class="icon icon_tongue" title="tongue"></a>
							</div>
							<div class="iconItem">
								<a class="icon icon_grin" title="grin"></a>
							</div>
							<div class="iconItem">
								<a class="icon icon_gasp" title="gasp"></a>
							</div>
							<div class="iconItem">
								<a class="icon icon_wink" title="wink"></a>
							</div>
							<div class="iconItem">
								<a class="icon icon_pacman" title="pacman"></a>
							</div>
							<div class="iconItem">
								<a class="icon icon_grumpy" title="grumpy"></a>
							</div>
							<div class="iconItem">
								<a class="icon icon_unsure" title="unsure"></a>
							</div>
							<div class="iconItem">
								<a class="icon icon_cry" title="cry"></a>
							</div>
							<div class="iconItem">
								<a class="icon icon_kiki" title="kiki"></a>
							</div>
							<div class="iconItem">
								<a class="icon icon_glasses" title="glasses"></a>
							</div>
							<div class="iconItem">
								<a class="icon icon_sunglasses" title="sunglasses"></a>
							</div>
							<div class="iconItem">
								<a class="icon icon_heart" title="heart"></a>
							</div>
							<div class="iconItem">
								<a class="icon icon_devil" title="devil"></a>
							</div>
							<div class="iconItem">
								<a class="icon icon_angel" title="angel"></a>
							</div>
							<div class="iconItem">
								<a class="icon icon_squint" title="squint"></a>
							</div>
							<div class="iconItem">
								<a class="icon icon_confused" title="confused"></a>
							</div>
							<div class="iconItem">
								<a class="icon icon_upset" title="upset"></a>
							</div>
							<div class="iconItem">
								<a class="icon icon_colonthree" title="colonthree"></a>
							</div>
							<div class="iconItem">
								<a class="icon icon_like" title="like"></a>
							</div>
						</div>
						<div class="layoutArrow"></div>
					</div>
				</div>
			</div>
		</div>
	</div>
</li>
</script>	
<script id="templateRoomMessage" type="text/x-handlebars-template">
<li class="message">
	<div class="clearfix">
		<div class="avatar">
			<img src="{!! asset("images") !!}/{AVATAR}" alt="{NAME}" width="32" height="32">
		</div>
		<div class="content clearfix">
			<div class="created">
				<i></i> <span>{CREATED}</span>
			</div>
			<div>
				<div class="fullname">{NAME}</div>
				<div class="msg">{MESSAGE}</div>
			</div>
		</div>
	</div>
</li>
</script>
</body>
</html>
