@extends('backend.layouts.master', ['page_title' => 'Thêm mới sản phẩm thô'])
@section ('title','Thêm mới sản phẩm thô')
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
              <!-- <h3 class="box-title">Thêm mới sản phẩm thô</h3> -->
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form role="form" method="post" action="{!! route('stock.store') !!}" enctype="multipart/form-data">
              <div class="box-body">
                <div class="form-group">
                  <label>Danh mục <span class="required">*</span></label>
                  <select class="form-control" name="unit">
                  	<option value="">---Chọn danh mục---</option>
                  	@foreach($category as $cat)                  	
                    	<option value="{{ $cat->id }}"> {{ $cat->name }} ({{ $cat->unit_name }})</option>
                    @endforeach
                  </select>
                </div>

                <div class="form-group">
                  <label>Tên sản phẩm <span class="required">*</span></label>

                  <input type="text" class="form-control" placeholder="Tên sản phẩm" name="pname" value="{!!old('pname')!!}">
                </div>

                <!-- <div class="form-group">
                  <label>Lượng sản phẩm</label>
                  <input type="text" class="form-control" placeholder="Lượng sản phẩm" name="pquantity">
                </div> -->

                <div class="form-group">
                  <label>Mô tả</label>
                  <textarea placeholder="Mô tả sản phẩm" rows="3" class="form-control" name="pdesc">{!!old('pdesc')!!}</textarea>
                </div>

                <!-- <div class="form-group">
                  <label>Trạng thái: </label>
                  <label class="radio-inline">
                    <input type="radio" name="pstatus" value="1" checked> Hiện
                  </label>
                  <label class="radio-inline">
                    <input type="radio" name="pstatus" value="0"> Ẩn
                  </label>
                </div> -->

                <div class="clearfix"></div>

                <div class="form-group">
                  <label>Ảnh sản phẩm</label>
                  <input type="file" name="pimage">

                  <p class="help-block"></p>
                </div>
              </div>
              <!-- /.box-body -->

              <div class="box-footer text-right">
                <button type="submit" class="btn btn-primary">Lưu</button>
              </div>
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