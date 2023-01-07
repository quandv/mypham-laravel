@extends('backend.layouts.master',['page_title' => 'Phân quyền'])
@section ('title','Phân quyền')
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
            <form role="form" id="post_category_add_form" method="post" action="{!! route('admin.role.store') !!}">
                <div class="box-body">
                    <div class="form-group ">
                        <label for="role_name" class="control-label">Tên quyền <span class="red-star">*</span></label>
                        <div>
                            <input class="form-control" id="role_name" name="role_name" placeholder="" type="text" value="{!! old('role_name')!!}">
                         </div>
                    </div>
                    <!-- <div class="form-group ">
                        <label for="email" class="control-label">Sort <span class="red-star">*</span></label>
                        <div>
                            <input class="form-control" id="sort" name="sort" placeholder="sort" type="text" value="{!! old('sort')!!}">
                         </div>
                    </div> -->
                    <div class="form-group">
	                    <label class="control-label" for="associated-permissions">Phân quyền</label>
	                    <div>
	                        <select name="associated_permissions" id="associated-permissions" class="form-control">
	                        	<option selected="selected" value="all">Tất cả</option>
	                        	<option value="custom">Tùy chọn</option></select>
	                        <div class="hidden mt-20" id="available-permissions">
	                            <div class="row">
	                                <div class="col-xs-12">
	                                 @if ($permissions->count())
                                        @foreach ($permissions as $perm)
                                            <input type="checkbox" name="permissions[]" value="{{ $perm->id }}" id="perm_{{ $perm->id }}" />
                                            <label for="perm_{{ $perm->id }}">{{ $perm->display_name }}</label><br/>
                                        @endforeach
                                    @else
                                        <p>There are no available permissions.</p>
                                    @endif                                                                               
	                                                                                    
	                                </div><!--col-lg-6-->
	                            </div><!--row-->
	                        </div><!--available permissions-->
	                    </div><!--col-lg-3-->
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
                                      <input class="form-control borderRad3" id="searchRole"  name="search_role" placeholder="Tên quyền" type="text" value="{!! Request::get('search_user')!!}">
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
                                    <th>Tên quyền</th>
                                    <th>Quyền</th>
                                    <th style="width: 100px">Xử lý</th>
                                </tr>
                             @if(!empty($data))
                                @foreach($data as $k=>$v)
                								<tr>
                								   <!--  <td><input type="checkbox" name="uid[]" value="{!! $v->id !!}"></td> -->
                									<td>{!! $v->id !!}</td>
                									<td>{!! $v->name !!}</td>
                									<td>
                										@if ($v->all)
                								            <span class="label label-success">All Permissions</span>
                								        @else
                									        @if (count($v->permissions) > 0) 
                									            @foreach ($v->permissions as $permission) 
                													<br/> {!! $permission->display_name !!}     
                		                                        @endforeach
                									        @else
                								           		<span class="label label-danger">No Permissions</span>
                								            @endif
                										@endif
                									</td>
                									<td>
                										<a class="btn btn-info btn-xs marginBot5" href="{!! route('admin.role.edit',['id'=>$v->id]) !!}" ><i class="fa fa-pencil"></i></a> 
                		                    <form id="delete-form-{!! $v->id !!}" style="display:inline-block" action="{!! route('admin.role.destroy',['id'=>$v->id]) !!}" method="POST" name="delete_item_cat"  >
      		                                    <input type="hidden" name="_method" value="DELETE">
      		                                    <input name="_token" type="hidden" value="{!! csrf_token() !!}">
      		                                    <a class="btn btn-danger btn-xs marginBot5 delete-catrgory" onclick="javascript:formSubmit({!! $v->id !!})"><i class="fa fa-minus-circle"></i></a>
                										</form>
                									</td>
                								</tr>
								
                                @endforeach
                                  
                                     
                             @endif
                              
                        </table> 
                 {!! $data->appends(Request::only(['search_role']))->links()!!}
                </div>
            </div>
            <!-- /.box-body -->
        </div>
    </div>
</div>

@endsection

@section('after-scripts-end')
  <script type="text/javascript">
       var associated = $("select[name='associated_permissions']");
	   var associated_container = $("#available-permissions");

		if (associated.val() == "custom")
		    associated_container.removeClass('hidden');
		else
		    associated_container.addClass('hidden');

		associated.change(function() {
		    if ($(this).val() == "custom")
		        associated_container.removeClass('hidden');
		    else
		        associated_container.addClass('hidden');
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
                'Your data has been deleted.',
                'success'
              );
            }, function(dismiss) {
              // dismiss can be 'cancel', 'overlay',
              // 'close', and 'timer'
              if (dismiss === 'cancel') {
                swal(
                  'Cancelled',
                  'Your data is safe :)',
                  'error'
                );
              }
            })
	    }
  </script>
@stop