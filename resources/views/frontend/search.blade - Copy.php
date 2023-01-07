@extends('frontend.layouts.master')

@if (isset($title))
	@section('title',$title)
@else
	@section('title','menu')
@endif

@section('content')
<!-- start main1 -->
@if(isset($products))
<div class="main_bg1">
<div class="wrap">	
	<div class="main1">
		<h2>@if(isset($stext)) Kết quả tìm kiếm với từ khóa: <i>"{{ $stext }}"</i> @endif</h2>
	</div>
</div>
</div>
<!-- start main -->
<div class="main_bg">
<div class="wrap">	
	<div class="main">
		<div class="container-fluid">
			<div class="row">
				@foreach($products as $item)
				<?php 
                    $img = json_decode($item->product_image);
                ?>
				<div class="grid1_of_3 col-lg-3 col-md-3 col-sm-4 col-xs-4">
					<div class="item-info">
						<a href="/san-pham/<?php echo $item->product_id.'/'.$item->alias.'.html'; ?>"><img src="{{ asset('/uploads/product/'.$img[0]) }}" alt="{{ $item->product_name }}"/>
						<h3>{{ $item->product_name }}</h3>
						</a>
						<div class="price">
							<h4>{{ number_format($item->product_price, 0, ',', '.') }} VND<span onclick="add_cart({{ $item->product_id }});">Mua</span></h4>
						</div>
						<span class="b_btm"></span>
					</div>
				</div>
				@endforeach
				<div class="clearfix"></div>
			</div>
			<div class="box-footer clearfix" id="pagination-link">
              	{{$products->appends(Request::only(['s']))->links()}}
            </div>
		</div>
	</div>
</div>
</div>
@endif

@stop
