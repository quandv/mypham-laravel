@extends('backend.layouts.master',['page_title'=> 'Đơn vị'])
@section ('title','Đơn vị')
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
                <h3 class="box-title">Sửa đơn vị</h3>
            </div> 
            <form role="form" method="post" id="" action="{!! route('unit.update', ['id' => $details->dv_id]) !!}" enctype="multipart/form-data">
                <div class="box-body">
                    <div class="form-group ">
                        <label for="dv_name" class="control-label">Tên đơn vị <span class="required">*</span></label>
                        <div>
                            <input class="form-control" id="dv_name" name="dv_name" placeholder="Tên đơn vị" type="text" value="{!! $details->dv_name!!}">
                         </div>
                    </div>

                    <div class="form-group ">
                        <label for="dv_description_" class="control-label">Mô tả</label>
                        <div>
                            <textarea class="form-control" id="dv_description_" name="dv_desc" rows="7" placeholder="Mô tả">{!! $details->dv_desc!!}</textarea>
                        </div>
                    </div>

                    <div class="form-group">
                      <label>Trạng thái: </label>
                      <label class="radio-inline">
                        <input type="radio" name="dv_status" value="1" @if($details->dv_status == 1) checked @endif> Hiện
                      </label>
                      <label class="radio-inline">
                        <input type="radio" name="dv_status" value="0" @if($details->dv_status == 0) checked @endif > Ẩn
                      </label>
                    </div>
                </div>
                <div class="box-footer">
                    <div class="pull-right">
                        <button class="btn btn-primary" type="submit" name="add">Lưu</button>
                    </div>
                </div>
                <input type="hidden" name="_method" value="PUT">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">

            </form>
        </div>    
    </div>
    <div class="col-sm-12 col-lg-7">
        <div class="box box-primary">
            <div class="box-body">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="">
                          <select name="select-option-chose" id="action-option" class="form-control pull-left borderRad3 marginRight3" style="width: 150px;" >
                            <option value="-1">--Xử lý--</option>
                              <option value="1">Xóa</option>
                          </select>
                          <a id="apply-select" class="btn btn-default form-control pull-left marginBot5" style="width: 100px;text-align:center">Áp dụng</a>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <form action="{!! route('admin.unit.search') !!}" method="get" id="post_category_search_form" class="form-horizontal" role="form">
                        <div class="pull-right">
                            <div class="input-group">
                                  <input class="form-control borderRad3 marginBot5" name="stxt" placeholder="đơn vị" type="text" value="{!! Request::get('stxt')!!}">
                                  <span class="input-group-btn">
                                    <button class="btn btn-default marginBot5" type="submit">
                                        <i class="fa fa-search"></i></button>
                                </span>
                            </div>
                        </div>
                        </form>
                    </div>
                </div>
                <br>
                <div class="table-responsive">
                     
                        <table class="table table-bordered table-hover table-striped k-table-list">
                          <tr>
                             <th style="width: 50px;"><input name="checkall-toggle" type="checkbox" id="checkAll"></th>
                              <th>Tên đơn vị</th>
                              <th>Mô tả</th>
                              <!-- <th>Trạng thái</th> -->
                              <th style="width: 100px">Xử lý</th>
                          </tr>
                          @if(!empty($listUnit))
                            @foreach($listUnit as $unit)
                            <tr>
                              <td><input type="checkbox" value="{{ $unit->dv_id }}" class="pid-checkbox check"></td>
                              <td>{!! $unit->dv_name !!}</td>
                              <td>{!! $unit->dv_desc !!}</td>
                              <!-- <td>
                                @if( $unit->dv_status == 0 )
                                  <span class="label label-default">Ẩn</span>
                                @else
                                  <span class="label label-success">Hiện</span>
                                @endif
                              </td> -->
                              <td>
                                <a class="btn btn-info btn-xs marginBot5" href="{!! route('unit.edit', ['id' => $unit->dv_id]) !!}"><i class="fa fa-pencil"></i></a>
                                <form id="delete-form-{{$unit->dv_id}}" style="display:inline-block" action="{!! route('unit.destroy', ['id' => $unit->dv_id]) !!}" method="post">
                                  <input type="hidden" name="_method" value="DELETE">
                                  <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                  <a class="btn btn-danger btn-xs marginBot5" onclick="javascript:del_unit({{$unit->dv_id}});"><i class="fa fa-minus-circle"></i></a>
                                </form>
                              </td>
                            </tr>
                            @endforeach
                          @endif                            
                        </table>                  
                </div>
                <div class="box-footer clearfix" id="pagination-link">
                  {{$listUnit->links()}}
                </div>
            </div>
            <!-- /.box-body -->
        </div>
    </div>
</div>

@endsection

@section('after-scripts-end')
<script type="text/javascript">
  function del_unit(id){
    swal({
        title: 'Thông báo',
        text: "Bạn chắc chắn muốn xóa mục này?",
        type: 'warning',
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Đồng ý',
        cancelButtonText: 'Hủy',
        showCancelButton: true,
      }).then(function() {
        $('#delete-form-'+id).submit();
      });
  }

  $(document).ready(function(){
    //check all
      $("#checkAll").click(function () {
          $(".check").prop('checked', $(this).prop('checked'));
      });
  });
</script>
@stop