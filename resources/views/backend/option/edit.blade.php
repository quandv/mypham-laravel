@extends('backend.layouts.master', ['page_title' => 'Quản lý option'])
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
              <h3 class="box-title">Sửa option</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form role="form" method="post" action="{!! route('admin.option.update', ['id' => $details->id]) !!}">
              <div class="box-body">

                <div class="form-group">
                  <label>Tên option <span class="required">*</span></label>
                  <input type="text" class="form-control" placeholder="Tên option" name="name" value="{{ $details->name }}">
                </div>

                <div class="form-group">
                  <label>Giá <span class="required">*</span></label>
                  <input type="number" class="form-control" placeholder="Giá option" name="price" min="1" value="{{ $details->price }}">
                </div>

                <div class="form-group">
                  <label>Loại: </label>
                  <label class="radio-inline">
                    <input type="radio" name="type" value="1" @if($details->type == 1) checked @endif > Bếp xử lý
                  </label>
                  <label class="radio-inline">
                    <input type="radio" name="type" value="0" @if($details->type == 0) checked @endif> Bếp không xử lý
                  </label>
                </div>

                <div class="form-group">
                  <label>Trạng thái: </label>
                  <label class="radio-inline">
                    <input type="radio" name="status" value="1" @if($details->status == 1) checked @endif > Còn hàng
                  </label>
                  <label class="radio-inline">
                    <input type="radio" name="status" value="0" @if($details->status == 0) checked @endif> Hết hàng
                  </label>
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