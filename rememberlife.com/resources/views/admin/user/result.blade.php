<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>{{ $htmlTitle }} - 结果页</title>
</head>
<body>
	{{ $message }} 
	<div >
		<span class="gotoTime">{{ $gototime or 3 }}</span> 秒后跳转至<a href="{{ $gotoUrl }}" class="gotoUrl" style="text-decoration: none;">{{ $gotoUrlName }}</a>
	</div>

	<script type="text/javascript" src="/js/jquery.js"></script>
	<script type="text/javascript">
		var gotoTime = {{ $gotoTime or 3 }};
		var previous = function (){history.go(-1);} // 上一页
        var gotoUrl = function (){location.href = "{{ $gotoUrl or '' }}" ;}
        gotoUrl = "{{ $gotoUrl or 0 }}" ?  gotoUrl : previous;
		setTimeout("gotoUrl()", 1000* gotoTime); // 跳转
		setInterval(function (){ // 修改页面时间
			gotoTime-=1;
			if(gotoTime>0){
				$('.gotoTime').text(gotoTime);
			}
		}, 1000);
	</script>
</body>
</html>
