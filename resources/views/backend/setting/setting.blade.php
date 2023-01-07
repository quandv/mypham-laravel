@extends('backend.layouts.master',['page_title' => 'Setting'])
@section ('title','Setting')
@section('content')
    <div class='row'>
    @if (session('flash_message_err') != '')
      <div class="alert alert-danger" role="alert">{!! session('flash_message_err')!!}</div>
    @endif
        <div class='col-sm-12 col-lg-6'>
            <!-- Box -->
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Basic</h3>
                    <div class="box-tools pull-right">
                        <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
                        <button class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove"><i class="fa fa-times"></i></button> 
                    </div>
                </div>
                <div class="box-body">
                     @if(count($errors->setting) > 0)
				      <div class="alert alert-danger" role="alert">
				        <ul>
				            @foreach ($errors->setting->all() as $error)
				                <li>{{ $error }}</li>
				            @endforeach
				        </ul>
				      </div>
				      @endif
				      @if (session('flash_message_succ') != '')
					      <div class="alert alert-success" role="alert"><span class="glyphicon glyphicon-ok text-success" aria-hidden="true"></span> {!! session('flash_message_succ') !!}</div>
					   @endif
              <form action="{!! route('admin.post.setting') !!}" method="post">
                <div class="form-group clearfix">
                  <label for="theme_optionLogo_title" class=" control-label">Thông báo khi khách đặt hàng</label>
                  <div class="">
                  <input class="form-control" name="setting_name" placeholder="Thông báo khi khách đặt hàng "  type="text" value="{!! Config::get('vgmconfig.order_notification') !!}">
                  </div>
                </div> 

                <div class="form-group clearfix">
                  <label for="theme_optionLogo_title" class=" control-label">RealTime </label>
                  <div class="radio">
                  <label>
                  <input type="radio" name="optionsRadios" id="optionsRadios1" value="1" @if(Config::get('vgmconfig.realtime')) checked="checked" @endif>
                  Công nghệ sử dụng Pusher (Recommend)
                  </label>
                  </div>
                  <div class="radio">
                  <label>
                  <input type="radio" name="optionsRadios" id="optionsRadios2" value="0" @if(!Config::get('vgmconfig.realtime')) checked="checked" @endif >
                  Công nghệ sử dụng Ajax 
                  </label>
                  </div>
                </div>

                <div class="form-group clearfix">
                  <label for="theme_optionLogo_title" class=" control-label">Trạng thái sản phẩm (hết hàng) </label>
                  <div class="radio">
                  <label>
                  <input type="radio" name="optionsPstatus" id="optionsPstatus1" value="1" @if(Config::get('vgmconfig.pstatus')) checked="checked" @endif>
                  Tự động cập nhật
                  </label>
                  </div>
                  <div class="radio">
                  <label>
                  <input type="radio" name="optionsPstatus" id="optionsPstatus2" value="0" @if(!Config::get('vgmconfig.pstatus')) checked="checked" @endif >
                  Không tự động cập nhật
                  </label>
                  </div>
                </div>

                <div class="form-group clearfix">
                  <label for="theme_optionLogo_title" class=" control-label">Số lượng sản phẩn hiển thị trên 1 trang</label>
                  <div class="">
                  <input type="number" class="form-control" name="per_page" placeholder=""  type="text" value="{!! Config::get('vgmconfig.per_page') !!}" style="width:200px;">
                  </div>
                </div>

              </div><!-- /.box-body -->
                <div class="box-footer">
                  <div class=" text-right">
                    <button type="submit" class="btn btn-primary">Lưu</button>
                  </div>
                  {!! csrf_field() !!}
                </div><!-- /.box-footer-->
              </form>

            </div><!-- /.box -->
        </div><!-- /.col -->
        <div class='col-sm-12 col-lg-6'>
            <!-- Box -->
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Email</h3>
                    <div class="box-tools pull-right">
                        <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
                        <button class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove"><i class="fa fa-times"></i></button> 
                    </div>
                </div>
                <div class="box-body">
                     @if(count($errors->email) > 0)
                      <div class="alert alert-danger" role="alert">
                        <ul>
                            @foreach ($errors->email->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                      </div>
                      @endif
                      @if (session('flash_message_succ') != '')
                          <div class="alert alert-success" role="alert"><span class="glyphicon glyphicon-ok text-success" aria-hidden="true"></span> {!! session('flash_message_succ') !!}</div>
                       @endif
                      <form action="{!! route('admin.post.settingemail') !!}" method="post">
                          <div class="form-group col-md-7 " style="overflow:hidden;">
                            <label for="theme_optionLogo_title" class=" control-label">To</label>
                            <div class="email_setting" id="email_setting">
                                @if(!empty(Config::get('vgmmail.to')))
                                    @foreach(Config::get('vgmmail.to') as $k => $v)
                                      @if($k == 0)
                                        <div class="inputEmail col-md-10 col-xs-10 col-sm-10 no-padding">         
                                          <input  style="margin-bottom: 3px;" class="form-control" name="email_setting[]" placeholder="Email"  type="text" value="{!! $v !!}">
                                        </div>
                                      @else
                                       <div class="inputEmail inputEmail-{!! $k !!} col-md-12 no-padding">
                                            <div class="col-md-10 col-xs-10 col-sm-10 no-padding">         
                                              <input  style="margin-bottom: 3px;" class="form-control" name="email_setting[]" placeholder="Email"  type="text" value="{!! $v !!}">
                                            </div>
                                            <div class="col-md-2 col-xs-2 col-sm-2"><button class="btn btn-danger btn-xs" type="button" onclick="closeEmail({!! $k !!});"><i class="fa fa-close"></i></button></div>
                                        </div>
                                      @endif
                                    @endforeach
                                 @else
                                     <input class="form-control" name="email_setting[]" placeholder="Email"  type="text" value="">
                                 @endif
                            </div>
                         </div> 
                         <div class="form-group col-md-5 ">
                             <label class="control-label">&nbsp;</label>
                              <div>
                                <button class="btn btn-primary btn-sm addRoom" type="button"><i class="fa fa-plus"></i> Thêm</button>
                              </div>
                         </div>
                             
                </div><!-- /.box-body -->
                <div class="box-footer">
                    <div class="text-right">
                       <button type="submit" class="btn btn-primary">Lưu</button>
                    </div>
                    {!! csrf_field() !!}
                </div><!-- /.box-footer-->
                </form>
            </div><!-- /.box -->
        </div><!-- /.col -->
    
    </div><!-- /.row -->
@endsection
@section('after-scripts-end')
    <script type="text/javascript">    
        $(document).ready(function(){
            $('.addRoom').on('click', function(){
                var sort = $('#email_setting .inputEmail').length + 1;
                var html = '';
                html += '<div class="inputEmail inputEmail-'+sort+' col-md-12 no-padding">';
                html += '<div class="col-md-10 col-xs-10 col-sm-10 no-padding">';
                html += '<div><input style="margin-bottom: 3px;" class="form-control" name="email_setting[]" placeholder="Email" type="text" value=""></div>';
                html += '</div>';
                html += '<div class="col-md-2 col-xs-2 col-sm-2"><button class="btn btn-danger btn-xs" type="button" onclick="closeEmail('+sort+');"><i class="fa fa-close"></i></button></div>';
                html += '</div>';
                $('#email_setting').append(html);
            });            
        });

        function closeEmail(sort){
          $('.inputEmail-'+sort).remove();
        }
    </script>
@stop