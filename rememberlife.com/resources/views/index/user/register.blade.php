@include('index.template.header')
        <div class="flex-center position-ref full-height">

            <div class="content">
                <div>
                    <form class="" action="/user/add" method="post" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <ul>
                            <li>用户名： <input type="text" name="name" class="user_input" id="" /></li>
                            <li>密&nbsp;&nbsp;&nbsp;&nbsp;码： <input type="text" name="password" class="user_input" id="" /></li>
                            <li>邮&nbsp;&nbsp;&nbsp;&nbsp;箱： <input type="email" name="mail" class="user_input" id="" /></li>
                            <li>手机号： <input type="text" name="phone" class="user_input" id="" /></li>
                            <!-- <li>上传头像： <input type="file" name="avatarFile" /> -->
                            <!-- <li>性&nbsp;&nbsp;&nbsp;&nbsp;别： <input type="text" name="sex" class="user_input" id="" /></li>
                            <li>年&nbsp;&nbsp;&nbsp;&nbsp;龄： <input type="text" name="age" class="user_input" id="" /></li>
                            <li>地&nbsp;&nbsp;&nbsp;&nbsp;址： <input type="text" name="address" class="user_input" id="" /></li> -->

                        </ul>
                        <input type="submit" value=" 提 交 " />
                    </form>
                </div>
                <div class="title m-b-md">
                </div>
            </div>
        </div>
@include('index.template.footer')
