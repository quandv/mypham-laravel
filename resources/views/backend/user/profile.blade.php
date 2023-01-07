@extends('backend.layouts.master',['page_title' => 'Hồ sơ cá nhân'])
@section ('title','Hồ sơ cá nhân')
@section('content')
<div class="row">
	<div class="col-sm-12">
	    @if (session('flash_message_err') != '')
	      <div class="alert alert-danger" role="alert">{!! session('flash_message_err')!!}</div>
	    @endif
	     @if (session('flash_message_succ') != '')
	      <div class="alert alert-success" role="alert"><span class="glyphicon glyphicon-ok text-success" aria-hidden="true"></span> {!! session('flash_message_succ') !!}</div>
	    @endif
	    @if(count($errors) > 0)
	      <div class="alert alert-danger" role="alert">
	        <ul>
	            @foreach ($errors->all() as $error)
	                <li>{{ $error }}</li>
	            @endforeach
	        </ul>
	      </div>
	      @endif
     </div>
    <div class="col-sm-3" id="category-box-form">
          <div class="box box-primary">
            <div class="box-body box-profile">
              @if(!empty(Auth::user()->avatar))
                 <img class="profile-user-img img-responsive img-circle" src="{{ asset('/uploads/users/'.Auth::user()->avatar) }}" alt="User profile picture">
              @else
              	<img class="profile-user-img img-responsive img-circle" src="{{ asset("/images/admin.png") }}" alt="User profile picture">
              @endif
              <h3 class="profile-username text-center">{!! Auth::user()->name !!}</h3>

              <p class="text-muted text-center">
                <small>Thành viên từ - {!! date('d-m-Y',strtotime(Auth::user()->created_at)) !!}</small>
              </p>

              <!-- <ul class="list-group list-group-unbordered">
                <li class="list-group-item">
                  <b>Followers</b> <a class="pull-right">1,322</a>
                </li>
                <li class="list-group-item">
                  <b>Following</b> <a class="pull-right">543</a>
                </li>
                <li class="list-group-item">
                  <b>Friends</b> <a class="pull-right">13,287</a>
                </li>
              </ul> -->
              	<!-- <a href="#" class="btn btn-primary btn-block"><b>Follow</b></a> -->
	            <form role="form" method="post" action="" enctype="multipart/form-data">
	                <div class="box-body">
	                    <div class="form-group ">
	                        <label for="changeAvatar" class="control-label">Thay đổi avatar </label>
	                        <div>
	                            <input class="form-control no-padding" id="changeAvatar" name="changeAvatar"  type="file" >
	                         </div>
	                    </div> 
	                </div>
	                <div class="box-footer">
	                    <div class="pull-right">
	                        <button class="btn btn-primary" type="submit" name="add">Lưu</button>
	                    </div>
	                </div>
	                {!! csrf_field() !!}

	            </form>
            </div>
            <!-- /.box-body -->
          </div>  
    </div>
    <div class="col-sm-3" id="category-box-form">
           <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Thay đổi mật khẩu</h3>
            </div> 
            <form role="form"  method="post" action="{!! route('admin.changepass') !!}">
                <div class="box-body">
                	<div class="form-group ">
                       <label for="password_current" class="control-label">Mật khẩu cũ <span class="required">*</span></label>
                        <div>
                            <input class="form-control" id="password_current" name="password_current" placeholder="" type="password">
                         </div>
                    </div>
                    <div class="form-group ">
                        <label for="password" class="control-label">Mật khẩu mới <span class="required">*</span></label>
                        <div>
                            <input class="form-control" id="password" name="password" placeholder="" type="password" >
                         </div>
                    </div>
                    <div class="form-group ">
                        <label for="confirm-pass" class="control-label">Nhập lại mật khẩu <span class="required">*</span></label>
                        <div>
                            <input class="form-control" id="confirm-pass" name="password_confirmation" placeholder="" type="password">
                         </div>
                    </div>  
                </div>
                <div class="box-footer">
                    <div class="pull-right">
                        <button class="btn btn-primary" type="submit" name="add">Lưu</button>
                    </div>
                </div>
                {!! csrf_field() !!}

            </form>
        </div>    
    </div>
</div>

@endsection

@section('after-scripts-end')
  <script type="text/javascript">
      
  </script>
@stop