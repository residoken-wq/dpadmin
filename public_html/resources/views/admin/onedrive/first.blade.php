@extends("admin.admin")
@section('content')

    <ol class="breadcrumb">
        <li class="breadcrumb-item"> Trang chủ</li>
        <li class="breadcrumb-item"><a href="">ONDDRIVE </a>
        </li>
    </ol>

    <div class="row container-fluid">
        <div class="col-xs-12 col-sm-12 col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-12">
                            @if(Session::has('errorDetail'))
                                <div class="alert alert-warning">
                                    {{ Session::get('errorDetail') }}
                                </div>
                            @endif
                            <p>Vui lòng đăng nhập ONEDRIVE để xử lý các file biên dịch. </p>
                            <a href="{{$url}}" class="btn btn-primary" data-dismiss="modal">ĐĂNG NHẬP ONEDRIVE </a>
                        </div>
                    </div>

                </div>
            </div>


        </div>


    </div>


    </div>
@endsection
@section("script_js")
    <script type="text/javascript">

    </script>
@endsection
