<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
	<meta name="description" content="{{ $description or Config('app.description') }}">
	<meta name="keywords" content="{{ $keywords or Config('app.keywords') }}">
    <meta name="author" content="{{ $author or Config('app.author') }}">

    <title>{{ $title or Config('app.title') }} </title>

    <!-- icon -->
    <link rel="shortcut icon" href="/images/logo/high go.ico" type="image/vnd.microsoft.icon">

	<!-- css -->
	@if (isset($css) && is_array($css))
	@foreach ($css as $css)
	<link rel="stylesheet" href="/css/{{ $css }}" type="text/css">
	@endforeach
	@endif

	<!-- js -->
	@if (isset($js) && is_array($js))
	@foreach ($js as $js)
	<script src="/js/{{ $js }}"></script>
	@endforeach
	@endif

    <!-- Bootstrap Core CSS -->
    <link rel="stylesheet" href="/css/bootstrap.min.css"  type="text/css">
    <link rel="stylesheet" href="/css/font.css" type="text/css" >

    <!-- Custom CSS -->
    <link rel="stylesheet" href="/css/style.css">

    <!-- Owl Carousel Assets -->
    <link href="/owl-carousel/owl.carousel.css" rel="stylesheet">
    <link href="/owl-carousel/owl.theme.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link rel="stylesheet" href="/font-awesome-4.4.0/css/font-awesome.min.css"  type="text/css">

    <!-- jQuery -->
    <script src="/js/jquery-2.1.1.js"></script>

    <!-- Core JavaScript Files -->
    <script src="/js/bootstrap.min.js"></script>

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="/js/html5shiv.js"></script>
        <script src="/js/respond.min.js"></script>
    <![endif]-->
</head>

<body>
<header>
    <!--Top-->
    <nav id="top">
        <div class="container">
            <div class="row">
                <div class="col-md-6 col-sm-6">
                    <div class="logo" style="">
                        <a href="{{ route('index') }}">
                            <img  src="/images/logo/high go music log.png"  alt="highgo music logo" title="highgo music" >
                        </a>
                    </div>
                </div>
                @if (!isset($noViewLogin))
                <div class="col-md-6 col-sm-6">
                    <ul class="list-inline top-link link">
                    @if (isset($user_name))
                        <li><a href="{{ route('userInfo') }}"><i class="fa "></i>{{ $user_name }}</a></li>
                    @else
                        <li><a href="{{ route('signIn') }}"><i class="fa "></i>Sign in</a></li>
                        <li><a href="{{ route('signUp') }}"><i class="fa "></i> Sign up</a></li>
                    @endif
                    </ul>
                </div>
                @endif
            </div>
        </div>
    </nav>

    <!--Navigation-->
    <nav id="menu" class="navbar">
        <div class="container">
            <div class="navbar-header"><span id="heading" class="visible-xs">Categories</span>
              <button type="button" class="btn btn-navbar navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse"><i class="fa fa-bars"></i></button>
            </div>
            <div class="collapse navbar-collapse navbar-ex1-collapse">
                <ul class="nav navbar-nav">
                    <li><a href="{{ route('index') }}"><i class="fa fa-home"></i> Home</a></li>
                    <li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i> Account</a>
                        <div class="dropdown-menu">
                            <div class="dropdown-inner">
                                <ul class="list-unstyled">
                                    <li><a href="{{ route('signIn') }}">Login</a></li>
                                    <li><a href="{{ route('signUp') }}">Register</a></li>
                                </ul>
                            </div>
                        </div>
                    </li>
                    <li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-play-circle-o"></i> Video</a>
                        <div class="dropdown-menu">
                            <div class="dropdown-inner">
                                <ul class="list-unstyled">
                                    <li><a href="archive.html">Text 201</a></li>
                                    <li><a href="archive.html">Text 202</a></li>
                                    <li><a href="archive.html">Text 203</a></li>
                                    <li><a href="archive.html">Text 204</a></li>
                                    <li><a href="archive.html">Text 205</a></li>
                                </ul>
                            </div>
                        </div>
                    </li>
                    <li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-list"></i> Category</a>
                        <div class="dropdown-menu" style="margin-left: -203.625px;">
                            <div class="dropdown-inner">
                                <ul class="list-unstyled">
                                    <li><a href="archive.html">Text 301</a></li>
                                    <li><a href="archive.html">Text 302</a></li>
                                    <li><a href="archive.html">Text 303</a></li>
                                    <li><a href="archive.html">Text 304</a></li>
                                    <li><a href="archive.html">Text 305</a></li>
                                </ul>
                                <ul class="list-unstyled">
                                    <li><a href="archive.html">Text 306</a></li>
                                    <li><a href="archive.html">Text 307</a></li>
                                    <li><a href="archive.html">Text 308</a></li>
                                    <li><a href="archive.html">Text 309</a></li>
                                    <li><a href="archive.html">Text 310</a></li>
                                </ul>
                                <ul class="list-unstyled">
                                    <li><a href="archive.html">Text 311</a></li>
                                    <li><a href="archive.html">Text 312</a></li>
                                    <li><a href="archive.html#">Text 313</a></li>
                                    <li><a href="archive.html#">Text 314</a></li>
                                    <li><a href="archive.html">Text 315</a></li>
                                </ul>
                            </div>
                        </div>
                    </li>
                    <li><a href="archive.html"><i class="fa fa-cubes"></i> Blocks</a></li>
                    <li><a href="contact.html"><i class="fa fa-envelope"></i> Contact</a></li>
                </ul>
            </div>
        </div>
    </nav>
    @if ($slide !== false)
        @include('index_slide')
    @endif
</header>
<!-- Header -->
