<!-- MODULE CHAT -->
    <audio id="message-chat" >
        <source src="{!! asset('audio/message.mp3')!!}" type="audio/mpeg">
        Your browser does not support the audio element.
    </audio>
    <div class="room-wrapper panel-chat" id="chat-room">
      <div class="panel-chat-heading">
        <h3><i class="fa fa-comments-o"></i> Phòng chat <i id="close-chat-room" class="fa fa-close pull-right" style="cursor: pointer;">&nbsp;</i></h3>
      </div>
      <div class="panel-chat-body">
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
                <textarea placeholder="Nội dung tin nhắn..." name="room_message_content" id="room_message_content" rows="4"></textarea>
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
  <div class="friends-wrapper panel-chat chat_box">
  <div class="chat_head"><i class="fa fa-weixin" aria-hidden="true"></i> Giao tiếp</div>
  <div class="chat_body">
      <input type="hidden" name="myinfo" id="myinfo" value=""> 
      <input type="hidden" name="myIP" id="myIP" value="">
      <input type="hidden" name="myID" id="myID" value="">
      <style type="text/css">
      
      .nav-tabs.nav-justified>.active>a, .nav-tabs.nav-justified>.active>a:focus, .nav-tabs.nav-justified>.active>a:hover{
         border:0px;

      }
       /*  @media (max-width: 768px){
         .nav-justified > li {
             display: table-cell;
             width: 1%;
       }
         .nav-justified > li > a  {
             border-bottom: 1px solid #ddd !important;
             border-radius: 4px 4px 0 0 !important;
             margin-bottom: 0 !important;
       }
         .nav-justified > li.active > a  {
             border-bottom: 1px solid transparent !important;
       }
       
      } */

      /* Add Group */
      .add-to-group{background-color:#edeff4;padding:2px;display: none;}
      .add-to-group input.add-group{width: 78%;padding-left: 3px;}
      .add-to-group button{width: 20%;padding: 4px 4px 5px 4px;}
     
      .chat_body { position: relative; }
      .name_search { position: absolute; bottom: 0; border-radius: 0px;font-size: 12px; padding:5px !important; }
      .name_search:forcus{ 
        box-shadow: 0 1px 1px rgba(0, 0, 0, 0.075) inset, 0 0 8px rgba(0, 0, 0, 0.6) !important;
      }
      .khachhang { display: none; }
      #tab-admin, #tab-client {cursor: pointer;}
      </style>
      <!-- <div id="exTab" class=""> 
           <ul class="nav nav-tabs nav-justified">
              <li class="active">
                <a  href="#1" data-toggle="tab">Thu ngân & Bếp</a>
              </li>
              <li><a href="#2" data-toggle="tab">Máy trạm</a>
              </li>
            </ul>
            <div class="tab-content ">
              <div class="tab-pane active" id="1">
                 <ul class="users-list-chat quantri" id="quantri"> 
      
                 </ul>
                 <input id="" name="" class="name_search form-control pull-right" placeholder="Tìm theo tên máy" type="text">
              </div>
              <div class="tab-pane" id="2">
                <ul class="users-list-chat khachhang" id="khachhang"> 
      
                </ul>
                
              </div>
            </div>
      </div> -->

      <div id="exTab" class=""> 
           <ul class="nav nav-tabs nav-justified">
              <li class="active">
                <a id="tab-admin" onclick="javascript:get_admin(this.id);">Thu ngân & Bếp</a>
              </li>
              <li><a id="tab-client" onclick="javascript:get_client(this.id);">Máy trạm</a>
              </li>
            </ul>
            <div class="tab-content">
               <ul class="users-list-chat" id="users-list-chat"> 
                    
               </ul>
               <input id="" name="" class="name_search form-control pull-right" placeholder="Tìm theo tên máy" type="text">
            </div>
      </div>
      
    </div>
      <div id="chat_footer_toogle" class="chat_footer">
        <a id="chat_footer_room" href="javascript:void(0)"><i class="fa fa-users"></i> Giao tiếp nhóm </a>
      </div>
    </div>

      <!-- Windows Chat -->
    <div class="windows-wrapper">
      <div class="container-chat">
        <div class="ChatTabsPagelet">
          <ul class="windowsChat" id="windowsChat">
            
          </ul>
        </div>
      </div>
    </div>
    <script id="templateChatMessageFriend" type="text/x-handlebars-template">
    <div class="message clearfix" data-id="{ID}">
      <div class="avatar">
        <img src="{AVATAR}" alt="{NAME}" width="32" height="32">
      </div>
      <div class="msg-body">
        <div class="kso">
          <span>{MESSAGE}</span>
        </div>
      </div>
    </div>
    </script> 
    <script id="templateChatMessageFriendGroup" type="text/x-handlebars-template">
    <div class="message clearfix" data-id="{ID}">
      <div class="name">
        <span>{NAME}</span>
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
    <li id="chat{ID}" class="chat{ID}" data-id="{ID}" data-ip="{IP}" data-room="{ROOM}" data-name="{NAME}">
      <div class="layoutInner">
        <div class="titleBar clearfix ">
          <h4>{NAME}</h4>
          <span class="glyphicon glyphicon-remove pull-right close-chat" style="font-size: 12px;font-weight: normal;color: #ccc;cursor: pointer;" data-toggle="tooltip" data-placement="top" title="Thoát"></span>
          <span class="glyphicon glyphicon-plus pull-right add-group" style="font-size: 12px;font-weight: normal;color: #ccc;cursor: pointer;margin-right: 5px" data-toggle="tooltip" data-placement="top" title="Thêm bạn chat"></span> 
        </div>
        <div class="add-to-group">
           <!-- <input type="text" class="add-group" name="add-group" placeholder="Them vao group"> -->
          <select class="select-group" multiple="multiple"></select>
          <button type="button" class="button-group btn btn-primary" >Xong</button>  
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
          <input name="message" class="input inputicon">
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

    <script id="templateChatWindowGroup" type="text/x-handlebars-template">
    <li id="chat{GID}" class="chat{GID}" data-group="1" data-id="{GID}" data-ip="{GIP}" data-room="{GROOM}" data-name="{GNAME}">
      <div class="layoutInner">
        <div class="titleBar clearfix ">
          <h4 data-toggle="tooltip" data-placement="top" title="{GNAME2}">{DNAME}</h4>
          <!-- <i class="close"></i> -->
          <span class="glyphicon glyphicon-remove pull-right close-group" style="font-size: 12px;font-weight: normal;color: #ccc;cursor: pointer;"  data-toggle="tooltip" data-placement="top" title="Thoát"></span>
          <span class="glyphicon glyphicon-plus pull-right add-group" style="font-size: 11px;font-weight: normal;color: #ccc;cursor: pointer;margin-right: 5px" data-toggle="tooltip" data-placement="top" title="Thêm bạn chat"></span>
        </div>
        <div class="add-to-group">
           <!-- <input type="text" class="add-group" name="add-group" placeholder="Them vao group"> -->
          <select select class="select-group" multiple="multiple"></select>
          <button type="button" class="button-group btn btn-primary">Xong</button>  
        </div>
        <div class="layoutBody">
          <div class="conversation">

          </div>
          <div class="typing" style="display: none;">
            <div class="message clearfix">
              <div class="avatar">
                <img src="{GAVATAR}" alt="{GNAME}" width="32" height="32">
              </div>
              <div class="bg"></div>
            </div>
          </div>
          <div class="viewed">
            <i></i> Đã xem lúc <span></span>
          </div>
        </div>
        <div class="layoutSubmit">
          <input name="message" class="inputgroup inputicon">
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
          <img src="{AVATAR}" alt="{NAME}" width="32" height="32">
        </div>
        <div class="content-chat clearfix">
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
    <!-- END MODULE CHAT -->