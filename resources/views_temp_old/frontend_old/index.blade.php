@extends('frontend.layouts.master')

@if (isset($title))
	@section('title',$title)
@else
	@section('title','menu')
@endif

@section('content')
<div class="title">
	<h1>	
		@if (isset($title))
			{{$title}}
		@else
			menu
		@endif
	</h1>
</div>
<div class="menu-child">
	<ul class="nav nav-tabs no-padding" role="tablist">
		@if(isset($childs))
			@foreach ($childs as $child)
				<li>
					@if( $category_id == $child->category_id)
						<a class="category-active" href="{{ asset('category/'.$child->category_alias.'/'.$child->category_id) }}">{{ $child->category_name }} /</a>
					@else
						<a href="{{ asset('category/'.$child->category_alias.'/'.$child->category_id) }}">{{ $child->category_name }} /</a>
					@endif
				</li>
			@endforeach
		@endif
	</ul>
</div>

<div class="tab-content">
	<div class="food-list">
		@foreach( $products as $product )
		<div class="food-item row">
			<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 no-padd-right food-item-img">
				<img id="img-{{ $product->product_id }}" src="{{ asset('uploads/product/'.$product->product_image) }}" alt="">
			</div>
			<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 no-padd-right food-item-content">
				<div class="main-content">
					<h3>{{ $product->product_name }}</h3>
					<p>{{ $product->product_desc }}</p>
				</div>
				
				@if(!in_array('',$product->option_id_group))
				<div class="sub-content sub-content-{{ $product->product_id }}">
					<form action="" class="option-form">				
						@foreach($product->option_id_group as $k => $v)
							@if($v > 0 && $product->option_status_group[$k] != 0)
								<div class="option-item option-item-{{ $product->product_id }}" data-opid="{{$v}}">
									<input class="option-input" type="checkbox" value="{{$v}}"> {{ $product->option_name_group[$k] }} ( {{ $product->option_price_group[$k] }} )
									<span class="count-option-{{$v}} hide">(<span class="num-{{$v}}">0</span>)</span>
									<button onclick="javascript:add1({{ $product->product_id }},{{ $v }});"  type="button" class="btn btn-default btn-xs add1-option add1-option-{{$v}} hide" style="background:rgba(0, 0, 0, 0) linear-gradient(#ec0000, #b10000) repeat scroll 0 0; color:#fff;">+1</button>
									<button onclick="javascript:down1({{ $product->product_id }},{{ $v }});" type="button" class="btn btn-default btn-xs down1-option down1-option-{{$v}} hide" style="background:rgba(0, 0, 0, 0) linear-gradient(#ec0000, #b10000) repeat scroll 0 0; color:#fff;">-1</button>
									<button onclick="javascript:delAll({{ $product->product_id }},{{ $v }});" type="button" class="btn btn-default btn-xs cancel-option cancel-option-{{$v}} hide" style="background:rgba(0, 0, 0, 0) linear-gradient(#ec0000, #b10000) repeat scroll 0 0; color:#fff; font-weight:bold;">X</button>
								</div>
							@endif
						@endforeach	
					</form>	
				</div>
				@endif
			</div>
			<div class="col-xs-12 col-sm-2 col-md-2 col-lg-2 no-padd-right food-item-price">
				@if($product->status == 1)
					<button type="button" class="btn-enable btn-enable-{{ $product->product_id }}" onclick="javascript:add_cart({{ $product->product_id }});">{{ number_format($product->product_price, 0,',', '.') }} | <i class="glyphicon glyphicon-plus"></i> </button>
				@else
					<button type="button" class="btn-disable">Hết hàng</button>
				@endif
				@permission('manager-product')
					<div class="manager-product-edit"><a href="<?php echo URL::to('/').'/admin/product/'.$product->product_id.'/edit'; ?>"><span class="label label-info"><i class="glyphicon glyphicon-edit"></i> Chỉnh sửa</span></a></div>
				@endauth

			</div>
		</div> <!-- end .food-item -->
		@endforeach

	</div><!-- end .food-list -->
	@if( count($products) == $limit )
		@if(isset($offset) && isset($limit))
			<div class="load-more text-center" data-id="{{$category_id}}" data-offset="{{$offset}}"><img src="{{ asset('images/icon/loadmore.png') }}" alt=""></div>
			<div class="loading text-center hide"><img src="{{ asset('images/icon/loading.gif') }}" alt=""></div>
		@else
			<div class="load-more text-center" data-id="{{$category_id}}" data-offset="{{$limit}}"><img src="{{ asset('images/icon/loadmore.png') }}" alt=""></span></div>
			<div class="loading text-center hide"><img src="{{ asset('images/icon/loading.gif') }}" alt=""></div>
			
		@endif	
	@endif	
</div>
@stop
