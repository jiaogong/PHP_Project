@include('index.template.header')
        <div class="flex-center position-ref full-height">

            <div class="content">
                <div class="title m-b-md">
                </div>

                <div class="links">
                    {{ Session::get('user_name') }}
                </div>
            </div>
        </div>
@include('index.template.footer')
