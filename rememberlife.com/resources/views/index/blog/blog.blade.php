@include('index.template.header')
	@section('content')
	<!--blog-->
	<div class="blog">
		<div class="container">
			<div class="blog-head heading">
				<h1>BLOG</h1>
			</div>
			<div class="blog-top">

				<div class="col-md-9 blog-left">
					<div class="blog-main">
						<a href="{{ url('blog/'.'1') }}" class="bg">DUIS AUTE IRURE DOLOR IN REPREHENDERIT IN VOLUPTATE VELIT ESSE</a>
						<p>Post by <a href="#">Admin</a> on saturday, March 02, 2015  <a href="#">5 comments</a></p>
					</div>
					<div class="blog-main-one">
						<div class="blog-one">
							<div class="col-md-5 blog-one-left">
								<a href="single.html"><img src="/image/index/blog-1.jpg" alt="" /></a>
							</div>
							<div class="col-md-7 blog-one-left">
								<p>Nunc quis turpis sed tortor viverra dictum. Etiam in cursus libero, ut cursus turpis. Nulla quis nulla pellentesque, commodo lorem sed, ultrices leo. Duis magna mauris, cursus vitae lacus ut, consequat malesuada magna. Duis bibendum pellentesque nisi eget volutpat.
									 Nunc rhoncus ultrices lectus.Aliquam eu dui quis orci ultrices eleifend ut non massa. Duis commodo, ante in vulputate iaculis, libero ex fringilla dolor, id laoreet augue lorem in velit.</p>
								<div class="b-btn">
									<a href="single.html">Read more</a>
								</div>
							</div>
							<div class="clearfix"></div>
						</div>
						<div class="blog-comments">
								<ul>
									<li><span class="glyphicon-bookmark" aria-hidden="true"></span><a href="#">Uncategorized</a></li>
									<li><span class="glyphicon-calendar" aria-hidden="true"></span><p>March 13,2014</p></li>
									<li><span class="glyphicon-user" aria-hidden="true"></span><a href="#">Admin</a></li>
								</ul>
								<div class="clearfix"></div>
						</div>
					</div>
				</div>
				<div class="clearfix"></div>
			</div>
			<div class="pagination">
				<nav>
					<ul class="pager">
						<li><a href="#">Previous</a></li>
						<li><a href="#">Next</a></li>
					</ul>
				</nav>
			</div>
		</div>
	</div>
	<!--blog-->
	@show
@include('index.template.footer')
