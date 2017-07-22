@include('index.template.header')
	@section('content')
	<!--light-box-files -->
		<script src="/js/index/jquery.chocolat.js"></script>
		<link rel="stylesheet" href="/css/index/chocolat.css" type="text/css" media="screen" charset="utf-8" />
		<!--light-box-files -->
		<script type="text/javascript" charset="utf-8">
		$(function() {
			$('.gallery-bottom a').Chocolat();
		});
		</script>
	<!--gallery-starts-->
	<div class="gallery">
		<div class="container">
			<div class="gallery-top heading">
				<h1>OUR GALLERY</h1>
			</div>
			<div class="gallery-bottom">
				<div class="gallery-1">
					<div class="col-md-3 gallery-left">
						<a href="/image/index/port-1.jpg">
							<img class="lazyOwl" src="/image/index/port-1.jpg" alt="name" />
						</a>
					</div>
					<div class="col-md-3 gallery-left">
						<a href="/image/index/port-2.jpg">
							<img class="lazyOwl" src="/image/index/port-2.jpg" alt="name" />
						</a>
					</div>
					<div class="col-md-3 gallery-left">
						<a href="/image/index/port-5.jpg">
							<img class="lazyOwl" src="/image/index/port-5.jpg" alt="name" />
						</a>
					</div>
					<div class="col-md-3 gallery-left">
						<a href="/image/index/port-6.jpg">
							<img class="lazyOwl" src="/image/index/port-6.jpg" alt="name" />
						</a>
					</div>
					<div class="clearfix"></div>
				</div>
				<div class="gallery-1">
					<div class="col-md-3 gallery-left">
						<a href="/image/index/port-3.jpg">
							<img class="lazyOwl" src="/image/index/port-3.jpg" alt="name" />
						</a>
					</div>
					<div class="col-md-3 gallery-left">
						<a href="/image/index/port-4.jpg">
							<img class="lazyOwl" src="/image/index/port-4.jpg" alt="name" />
						</a>
					</div>
					<div class="col-md-3 gallery-left">
						<a href="/image/index/port-9.jpg">
							<img class="lazyOwl" src="/image/index/port-9.jpg" alt="name" />
						</a>
					</div>
					<div class="col-md-3 gallery-left">
						<a href="/image/index/port-10.jpg">
							<img class="lazyOwl" src="/image/index/port-10.jpg" alt="name" />
						</a>
					</div>
					<div class="clearfix"></div>
				</div>
				<div class="gallery-1">
					<div class="col-md-3 gallery-left">
						<a href="/image/index/port-11.jpg">
							<img class="lazyOwl" src="/image/index/port-11.jpg" alt="name" />
						</a>
					</div>
					<div class="col-md-3 gallery-left">
						<a href="/image/index/port-12.jpg">
							<img class="lazyOwl" src="/image/index/port-12.jpg" alt="name" />
						</a>
					</div>
					<div class="col-md-3 gallery-left">
						<a href="/image/index/port-7.jpg">
							<img class="lazyOwl" src="/image/index/port-7.jpg" alt="name" />
						</a>
					</div>
					<div class="col-md-3 gallery-left">
						<a href="/image/index/port-8.jpg">
							<img class="lazyOwl" src="/image/index/port-8.jpg" alt="name" />
						</a>
					</div>
					<div class="clearfix"></div>
				</div>
			</div>
		</div>
	</div>
	<!----gallery-end---->
	@show
@include('index.template.footer')
