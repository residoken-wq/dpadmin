@extends("admin.admin")
@section('content')
    <ol class="breadcrumb">
        <li class="breadcrumb-item"> Trang chủ</li>
        <li class="breadcrumb-item"><a href="">Tạo mới Phiếu Dịch </a>
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
                        <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">OK</button>
                        <a href="/admin/index/lists" class="btn btn-sm btn-danger">
                            <i class="fa fa-ban"></i>
                            DANH SÁCH
                        </a>


                    </div>
                </div>
            </div>
        </div>
    @endif

    <div class="toast d-flex justify-content-center align-items-center" role="alert" aria-live="polite"
         aria-atomic="true" data-delay="10000" style="top:1em;right:1em;position: absolute;z-index:11111">
        <div role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-header bg-warning">
                <strong class="mr-auto toast-heading">Thông báo</strong>
                <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="toast-body"></div>
        </div>
    </div>
    {!!Form::open(['method'=>'post','class'=>'s', 'name' => 'formPhieu'])!!}
    <div class="row container-fluid">
        <div class="col-xs-12 col-sm-12 col-lg-12 ">
            <div class="card">

                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-5">

                            <div class="form-group">
                                <label for="name"> Số:</label>
                                <input type='text' class="form-control" value="{{@$data['code']}}" disabled="disabled"/>
                                {!! Form::hidden('code',@$data['code'],['class'=>'form-control'])!!}


                            </div>

                        </div>


                        <div class="col-sm-5">

                            <div class="form-group">
                                <label for="name"> Ngày:</label>

                                {!! Form::text('mydate',date('d/m/Y'),['class'=>'form-control','Disabled'=>'Disabled'])!!}


                            </div>

                        </div>

                    </div>

                </div>
            </div>


        </div>


        <div class="col-xs-6 col-sm-6 col-lg-6 ">
            <div class="card">
                <div class="card-header">
                    <strong> Thông tin PHIẾU DỊCH THUẬT </strong>
                    <small>Form</small>
                </div>
                <div class="card-body">
                    <div class="row">

                        <div class="col-sm-10">

                            <div class="form-group">
                                <label for="name">Tên Khách Hàng:</label>

                                <div class='input-group'>
                                    {!! Form::select('cid_customer',$cid_customer,@$data['cid_customer'],['class'=>'form-control cid_customer'])!!}
                                    <div class="input-group-btn">
                                        <a href="/admin/customer/add" class="btn btn-primary  btn-flat" target="_blank">
                                            <i class="fa fa-plus"></i>
                                        </a>
                                    </div>
                                </div>

                                @if($errors->has("cid_customer"))
                                    <div class="alert alert-danger invalid-feedback" role="alert">
                                        * {{$errors->first("cid_customer")}}</div>
                                @endif

                            </div>

                        </div>
                        <div class="col-sm-10">

                            <div class="form-group">
                                <label for="name">Nhà Cung Cấp:</label>
                                <div class='input-group'>
                                    {!! Form::select('cid_supplier',$cid_supplier,@$data['cid_supplier'],['class'=>'form-control cid_supplier' ])!!}
                                </div>
                                @if($errors->has("cid_supplier"))
                                    <div class="alert alert-danger invalid-feedback" role="alert">
                                        * {{$errors->first("cid_supplier")}}</div>
                                @endif
                            </div>

                        </div>
                        <div class="col-sm-10">

                            <div class="form-group">
                                <label for="name">Loại văn kiện:</label>
                                <div class="row">
                                    <div class="col-xs-8 col-sm-8">
                                        {!! Form::text('name',@$data['name'],['class'=>'form-control','placeholder'=>"Diễn giải "])!!}
                                    </div>
                                    <div class="col-xs-4 col-sm-4">
                                        {!! Form::text('name_number',@$data['name_number'],['class'=>'form-control inputNumber',"placeholder"=>"Số lượng"])!!}
                                    </div>
                                </div>
                                @if($errors->has("name"))
                                    <div class="alert alert-danger invalid-feedback" role="alert">
                                        * {{$errors->first("name")}}</div>
                                @endif
                                @if($errors->has("name_number"))
                                    <div class="alert alert-danger">* {{$errors->first("name_number")}}</div>
                                @endif
                            </div>

                        </div>

                        <div class="col-sm-10">

                            <div class="form-group">
                                <label for="name">Tên trong hồ sơ:</label>
                                {!! Form::text('name_docs',@$data['name_docs'],['class'=>'form-control'])!!}

                                @if($errors->has("name_docs"))
                                    <div class="alert alert-danger">* {{$errors->first("name_docs")}}</div>
                                @endif


                            </div>

                        </div>
                        <div class="col-sm-10">

                            <div class="form-group">
                                <label for="name">Đường dẫn vật lý:</label>
                                <div class='input-group'>
                                    {!! Form::text('path_work',@$data['path_work'],['class'=>'form-control'])!!}
                                    <div class="input-group-btn">
                                        <a href="javascript:void(0);" class="btn btn-primary btn-flat btnOnedrive">
                                            <i class="fa fa-mixcloud" aria-hidden="true"></i>
                                        </a>
                                    </div>
                                </div>
                                @if($errors->has("path_work"))
                                    <div class="alert alert-danger">* {{$errors->first("path_work")}}</div>
                                @endif
                                <div id="alertOnedrive" class="hidden alert alert-warning">

                                </div>

                            </div>

                        </div>


                        <div class="col-sm-10">

                            <div class="form-group">

                                <label>Ghi chú để xuất ra file pdf:</label>


                                {!! Form::textarea('ghichu',@$data['ghichu'],['class'=>'form-control ','rows'=>'4`'])!!}

                            </div>

                        </div>
                    </div>

                </div>
            </div>


        </div>

        <div class="col-xs-6 col-sm-6 col-lg-6">
            <div class="card">
                <div class="card-header">
                    <strong> Nội dung </strong>
                    <small>Form</small>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-10">

                            <div class="form-group">
                                <label for="name">Số điện thoại:</label>
                                {!! Form::text('phone',@$data['phone'],['class'=>'form-control','id'=>'phone'])!!}

                                @if($errors->has("phone"))
                                    <div class="alert alert-danger">* {{$errors->first("phone")}}</div>
                                @endif

                            </div>

                        </div>

                        <div class="col-sm-10">

                            <div class="form-group">
                                <label for="name">Số bản dịch:</label>
                                {!! Form::text('sobandich',@$data['sobandich'],['class'=>'form-control'])!!}


                                @if($errors->has("sobandich"))
                                    <div class="alert alert-danger">* {{$errors->first("sobandich")}}</div>
                                @endif
                            </div>

                        </div>

                        <div class="col-sm-10">

                            <div class="form-group">
                                <label for="name">Ngày trả hồ sơ:</label>

                                <div class="row">
                                    <div class='col-xs-8 col-sm-8'>
                                        <div class='input-group'>
                                            {!! Form::text('ngaytrahoso',@$data['ngaytrahoso'],['class'=>'form-control ngaytrahoso'])!!}
                                            <div class="input-group-addon click_datepicker">
                                                <i class="fa fa-calendar"></i>
                                            </div>
                                        </div>

                                    </div>
                                    <div class='col-xs-4 col-sm-4'>
                                        <div class='input-group'>
                                            {!! Form::text('giotrahoso',@$data['giotrahoso'],['class'=>'form-control giotrahoso'])!!}
                                            <div class="input-group-addon click_timepicker">
                                                <i class="fa fa-clock-o"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                @if($errors->has("ngaytrahoso"))
                                    <div class="alert alert-danger">* {{$errors->first("ngaytrahoso")}}</div>
                                @endif


                            </div>

                        </div>


                        <div class="col-sm-10">

                            <div class="form-group">

                                <h6><span for="name" class="badge  badge-success">Phí dịch thuật:</span></h6>


                                <div class='input-group'>
                                    {!! Form::text('phidichthuat',@$data['phidichthuat'],['class'=>'form-control my_price element_price inputNumber','id'=>'phidichthuat'])!!}

                                    <div class="input-group-addon">
                                        VNĐ
                                    </div>

                                </div>
                                <p class='view_myprice'></p>
                            </div>

                        </div>


                        <div class="col-sm-10">

                            <div class="form-group">
                                <h6><span for="name" class="badge  badge-success">Công chứng:</span></h6>


                                <div class='input-group'>
                                    {!! Form::text('congchung',@$data['congchung'],['class'=>'form-control my_price element_price inputNumber','id'=>'congchung'])!!}

                                    <div class="input-group-addon">
                                        VNĐ
                                    </div>

                                </div>
                                <p class='view_myprice'></p>


                            </div>

                        </div>
                        <div class="col-sm-10">

                            <div class="form-group">
                                <h6><span for="name" class="badge  badge-success">Dấu công ty:</span></h6>


                                <div class='input-group'>
                                    {!! Form::text('daucongty',@$data['daucongty'],['class'=>'form-control my_price element_price inputNumber','id'=>'daucongty'])!!}

                                    <div class="input-group-addon">
                                        VNĐ
                                    </div>

                                </div>
                                <p class='view_myprice'></p>

                            </div>

                        </div>

                        <div class="col-sm-10">

                            <div class="form-group">
                                <h6><span for="name" class="badge  badge-success">Sao y:</span></h6>
                                <div class='input-group'>
                                    {!! Form::text('saoy',@$data['saoy'],['class'=>'form-control my_price element_price inputNumber','id'=>'saoy'])!!}

                                    <div class="input-group-addon">
                                        VNĐ
                                    </div>

                                </div>


                                <p class='view_myprice'></p>

                            </div>

                        </div>

                        <div class="col-sm-10">

                            <div class="form-group">

                                <h6><span for="name" class="badge  badge-success">Ngoại vụ:</span></h6>

                                <div class='input-group'>
                                    {!! Form::text('ngoaivu',@$data['ngoaivu'],['class'=>'form-control my_price element_price inputNumber','id'=>'ngoaivu'])!!}

                                    <div class="input-group-addon">
                                        VNĐ
                                    </div>

                                </div>


                                <p class='view_myprice'></p>

                            </div>

                        </div>

                        <div class="col-sm-10">

                            <div class="form-group">

                                <h6><span for="name" class="badge  badge-success">Phí vận chuyện:</span></h6>

                                <div class='input-group'>
                                    {!! Form::text('phivanchuyen',@$data['phivanchuyen'],['class'=>'form-control my_price element_price inputNumber','id'=>'phivanchuyen'])!!}

                                    <div class="input-group-addon">
                                        VNĐ
                                    </div>

                                </div>


                                <p class='view_myprice'></p>

                            </div>

                        </div>


                        <div class="col-sm-10">

                            <div class="form-group">

                                <h6><span for="name" class="badge  badge-success">VAT:   </span></h6>


                                <div class='input-group'>
                                    {!! Form::text('vat',@$data['vat'],['class'=>'form-control my_price element_price inputNumber'])!!}
                                    <div class="input-group-addon">
                                        VNĐ
                                    </div>

                                </div>


                            </div>

                        </div>


                        <div class="col-sm-10">

                            <div class="form-group">

                                <h6><span for="name" class="badge  badge-danger">Tổng cộng:  </span></h6>


                                <div class='input-group'>
                                    {!! Form::text('tong',@$data['tong'],['class'=>'form-control total_price inputNumber','id'=>'tong'])!!}

                                    <div class="input-group-addon">
                                        VNĐ
                                    </div>

                                </div>

                                <p class='view_myprice'></p>

                            </div>

                        </div>


                        <div class="col-sm-10">

                            <div class="form-group">

                                <h6><span for="name" class="badge  badge-primary">Tạm ứng:  </span></h6>


                                <div class='input-group'>
                                    {!! Form::text('tamung',@$data['tamung'],['class'=>'form-control tamung_price inputNumber','id'=>'tamung'])!!}

                                    <div class="input-group-addon">
                                        VNĐ
                                    </div>

                                </div>

                                <p class='view_myprice'></p>

                            </div>

                        </div>

                        <div class="col-sm-10">

                            <div class="form-group">

                                <h6> <span for="name" class="badge  badge-warning">Còn lại:
                                                            </span></h6>

                                <div class='input-group'>
                                    {!! Form::text('conglai',@$data['conglai'],['class'=>'form-control conglai_price inputNumber','id'=>'conglai'])!!}

                                    <div class="input-group-addon">
                                        VNĐ
                                    </div>

                                </div>

                                <p class='view_myprice'></p>

                            </div>

                        </div>

                        <div class="col-sm-10">

                            <div class="form-group">
                                <label>
                                    <input name="approved" type="checkbox" value="1" class="approved_check">

                                    Đã nhận đầy đủ
                                </label>


                            </div>

                        </div>


                    </div>

                </div>
            </div>


        </div>

        <div class="col-sm-12">

            <div class="card-footer">
                <input type='hidden' name='_token' value='{{ csrf_token()}}'/>
                <button type="submit" class="btn btn-sm btn-primary"><i class="fa fa-save"></i> LƯU</button>
                <button type="reset" class="btn btn-sm btn-danger"><i class="fa fa-undo"></i> LÀM LẠI</button>
            </div>
        </div>
    </div>
    </div>
    {!!Form::close()!!}

