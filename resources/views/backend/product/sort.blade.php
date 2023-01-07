@extends('backend.layouts.master', ['page_title' => 'Quản lý sản phẩm'])
@section ('title','Quản lý sản phẩm')
@section('content')
{{ Html::style(asset('css/sort.product.css')) }}
    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12 no-padding">
        	<div class="box box-warning">
            <!-- <div class="box-header">
              	<h3 class="box-title">Danh sách sản phẩm</h3>
            </div> -->
            <!-- /.box-header -->
            <div class="box-body">
            	@if(isset($data) && count($data) >0)
              <?php
                $catIdArr = array();
              ?>
	            	@foreach($data as $key => $val)
      						<div class="col-sm-6 col-md-6 col-lg-4 left no-padding">
      							<div class="col-md-12 no-padding">                
      								<h3 style="text-transform:uppercase;"><span class="label label-primary">{!! $val['category_name'] !!}</span></h3>
      								<ul id="sortable-{!! $val['category_id'] !!}" class="source sortable  ui-sortable ui-sortable-{!! $val['category_id'] !!}" data-cat-id="{!! $val['category_id'] !!}">
      									@if(count($val['data']) >0)
      										@foreach($val['data'] as $key2 => $val2)
      											<li class="sort-li" data-id="{!! $val2->product_id !!}" data-sort="{!! $key2 + 1 !!}" style="height:50px;" >
                              <img src="{{ asset('uploads/product/'.$val2->product_image) }}" alt="" style="width:40px;height:40px;border-radius:5px;">
                              {!! $val2->product_name !!}
                               <span class="pull-right badge sort-{!! $val2->product_id !!}" style="background-color:#f39c12 !important;">{!! $val2->sort !!}</span>
                            </li>

      										@endforeach
      									@endif
      								</ul>
      							</div>
      						</div>
                  <?php
                    $catIdArr[] = $val['category_id'];
                    $catIdStr = implode(',', $catIdArr);
                  ?>
      					@endforeach
                <div id="catIdStr" data-id="{!! $catIdStr !!}"></div>
      				@endif
				
			</div>
  				<div id="loading" class="hide" style="position:absolute;top:0;background:rgba(255,255,255,0.5);width:100%;height:100%;">
            <img src="{{ asset('images/icon/hourglass.gif') }}" alt="" style="position:relative;top:20%;left:50%;">
          </div>
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
      
    </section>
    <!-- /.content -->
@endsection

@section('after-scripts-end')
{{-- Html::script(asset('js/jquery-ui.min.js')) --}}
{{ Html::script(asset('js/jquery.sortable.min.js')) }}

	<script type="text/javascript">
    $('.sort-li').mousedown(function() {
      $(this).css('cursor', 'pointer');
    });
    $('.sortable-placeholder').mousedown(function() {
      $(this).css('cursor', 'pointer');
    });
    $('.sort-li').mouseleave(function() {
      $(this).css('cursor', 'pointer');
    });
    $('.sortable-placeholder').mouseleave(function() {
      $(this).css('cursor', 'pointer');
    });

		$(function () {
      var catIdStr = $('#catIdStr').attr('data-id');
      var catIdArr = catIdStr.split(',');

      $.each(catIdArr, function(index,value){
          /*$('#sortable-'+value).sortable({
              axis: "y",
              stop: function(event, ui){
                var idArr = new Array();
                var sortArr = new Array();
                  $('.ui-sortable-'+value+' li').each(function(i, el){
                      $(el).attr('data-sort',$(el).index()+1);
                      var id = $(el).attr('data-id');
                      var sort = $(el).attr('data-sort');
                      idArr.push(id);
                      sortArr.push(sort);
                  });
                  updateSort(idArr,sortArr,value);
              }
          });*/

          $('#sortable-'+value).sortable({cursor: "pointer"}).bind('sortupdate', function() {
              var idArr = new Array();
              var sortArr = new Array();
              $('.ui-sortable-'+value+' li').each(function(i, el){
                  $(el).attr('data-sort',$(el).index()+1);
                  var id = $(el).attr('data-id');
                  var sort = $(el).attr('data-sort');
                  idArr.push(id);
                  sortArr.push(sort);
              });
              updateSort(idArr,sortArr,value);
          });
      });

		});
    
    function updateSort(idArr,sortArr,value){
      $.ajax({
        url : base_url+"/product/update_sort",
            type : "post",
            dataType:"json",
            data : {
                "_token": tokenvrf,
                'idArr' : idArr,
                'sortArr' : sortArr,
                'idCatRoot': value
            },
            beforeSend: function(){
              var top50 = ($(window).scrollTop() + ( $(window).height() / 2) - 200 );
              $('#loading img').css({'top':top50});
              $('#loading').removeClass('hide');
            },
            success : function (result){
                $('.ui-sortable-'+value+' li').each(function(index, value){
                  var id = $(this).attr('data-id');
                  var sort = $(this).attr('data-sort');
                  $('.sort-'+id).text( sort );
                });
                $('#loading').addClass('hide');
                if(result){
                  swal({
                    title: 'Thành công',
                    text: "",
                    type: 'success',
                    timer: 1000
                  })
                }else{
                  swal({
                    title: 'Lỗi',
                    text: "",
                    type: 'error',
                    timer: 1000
                  })
                }
            }
      });
    }
	</script>
@stop