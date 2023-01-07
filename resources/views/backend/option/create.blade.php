@extends('backend.layouts.master', ['page_title' => 'Quản lý Option'])
@section ('title','Quản lý Option')
@section('content')

    <!-- Main content -->
    <section class="content">
      <div class="row">        
        <div class="col-xs-12 col-md-12 col-lg-6">
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
              <h3 class="box-title">Thêm mới Option</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form role="form" method="post" action="{!! route('admin.option.store') !!}">
              <div class="box-body">
                <div class="form-group">
                  <label>Tên option <span class="required">*</span></label>
                  <input type="text" class="form-control" placeholder="Tên option" name="name">
                </div>

                <div class="form-group">
                  <label>Giá <span class="required">*</span></label>
                  <input type="number" class="form-control" placeholder="Giá option" name="price" min="1">
                </div>

                <div class="form-group">
                  <label>Loại: </label>
                  <label class="radio-inline">
                    <input type="radio" name="type" value="1" checked> Bếp xử lý
                  </label>
                  <label class="radio-inline">
                    <input type="radio" name="type" value="0"> Bếp không xử lý
                  </label>
                </div>

                <div class="form-group">
                  <label>Trạng thái: </label>
                  <label class="radio-inline">
                    <input type="radio" name="status" value="1" checked> Còn hàng
                  </label>
                  <label class="radio-inline">
                    <input type="radio" name="status" value="0"> Hết hàng
                  </label>
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