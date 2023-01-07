@extends('backend.layouts.master',['page_title' => 'Phân quyền'])
@section ('title','Phân quyền')
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
                <h3 class="box-title">Chỉnh sửa quyền</h3>
            </div> 
            <form role="form" id="post_category_add_form" method="post" action="{!! route('admin.role.update',['id'=>$data->id]) !!}">
                <div class="box-body">
                    <div class="form-group ">
                        <label for="role_name" class="control-label">Tên quyền <span class="required">*</span></label>
                        <div>
                            <input class="form-control" id="role_name" name="role_name" placeholder="" type="text" value="{!!  old('role_name',isset($data->name) ? $data->name : null) !!}">
                         </div>
                    </div>
                    <!-- <div class="form-group ">
                        <label for="email" class="control-label">Sort <span class="red-star">*</span></label>
                        <div>
                            <input class="form-control" id="sort" name="sort" placeholder="sort" type="text" value="{!! old('sort')!!}">
                         </div>
                    </div> -->
                    <div class="form-group">
	                    <label class="control-label" for="associated-permissions">Quyền</label>
	                    <div>
	                        @if ($data->id != 1)
	                            {{-- Administrator has to be set to all --}}
	                            {{ Form::select('associated_permissions', ['all' => 'All', 'custom' => 'Custom'], $data->all ? 'all' : 'custom', ['class' => 'form-control']) }}
	                        @else
	                            <span class="label label-success">All Permissions</span>
	                        @endif

	                        <div id="available-permissions" class="hidden mt-20">
	                            <div class="row">
	                                <div class="col-xs-12">
	                                    @if ($permissions->count())
	                                        @foreach ($permissions as $perm)
	                                            <input type="checkbox" name="permissions[]" value="{{ $perm->id }}" id="perm_{{ $perm->id }}" {{in_array($perm->id, $role_permissions) ? 'checked' : ""}} /> <label for="perm_{{ $perm->id }}">{{ $perm->display_name }}</label><br/>
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
                {!! method_field('PUT') !!}

            </form>
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
  </script>
@stop