@section('header')
<!DOCTYPE html>
<html>
<head lang="{{ config('app.locale') }}">
<title>{{ $htmlTitle }}</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="keywords" content="@yield('keywords', 'Majestic Responsive web
template, Bootstrap Web Templates, Flat Web Templates, Andriod Compatible web template,
Smartphone Compatible web template, free webdesigns for Nokia, Samsung, LG, SonyErricsson,
 Motorola web design')" />
 <!-- icon -->
 <link rel="shortcut icon" href="/image/logo/favicon.ico" type="image/x-icon">
<script type="application/x-javascript">
addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false);
function hideURLbar(){ window.scrollTo(0,1); }
</script>
<link href="/css/index/bootstrap.css" rel='stylesheet' type='text/css' />
<link href="/css/index/style.css" rel='stylesheet' type='text/css' />
<!-- <link href='http://fonts.useso.com/css?family=Titillium+Web:400,200,200italic,300,300italic,400italic,600,600italic,700,700italic,900' rel='stylesheet' type='text/css'> -->
<script src="/js/jquery.js"></script>
<!-- start-smoth-scrolling-->
<script type="text/javascript" src="/js/index/move-top.js"></script>
<script type="text/javascript" src="/js/index/easing.js"></script>
@section('header_js')
<script type="text/javascript">
			jQuery(document).ready(function($) {
				$(".scroll").click(function(event){
					event.preventDefault();
					$('html,body').animate({scrollTop:$(this.hash).offset().top},1000);
				});
			});
</script>
@show
<!-- start-smoth-scrolling-->
</head>
<body>
	<!--start-header-->
	<div class="header" id="home">
		<div class="container">
			<div class="logo">
        <a href="{{ route('home') }}">
          <img src="/image/logo/remember life log.png" alt="rememberlife log" title="rememberlife" alt="" height="80px">
        </a>
			</div>
			@section('menu')
			<div class="navigation">
			 <span class="menu"></span>
				<ul class="navig">
					<li><a class="{{ (Route::currentRouteName()=='home') ? 'active' : '' }}"
                        href="{{ route('home') }}">Home</a><span> </span></li>
					<li><a class="{{ (Route::currentRouteName()=='about') ? 'active' : '' }}"
                        href="{{ route('about') }}">About</a><span> </span></li>
					<li><a class="{{ (Route::currentRouteName()=='blog') ? 'active' : '' }}"
                        href="{{ route('blog') }}">Blog</a><span> </span></li>
					<li><a class="{{ (Route::currentRouteName()=='pages') ? 'active' : '' }}"
                        href="{{ route('pages') }}">Pages</a><span> </span></li>
					<li><a class="{{ (Route::currentRouteName()=='gallery') ? 'active' : '' }}"
                        href="{{ route('gallery') }}">Gallery</a><span> </span></li>
					<li><a class="{{ (Route::currentRouteName()=='contact') ? 'active' : '' }}"
                        href="{{ route('contact') }}">Contact</a><span> </span></li>
                    @if(Session::has('user_id'))
                    <li><a class="{{ (Route::currentRouteName()=='login') ?'active' : '' }}"
                        href="{{ route('account') }}">{{ Session::get('user_name') }}</a></li>
                    <li><a class="{{ (Route::currentRouteName()=='logout') ?'active' : '' }}"
                        href="{{ route('logout') }}">退出</a></li>
                    @else
                    <li><a class="{{ (Route::currentRouteName()=='login') ? 'active' : '' }}"
                        href="{{ route('login') }}">login</a></li>
                    <li><a class="{{ (Route::currentRouteName()=='signin') ? 'active' : '' }}"
                        href="{{ route('signin') }}">signin</a></li>
                    @endif

				</ul>
			</div>
				 <!-- script-for-menu -->
		 <script>
				$("span.menu").click(function(){
					$(" ul.navig").slideToggle("slow" , function(){
					});
				});
		 </script>
		 @show
		 <!-- script-for-menu -->
		</div>
	</div>
	<!--end-header-->
@show
