@include('index.template.header')
        <div class="flex-center position-ref full-height">

            <div class="content">
                <div>
                    <form class="" action="{{ route('login') }}" method="post">
                        {{ csrf_field() }}
                        <ul>
                            <li>用户名： <input type="text" name="name" class="user_input" id="" /></li>
                            <li>密&nbsp;&nbsp;&nbsp;&nbsp;码： <input type="text" name="password" class="user_input" id="" /></li>
                        </ul>
                        <input type="text" name="name" value="Name" onFocus="this.value = '';" onBlur="if (this.value == '') {this.value = 'Name';}" />
                        <input type="text" name="email" value="Email" onFocus="this.value = '';" onBlur="if (this.value == '') {this.value = 'Email';}" />
                        <input type="submit" value=" 提 交 " />
                    </form>
                </div>
                <div class="title m-b-md">
                </div>
            </div>
        </div>
@include('index.template.footer')
