@include('header')
    <div class="signin">
        登录
        <form action="{{ route('signIn.data')}}" method="post">
        <ul>
            {{ csrf_field() }}
            <li>用户名：<input type="text" name="name"></li>
            <li>密  码：<input type="password" name="password"></li>
            <li><input type="submit" value="提 交"></li>
        </ul>
        </form>
    </div>
@include('footer')
