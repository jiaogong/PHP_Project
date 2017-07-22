@include('index.template.header')
        <div class="flex-center position-ref full-height">

            <div class="content">
                <div>
                    <div>{{ $message }}</div>
                </div>
                <div class="title m-b-md">
                </div>
            </div>
        </div>
        <script language="javascript">
            var previous = function (){history.go(-1);} // 上一页
            var gotoUrl = function (){location.href = "{{ $gotoUrl or '' }}" ;}
            gotoUrl = "{{ $gotoUrl or 0 }}" ?  gotoUrl : previous;
            setTimeout("gotoUrl()", 1000* {{ $gototime or 3 }});
        </script>
@include('index.template.footer')
