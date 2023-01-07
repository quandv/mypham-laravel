@extends('frontend.layouts.master')

@if (isset($title))
	@section('title',$title)
@else
	@section('title','menu')
@endif

@section('content')
<!-- start main1 -->
@if(isset($sale) && count($sale) > 0)
<div class="main_bg1">
<div class="wrap">	
	<div class="main1">
		<h2>SẢN PHẨM KHUYẾN MẠI</h2>
	</div>
</div>
</div>
<!-- start main -->
<div class="main_bg">
<div class="wrap">	
	<div class="main">
		<div class="container-fluid">
			<div class="row">
				@foreach($sale as $saleItem)
				<?php 
                    $img = json_decode($saleItem->product_image);
                ?>
				<div class="grid1_of_3 col-lg-3 col-md-3 col-sm-4 col-xs-4">
					<div class="item-info">
						<a href="/san-pham/<?php echo $saleItem->product_id.'/'.$saleItem->alias.'.html'; ?>"><img src="{{ asset('/uploads/product/'.$img[0]) }}" alt="{{ $saleItem->product_name }}"/>
						<h3>{{ $saleItem->product_name }}</h3>
						</a>
						<div class="price">
							<h4>{{ number_format($saleItem->product_price, 0, ',', '.') }} VND<span onclick="add_cart({{ $saleItem->product_id }});">Mua</span></h4>
						</div>
						<span class="b_btm"></span>
					</div>
				</div>
				@endforeach
				<div class="clearfix"></div>
			</div>
		</div>
	</div>
</div>
</div>
@endif

@if(isset($hot) && count($hot) > 0)
<div class="main_bg1">
<div class="wrap">	
	<div class="main1">
		<h2>SẢN PHẨM HOT</h2>
	</div>
</div>
</div>
<!-- start main -->
<div class="main_bg">
<div class="wrap">	
	<div class="main">
		<div class="container-fluid">
			<div class="row">
				@foreach($hot as $hotItem)
				<?php 
                    $img = json_decode($hotItem->product_image);
                ?>
				<div class="grid1_of_3 col-lg-3 col-md-3 col-sm-4 col-xs-4">
					<div class="item-info">
						<a href="/san-pham/<?php echo $hotItem->product_id.'/'.$hotItem->alias.'.html'; ?>"><img src="{{ asset('/uploads/product/'.$img[0]) }}" alt="{{ $hotItem->product_name }}" id="img-{{ $hotItem->product_id }}" />
						<h3>{{ $hotItem->product_name }}</h3>
						</a>
						<div class="price">
							<h4>{{ number_format($hotItem->product_price, 0, ',', '.') }} VND<span onclick="add_cart({{ $hotItem->product_id }});">Mua</span></h4>
						</div>
						<span class="b_btm"></span>
					</div>
				</div>
				@endforeach
				<div class="clearfix"></div>
			</div>
		</div>
	</div>
</div>
</div>
@endif

@if(isset($new) && count($new) > 0)
<div class="main_bg1">
<div class="wrap">	
	<div class="main1">
		<h2>SẢN PHẨM MỚI</h2>
	</div>
</div>
</div>
<!-- start main -->
<div class="main_bg">
<div class="wrap">	
	<div class="main">
		<div class="container-fluid">
			<div class="row">
				@foreach($new as $newItem)
				<?php 
                    $img = json_decode($newItem->product_image);
                ?>
				<div class="grid1_of_3 col-lg-3 col-md-3 col-sm-4 col-xs-4">
					<div class="item-info">
						<a href="/san-pham/<?php echo $newItem->product_id.'/'.$newItem->alias.'.html'; ?>"><img src="{{ asset('/uploads/product/'.$img[0]) }}" alt="{{ $newItem->product_name }}"/>
						<h3>{{ $newItem->product_name }}</h3>
						</a>
						<div class="price">
							<h4>{{ number_format($newItem->product_price, 0, ',', '.') }} VND<span onclick="add_cart({{ $newItem->product_id }});">Mua</span></h4>
						</div>
						<span class="b_btm"></span>
					</div>
				</div>
				@endforeach
				<div class="clearfix"></div>
			</div>
		</div>
	</div>
</div>
</div>
@endif
@stop
