@extends('backend.layouts.master',['page_title'=> 'Danh mục'])
@section ('title','Danh mục')
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
                <h3 class="box-title">Chỉnh sửa danh mục</h3>
            </div> 
            <form role="form" id="post_category_add_form" method="post" action="{!! route('admin.category.update',['cat_id'=>$data->category_id]) !!}" enctype="multipart/form-data">
                <div class="box-body">
                    <div class="form-group ">
                        <label for="post_category_name_" class="control-label">Tên danh mục <span class="red-star">*</span></label>
                        <div>
                            <input class="form-control" id="post_category_name_" name="category_name" placeholder="Tên danh mục" type="text" value="{!! old('inputHoten',isset($data->category_name) ? $data->category_name : null) !!}">
                         </div>
                    </div>
                    <div class="form-group ">
                        <label for="category_parent" class="control-label">Danh mục cha</label>
                        <div>
                            <select class="form-control" id="category_parent" name="category_parent">
                                <option value="">--Chọn danh mục--</option>
                                {!! $select_cat !!}
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                      <label>Loại: </label>
                      <label class="radio-inline">
                        <input type="radio" name="category_type" value="0" @if($data->category_type == 0) checked @endif > Không hiển thị ở menu chính
                      </label>
                      <label class="radio-inline">
                        <input type="radio" name="category_type" value="1" @if($data->category_type == 1) checked @endif > Hiển thị ở menu chính
                      </label>
                    </div>

                    <div class="form-group ">
                        <label for="category_description_" class="control-label">Mô tả</label>
                        <div>
                            <textarea class="form-control" id="category_description_" name="category_description" rows="7" placeholder="Mô tả">{!! old('category_description',isset($data->category_desc) ? $data->category_desc : null) !!}</textarea>
                        </div>
                    </div>

                    <div class="form-group">
                      <label>Trạng thái: </label>
                      <label class="radio-inline">
                        <input type="radio" name="category_status" value="1" @if($data->category_status == 1) checked @endif > Hiện
                      </label>
                      <label class="radio-inline">
                        <input type="radio" name="category_status" value="0" @if($data->category_status == 0) checked @endif > Ẩn
                      </label>
                    </div>

                    <div class="form-group">
                          <label for="fileImage">Ảnh</label>
                          <div class="category-image">
                          	@if(!empty($data->category_image))
            						    	<img style="width:150px;height:150px" src="{!! asset('public/uploads/category/'.$data->category_image) !!}" alt="category-image">
             
            						    @endif
                          </div>
                          <input type="file" id="fileImage" name="fileImage">
                    </div>
                    <div class="form-group">
                          <label for="fileImageHover">Ảnh(khi được chọn)</label>
                          <div class="category-image">
                            @if(!empty($data->category_image_hover))
                              <img style="width:150px;height:150px" src="{!! asset('public/uploads/category/'.$data->category_image_hover) !!}" alt="category-image-hover">
             
                            @endif
                          </div>
                          <input type="file" id="fileImageHover" name="fileImageHover">
                    </div>
                </div>
                <div class="box-footer">
                    <div class="pull-right">
                        <button class="btn btn-primary" type="submit" name="save">Lưu</button>
                    </div>
                </div>
                {!! csrf_field()!!}
                {!! method_field('PUT') !!}

            </form>
        </div>    
    </div>
@endsection

@section('after-scripts-end')
  <script type="text/javascript">
    function formSubmit(id){
      swal({
        title: 'Thông báo',
        text: "Bạn chắc chắc muốn xóa mục này?",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Đồng ý',
        cancelButtonText: 'Hủy'
      }).then(function() {
        $('#delete-form-'+id).submit();  
        swal(
          'Thành công!',
          '',
          'success'
        );
      })
    }
  </script>
@stop