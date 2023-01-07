@extends('backend.layouts.master',['page_title' => 'Tài khoản'])
@section ('title','Tài khoản')
@section('content')
<div class="row">
    <div class="col-sm-12 col-lg-5" id="category-box-form">
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
                <h3 class="box-title">Thêm mới</h3>
            </div> 
            <form role="form" id="post_category_add_form" method="post" action="{!! route('admin.user.store') !!}" enctype="multipart/form-data">
                <div class="box-body">
                    <div class="form-group ">
                        <label for="user_name" class="control-label">Tên tài khoản <span class="required">*</span></label>
                        <div>
                            <input class="form-control" id="user_name" name="user_name" placeholder="" type="text" value="{!! old('user_name')!!}">
                         </div>
                    </div>
                     <div class="form-group ">
                        <label for="email" class="control-label">Email <span class="required">*</span></label>
                        <div>
                            <input class="form-control" id="email" name="email" placeholder="" type="text" value="{!! old('email')!!}">
                         </div>
                    </div>
                    <div class="form-group ">
                        <label for="password" class="control-label">Mật khẩu <span class="required">*</span></label>
                        <div>
                            <input class="form-control" id="password" name="password" placeholder="" type="text" value="{!! old('password')!!}">
                         </div>
                    </div>
                    <div class="form-group ">
                        <label for="confirm-pass" class="control-label">Nhập lại mật khẩu <span class="required">*</span></label>
                        <div>
                            <input class="form-control" id="confirm-pass" name="password_confirmation" placeholder="" type="text" value="{!! old('password_confirmation')!!}">
                         </div>
                    </div>
                    <div class="form-group ">
                        <label for="category_parent" class="control-label">Phân quyền</label>
                        <div>
                            @if (count($roles) > 0)
	                            @foreach($roles as $role)
	                                <input type="checkbox" value="{{ $role->id }}" name="assignees_roles[]" id="role-{{ $role->id }}" /> <label for="role-{{ $role->id }}">{{ $role->name }}</label>
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

            </form>
        </div>    
    </div>
    <div class="col-sm-12 col-lg-7">
        <div class="box box-primary">
            <div class="box-body">
                <form action="" method="get" id="post_user_search_form" class="form-horizontal" role="form">
                    <div class="row">
                        <div class="col-sm-6"></div>
                        <div class="col-sm-6">
                            <div class="pull-right">
                                <div class="input-group">
                                      <input class="form-control borderRad3" id="searchUserName"  name="search_user" placeholder="Tìm theo tên hay email..." type="text" value="{!! Request::get('search_user')!!}">
                                      <span class="input-group-btn">
                                        <button class="btn btn-default" type="submit">
                                            <i class="fa fa-search"></i></button>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                <br>
                <div class="table-responsive">
                        <table class="table table-bordered table-hover table-striped k-table-list">
                          <tr>
                             <!--  <th style="width: 50px;"><input name="checkall-toggle" type="checkbox"></th> -->
                              <th>ID</th>
                              <th>Tên tài khoản</th>
                              <th>Email</th>
                              <th>Quyền</th>
                              <th style="width: 100px">Xử lý</th>
                          </tr>
                          @if(!empty($data))
                            @foreach($data as $k=>$v)
              								<tr>
              								   <!--  <td><input type="checkbox" name="uid[]" value="{!! $v->id !!}"></td> -->
              									<td>{!! $v->id !!}</td>
              									<td>{!! $v->name !!}</td>
              									<td>{!! $v->email !!}</td>
              									@if(count($v->roles) > 0 )
              										<td>
              											@foreach($v->roles as $role)
              											 {!! $role->name !!} <br/>
              											@endforeach
              										</td>
              									@else
            									    <td>
            									    	No Permisions
            									    </td>
              									@endif
              									<td>
              										<a class="btn btn-info btn-xs marginBot5" href="{!! route('admin.user.edit',['id'=>$v->id]) !!}" ><i class="fa fa-pencil"></i></a> 
                                  <form id="delete-form-{!! $v->id !!}" style="display:inline-block" action="{!! route('admin.user.destroy',['id'=>$v->id]) !!}" method="POST" name="delete_item_cat">
                                      <input type="hidden" name="_method" value="DELETE">
                                      <input name="_token" type="hidden" value="{!! csrf_token() !!}">
                                      <a class="btn btn-danger btn-xs delete-catrgory marginBot5" onclick="javascript:formSubmit({!! $v->id !!})"><i class="fa fa-minus-circle"></i></a>
              										</form>
              									</td>
              								</tr>								
                            @endforeach
                          @endif                          
                      </table>
                 	{!! $data->appends(Request::only(['search_user']))->links() !!}
                </div>
            </div>
            <!-- /.box-body -->
        </div>
    </div>
</div>

@endsection

@section('after-scripts-end')
  <script type="text/javascript">
        /*$('input[name=checkall-toggle]').change(function(){
            var checkStatus = this.checked;
            $('#user-form-for-del').find(':checkbox').each(function(){
                this.checked = checkStatus;
            });
        });*/ 
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
       function formSubmit(id)
	    {
	      /*var x = confirm("Are you sure you want to delete?");
	      if (x)
	          $('#delete-form-'+id).submit();
	      else
	        return false;*/
          swal({
          title: 'Are you sure?',
          text: "You won't be able to revert this!",
          type: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Yes, delete it!',
          cancelButtonText: 'No, cancel!',
          confirmButtonClass: 'btn btn-success',
          cancelButtonClass: 'btn btn-danger',
          buttonsStyling: false
        }).then(function() {
          $('#delete-form-'+id).submit();
          swal(
            'Deleted!',
            'Your file has been deleted.',
            'success'
          );
        }, function(dismiss) {
          // dismiss can be 'cancel', 'overlay',
          // 'close', and 'timer'
          if (dismiss === 'cancel') {
            swal(
              'Cancelled',
              'Your imaginary file is safe :)',
              'error'
            );
          }
        })
	    }


  </script>
@stop