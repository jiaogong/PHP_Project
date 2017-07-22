<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
	<head>
		<meta charset="utf-8">
		<title>后台管理模板</title>
		<meta name="renderer" content="webkit">
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
		<meta name="apple-mobile-web-app-status-bar-style" content="black">
		<meta name="apple-mobile-web-app-capable" content="yes">
		<meta name="format-detection" content="telephone=no">

		<link rel="stylesheet" href="/plugins/layui/css/layui.css" media="all" />
		<link rel="stylesheet" href="/css/admin/global.css" media="all">
		<link rel="stylesheet" href="/plugins/font-awesome/css/font-awesome.min.css">
		<script charset="utf-8" src="/js/admin/navbar.js"></script>

	</head>

	<body>
		<div class="layui-layout layui-layout-admin">
			<div class="layui-header header header-demo">
				<div class="layui-main">
					<div class="admin-login-box">
						<a class="logo" style="left: 0;" href="{{ route('admin_login') }}">
							<span style="font-size: 22px;">后台管理系统</span>
						</a>
						<div class="admin-side-toggle">
							<i class="fa fa-bars" aria-hidden="true"></i>
						</div>
					</div>
					<ul class="layui-nav admin-header-item">
						<li class="layui-nav-item">
							<a href="{{ route('home') }}" target="_blank">前台网站</a>
						</li>
						<li class="layui-nav-item" id="video1">
							<a href="javascript:;">视频</a>
						</li>
						<li class="layui-nav-item">
							<a href="javascript:;" class="admin-header-user">
								<img src="/image/admin/0.jpg" />
								<span>{{ session('admin_user_name') }}</span>
							</a>
							<dl class="layui-nav-child">
								<dd>
									<a href="javascript:;"><i class="fa fa-user-circle" aria-hidden="true"></i> 个人信息</a>
								</dd>
								<dd>
									<a href="javascript:;"><i class="fa fa-gear" aria-hidden="true"></i> 设置</a>
								</dd>
								<dd id="lock">
									<a href="javascript:;">
										<i class="fa fa-lock" aria-hidden="true" style="padding-right: 3px;padding-left: 1px;"></i> 锁屏
									</a>
								</dd>
								<dd>
									<a href="{{ route('admin_logout') }}"><i class="fa fa-sign-out" aria-hidden="true"></i> 注销</a>
								</dd>
							</dl>
						</li>
					</ul>
