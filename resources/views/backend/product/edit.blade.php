@extends('backend.layouts.master', ['page_title' => 'Quản lý sản phẩm'])
@section ('title','Quản lý sản phẩm')
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
        <div class="col-xs-12 col-md-12 col-lg-12">
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
              <h3 class="box-title">Sửa sản phẩm</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form role="form" method="post" action="{!! route('admin.product.update', ['id' => $details->product_id]) !!}" enctype="multipart/form-data">
              <div class="box-body">
                <div class="form-group">
                  <label>Danh mục</label>
                  <select class="form-control" name="cat_id">
                  	<!-- <option value="0">Chọn danh mục</option> -->
                  	@foreach($listCategory as $cat)
                      @if( $cat->category_id == $details->category_id)
                    	<option value="{{ $cat->category_id }}" selected> --- {{ $cat->category_name }}</option>
                      @endif
                      @if( $cat->category_id != $details->category_id)
                      <option value="{{ $cat->category_id }}"> --- {{ $cat->category_name }}</option>
                      @endif
                    @endforeach
                  </select>
                </div>

                <div class="form-group">
                  <label>Tên sản phẩm</label>
                  <input type="text" class="form-control" placeholder="Tên sản phẩm" name="pname" value="{{ $details->product_name }}">
                </div>

                <div class="form-group">
                  <label>Giá</label>
                  <input type="number" class="form-control" placeholder="Giá sản phẩm" name="pprice" min="0" value="{{ $details->product_price }}">
                </div>

                <div class="form-group">
                  <label>Loại: </label>
                  <label class="radio-inline">
                    <input type="radio" name="ptype" value="0" @if( $details->product_type == 0 ) checked @endif> Thường
                  </label>
                  <label class="radio-inline">
                    <input type="radio" name="ptype" value="1" @if( $details->product_type == 1 ) checked @endif > Mới
                  </label>
                  <label class="radio-inline">
                    <input type="radio" name="ptype" value="2" @if( $details->product_type == 2 ) checked @endif > Hot
                  </label>
                  <label class="radio-inline">
                    <input id="sale-off" type="radio" name="ptype" value="3" @if( $details->product_type == 3 ) checked @endif > Sale-off
                  </label>
                </div>

                <div id="sale-off-value" class="form-group hide">
                  <label>Sale off(%)</label>
                  <input type="number" class="form-control" placeholder="Giảm giá" name="psaleoff" min="0" value="{!!old('psaleoff')!!}">
                </div>

                <div class="form-group">
                  <label>Trạng thái: </label>
                  <label class="radio-inline">
                    <input type="radio" name="pstatus" value="1" @if($details->status == 1) checked @endif > Còn hàng
                  </label>
                  <label class="radio-inline">
                    <input type="radio" name="pstatus" value="0" @if($details->status == 0) checked @endif> Hết hàng
                  </label>
                </div>

                <div class="form-group">
                  <label>Mô tả</label>
                  <textarea placeholder="Mô tả sản phẩm" rows="3" class="form-control" name="pdesc">{{ $details->product_desc }}</textarea>
                </div>

                <div class="form-group">
                  <label>Thông tin chi tiết</label>
                  <textarea placeholder="Thông tin chi tiết về sản phẩm" rows="3" class="form-control" name="pcontent">{{ $details->product_content }}</textarea>
                </div>

                <div class="clearfix"></div>

                <div class="form-group">
                  @if(isset($details->product_image))
                  <?php $pimageArr = json_decode($details->product_image); ?>
                  @foreach ($pimageArr as $pimage)
                    <div class="pimg col-lg-2 col-md-2 col-sm-3 col-sx-4">
                      <img style="width: 100%;height:150px;border:1px solid #aaa;" src="{{ asset('uploads/product/'.$pimage) }}" alt="">
                    </div>
                  @endforeach  
                  <div class="clearfix"></div>
                  @endif
                </div>

                <div class="form-group">
                  <label>Ảnh sản phẩm</label>                  
                  <input id="fileupload" type="file" name="files[]" multiple>
                  <input type="hidden" name="pimage_old" value="{{ $details->product_image }}">
                  <p class="help-block"></p>
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

@section('after-scripts-end')
  {{ Html::script(asset('bower_components/ckeditor/ckeditor.js')) }}
  {{ Html::script(asset('bower_components/ckfinder/ckfinder.js')) }}
  
  <script type="text/javascript">
    config = {};
    config.toolbarGroups = [
      { name: 'editing', groups: [ 'find', 'selection', 'spellchecker', 'editing' ] },
      { name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ] },
      { name: 'forms', groups: [ 'forms' ] },
      { name: 'paragraph', groups: [ 'list', 'indent', 'blocks', 'align', 'bidi', 'paragraph' ] },
      { name: 'links', groups: [ 'links' ] },
      { name: 'clipboard', groups: [ 'clipboard', 'undo' ] },
      '/',
      { name: 'styles', groups: [ 'styles' ] },
      { name: 'insert', groups: [ 'insert' ] },
      { name: 'colors', groups: [ 'colors' ] },
      { name: 'tools', groups: [ 'tools' ] },
      { name: 'others', groups: [ 'others' ] },
      { name: 'about', groups: [ 'about' ] },
      { name: 'document', groups: [ 'mode', 'document', 'doctools' ] }
    ];

    config.removeButtons = 'Form,Checkbox,Radio,TextField,Textarea,Select,Button,ImageButton,HiddenField,SelectAll,Scayt,NewPage,Preview,Print,Save,Templates,Cut,Copy,Find,Replace,Paste,PasteText,PasteFromWord';
    
    config.filebrowserBrowseUrl = '/bower_components/ckfinder/ckfinder.html';
    config.filebrowserImageBrowseUrl = '/bower_components/ckfinder/ckfinder.html';

    CKEDITOR.replace( 'pcontent', config );
  </script>
  
@stop