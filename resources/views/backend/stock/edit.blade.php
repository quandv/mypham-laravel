@extends('backend.layouts.master', ['page_title' => 'Chỉnh sửa sản phẩm thô'])
@section ('title','Quản lý sản phẩm nhập')
@section('content')
<style>
  #list-option{
    height: 100px;
    overflow-y: scroll;
    border: 1px solid #ccc;
    padding: 10px 0;
  }
</style>
    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12 col-md-6">
          <div>
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
          <div class="box box-primary">
            <div class="box-header with-border">
              <!-- <h3 class="box-title">Sửa sản phẩm(nhập)</h3> -->
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form role="form" method="post" action="{!! route('stock.update', ['id' => $details->spt_id]) !!}" enctype="multipart/form-data">
              <div class="box-body">
                <div class="form-group">
                  <label>Danh mục</label>
                  <select class="form-control" name="unit">
                  	<!-- <option value="0">Chọn danh mục</option> -->
                  	@foreach($category as $cat)
                      @if( $cat->id == $details->spt_category_id)
                    	 <option value="{{ $cat->id }}" selected> {{ $cat->name }} ({{ $cat->unit_name }})</option>
                      @else                      
                        <option value="{{ $cat->id }}"> {{ $cat->name }} ({{ $cat->unit_name }})</option>
                      @endif
                    @endforeach
                  </select>
                </div>

                <div class="form-group">
                  <label>Tên sản phẩm <span class="required">*</span></label>
                  <input type="text" class="form-control" placeholder="Tên sản phẩm" name="pname" value="@if(isset($details->spt_name)){{ $details->spt_name }}@endif">
                </div>

                <!-- <div class="form-group">
                  <label>Lượng sản phẩm</label>
                  <input type="text" class="form-control" placeholder="Lượng sản phẩm" name="pquantity" value="@if(isset($details->spt_quantity)){{ $details->spt_quantity }}@endif">
                </div> -->

                <div class="form-group">
                  <label>Mô tả</label>
                  <textarea placeholder="Mô tả sản phẩm" rows="3" class="form-control" name="pdesc">@if(isset($details->spt_desc)){{ $details->spt_desc }}@endif</textarea>
                </div>

                <!-- <div class="form-group">
                  <label>Trạng thái: </label>
                  <label class="radio-inline">
                    <input type="radio" name="pstatus" value="1" @if($details->spt_status == 1) checked @endif > Hiện
                  </label>
                  <label class="radio-inline">
                    <input type="radio" name="pstatus" value="0" @if($details->spt_status == 0) checked @endif> Ẩn
                  </label>
                </div> -->

                <div class="clearfix"></div>

                <div class="form-group">
                  @if(isset($details->spt_image))
                    <img width="200px" src="{{ asset('uploads/product_stock/'.$details->spt_image) }}" alt=""> <div class="clearfix"></div>
                  @endif
                  <label>Ảnh sản phẩm</label>                  
                  <input type="file" name="pimage">
                  <input type="hidden" name="pimage_old" value="@if(isset($details->spt_image)){{ $details->spt_image }}@endif">
                  <p class="help-block"></p>
                </div>
              </div>
              <!-- /.box-body -->

              <div class="box-footer text-right">
                <button type="submit" class="btn btn-primary">Lưu</button>
              </div>
              <input type="hidden" name="_method" value="PUT">
              <input type="hidden" name="_token" value="{{ csrf_token() }}">
            </form>
          </div>
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
@endsection