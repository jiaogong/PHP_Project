<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
		<title>{{ $htmlTitle }}</title>
		<link rel="stylesheet" href="/plugins/layui/css/layui.css" media="all" />
		<link rel="stylesheet" href="/css/admin/login.css" />
	</head>
	<body class="beg-login-bg">
		<div class="beg-login-box">
			<header>
				<h1>后台注册</h1>
			</header>
			<div class="beg-login-main">

				<form action="{{ route('admin_register') }}" class="layui-form" method="post">
					{{ csrf_field() }}
					<input type='hidden' name='method' value="{{ $method }}">
					<div class="layui-form-item">
						<label class="beg-login-icon">
						<i class="layui-icon">&#xe612;</i>
					</label>
						<input type="text" name="userName" lay-verify="userName" autocomplete="off" placeholder="这里输入登录名" class="layui-input userName">
					</div>
					<div class="layui-form-item">
						<label class="beg-login-icon">
						<i class="layui-icon">&#xe642;</i>
					</label>
						<input type="password" name="password" lay-verify="password" autocomplete="off" placeholder="这里输入密码" class="layui-input password">
					</div>
					<div class="layui-form-item">
						<label class="beg-login-icon">
						<i class="layui-icon">&#xe642;</i>
					</label>
						<input type="password" name="password2" lay-verify="password" autocomplete="off" placeholder="再次输入密码" class="layui-input password2">
					</div>
					<div class="layui-form-item">
						<div class="beg-pull-right">
							<button class="layui-btn layui-btn-primary" lay-submit lay-filter="register">
							<!-- <i class="layui-icon">&#xe630;</i> --> 注册
							</button>
						</div>
						<div class="beg-clear"></div>
					</div>
				</form>
			</div>
		</div>
		<script type="text/javascript" src="/plugins/layui/layui.js"></script>
		<script>
			layui.use(['layer', 'form'], function() {
				var layer = layui.layer,
					$ = layui.jquery,
					form = layui.form();

				form.on('submit(register)',function(data){
					userName = data.field.userName;
					password = data.field.password;
					password2 = data.field.password2;

					if (  userName && password && password2 ) {
						if (password !== password2 ) {
							alert('两次输入的密码不一致！');
							return false;
						} else {
							// location.href="{{ route('admin_register') }}";
							return true;
						}	
					} else if ( !userName ) {
						alert('请输入用户名！');
						return false;
					} else if ( !password ) {
						alert('请输入密码！');
						return false;
					} else if ( !password2 ) {
						alert('请再次输入密码！');
						return false;
					} else {
						alert('没有数据！');
						return false;
					}
				});
			});
		</script>
	</body>

</html>
