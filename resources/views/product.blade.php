@extends('layout.main')

@section('content')
<section class="banner-area organic-breadcrumb">
	<div class="container">
		<div class="breadcrumb-banner d-flex flex-wrap align-items-center justify-content-end">
			<div class="col-first">
				<h1>Product Details Page</h1>
				<nav class="d-flex align-items-center">
					<a href="/"><span class="lnr lnr-arrow-right"></span> Home</a>
					<a href="/products"><span class="lnr lnr-arrow-right"></span> Products</a>
				</nav>
			</div>
		</div>
	</div>
</section>
	<div class="product_image_area">
		<div class="container">
			<div class="row s_product_inner">
				<div class="col-lg-6">
					<div class="single-product">
						<img class="img-fluid" src="{{ asset('storage/'. $product->image) }}" alt="">
					</div>
				</div>
				<div class="col-lg-5 offset-lg-1">
					<div class="s_product_text">
						<h3>{{ $product->name }}</h3>
						<h2>RP. {{ number_format($product->price, 0, ',', '.') }}</h2>
						<ul class="list">
							<li><a class="active"><span>Category</span> : {{ $product->category->name }}</a></li>
							<li><a ><span>Availibility</span> : 
                                @if ($product->qty > 0)
                                	{{ $product->qty }} In Stock
                                @else
                                	{{ $product->qty }} Out of stock 
                                @endif</a>
                            </li>
						</ul>	
						<p>{{ $product->short_desc }}</p>
						<form action="/add_cart/{{ $product->slug }}" method="POST">
							@csrf
							<div class="input-group-icon my-3">
								<div class="icon"></div>
								<div class="form-select bg-light" id="default-select">
									<select name="color">
										@php
											$colors = json_decode($product->color)
										@endphp
										@foreach ($colors as $color)
											@if(old('color') == $color)
												<option value="{{ $color }}" selected>{{ $color }}</option>
											@else
												<option value="{{ $color }}">{{ $color }}</option>
											@endif
										@endforeach
									</select>
								</div>
							</div>
							<div class="input-group-icon my-3">
								<div class="icon"></div>
								<div class="form-select bg-light" id="default-select">
									<select name="size">
										@php
											$sizes = json_decode($product->size)
										@endphp
										@foreach ($sizes as $size)
											@if(old('size') == $size)
												<option value="{{ $size }}" selected>{{ $size }}</option>
											@else
												<option value="{{ $size }}">{{ $size }}</option>
											@endif
										@endforeach
									</select>
								</div>
							</div>
							<div class="product_count mt-3">
								<label for="qty">Quantity:</label>
								<input type="text" name="qty" id="sst"  maxlength="12" value="1" title="Quantity:" class="input-text qty">
								<button onclick="var result = document.getElementById('sst'); var sst = result.value; if( !isNaN( sst )) result.value++;return false;"
								 class="increase items-count" type="button"><i class="lnr lnr-chevron-up"></i></button>
								<button onclick="var result = document.getElementById('sst'); var sst = result.value; if( !isNaN( sst ) &amp;&amp; sst > 1 ) result.value--;return false;"
								 class="reduced items-count" type="button"><i class="lnr lnr-chevron-down"></i></button>
							</div>
							<div class="card_area d-flex align-items-center">
								@if ($product->qty > 0)
									<button type="submit" class="primary-btn border-0">Add to Cart</button>
								@else
									<button type="button" disabled class="genric-btn disable e-large border-0">Not Available</button>
								@endif
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
	<section class="product_description_area">
		<div class="container">
			<ul class="nav nav-tabs" id="myTab" role="tablist">
				<li class="nav-item">
					<a class="nav-link" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Description</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" id="contact-tab" data-toggle="tab" href="#contact" role="tab" aria-controls="contact"
					 aria-selected="false">Comments</a>
				</li>
				<li class="nav-item">
					<a class="nav-link active" id="review-tab" data-toggle="tab" href="#review" role="tab" aria-controls="review"
					 aria-selected="false">Reviews</a>
				</li>
			</ul>
			<div class="tab-content mt-5 mx-3" id="myTabContent">
				<div class="tab-pane fade" id="home" role="tabpanel" aria-labelledby="home-tab">
					<p>{{ $product->desc }}</p>
				</div>
				<div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">
					<div class="row">
						<div class="col-lg-6">
							@if ($productComments->count())
							@foreach ($productComments as $productComment)
								<div class="comment_list">
									<div class="comment_item">
										<div class="media">
											<div class="media-body">
												<h6>{{ $productComment->name }}</h6>
												<a>{{ $productComment->created_at->format('F j, Y \a\t g:i a') }}</a>
											</div>
										</div>
										<p>{{ $productComment->message }}</p>
									</div>
								</div>
								@endforeach

								<div class="text-center mt-5">
									<button id="loadMore" class="primary-btn border-0">Load More</button>
								</div>
							@else
								<h4 class="d-flex justify-content-center align-items-center my-5">There are no comments for now</h4>
							@endif
						</div>
						<div class="col-lg-6">
								<div class="review_box">
									<h4>Post a comment</h4>
									<form class="row contact_form" action="/addProductComment" method="post" id="contactForm">
										@csrf
										<div class="col-md-12">
											<div class="form-group">
												<input type="hidden" name="product_id" value="{{ $product->id}}">
												<textarea class="form-control @error('message') is-invalid @enderror" name="message" required id="message" rows="1" placeholder="Message"></textarea>
												@error('message')
													<div class="invalid-feedback">  
													{{ $message }}
													</div>
												@enderror
											</div>
										</div>
										<div class="col-md-12 text-right">
											<button type="submit" value="submit" class="btn primary-btn">Submit Now</button>
										</div>
									</form>
								</div>
						</div>
					</div>
				</div>
				<div class="tab-pane fade show active" id="review" role="tabpanel" aria-labelledby="review-tab">
					<div class="row">
						<div class="col-lg-6">
							<div class="row total_rate">
								<div class="col-6">
									<div class="box_total">
										<h5>Overall</h5>
										@php
											$sum = \App\Models\Review::where('product_id', $product->id)->sum('rating');
											$count = \App\Models\Review::where('product_id', $product->id)->count();
											$average = $count > 0 ? $sum / $count : 0;
										@endphp
										<h4>{{ $average }}</h4>
										<h6>({{ $reviews->count() }} Reviews)</h6>
									</div>
								</div>
								<div class="col-6">
									<div class="rating_list">
										<h3>Based on {{ $reviews->count() }} Reviews</h3>
										<ul class="list">
											@for ($i = 5; $i >= 1; $i--)
												@php
													$count = \App\Models\Review::where('product_id', $product->id)->where('rating', $i)->count();
												@endphp
												<li><a>{{ $i }} Star <i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i> {{ $count }}</a></li>
											@endfor
										</ul>
									</div>
								</div>
							</div>
						</div>
						<div class="col-lg-6 mt-3">
							@if ($reviews->count())
								<div class="review_list">
									@foreach ($reviews as $review)
										<div class="review_item">
											<div class="media">
												<div class="media-body">
													<h4>{{ $review->name }}</h4>
													@for ($i = 1; $i <= 5; $i++)
														@if ($i <= $review->rating)
															<i class="fa fa-star"></i>
														@else
															<i class="fa fa-star text-muted"></i>
														@endif
													@endfor
												</div>
											</div>
											<p>{{ $review->message }}</p>
										</div>
									@endforeach
								</div>

								<div class="text-center mt-5">
									<button id="loadMoreBtn" class="primary-btn border-0">Load More</button>
								</div>
							@else
								<h4 class="d-flex justify-content-center my-5">There are no reviews for now</h4>
							@endif
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>

	<script>
		$(function() {
			let reviewsPerPage = 3;
			let reviewItems = $("div.review_item");
			let totalReviews = reviewItems.length;
			let displayedReviews = reviewsPerPage;
	
			reviewItems.slice(reviewsPerPage).hide();
	
			if (totalReviews <= reviewsPerPage) {
				$("#loadMoreBtn").hide();
			}
	
			$("#loadMoreBtn").on('click', function(e) {
				e.preventDefault();
				reviewItems.slice(displayedReviews, displayedReviews + reviewsPerPage).slideDown();
				displayedReviews += reviewsPerPage;
	
				if (displayedReviews >= totalReviews) {
					$("#loadMoreBtn").hide();
				}
			});
		});

		$(function() {
			let commentsPerPage = 3;
			let commentItems = $("div.comment_item");
			let totalComments = commentItems.length;
			let displayedComments = commentsPerPage;
	
			commentItems.slice(commentsPerPage).hide();
	
			if (totalComments <= commentsPerPage) {
				$("#loadMore").hide();
			}
	
			$("#loadMore").on('click', function(e) {
				e.preventDefault();
				commentItems.slice(displayedComments, displayedComments + commentsPerPage).slideDown();
				displayedComments += commentsPerPage;
	
				if (displayedComments >= totalComments) {
					$("#loadMore").hide();
				}
			});
		});
	</script>
	
@endsection

