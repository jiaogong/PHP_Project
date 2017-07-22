<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<title>user add </title>
	</head>
	<body>
		<form action="addData" method="post">
			{{ csrf_field() }}
			用户名：<input type="text" name="name">
			邮  箱：<input type="text" name="email">
			密  码：<input type="password" name="password">
			<input type="submit" value="添 加">
		</form>
		<div>
			@if (isset($user))
			<table border=1> 
				<tr>
					<th>id</td>
					<th>邮箱</td>
					<th>用户名</td>
					<th>密码</td>
					<th>创建时间</td>
					<th>更新时间</td>
				</tr>
				@foreach ($user as $user)
				<tr>
					<td>{{ $user->id }}</td>
					<td>{{ $user->email }}</td>
					<td>{{ $user->name }}</td>
					<td>{{ $user->password }}</td>
					<td>{{ $user->created_at }}</td>
					<td>{{ $user->updated_at }}</td>
				</tr>
				@endforeach
			</table>
			@endif
		</div>	
					
	</body>
</html>
	