<!-- 					<ul class="layui-nav admin-header-item-mobile">
						<li class="layui-nav-item">
							<a href="{{ route('admin_logout') }}"><i class="fa fa-sign-out" aria-hidden="true"></i> 注销</a>
						</li>
					</ul> -->
				</div>
			</div>
			<div class="layui-side layui-bg-black" id="admin-side">
				<div class="layui-side-scroll" id="admin-navbar-side" lay-filter="side"></div>
			</div>
			<div class="layui-body" style="bottom: 0;border-left: solid 2px #1AA094;" id="admin-body">
				<div class="layui-tab admin-nav-card layui-tab-brief" lay-filter="admin-tab">
					<ul class="layui-tab-title">
						 <li class="layui-this">
							<i class="fa fa-dashboard" aria-hidden="true"></i>
							<cite>控制面板</cite>
						</li> 
					</ul>
					<div class="layui-tab-content" style="min-height: 150px; padding: 5px 0 0 0;">
						<div class="layui-tab-item layui-show">
							<iframe src="{{ route('admin_homeShow_add') }}"></iframe>
						</div>
					</div>
				</div>
			</div>
			<div class="layui-footer footer footer-demo" id="admin-footer">
				<div class="layui-main">
					<p>2017 &copy;
						<a href="/" target="_blank"></a> LGPL license
					</p>
				</div>
			</div>
			<div class="site-tree-mobile layui-hide">
				<i class="layui-icon">&#xe602;</i>
			</div>
			<div class="site-mobile-shade"></div>

			<!--锁屏模板 start-->
			<script type="text/template" id="lock-temp">
				<div class="admin-header-lock" id="lock-box">
					<div class="admin-header-lock-img">
						<img src="/image/admin/0.jpg"/>
					</div>
					<div class="admin-header-lock-name" id="lockUserName">beginner</div>
					<input type="text" class="admin-header-lock-input" value=" 请设置锁屏密码.." name="lockPwd" id="lockPwd" />
					<input type="text" class="admin-header-lock-input" value=" 请再次输入锁屏密码.." name="lockPwd2" id="lockPwd2" />
					<br><button class="layui-btn layui-btn-small admin-header-lock-but" id="unlock">设置</button>
					<!-- <input type="text" class="admin-header-lock-input" value="输入解锁密码.." name="lockPwd" id="lockPwd" />
					<input type="text" class="admin-header-lock-input" value="请再次输入解锁密码.." name="lockPwd" id="lockPwd" />
					<button class="layui-btn layui-btn-small" id="unlock">解锁</button> -->
				</div>
			</script>
			<!--锁屏模板 end -->

			<script type="text/javascript" src="/plugins/layui/layui.js"></script>
			<!-- <script type="text/javascript" src="/js/admin/nav.js"></script> -->
			<script src="/js/admin/index.js"></script>
			<script>
				layui.use('layer', function() {
					var $ = layui.jquery,
						layer = layui.layer;

					$('#video1').on('click', function() {
						layer.open({
							title: 'YouTube',
							maxmin: true,
							type: 2,
							content: 'video.html',
							area: ['800px', '500px']
						});
					});

				});
			</script>
			<script >
				// 左边导航配置
				var navs = [{
					"title": "基本元素",
					"icon": "fa-cubes",
					"spread": true,
					"children": [
						{
							"title": "前台首页图管理",
							"icon": "&#xe641;",
							"href": "{{ route('admin_homeShow_list') }}"
						},
						{
							"title": "前台",
							"icon": "&#xe63c;",
							"href": "form.html"
						},
						{
							"title": "表格",
							"icon": "&#xe63c;",
							"href": "table.html"
						},
						{
							"title": "导航",
							"icon": "&#xe609;",
							"href": "nav.html"
						},
						{
							"title": "Tab选项卡",
							"icon": "&#xe62a;",
							"href": "tab.html"
						},
						{
							"title": "辅助性元素",
							"icon": "&#xe60c;",
							"href": "auxiliar.html"
						}
					]
				}, {
					"title": "商品管理",
					"icon": "fa-cogs",
					"spread": false,
					"children": [
						{
							"title": "Datatable",
							"icon": "fa-table",
							"href": "begtable.html"
						},
						{
							"title": "Navbar组件",
							"icon": "fa-navicon",
							"href": "navbar.html"
						},
						{
							"title": "Laytpl+Laypage",
							"icon": "&#xe628;",
							"href": "paging.html"
						}
					]
				}, {
					"title": "blog管理",
					"icon": "fa-cogs",
					"spread": false,
					"children": [
						{
							"title": "blog管理",
							"icon": "fa-table",
							"href": "{{ route('admin_blog_list') }}"
						},
						{
							"title": "blog类型管理",
							"icon": "fa-navicon",
							"href": "{{ route('admin_blog_type_list') }}"
						},
						{
							"title": "Laytpl+Laypage",
							"icon": "&#xe628;",
							"href": "paging.html"
						}
					]
				}, {
					"title": "第三方组件",
					"icon": "&#x1002;",
					"spread": false,
					"children": [
						{
							"title": "iCheck组件",
							"icon": "fa-check-square-o",
							"href": "icheck.html"
						}
					]
				}, {
					"title": "后台用户管理",
					"icon": "fa-address-book",
					"href": "",
					"spread": false,
					"children": [
						{
							"title": "用户增修删",
							"icon": "fa-github",
							"href": "{{ route('admin_user_list') }}/"
						},
						{
							"title": "QQ",
							"icon": "fa-qq",
							"href": "http://www.qq.com/"
						},
						{
							"title": "Fly社区",
							"icon": "&#xe609;",
							"href": "http://fly.layui.com/"
						},
						{
							"title": "新浪微博",
							"icon": "fa-weibo",
							"href": "http://weibo.com/"
						}
					]
				}, {
					"title": "这是一级导航",
					"icon": "fa-stop-circle",
					"href": "https://www.baidu.com",
					"spread": false
				}];
			</script>
		</div>
	</body>
</html>
