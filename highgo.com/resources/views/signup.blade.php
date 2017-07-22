@include('header')
    <div class="signin">
        注 册
        <form action="{{ route('signUp.data')}}" method="post">
        <ul>
            {{ csrf_field() }}
            <li>用户名：<input type="text" name="name" placeholder="username"></li>
            <li>邮  箱：<input type="email" name="email"></li>
            <li>手  机：<input type="tel" name="phone"></li>
            <li>密  码：<input type="password" class="password" name="password"></li>
            <li>年  龄：<input type="number" name="age" min="10"></li>
            <li>性  别：<select name="sex">
                            <option value="male" selected="selected">male</option>
                            <option value="female">female</option>
                            <option value="nuter">nuter</option>
                        </select>
            </li>
            <li>住  址：<input type="text" name="address" ></li>
            <li><input type="submit" value="提 交"></li>
        </ul>
        </form>
    </div>
@include('footer')
