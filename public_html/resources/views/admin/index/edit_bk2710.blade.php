@extends("admin.admin")
@section('content')
    <ol class="breadcrumb">
        <li class="breadcrumb-item"> Trang chủ</li>
        <li class="breadcrumb-item"><a href="/admin/index/lists">Danh Sách Phiếu Dịch </a>
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
                        <a href="/admin/index/lists" class="btn btn-sm btn-info">
                            <i class="fa fa-list"></i>
                            DANH SÁCH
                        </a>
                        <a href="/admin/index/pdf/{{$data['id']}}" class="btn btn-sm btn-dark" target="_black;">
                            <i class="fa fa-file-pdf-o"></i>
                            XUẤT PDF
                        </a>
                        @if(isset($data['locked']) && !$data['locked'])
                            <a href="/admin/index/lock/{{$data['id']}}" class="btn btn-sm btn-warning" target="_black;">
                                <i class="fa fa-lock"></i>
                                KHÓA PHIẾU
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @endif
    {!!Form::open(['method'=>'post','class'=>'s', 'disabled' => $data['locked']?true:false])!!}
    <div class="row container-fluid">
        <div class="col-xs-12 col-sm-12 col-lg-12 ">
            <div class="card">
                <div class="card-header">
                    <strong> Thông Tin Phiếu Dịch </strong>
                    <small>Form</small>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-5">
                            <div class="form-group">
                                <label for="name">Loại văn kiện: </label>
                                <div class="row">
                                    <div class="col-xs-8 col-sm-8">
                                        {!! Form::text('name',@$data['name'],[ 'readonly'=> $data['locked']?true:false, 'class'=>'form-control','placeholder'=>"Diễn giải "])!!}
                                    </div>
                                    <div class="col-xs-4 col-sm-4">
                                        {!! Form::number('name_number',@$data['name_number'],[ 'readonly'=> $data['locked']?true:false, 'class'=>'form-control',"placeholder"=>"Số lượng"])!!}
                                    </div>
                                </div>
                                @if($errors->has("name"))
                                    <div class="alert alert-danger">* {{$errors->first("name")}}</div>
                                @endif
                                @if($errors->has("name_number"))
                                    <div class="alert alert-danger">* {{$errors->first("name_number")}}</div>
                                @endif
                            </div>
                        </div>
                        <div class="col-sm-5">
                            <div class="form-group">
                                <label for="name">Đường dẫn vật lý: </label>
                                {!! Form::text('path_work',@$data['path_work'],[ 'readonly'=> $data['locked']?true:false, 'class'=>'form-control'])!!}
                                @if($errors->has("path_work"))
                                    <div class="alert alert-danger">* {{$errors->first("path_work")}}</div>
                                @endif
                            </div>
                        </div>
                        <div class="col-sm-5">
                            <div class="form-group">
                                <label for="name">Tên trong hồ sơ: </label>
                                {!! Form::text('name_docs',@$data['name_docs'],[ 'readonly'=> $data['locked']?true:false, 'class'=>'form-control'])!!}
                                @if($errors->has("name_docs"))
                                    <div class="alert alert-danger">* {{$errors->first("name_docs")}}</div>
                                @endif
                            </div>
                        </div>
                        <div class="col-sm-5">
                            <div class="form-group">
                                <label for="name">Số bản dịch: </label>
                                {!! Form::text('sobandich',@$data['sobandich'],[ 'readonly'=> $data['locked']?true:false, 'class'=>'form-control'])!!}
                                <small class="help-block">* Số lượng bản dịch.</small>
                                @if($errors->has("sobandich"))
                                    <div class="alert alert-danger">* {{$errors->first("sobandich")}}</div>
                                @endif
                            </div>
                        </div>
                        <div class="col-sm-5">
                            <div class="form-group">
                                <label for="name">Ngày trả hồ sơ: </label>
                                <div class="row">
                                    <div class='col-xs-8 col-sm-8'>
                                        <div class="input-group">
                                            {!! Form::text('ngaytrahoso',@$data['ngaytrahoso'],[ 'readonly'=> $data['locked']?true:false, 'class'=>'form-control ngaytrahoso'])!!}
                                            <div class="input-group-addon click_datepicker">
                                                <i class="fa fa-calendar"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <div class='col-xs-4 col-sm-4'>
                                        <div class="input-group">
                                            {!! Form::text('giotrahoso',@$data['giotrahoso'],[ 'readonly'=> $data['locked']?true:false, 'class'=>'form-control giotrahoso'])!!}
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
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xs-6 col-sm-6 col-lg-6">
            <div class="card">
                <div class="card-header">
                    <strong> Nhà Cung Cấp: {{$maindata->Supplier()['name']}}   </strong>
                    {!! Form::select('cid_supplier',$cid_supplier,@$data['cid_supplier'],[ 'readonly'=> $data['locked']?true:false, 'class'=>'form-control cid_supplier' ])!!}
                    @if($errors->has("cid_supplier"))
                        <div class="alert alert-danger">* {{$errors->first("cid_supplier")}}</div>
                    @endif
                    <small>Form</small>
                </div>
                <div class="card-body">
                    <div class="row">
                        @if(Auth::user()->roles=='1')
                            <div class="col-sm-10">
                                <div class="form-group">
                                    <h6><span for="name" class="badge  badge-success">Công chứng: </span></h6>
                                    <div class="input-group">
                                        {!! Form::number('congchung_1',@$data['congchung_1'],[ 'readonly'=> $data['locked']?true:false, 'class'=>'form-control my_price_1 element_price_1','id'=>'congchung_1'])!!}
                                        <div class="input-group-addon">
                                            VNĐ
                                        </div>
                                    </div>
                                    <p class='view_myprice'></p>
                                </div>
                            </div>
                            <div class="col-sm-2">
                                <div class="form-group">
                                    <label class="text text-primary">Đã chi</label>
                                    <div class="input-group">
                                        {!!Form::checkbox("approved_cong_chung",2,@$data['approved_cong_chung'],[ 'readonly'=> $data['locked']?true:false, 'class'=>"has_da_chi"])!!}
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-10">
                                <div class="form-group">
                                    <h6><span for="name" class="badge  badge-success">Dấu công ty: </span></h6>
                                    <div class="input-group">
                                        {!! Form::number('daucongty_1',@$data['daucongty_1'],[ 'readonly'=> $data['locked']?true:false, 'class'=>'form-control my_price_1 element_price_1','id'=>'daucongty_1'])!!}
                                        <div class="input-group-addon">
                                            VNĐ
                                        </div>
                                    </div>
                                    <p class='view_myprice'></p>
                                </div>
                            </div>
                            <div class="col-sm-2">
                                <div class="form-group">
                                    <label class="text text-primary">Đã chi</label>
                                    <div class="input-group">
                                        {!!Form::checkbox("approved_dau_cong_ty",2,@$data['approved_dau_cong_ty'],[ 'readonly'=> $data['locked']?true:false, 'class'=>"has_da_chi"])!!}
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-10">
                                <div class="form-group">
                                    <h6><span for="name" class="badge  badge-success">Sao y: </span></h6>
                                    <div class="input-group">
                                        {!! Form::number('saoy_1',@$data['saoy_1'],[ 'readonly'=> $data['locked']?true:false, 'class'=>'form-control my_price_1 element_price_1','id'=>'saoy_1'])!!}
                                        <div class="input-group-addon">
                                            VNĐ
                                        </div>
                                    </div>
                                    <p class='view_myprice'></p>
                                </div>
                            </div>
                            <div class="col-sm-2">
                                <div class="form-group">
                                    <label class="text text-primary">Đã chi</label>
                                    <div class="input-group">
                                        {!!Form::checkbox("approved_sao_y",2,@$data['approved_sao_y'],[ 'readonly'=> $data['locked']?true:false, 'class'=>"has_da_chi"])!!}
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-10">
                                <div class="form-group">
                                    <h6><span for="name" class="badge  badge-success">Ngoại vụ: </span></h6>
                                    <div class="input-group">
                                        {!! Form::number('ngoaivu_1',@$data['ngoaivu_1'],[ 'readonly'=> $data['locked']?true:false, 'class'=>'form-control my_price_1 element_price_1','id'=>'ngoaivu_1'])!!}
                                        <div class="input-group-addon">
                                            VNĐ
                                        </div>
                                    </div>
                                    <p class='view_myprice'></p>
                                </div>
                            </div>
                            <div class="col-sm-2">
                                <div class="form-group">
                                    <label class="text text-primary">Đã chi</label>
                                    <div class="input-group">
                                        {!!Form::checkbox("approved_ngoai_vu",2,@$data['approved_ngoai_vu'],[ 'readonly'=> $data['locked']?true:false, 'class'=>"has_da_chi"])!!}
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-10">
                                <div class="form-group">
                                    <h6><span for="name" class="badge  badge-success">Phí vận chuyện: </span></h6>
                                    <div class="input-group">
                                        {!! Form::number('phivanchuyen_1',@$data['phivanchuyen_1'],[ 'readonly'=> $data['locked']?true:false, 'class'=>'form-control my_price_1 element_price_1','id'=>'phivanchuyen_1'])!!}
                                        <div class="input-group-addon">
                                            VNĐ
                                        </div>
                                    </div>
                                    <p class='view_myprice'></p>
                                </div>
                            </div>
                            <div class="col-sm-2">
                                <div class="form-group">
                                    <label class="text text-primary">Đã chi</label>
                                    <div class="input-group">
                                        {!!Form::checkbox("approved_phi_van_chuyen",2,@$data['approved_phi_van_chuyen'],[ 'readonly'=> $data['locked']?true:false, 'class'=>"has_da_chi"])!!}
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-10">
                                <div class="form-group">
                                    <h6><span for="name" class="badge  badge-success">Vat:   </span></h6>
                                    <div class="input-group">
                                        {!! Form::number('vat_1',@$data['vat_1'],[ 'readonly'=> $data['locked']?true:false, 'class'=>'form-control my_price_1 element_price_1'])!!}
                                        <div class="input-group-addon">
                                            VNĐ
                                        </div>
                                    </div>
                                    <p class='view_myprice'></p>
                                </div>
                            </div>
                            <div class="col-sm-2">
                                <div class="form-group">
                                    <label class="text text-primary">Đã chi</label>
                                    <div class="input-group">
                                        {!!Form::checkbox("approved_vat",2,@$data['approved_vat'],[ 'readonly'=> $data['locked']?true:false, 'class'=>"has_da_chi"])!!}
                                    </div>
                                </div>
                            </div>
                        @endif
                        <div class="col-sm-9">
                            <div class="form-group">
                                <h6><span for="name" class="badge  badge-primary">Phí dịch vụ:  </span></h6>
                                <div class="input-group">
                                    {!! Form::number('tong_1',@$data['tong_1'],[ 'readonly'=> $data['locked']?true:false, 'class'=>'form-control total_price_1','id'=>'tong_1'])!!}
                                    <div class="input-group-addon">
                                        VNĐ
                                    </div>
                                </div>
                                <p class='view_myprice'></p>
                            </div>
                        </div>
                        <div class="col-sm-3  text-center">
                            {{--                            <div class="form-group mt-3">--}}
                            {{--                                <label class="text text-primary">--}}
                            {{--                                    <strong> Đã chi đầy đủ </strong>--}}
                            {{--                                </label>--}}
                            {{--                                <div class='input-group text-center'>--}}
                            {{--                                    <input {{($data['approved_1']=='2')?'checked="checked"':''}} name="approved_1"--}}
                            {{--                                           type="checkbox" value="1" id='approved_1' style="margin: auto">--}}
                            {{--                                </div>--}}
                            {{--                            </div>--}}
                        </div>
                        <div class="col-sm-10 view_approved_1" style="{{($data['approved_1']=='1')?'display:none':''}}">
                            <div class="form-group">
                                <h6><span for="name" class="badge  badge-danger">Người nhận tiền  </span></h6>
                                <div class="input-group">
                                    {!! Form::text('nguoinhantien_1',@$data['nguoinhantien_1'],[ 'readonly'=> $data['locked']?true:false, 'class'=>'form-control ','id'=>''])!!}
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-10">
                            <div class="form-group">
                                <label>Ghi chú để xuất ra file pdf:</label>
                                {!! Form::textarea('ghichu',@$data['ghichu'],[ 'readonly'=> $data['locked']?true:false, 'class'=>'form-control ','rows'=>'4`'])!!}
                            </div>
                        </div>
                        <div class="container row mt-3 border-top">
                            <div class="col-sm-9">
                                <div class="form-group">
                                    <h6><span for="name" class="badge  badge-danger">Phí dịch thuật: </span></h6>
                                    <div class="input-group">
                                        {!! Form::number('phidichthuat_1',@$data['phidichthuat_1'],[ 'readonly'=> $data['locked']?true:false, 'class'=>'form-control   phidichthuat_1  element_price','id'=>'phidichthuat_1'])!!}
                                        <div class="input-group-addon">
                                            VNĐ
                                        </div>
                                    </div>
                                    <p class='view_myprice'></p>
                                </div>
                            </div>
                            <div class="col-sm-3 mt-2">
                                <div class="form-group">
                                    <label class="text text-primary">Đã chi phí dịch thuật</label>
                                    <div class="text-center">

                                        {!!Form::checkbox("approved_2",2,@$data['approved_2'],[ 'readonly'=> $data['locked']?true:false, 'class'=>"has_da_chi"])!!}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xs-6 col-sm-6 col-lg-6">
            <div class="card">
                <div class="card-header">
                    <strong> Khách Hàng: {{$maindata->Customer()['name']}}   </strong>
                    {!! Form::select('cid_customer',$cid_customer,@$data['cid_customer'],[ 'readonly'=> $data['locked']?true:false, 'class'=>'form-control cid_customer'])!!}
                    @if($errors->has("cid_customer"))
                        <div class="alert alert-danger">* {{$errors->first("cid_customer")}}</div>
                    @endif
                    <small>Form</small>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-10">
                            <div class="form-group">
                                <h6><span for="name" class="badge  badge-success">Phí dịch thuật: </span></h6>
                                <div class="input-group">
                                    {!! Form::number('phidichthuat',@$data['phidichthuat'],[ 'readonly'=> $data['locked']?true:false, 'class'=>'form-control my_price element_price','id'=>'phidichthuat'])!!}
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
                                <div class="input-group">
                                    {!! Form::number('congchung',@$data['congchung'],[ 'readonly'=> $data['locked']?true:false, 'class'=>'form-control my_price element_price','id'=>'congchung'])!!}
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
                                <div class="input-group">
                                    {!! Form::number('daucongty',@$data['daucongty'],[ 'readonly'=> $data['locked']?true:false, 'class'=>'form-control my_price element_price','id'=>'daucongty'])!!}
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
                                <div class="input-group">
                                    {!! Form::number('saoy',@$data['saoy'],[ 'readonly'=> $data['locked']?true:false, 'class'=>'form-control my_price element_price','id'=>'saoy'])!!}
                                    <div class="input-group-addon">
                                        VNĐ
                                    </div>
                                </div>
                                <p class='view_myprice'></p>
                            </div>
                        </div>
                        <div class="col-sm-10">
                            <div class="form-group">
                                <h6><span for="name" class="badge  badge-success">Ngoại vụ: </span></h6>
                                <div class="input-group">
                                    {!! Form::number('ngoaivu',@$data['ngoaivu'],[ 'readonly'=> $data['locked']?true:false, 'class'=>'form-control my_price element_price','id'=>'ngoaivu'])!!}
                                    <div class="input-group-addon">
                                        VNĐ
                                    </div>
                                </div>
                                <p class='view_myprice'></p>
                            </div>
                        </div>
                        <div class="col-sm-10">
                            <div class="form-group">
                                <h6><span for="name" class="badge  badge-success">Phí vận chuyện: </span></h6>
                                <div class="input-group">
                                    {!! Form::number('phivanchuyen',@$data['phivanchuyen'],[ 'readonly'=> $data['locked']?true:false, 'class'=>'form-control my_price element_price','id'=>'phivanchuyen'])!!}
                                    <div class="input-group-addon">
                                        VNĐ
                                    </div>
                                </div>
                                <p class='view_myprice'></p>
                            </div>
                        </div>
                        <div class="col-sm-10">
                            <div class="form-group">
                                <h6><span for="name" class="badge  badge-success">Vat:   </span></h6>
                                <div class="input-group">
                                    {!! Form::number('vat',@$data['vat'],[ 'readonly'=> $data['locked']?true:false, 'class'=>'form-control my_price element_price','id'=>'vat'])!!}
                                    <div class="input-group-addon">
                                        VNĐ
                                    </div>
                                </div>
                                <p class='view_myprice'></p>
                            </div>
                        </div>
                        <div class="col-sm-10">
                            <div class="form-group">
                                <h6><span for="name" class="badge  badge-danger">Tổng cộng:  </span></h6>
                                <div class="input-group">
                                    {!! Form::number('tong',@$data['tong'],[ 'readonly'=> $data['locked']?true:false, 'class'=>'form-control total_price','id'=>'tong'])!!}
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
                                <div class="input-group">
                                    {!! Form::number('tamung',@$data['tamung'],[ 'readonly'=> $data['locked']?true:false, 'class'=>'form-control tamung_price','id'=>'tamung'])!!}
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
                                <div class="input-group">
                                    {!! Form::number('conglai',@$data['conglai'],[ 'readonly'=> $data['locked']?true:false, 'class'=>'form-control conglai_price','id'=>'conglai'])!!}
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
                                    <input {{($data['approved']=='2')?'checked="checked"':''}} name="approved"
                                           type="checkbox" value="2" class="approved_check">
                                    <span class="text text-primary"><strong>Đã nhận đầy đủ</strong></span>
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
                @if(isset($data['locked']) && !$data['locked'])
                <button type="submit" class="btn btn-sm btn-primary"><i class="fa fa-save"></i> LƯU</button>
                @endif
                <a href="/admin/index/lists" class="btn btn-sm btn-info">
                    <i class="fa fa-list"></i>
                    DANH SÁCH
                </a>
                <a href="/admin/index/pdf/{{$data['id']}}" class="btn btn-sm btn-dark" target="_black;">
                    <i class="fa fa-file-pdf-o"></i>
                    XUẤT PDF
                </a>
                @if(Auth::user()->roles=='1')
                    <div class="pull-right">
                        @if(isset($data['locked']) && $data['locked'])
                            <a href="/admin/index/unlock/{{$data['id']}}" class="btn btn-sm btn-success"
                               target="_black;">
                                <i class="fa fa-unlock"></i>
                                MỞ KHÓA PHIẾU
                            </a>
                        @else
                            <a href="/admin/index/lock/{{$data['id']}}" class="btn btn-sm btn-warning" target="_black;">
                                <i class="fa fa-lock"></i>
                                KHÓA PHIẾU
                            </a>
                        @endif

                    </div>
                @endif
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
    <link rel="stylesheet" type="text/css" href="/css/flexselect.css">
    <script type="text/javascript">
        $(document).ready(function () {
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
            $(".approved_check").change(function () {
                if ($(this).prop("checked")) {
                    $(".conglai_price").val(0);
                    $(".tamung_price").val(0);
                }
            });
            $("#approved_1").click(function () {
                if ($(this).prop("checked")) {
                    $(".view_approved_1").show();
                    if ($("input").hasClass("has_da_chi")) {
                        $(".has_da_chi").prop("checked", true);
                    }
                } else {
                    $(".view_approved_1").hide();
                    if ($("input").hasClass("has_da_chi")) {
                        $(".has_da_chi").prop("checked", false);
                    }
                }
            });
            $(".has_da_chi").click(function () {
                var is_has = false;
                $(".has_da_chi").each(function () {
                    if ($(this).prop("checked")) {
                        is_has = true;
                    }
                });
                if ($("#approved_1").prop("checked")) {
                    is_has = true;
                }
                if (is_has) {
                    $(".view_approved_1").show();
                } else {
                    $(".view_approved_1").hide();
                }
            });
            $("select.cid_customer").flexselect();
            $("select.cid_supplier").flexselect();

            $('#myMessagerSuccess').modal('show');
        });
    </script>
@endsection
