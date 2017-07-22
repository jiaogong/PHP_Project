@include('header')
     <form action="{{ url('add') }}" method="POST">
        {{ csrf_field() }}
        用户名：<input type="text" name="name" class="form-control" required="required" >
        邮  箱：<input type="email" name="email" class="form-control" required="required" >
        密  码：<input type="password" name="password" class="form-control" required="required" >
        <input type="submit" value="提交">

    </form>
    <div class="container">
        @foreach ($users as $user)
        {{ $user->name }}
        @endforeach
    </div>

    {{ $users->render() }}
        
@include('footer')
