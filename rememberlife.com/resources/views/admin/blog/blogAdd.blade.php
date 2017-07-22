<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
	<head>
		<meta charset="UTF-8">
		<title>{{ $htmlTitle }}</title>
		<meta name="renderer" content="webkit">
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
		<meta name="apple-mobile-web-app-status-bar-style" content="black">
		<meta name="apple-mobile-web-app-capable" content="yes">
		<meta name="format-detection" content="telephone=no">

		<link rel="stylesheet" href="/plugins/layui/css/layui.css" media="all" />
		<link rel="stylesheet" href="/plugins/font-awesome/css/font-awesome.min.css">
	</head>

	<body>
		<div style="margin: 15px;">
			<!-- 面包屑导航 开始 -->
			<span class="layui-breadcrumb">
			  <a href="{{ route('admin_rsm_list') }}">6小图列表页</a>
			  <a><cite>添加</cite></a>
			</span>
			<!-- 面包屑导航 结束 -->
			<fieldset class="layui-elem-field layui-field-title" style="margin-top: 20px;">
				<legend>前台-轮播-6小图-添加</legend>
			</fieldset>

			<form class="layui-form" method="post" action="{{ route('admin_rsm_add_data') }}" enctype="multipart/form-data">
				{{ csrf_field() }}
				<div class="layui-form-item">
					<label class="layui-form-label">标题</label>
					<div class="layui-input-block">
						<input type="text" name="title" lay-verify="title" autocomplete="off" placeholder="请输入标题" class="layui-input">
					</div>
				</div>
				<div class="layui-form-item">
					<label class="layui-form-label">图片</label>
					<div class="layui-input-block">
						<input type="file" name="file1" value="" lay-verify="file">
					</div>
				</div>
				<div class="layui-form-item">
					<label class="layui-form-label">地址</label>
					<div class="layui-input-block">
							<input type="tel" name="url" lay-verify="url" autocomplete="off" class="layui-input">
						</div>
				</div>
				<div class="layui-form-item layui-form-text">
					<label class="layui-form-label">普通文本域</label>
					<div class="layui-input-block">
						<textarea placeholder="请输入内容" class="layui-textarea"></textarea>
					</div>
				</div>
				<div class="layui-form-item layui-form-text">
					<label class="layui-form-label">编辑器</label>
					<div class="layui-input-block">
						<textarea class="layui-textarea layui-hide" name="content" lay-verify="content" id="LAY_demo_editor"></textarea>
					</div>
				</div>
				<div class="layui-form-item">
					<div class="layui-inline">
						<label class="layui-form-label">状态</label>
						<div class="layui-input-inline">
						<select name="status">
							<option value="">请选择状态</option>
							<option value="1" selected="">开启</option>
							<option value="0">关闭</option>
						</select>
						</div>
					</div>
				<div class="layui-form-item">
					<div class="layui-input-block">
						<button class="layui-btn" lay-submit="" lay-filter="rotation">立即提交</button>
						<button type="reset" class="layui-btn layui-btn-primary">重置</button>
					</div>
				</div>
			</form>
		</div>
		<script type="text/javascript" src="/plugins/layui/layui.js"></script>
		<script>
			layui.use(['form', 'layedit', 'laydate', 'element'], function() {
				var form = layui.form(),
					layer = layui.layer,
					layedit = layui.layedit,
					laydate = layui.laydate,
					element = layui.element(); // 导航的hover效果、二级菜单等功能，需要依赖element模块

				//创建一个编辑器
				var editIndex = layedit.build('LAY_demo_editor');
				//自定义验证规则
				form.verify({
					title: [/(.+){6,12}$/, '标题必须6到12位'],
					// file: function (value) {
					// 	if (value.length < 1) {
					// 		return '请上传图片';
					// 	}
					// 	var extension = ['.gif', '.jpg', '.jpeg', '.png'];
					// 	var imgsrc = value.toLowerCase();
					// 	var r = false;
					// 	for(var i = 0; i < extension.length; i++) {
					// 		if (imgsrc.indexOf([extension[i]]) > 0) {
					// 			r = true;
					// 			break;
					// 		}
					// 	}
					// 	if (!r) {
					// 		return '图片格式不正确';
					// 	}
					// },
					url: [/(.+){6,12}$/, '地址必须6到12位'],
					content: function(value) {
						layedit.sync(editIndex);
					}
				});

				//监听提交
				form.on('submit(rotation)', function(data) {
					// layer.alert(JSON.stringify(data.field), {
					// 	title: '最终的提交信息'
					// })
					return true;
				});
			});
		</script>
	</body>

</html>