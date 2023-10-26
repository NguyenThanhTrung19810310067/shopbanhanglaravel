@extends('welcome')
@section('content')
<div class="features_items"><!--features_items-->
						<h2 class="title text-center">Sản phẩm</h2>
						@foreach ($product as $pro)
						<a href="{{URL::to('chi-tiet-san-pham/'.$pro->product_id)}}">
							<div class="col-sm-4">
							<div class="product-image-wrapper">
								<div class="single-products">
										<div class="productinfo text-center">
											<img style="width: 275px; height: 170px;" src="{{URL::to('public/product/'.$pro->product_image)}}" alt="" />
											<h2>{{number_format($pro->product_price).' VND'}}</h2>
											<p>{{($pro->product_name)}}</p>
											<a href="#" class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>Thêm vào giỏ hàng</a>
										</div>
										{{-- <div class="product-overlay">
											<div class="overlay-content">
												<h2>$56</h2>
												<p>Easy Polo Black Edition</p>
												<a href="#" class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>Thêm vào giỏ hàng</a>
											</div>
										</div> --}}
								</div>
								<div class="choose">
									<ul class="nav nav-pills nav-justified">
										<li><a href="#"><i class="fa fa-plus-square"></i>Thêm yêu thích</a></li>
										<li><a href="#"><i class="fa fa-plus-square"></i>Thêm so sánh</a></li>
									</ul>
								</div>
							</div>
							</div>
						</a>
						@endforeach
					</div><!--features_items-->
					
					
@endsection