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
		@foreach ($childs as $child)
			<li>
				<a href="{{$child->category_id}}">{{ $child->category_name }} /</a>
			</li>
		@endforeach
	</ul>
</div>

<div class="tab-content">

	<div class="food-list">

		@foreach( $products as $product )
		<div class="food-item row">
			<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 no-padd-right food-item-img">
				<img src="{{ asset($product->product_image) }}" alt="">
			</div>
			<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 no-padd-right food-item-content">
				<div class="main-content">
					<h3>{{ $product->product_name }}</h3>
					<p>{{ $product->product_desc }}</p>
				</div>

				@if(isset($product->opname))
				<?php 
					$opname 	= explode(',', $product->opname);
					$opprice 	= explode(',', $product->opprice);
					$opid 		= explode(',', $product->opid);

					$count = count(explode(',', $product->opid)); 
				?>
				<div class="sub-content">
					<form action="" class="option">
						@for ($i = 0; $i < $count; $i++)
						<div class="option-item" data-opid="{{$opid[$i]}}"><input type="checkbox"> {{ $opname[$i].' ( '.number_format($opprice[$i], '0', ',', '.').'d ) ' }}  </div>
						@endfor
					</form>										
				</div>
				@endif
			</div>
			<div class="col-xs-12 col-sm-2 col-md-2 col-lg-2 no-padd-right food-item-price">
				<button>{{ number_format($product->product_price, 0,',', '.') }} | <i class="glyphicon glyphicon-plus"></i> </button>
			</div>
		</div> <!-- end .food-item -->
		@endforeach

	</div><!-- end .food-list -->
	@if(isset($offset))
		<div class="load-more text-center" data-id="{{$category_id}}" data-offset="{{$offset}}">load-more</div>
	@else
		<div class="load-more text-center" data-id="{{$category_id}}" data-offset="1">load-more</div>
	@endif

	<div id="xoi" role="tabpanel" class="tab-pane  food-list">
		<div class="food-item row">
			<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 no-padd-right food-item-img">
				<img src="images/Order-Food-2.png" alt="">
			</div>
			<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 no-padd-right food-item-content">
				<div class="main-content">
					<h3>cơm gà</h3>
					<p>với rau, củ, nước tương và các gia giảm khác</p>
				</div>
				<div class="sub-content hide">
					<form action="">
						<input type="checkbox"> trứng (+5.000d)
						<input type="checkbox"> xúc xích (+10.000d)
						<input type="checkbox"> đùi gà (+30.000d)
					</form>
				</div>
			</div>
			<div class="col-xs-12 col-sm-2 col-md-2 col-lg-2 no-padd-right food-item-price">
				<button>50.000d | <i class="glyphicon glyphicon-plus"></i> </button>
			</div>
		</div> <!-- end .food-item -->
	</div><!-- end .food-list -->

	<div id="bun" role="tabpanel" class="tab-pane  food-list">
		<div class="food-item row">
			<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 no-padd-right food-item-img">
				<img src="images/Order-Food-1.png" alt="">
			</div>
			<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 no-padd-right food-item-content">
				<div class="main-content">
					<h3>cơm gà</h3>
					<p>với rau, củ, nước tương và các gia giảm khác</p>
				</div>
				<div class="sub-content hide">
					<form action="">
						<input type="checkbox"> trứng (+5.000d)
						<input type="checkbox"> xúc xích (+10.000d)
						<input type="checkbox"> đùi gà (+30.000d)
					</form>
				</div>
			</div>
			<div class="col-xs-12 col-sm-2 col-md-2 col-lg-2 no-padd-right food-item-price">
				<button>50.000d | <i class="glyphicon glyphicon-plus"></i> </button>
			</div>
		</div> <!-- end .food-item -->
	</div><!-- end .food-list -->

	<div id="pho" role="tabpanel" class="tab-pane  food-list">
		<div class="food-item row">
			<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 no-padd-right food-item-img">
				<img src="images/Order-Food-3.png" alt="">
			</div>
			<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 no-padd-right food-item-content">
				<div class="main-content">
					<h3>cơm gà</h3>
					<p>với rau, củ, nước tương và các gia giảm khác</p>
				</div>
				<div class="sub-content hide">
					<form action="">
						<input type="checkbox"> trứng (+5.000d)
						<input type="checkbox"> xúc xích (+10.000d)
						<input type="checkbox"> đùi gà (+30.000d)
					</form>
				</div>
			</div>
			<div class="col-xs-12 col-sm-2 col-md-2 col-lg-2 no-padd-right food-item-price">
				<button>50.000d | <i class="glyphicon glyphicon-plus"></i> </button>
			</div>
		</div> <!-- end .food-item -->
	</div><!-- end .food-list -->

	<div id="mi" role="tabpanel" class="tab-pane  food-list">
		<div class="food-item row">
			<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 no-padd-right food-item-img">
				<img src="images/Order-Food-1.png" alt="">
			</div>
			<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 no-padd-right food-item-content">
				<div class="main-content">
					<h3>cơm gà</h3>
					<p>với rau, củ, nước tương và các gia giảm khác</p>
				</div>
				<div class="sub-content hide">
					<form action="">
						<input type="checkbox"> trứng (+5.000d)
						<input type="checkbox"> xúc xích (+10.000d)
						<input type="checkbox"> đùi gà (+30.000d)
					</form>
				</div>
			</div>
			<div class="col-xs-12 col-sm-2 col-md-2 col-lg-2 no-padd-right food-item-price">
				<button>50.000d | <i class="glyphicon glyphicon-plus"></i> </button>
			</div>
		</div> <!-- end .food-item -->
	</div><!-- end .food-list -->

	<div id="banh-mi" role="tabpanel" class="tab-pane  food-list">
		<div class="food-item row">
			<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 no-padd-right food-item-img">
				<img src="images/Order-Food-2.png" alt="">
			</div>
			<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 no-padd-right food-item-content">
				<div class="main-content">
					<h3>cơm gà</h3>
					<p>với rau, củ, nước tương và các gia giảm khác</p>
				</div>
				<div class="sub-content hide">
					<form action="">
						<input type="checkbox"> trứng (+5.000d)
						<input type="checkbox"> xúc xích (+10.000d)
						<input type="checkbox"> đùi gà (+30.000d)
					</form>
				</div>
			</div>
			<div class="col-xs-12 col-sm-2 col-md-2 col-lg-2 no-padd-right food-item-price">
				<button>50.000d | <i class="glyphicon glyphicon-plus"></i> </button>
			</div>
		</div> <!-- end .food-item -->
	</div><!-- end .food-list -->
</div>
@stop