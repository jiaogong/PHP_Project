@include('index.template.header')
	@section('content')
	<!--banner-starts-->
	<div class="banner" id="home">
		<div class="container">
			<section class="slider">
				<div class="flexslider">
					<ul class="slides">
						@if(count($rsmInfo) > 0)
						@foreach($rsmInfo as $rsm)
						<li>
							<div class="banner-top">
								<div class="col-md-6 banner-left">
									<div class="bnr-one">
										<img src="{{ $rsm['image_path1'] }}" alt="" />
										<h3>{{ $rsm['title1'] }}</h3>
										<a href="{{ $rsm['url1'] }}">Read More</a>
									</div>
								</div>
								@if(!empty($rsm['title2']))
								<div class="col-md-6 banner-left">
									<div class="bnr-one">
										<img src="{{ $rsm['image_path2'] }}" alt="" />
										<h3>{{ $rsm['title2'] }}</h3>
										<a href="{{ $rsm['url2'] }}">Read More</a>
									</div>
								</div>
								@endif
								<div class="clearfix"></div>
							</div>
						</li>
						@endforeach
						@endif
				  	</ul>
				</div>
			</section>
		</div>
	</div>
	<!--banner-ends-->
	<!--FlexSlider-->
	<link rel="stylesheet" href="/css/index/flexslider.css" type="text/css" media="screen" />
	<script defer src="/js/index/jquery.flexslider.js"></script>
	<script type="text/javascript">
	$(function(){
	  //SyntaxHighlighter.all();
	});
	$(window).on('load', function(){
	  $('.flexslider').flexslider({
		animation: "slide",
		start: function(slider){
		  $('body').removeClass('loading');
		}
	  });
	});
  </script>
</div>
			<!--End-slider-script-->
	<!--welcome-starts-->
	<div class="welcome">
		<div class="container">
			<div class="welcome-top">
				<h1>欢迎来到rememberlife TO OUR SITE</h1>
				<p> 你好中国人民共和国Maecenas ornare lobortis mi id dapibus. Sed magna leo, malesuada in luctus ut, convallis nec sapien. Nulla rhoncus, nunc sollicitudin sodales elementum, augue nunc congue tellus, a varius urna odio vitae mauris. Aenean ultricies porttitor dui quis laoreet.</p>
			</div>
			<div class="welcome-bottom">
				<div class="col-md-6 welcome-left">
					<h3>Aenean ultricies porttitor</h3>
					<p>Integer tincidunt ligula id lacinia placerat. Etiam rutrum fermentum tortor. Nunc tempor dui nec tincidunt eleifend. Phasellus lacinia gravida mollis. Curabitur laoreet ligula tempus, elementum dui quis, malesuada velit. Nullam cursus a magna vitae vestibulum.</p>
					<div class="welcome-one">
						<div class="col-md-6 welcome-one-left">
							<a href="single.html"><img src="/image/index/w-6.jpg" alt="" /></a>
						</div>
						<div class="col-md-6 welcome-one-right">
							<a href="single.html"><img src="/image/index/w-4.jpg" alt="" /></a>
							<a href="single.html" class="one-top"><img src="/image/index/w-5.jpg" alt="" /></a>
						</div>
						<div class="clearfix"></div>
					</div>
				</div>
				<div class="col-md-6 welcome-left">
					<h3>Nullam mattis nibh dolor</h3>
					<p>Integer tincidunt ligula id lacinia placerat. Etiam rutrum fermentum tortor. Nunc tempor dui nec tincidunt eleifend. Phasellus lacinia gravida mollis. Curabitur laoreet ligula tempus, elementum dui quis, malesuada velit. Nullam cursus a magna vitae vestibulum.</p>
					<div class="welcome-one">
						<a href="single.html"><img src="/image/index/w-2.jpg" alt="" /></a>
					</div>
				</div>
				<div class="clearfix"></div>
			</div>
		</div>
	</div>
	<!--welcome-ends-->
	<!--offer-starts-->
	<div class="offer">
		<div class="container">
			<div class="offer-top heading">
				<h2>OUR BEST OFFERS</h2>
			</div>
			<div class="offer-bottom">
				<div class="col-md-3 offer-left">
					<a href="single.html"><img src="/image/index/o-1.jpg" alt="" />
					<h6>$29</h6></a>
					<h4><a href="single.html">Quisque sed neque</a></h4>
					<p>Maecenas interdum augue eget elit interdum, vitae elementum diam molestie. Nulla facilisi.</p>
					<div class="o-btn">
						<a href="single.html">Read More</a>
					</div>
				</div>
				<div class="col-md-3 offer-left">
					<a href="single.html"><img src="/image/index/o-2.jpg" alt="" />
					<h6>$70</h6></a>
					<h4><a href="single.html">Donec mattis nunc</a></h4>
					<p>Maecenas interdum augue eget elit interdum, vitae elementum diam molestie. Nulla facilisi.</p>
					<div class="o-btn">
						<a href="single.html">Read More</a>
					</div>
				</div>
				<div class="col-md-3 offer-left">
					<a href="single.html"><img src="/image/index/o-3.jpg" alt="" />
					<h6>$46</h6></a>
					<h4><a href="single.html">Maecenas non risus</a></h4>
					<p>Maecenas interdum augue eget elit interdum, vitae elementum diam molestie. Nulla facilisi.</p>
					<div class="o-btn">
						<a href="single.html">Read More</a>
					</div>
				</div>
				<div class="col-md-3 offer-left">
					<a href="single.html"><img src="/image/index/o-5.jpg" alt="" />
					<h6>$80</h6></a>
					<h4><a href="single.html">Nullam vitae nisl</a></h4>
					<p>Maecenas interdum augue eget elit interdum, vitae elementum diam molestie. Nulla facilisi.</p>
					<div class="o-btn">
						<a href="single.html">Read More</a>
					</div>
				</div>
				<div class="clearfix"></div>
			</div>
		</div>
	</div>
	<!--offer-ends-->
	<!--nature-starts-->
	<div class="nature">
		<div class="container">
			<div class="nature-top">
				<h3>Maecenas ornare lobortis</h3>
				<p>Phasellus tempor erat id erat gravida pulvinar. Aenean est felis, ullamcorper et volutpat sed, cursus at enim. Vestibulum vel finibus neque. In sed magna tellus.</p>
			</div>
		</div>
	</div>
	<!--nature-ends-->
	<!--field-starts-->
	<div class="fields">
		<div class="container">
			<div class="fields-top">
				<div class="col-md-4 fields-left">
					<span class="home"></span>
					<h4>Vestibulum vel finibus</h4>
					<p>Pellentesque sed sem bibendum, rutrum ipsum vitae, facilisis turpis. Mauris vitae metus gravida, hendrerit erat ac, facilisis ligula.</p>
				</div>
				<div class="col-md-4 fields-left">
					<span class="men"></span>
					<h4>Quisque non ligula</h4>
					<p>Pellentesque sed sem bibendum, rutrum ipsum vitae, facilisis turpis. Mauris vitae metus gravida, hendrerit erat ac, facilisis ligula.</p>
				</div>
				<div class="col-md-4 fields-left">
					<span class="pen"></span>
					<h4>Lorem ipsum dolor</h4>
					<p>Pellentesque sed sem bibendum, rutrum ipsum vitae, facilisis turpis. Mauris vitae metus gravida, hendrerit erat ac, facilisis ligula.</p>
				</div>
				<div class="clearfix"></div>
			</div>
		</div>
	</div>
	<!--field-end-->
	@show
@include('index.template.footer')
