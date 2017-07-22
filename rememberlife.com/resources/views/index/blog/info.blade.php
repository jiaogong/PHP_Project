@include('index.template.header')
	@section('content')
	<div class="blog">
		<div class="container">
			<div class="blog-head heading">

			</div>
			<div class="blog-top">
				<div class="col-md-9 blog-left">
					<div class="blog-main">
						<a href="{{ (Route::currentRouteName()) }}" class="bg">DUIS AUTE IRURE DOLOR IN REPREHENDERIT IN VOLUPTATE VELIT ESSE</a>
						<p>Post by <a href="#">Admin</a> on saturday, March 02, 2015  <a href="#">5 comments</a></p>
					</div>
					<div class="blog-main-one">
						<div class="blog-one">
							<img src="/image/index/bg-1.jpg" alt="" />
							<p>Aenean vitae risus tempor, suscipit turpis elementum, lacinia justo. Aenean tortor orci, tristique sed libero vel, vulputate elementum lectus. Aliquam dapibus nisi et gravida accumsan. Nam aliquam blandit dapibus. Aliquam bibendum vestibulum neque, eu dapibus nunc congue vitae. Praesent mollis dolor eget elementum auctor.Nunc quis turpis sed tortor viverra dictum. Etiam in cursus libero, ut cursus turpis. Nulla quis nulla pellentesque, commodo lorem sed, ultrices leo. Duis magna mauris, cursus vitae lacus ut, consequat malesuada magna. Duis bibendum pellentesque nisi eget volutpat. Nunc rhoncus ultrices lectus.Aliquam eu dui quis orci ultrices eleifend ut non massa. Duis commodo, ante in vulputate iaculis, libero ex fringilla dolor, id laoreet augue lorem in velit.</p>
						</div>
						<div class="blog-comments">
							<ul>
								<li><a href="#">Uncategorized</a></li>
								<li><p>2017年3月25日</p></li>
								<li><a href="#">Admin</a></li>
							</ul>
							<div class="clearfix"></div>
						</div>
					</div>
					<div class="comments">
						<div class="comments-top heading">
							<h3>COMMENTS</h3>
						</div>
						<div class="comments-bottom">
							<div class="media">
								<div class="media-left">
									<a href="#">
									<img class="media-object" src="/image/index/co.png" alt="" />
									</a>
								</div>
								<div class="media-body">
									<h4 class="media-heading">Fusce scelerisque</h4>
									<p>Phasellus ut ex eu quam interdum ultrices ac congue nunc. Donec ultricies volutpat purus at rutrum. Suspendisse malesuada ligula eu elit aliquet porttitor. Integer ac magna eget lacus venenatis sagittis id vitae massa.</p>
									<div class="media">
										<div class="media-left">
											<a href="#">
											<img class="media-object" src="/image/index/co.png" alt="" />
											</a>
										</div>
										<div class="media-body">
											<h4 class="media-heading">Curabitur vitae libero</h4>
											<p>Phasellus ut ex eu quam interdum ultrices ac congue nunc. Donec ultricies volutpat purus at rutrum. Suspendisse malesuada ligula eu elit aliquet porttitor. Integer ac magna eget lacus venenatis sagittis id vitae massa.</p>
										</div>
									</div>
								</div>
								<div class="media">
									<div class="media-left">
										<a href="#">
										<img class="media-object" src="/image/index/co.png" alt="">
										</a>
									</div>
									<div class="media-body">
										<h4 class="media-heading"><a href="#">Melinda Dee</a></h4>
										<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
										Duis aute irure dolor in reprehenderit .</p>
									</div>
									</div>
								</div>
					</div>
				</div>
				<div class="related heading">
							<h3>RELATED POSTS</h3>
							<div class="related-bottom">
								<div class="col-md-3 related-left">
									<img src="/image/index/r-1.jpg" alt="" />
									<h4>Cum sociis sere</h4>
								</div>
								<div class="col-md-3 related-left">
									<img src="/image/index/r-2.jpg" alt="" />
									<h4>Vestibulum est ex</h4>
								</div>
								<div class="col-md-3 related-left">
									<img src="/image/index/r-3.jpg" alt="" />
									<h4>Ut tincidunt</h4>
								</div>
								<div class="col-md-3 related-left">
									<img src="/image/index/r-4.jpg" alt="" />
									<h4> Aliquam eu quam</h4>
								</div>
								<div class="clearfix"></div>
							</div>
						</div>
						<div class="reply heading">
					 		<h3>LEAVE A COMMENT</h3>
					 		<div class="contact-form">
								<form>
									<input type="text" placeholder="Name" required/>
									<input type="text" placeholder="Email" required/>
									<input type="text" placeholder="Phone" required/>
									<textarea placeholder="Message"></textarea>
									<input type="submit" value="POST"/>
				   				</form>
				   			</div>
						</div>
				</div>
				<div class="col-md-3 blog-right">
					<div class="categories">
						<h3>CATEGORIES</h3>
						<ul>
							<li><a href="#">Aenean tortor orci</a></li>
							<li><a href="#">Duis bibendum pellentesquev</a></li>
							<li><a href="#">Quisque pharetra semper</a></li>
							<li><a href="#">Cras condimentum risus</a></li>
							<li><a href="#"> Quisque id erat sapien</a></li>
						</ul>
					</div>
					<div class="categories">
						<h3>RECENT POSTS</h3>
						<ul>
							<li><a href="#">Fusce id volutpat est</a></li>
							<li><a href="#">Phasellus condimentum odio</a></li>
							<li><a href="#">Donec interdum eros elit</a></li>
							<li><a href="#">Cras condimentum risus</a></li>
							<li><a href="#">Proin sodales diam ac </a></li>
						</ul>
					</div>
					<div class="categories">
						<h3>ARCHIVES</h3>
						<ul>
							<li><a href="#">March 3014</a></li>
							<li><a href="#">May 2014</a></li>
							<li><a href="#">August 2014</a></li>
							<li><a href="#">October 2014</a></li>
						</ul>
					</div>
				</div>
				<div class="clearfix"></div>
			</div>
		</div>
	</div>
	<!--blog-->
	@show
@include('index.template.footer')
