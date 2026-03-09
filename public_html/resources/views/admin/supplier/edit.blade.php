@extends("admin.admin")
@section('content')

    <ol class="breadcrumb">
        <li class="breadcrumb-item"> Trang chủ</li>
        <li class="breadcrumb-item"><a href="/admin/supplier/lists">Danh Sách Nhà Cung Cấp </a>
        </li>


    </ol>

    @if(!empty(session('success')))

        <div id='myMessagerSuccess' class="modal" tabindex="1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Thông Báo:</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p>{!!session('success')!!}</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">OK</button>

                    </div>
                </div>
            </div>
        </div>
    @endif

    {!!Form::open(['method'=>'post','class'=>'s'])!!}
    <div class="row container-fluid">


        <div class="col-xs-6 col-sm-6 col-lg-6">
            <div class="card">
                <div class="card-header">
                    <strong> Chỉnh sửa nhà cung cấp </strong>
                    <small>Form</small>
                </div>
                <div class="card-body">
                    <div class="row">


                        <div class="col-sm-10">

                            <div class="form-group {{($errors->has('name'))? 'has-error':''}}">

                                <label for="name"> Tên nhà cung cấp: </label>
                                {!! Form::text('name',@$data['name'],['class'=>'form-control','autocomplete'=>'on'])!!}
                                @if($errors->has("name"))

                                    <label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i>
                                        * {{$errors->first("name")}}</label>
                                @endif


                            </div>

                        </div>
                        <div class="col-sm-10">

                            <div class="form-group">
                                <label for="name">Số điện thoại: </label>


                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-phone"></i>
                                    </div>
                                    {!! Form::text('phone',@$data['phone'],['class'=>'form-control'])!!}
                                </div>

                            </div>

                        </div>

                        <div class="col-sm-10">

                            <div class="form-group">
                                <label for="name">Địa chỉ: </label>
                                {!! Form::text('address',@$data['address'],['class'=>'form-control'])!!}


                            </div>

                        </div>

                        <div class="col-sm-10">

                            <div class="form-group">
                                <label for="name">Email : </label>


                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-envelope"></i>
                                    </div>
                                    {!! Form::email('email',@$data['email'],['class'=>'form-control'])!!}
                                </div>


                            </div>

                        </div>

                        <div class="col-sm-10">

                            <div class="form-group">
                                <label for="name">Ghi chú : </label>
                                {!! Form::textarea('note',@$data['note'],['class'=>'form-control','rows'=>3])!!}
                            </div>

                        </div>

                    </div>

                </div>
            </div>


        </div>

        <div class="col-xs-6 col-sm-6 col-lg-6">
            <div class="card">
                <div class="card-header">
                    <strong> Mức Phí </strong>
                    <small>Form</small>
                </div>
                <div class="card-body">
                    <div class="row">


                        <div class="col-sm-10">

                            <div class="form-group">

                                <h6><span for="name" class="badge  badge-success">Phí dịch thuật  : </span></h6>


                                <div class='input-group'>
                                    {!! Form::number('phidichthuat',@$data['phidichthuat'],['class'=>'form-control my_price element_price', 'min'=> 0])!!}

                                    <div class="input-group-addon">
                                        VNĐ
                                    </div>

                                </div>
                                <p class='view_myprice'></p>
                            </div>

                        </div>


                        <div class="col-sm-10">

                            <div class="form-group">
                                <h6><span for="name" class="badge  badge-success">Công chứng: </span></h6>


                                <div class='input-group'>
                                    {!! Form::number('congchung',@$data['congchung'],[ 'min' => 0,'class'=>'form-control my_price element_price'])!!}

                                    <div class="input-group-addon">
                                        VNĐ
                                    </div>

                                </div>
                                <p class='view_myprice'></p>


                            </div>

                        </div>
                        <div class="col-sm-10">

                            <div class="form-group">
                                <h6><span for="name" class="badge  badge-success">Dấu công ty: </span></h6>


                                <div class='input-group'>
                                    {!! Form::number('daucongty',@$data['daucongty'],[ 'min' => 0,'class'=>'form-control my_price element_price'])!!}

                                    <div class="input-group-addon">
                                        VNĐ
                                    </div>

                                </div>
                                <p class='view_myprice'></p>

                            </div>

                        </div>

                        <div class="col-sm-10">

                            <div class="form-group">
                                <h6><span for="name" class="badge  badge-success">Sao y: </span></h6>
                                <div class='input-group'>
                                    {!! Form::number('saoy',@$data['saoy'],[ 'min' => 0,'class'=>'form-control my_price element_price'])!!}

                                    <div class="input-group-addon">
                                        VNĐ
                                    </div>

                                </div>


                                <p class='view_myprice'></p>

                            </div>

                        </div>

                        <div class="col-sm-10">

                            <div class="form-group">

                                <h6><span for="name" class="badge  badge-success">Ngoại vụ : </span></h6>

                                <div class='input-group'>
                                    {!! Form::number('ngoaivu',@$data['ngoaivu'],[ 'min' => 0,'class'=>'form-control my_price element_price'])!!}

                                    <div class="input-group-addon">
                                        VNĐ
                                    </div>

                                </div>


                                <p class='view_myprice'></p>

                            </div>

                        </div>

                        <div class="col-sm-10">

                            <div class="form-group">

                                <h6><span for="name" class="badge  badge-success">Phí vận chuyện  : </span></h6>

                                <div class='input-group'>
                                    {!! Form::number('phivanchuyen',@$data['phivanchuyen'],[ 'min' => 0,'class'=>'form-control my_price element_price'])!!}

                                    <div class="input-group-addon">
                                        VNĐ
                                    </div>

                                </div>


                                <p class='view_myprice'></p>

                            </div>

                        </div>


                        <div class="col-sm-10">

                            <div class="form-group">

                                <h6><span for="name" class="badge  badge-success">Vat  :   </span></h6>


                                <div class='input-group'>
                                    {!! Form::number('vat',@$data['vat'],[ 'min' => 0,'class'=>'form-control vat_price','maxlength'=>2])!!}
                                    <div class="input-group-addon">
                                        %
                                    </div>

                                </div>


                            </div>

                        </div>


                        <div class="col-sm-10">

                            <div class="form-group">

                                <h6><span for="name" class="badge  badge-danger">Tổng cộng  :  </span></h6>


                                <div class='input-group'>
                                    {!! Form::number('tong',@$data['tong'],[ 'min' => 0,'class'=>'form-control total_price'])!!}

                                    <div class="input-group-addon">
                                        VNĐ
                                    </div>

                                </div>

                                <p class='view_myprice'></p>

                            </div>

                        </div>


                    </div>

                </div>
            </div>


        </div>
        <div class="col-sm-12">

            <div class="card-footer">
                <input type='hidden' name='_token' value='{{ csrf_token()}}'/>
                <button type="submit" class="btn btn-sm btn-primary"><i class="fa fa-dot-circle-o"></i> LƯU</button>
                <a href='/admin/supplier/lists' class="btn btn-sm btn-danger">
                    <i class="fa fa-ban"></i> Danh Sách NCC </a>
            </div>
        </div>


    </div>


    </div>
    {!!Form::close()!!}
@endsection
@section("script_js")
    <script type="text/javascript">
        $(document).ready(function () {
            $('#myMessagerSuccess').modal('show');
        });
    </script>
@endsection
