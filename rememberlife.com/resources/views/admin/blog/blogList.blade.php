<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
	<head>
		<meta charset="UTF-8">
		<title>{{ $htmlTitle }}</title>
		<link rel="stylesheet" href="/plugins/layui/css/layui.css" media="all" />
		<link rel="stylesheet" href="/css/admin/global.css" media="all">
		<link rel="stylesheet" href="/plugins/font-awesome/css/font-awesome.min.css">
		<link rel="stylesheet" href="/css/admin/table.css" />
	</head>

	<body>
		<div class="admin-main">
			<div style="margin-bottom: 5px;">
				<!-- 面包屑导航 开始 -->
				<span class="layui-breadcrumb">
				  <a><cite>6小图列表页</cite></a>
				</span>
				<!-- 面包屑导航 结束 -->
			</div>
			<blockquote class="layui-elem-quote">
				<a href="{{ route('admin_blog_add') }}" class="layui-btn layui-btn-small" id="add">
					<i class="layui-icon">&#xe608;</i> 发布blog
				</a>
			</blockquote>
			<fieldset class="layui-elem-field">
				<legend>数据列表</legend>
				<div class="layui-field-box">
					@if(count($blogInfo) > 0)
					<table class="site-table table-hover">
						<thead>
							<tr>
								<th>标题</th>
								<th>图片</th>
								<th>作者</th>
								<th>创建时间</th>
								<th>状态</th>
								<th>排序值</th>
								<th>操作</th>
							</tr>
						</thead>
						<tbody>
							@foreach($blogInfo as $b)
							<tr>
								<td>
									<a href="{{ url($b->url) }}">{{ $b->title }}</a>
								</td>
								<td><img src="{{ $b->image_path }}"  style="width:45px;"/></td>
								<td>{{ $b->user_name }}</td>
								<td>{{ $b->created_at }}</td>
								<td>{{ $b->status == 1 ? '正常' : '关闭' }}</td>
								<td>{{ $b->sort > 0 ?: '默认' }}</td>
								<td>
									<a href="{{ url('admin/rsmpreview/'. $b->id) }}" target="_blank" class="layui-btn layui-btn-normal layui-btn-mini">预览</a>
									<a href="{{ url('admin/rsmmodify/'. $rsm->id) }}" class="layui-btn layui-btn-mini">编辑</a>
									<a href="{{ url('admin/rsmdel/'. $rsm->id) }}" data-id="1" data-opt="del" class="layui-btn layui-btn-danger layui-btn-mini">删除</a>
								</td>
							</tr>
							@endforeach
						</tbody>
					</table>
					@else
						<div style="margin-left: 48%;color:#666">暂无数据！</div>
					@endif
				</div>
			</fieldset>
			<div class="admin-table-page">
				<div id="page" class="page">
				</div>
			</div>
		</div>
		<script type="text/javascript" src="/plugins/layui/layui.js"></script>
		<script>
			// layui.config({
			// 	base: 'plugins/layui/modules/'
			// });

			layui.use('element', function() {
				var element = layui.element();
					// laypage = layui.laypage,
					// layer = parent.layer === undefined ? layui.layer : parent.layer;
			// 	$('input').iCheck({
			// 		checkboxClass: 'icheckbox_flat-green'
			// 	});

			// 	//page
			// 	laypage({
			// 		cont: 'page',
			// 		pages: 25 //总页数
			// 			,
			// 		groups: 5 //连续显示分页数
			// 			,
			// 		jump: function(obj, first) {
			// 			//得到了当前页，用于向服务端请求对应数据
			// 			var curr = obj.curr;
			// 			if(!first) {
			// 				//layer.msg('第 '+ obj.curr +' 页');
			// 			}
			// 		}
			// 	});

			// 	$('#search').on('click', function() {
			// 		parent.layer.alert('你点击了搜索按钮')
			// 	});

			// 	$('#add').on('click', function() {
			// 		$.get('temp/edit-form.html', null, function(form) {
			// 			layer.open({
			// 				type: 1,
			// 				title: '添加表单',
			// 				content: form,
			// 				btn: ['保存', '取消'],
			// 				area: ['600px', '400px'],
			// 				maxmin: true,
			// 				yes: function(index) {
			// 					console.log(index);
			// 				},
			// 				full: function(elem) {
			// 					var win = window.top === window.self ? window : parent.window;
			// 					$(win).on('resize', function() {
			// 						var $this = $(this);
			// 						elem.width($this.width()).height($this.height()).css({
			// 							top: 0,
			// 							left: 0
			// 						});
			// 						elem.children('div.layui-layer-content').height($this.height() - 95);
			// 					});
			// 				}
			// 			});
			// 		});
			// 	});

			// 	$('#import').on('click', function() {
			// 		var that = this;
			// 		var index = layer.tips('只想提示地精准些', that,{tips: [1, 'white']});
			// 		$('#layui-layer'+index).children('div.layui-layer-content').css('color','#000000');
			// 	});

			// 	$('.site-table tbody tr').on('click', function(event) {
			// 		var $this = $(this);
			// 		var $input = $this.children('td').eq(0).find('input');
			// 		$input.on('ifChecked', function(e) {
			// 			$this.css('background-color', '#EEEEEE');
			// 		});
			// 		$input.on('ifUnchecked', function(e) {
			// 			$this.removeAttr('style');
			// 		});
			// 		$input.iCheck('toggle');
			// 	}).find('input').each(function() {
			// 		var $this = $(this);
			// 		$this.on('ifChecked', function(e) {
			// 			$this.parents('tr').css('background-color', '#EEEEEE');
			// 		});
			// 		$this.on('ifUnchecked', function(e) {
			// 			$this.parents('tr').removeAttr('style');
			// 		});
			// 	});
			// 	$('#selected-all').on('ifChanged', function(event) {
			// 		var $input = $('.site-table tbody tr td').find('input');
			// 		$input.iCheck(event.currentTarget.checked ? 'check' : 'uncheck');
			// 	});
			});
		</script>
	</body>

</html>