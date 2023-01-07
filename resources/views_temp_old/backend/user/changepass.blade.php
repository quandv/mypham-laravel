@extends('backend.layouts.master',['page_title' => 'Profile'])
@section ('title','Profile')
@section('content')
<div class="row">
    <div class="col-sm-5" id="category-box-form">
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
                <h3 class="box-title">Profile</h3>
            </div> 
            <form role="form" id="post_category_add_form" method="post" action="{!! route('admin.user.store') !!}" enctype="multipart/form-data">
                <div class="box-body">
                    <div class="form-group ">
                        <label for="user_name" class="control-label">Name <span class="red-star">*</span></label>
                        <div>
                            <input class="form-control" id="user_name" name="user_name" placeholder="Name" type="text" value="{!! old('user_name')!!}">
                         </div>
                    </div>
                     <div class="form-group ">
                        <label for="email" class="control-label">Email <span class="red-star">*</span></label>
                        <div>
                            <input class="form-control" id="email" name="email" placeholder="Email" type="text" value="{!! old('email')!!}">
                         </div>
                    </div>
                    <div class="form-group ">
                        <label for="password" class="control-label">Password <span class="red-star">*</span></label>
                        <div>
                            <input class="form-control" id="password" name="password" placeholder="Password" type="text" value="{!! old('password')!!}">
                         </div>
                    </div>
                    <div class="form-group ">
                        <label for="confirm-pass" class="control-label">Confirm Pass <span class="red-star">*</span></label>
                        <div>
                            <input class="form-control" id="confirm-pass" name="password_confirmation" placeholder="Name" type="text" value="{!! old('password_confirmation')!!}">
                         </div>
                    </div>  
                </div>
                <div class="box-footer">
                    <div class="pull-right">
                        <button class="btn btn-primary" type="submit" name="add">Add</button>
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
        $('input[name=checkall-toggle]').change(function(){
            var checkStatus = this.checked;
            $('#user-form-for-del').find(':checkbox').each(function(){
                this.checked = checkStatus;
            });
        }); 
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