@extends('backend.layouts.master',['page_title' => 'Tài khoản'])
@section ('title','Tài khoản')
@section('content')
<div class="row">
    <div class="col-sm-12" id="category-box-form">
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
        <div class="box box-solid">
            <div class="box-header with-border">
                <h3 class="box-title">Chỉnh sửa tài khoản</h3>
            </div> 
            <form role="form" id="post_user_add_form" method="post" action="{!! route('admin.user.update',['id'=>$data->id]) !!}">
                <div class="box-body">
                    <div class="form-group ">
                        <label for="user_name" class="control-label">Tên tài khoản <span class="red-star">*</span></label>
                        <div>
                            <input class="form-control" id="user_name" name="user_name" placeholder="Name" type="text" value="{!!  old('user_name',isset($data->name) ? $data->name : null) !!}">
                         </div>
                    </div>
                     <div class="form-group ">
                        <label for="email" class="control-label">Email <span class="red-star">*</span></label>
                        <div>
                            <input class="form-control" id="email" name="email" placeholder="Email" type="text" value="{!! old('email',isset($data->email) ? $data->email : null)!!}">
                         </div>
                    </div>
                    <div class="form-group ">
                        <label for="old_password" class="control-label">Mật khẩu cũ <span class="red-star">*</span></label>
                        <div>
                            <input class="form-control" id="old_password" name="old_password" placeholder="Nhập mật khẩu cũ" type="text" value="">
                         </div>
                    </div>
                    <div class="form-group ">
                        <label for="password" class="control-label">Mật khẩu mới mới <span class="red-star">*</span></label>
                        <div>
                            <input class="form-control" id="password" name="password" placeholder="Nhập mật khẩu mới" type="text" value="">
                         </div>
                    </div>
                    <div class="form-group ">
                        <label for="confirm-pass" class="control-label">Nhập lại mật khẩu mới <span class="red-star">*</span></label>
                        <div>
                            <input class="form-control" id="confirm-pass" name="password_confirmation" placeholder="Xác nhận mật khẩu" type="text" value="">
                         </div>
                    </div>
                    <div class="form-group ">
                        <label for="category_parent" class="control-label">Phân quyền</label>
                        <div>

                            @if (count($roles) > 0)
	                            @foreach($roles as $role)
	                                <input type="checkbox" value="{{ $role->id }}" name="assignees_roles[]" {{in_array($role->id, $user_roles) ? 'checked' : ''}} id="role-{{$role->id}}"/> <label for="role-{{ $role->id }}">{{ $role->name }}</label>
	                                <a href="#" data-role="role_{{ $role->id }}" class="show-permissions small">
	                                    (
	                                        <span class="show-text">Hiển thị</span>
	                                        <span class="hide-text hidden">Ẩn</span>
	                                        
	                                    )
	                                </a>
	                                <br/>  
	                                <div class="permission-list hidden" data-role="role_{{ $role->id }}">
	                                    @if ($role->all)
	                                       All Permissions<br/><br/>
	                                    @else
	                                        @if (count($role->permissions) > 0)
	                                            <blockquote class="small">{{--
	                                        --}}@foreach ($role->permissions as $perm){{--
	                                            --}}{{$perm->display_name}}<br/>
	                                                @endforeach
	                                            </blockquote>
	                                        @else
	                                            <span>No Permissions</span><br/><br/>
	                                        @endif
	                                    @endif
	                                </div><!--permission list-->
	                            @endforeach
	                        @else
	                            <span>No Roles to set.</span>	                        
	                        @endif
                        </div>
                    </div>  
                </div>
                <div class="box-footer">
                    <div class="pull-right">
                        <button class="btn btn-primary" type="submit" name="add">Lưu</button>
                    </div>
                </div>

                {!! csrf_field() !!}
                {!! method_field('PUT') !!}

            </form>
        </div>    
    </div>
@endsection

@section('after-scripts-end')
  <script type="text/javascript">
  	$(function() {
		    $(".show-permissions").click(function(e) {
		        e.preventDefault();
		        var $this = $(this);
		        var role = $this.data('role');
		        var permissions = $(".permission-list[data-role='"+role+"']");
		        var hideText = $this.find('.hide-text');
		        var showText = $this.find('.show-text');
		        // console.log(permissions); // for debugging

		        // show permission list
		        permissions.toggleClass('hidden');

		        // toggle the text Show/Hide for the link
		        hideText.toggleClass('hidden');
		        showText.toggleClass('hidden');
		    });
		});

  </script>
@stop