@endsection
@section("script_js")
    <script type="text/javascript" src="/admin/bower_components/time-picker/dist/time-picker.js"></script>
    <script type="text/javascript" src="/admin/bower_components/jqueryui-datepicker/datepicker.js"></script>

    <link rel="stylesheet" type="text/css" href="/admin/bower_components/jqueryui-datepicker/datepicker.css">
    <link rel="stylesheet" type="text/css" href="/admin/bower_components/time-picker/dist/time-picker.css">

    <script src="/js/jquery.flexselect.js"></script>
    <script src="/js/liquidmetal.js"></script>
    <script src="/js/cleave.min.js"></script>
    <link rel="stylesheet" type="text/css" href="/css/flexselect.css">

    <script type="text/javascript">
        $(document).ready(function () {
            $('input.inputNumber').toArray().forEach(function (field) {
                new Cleave(field, {
                    numeral: true,
                    numeralThousandsGroupStyle: 'none',
                });
            });

            $(".cid_supplier").change(function () {
                var th = $(this);
                $.ajax({
                    type: "get",
                    url: "/admin/index/getsupplier/" + $(th).val(),
                    dataType: 'json',
                    success: function (result) {
                        if (typeof result == 'object') {
                            $("#phidichthuat").val(result.phidichthuat).keyup();
                            $("#congchung").val(result.congchung).keyup();
                            $("#daucongty").val(result.daucongty).keyup();
                            $("#saoy").val(result.saoy).keyup();
                            $("#ngoaivu").val(result.ngoaivu).keyup();
                            $("#phivanchuyen").val(result.phivanchuyen).keyup();
                            $("#vat").val(result.vat);
                            $("#tong").val(result.tong).keyup();
                        }

                    }
                });
            });

            $(document).on("click", ".btnOnedrive", function () {
                var strUrl = "{{ route('onedrive.getpath') }}";
                $('.btnOnedrive').addClass('disabled');
                var formData = new FormData();
                formData.append('code', $('input[name="code"]').val());
                formData.append('mydate', $('input[name="mydate"]').val());
                formData.append('name_docs', $('input[name="name_docs"]').val());
                formData.append('cid_customer', $('select[name="cid_customer"]').val());
                formData.append('cid_customer_name', $('select[name="cid_customer"] option:selected').text());
                formData.append('cid_supplier', $('select[name="cid_supplier"]').val());
                formData.append('cid_supplier_name', $('select[name="cid_supplier"] option:selected').text());
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    type: "POST",
                    url: strUrl,
                    data: formData,
                    contentType: false,
                    cache: false,
                    processData: false,
                }).always(function () {
                    $('.btnOnedrive').addClass('disabled');
                }).done(function (response) {
                    if (response.success === true) {
                        $('form[name="formPhieu"]').removeClass('was-validated');
                        $(".toast-header").removeClass('bg-danger').removeClass('bg-warning').addClass('bg-success');
                        $('input[name="path_work"]').val(response.id);
                        $('#alertOnedrive').removeClass('alert-warning').addClass('alert-success');
                    } else {
                        $(".toast-header").removeClass('bg-success').removeClass('bg-warning').addClass('bg-danger');
                        $('.btnOnedrive').removeClass('disabled');
                        $('#alertOnedrive').removeClass('alert-success').addClass('alert-danger');
                    }
                    $('#alertOnedrive').html(response.message);
                    $(".toast-body").html(response.message);
                    $(".toast").toast("show");

                }).fail(function (data) {
                    var strError = [];
                    $.each(data.responseJSON, function (key, value) {
                        var input = '[name=' + key + ']';
                        $(input + '+span>strong').text(value);
                        strError.push('- ' + value);
                        $(input).parent().parent().addClass('has-error');
                    });
                    $('.btnOnedrive').removeClass('disabled');
                    $(".toast-header").addClass('bg-danger');
                    $('#alertOnedrive').removeClass('alert-success').addClass('alert-danger');
                    $(".toast-body").html('<div>' + strError.join('<br/>') + '</div>');
                    $(".toast").toast("show");
                });
            });

            $(".cid_customer").change(function () {
                var th = $(this);
                $.ajax({
                    type: "get",
                    url: "/admin/index/getcustomer/" + $(th).val(),
                    dataType: 'json',
                    success: function (result) {
                        if (typeof result == 'object') {
                            $("#phone").val(result.phone);
                        }

                    }
                });
            });
            $(".ngaytrahoso").datepicker({
                dateFormat: "yy-mm-dd",
                minDate: 0
            });
            $(".click_datepicker").click(function () {
                $(".ngaytrahoso").focus();
            });

            if ($(".ngaytrahoso").val() == "") {
                $(".ngaytrahoso").val('{{date("Y-m-d")}}');
            }
            if ($(".giotrahoso").val() == "") {
                $(".giotrahoso").val('{{date("h:i")}}');
            }
            $('.giotrahoso').timepicker({
                'timeFormat': 'H:i',
                'showDuration': true
            });
            $(".click_timepicker").click(function () {
                $(".giotrahoso").focus();
            });


            $("select.cid_customer").flexselect();
            $("select.cid_supplier").flexselect();

            $(".tamung_price").keyup(function () {

                if (parseInt($(this).val()) > parseInt($('.total_price').val())) {
                    $(this).val($(".total_price").val());
                }
                $(this).parent().next(".view_myprice").html(formatMoney($(this).val(), 0, ".", ","));
                $(".conglai_price").val(parseInt($('.total_price').val()) - $(this).val());

            });
            $(".conglai_price").css("pointer-events", 'none');
        });
    </script>

    <script type="text/javascript">
        $(document).ready(function () {
            $('#myMessagerSuccess').modal('show');
        });
    </script>

@endsection
