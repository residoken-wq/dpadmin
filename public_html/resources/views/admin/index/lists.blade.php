@extends("admin.admin")
@section('content')
    <ol class="breadcrumb">
        <li class="breadcrumb-item"> Trang chủ</li>
        <li class="breadcrumb-item"><a href="">Quản lý phiếu dịch </a>
        </li>
    </ol>
    <div class="container-fluid">
        {!! Form::open(['method'=>'get']) !!}
        <div class="row view_search">
            <div class="col-sm-3">
                <div class="form-group">
                    <label for="name">Tên Trong Hồ Sơ: </label>
                    {!! Form::text('name_docs',@$search['name_docs'],['class'=>"form-control" ]) !!}
                </div>
            </div>
            <div class="col-sm-3">
                <div class="form-group">
                    <label for="name">Trạng Thái Phiếu: </label>
                    {!! Form::select('approved',$approved,@$search['approved'],['class'=>"form-control select_flex" ]) !!}
                </div>
            </div>
            <div class="col-sm-3">
                <div class="form-group">
                    <label for="name"> Tên Khách hàng </label>
                    {!! Form::select('cid_customer',$cid_customer,@$search['cid_customer'],['class'=>"form-control select_flex" ]) !!}
                </div>
            </div>
            <div class="col-sm-3">
                <div class="form-group">
                    <label for="name"> Tên Nhà Cung Cấp </label>
                    {!! Form::select('cid_supplier',$cid_supplier,@$search['cid_supplier'],['class'=>"form-control select_flex" ]) !!}
                </div>
            </div>
            <div class="col-sm-3">
                <div class="form-group">
                    {!! Form::text('cid_id',@$search['cid_id'],['class'=>"form-control" ,'placeholder'=>'Barcode']) !!}
                </div>
            </div>
            <div class="col-sm-3">
                <div class="form-group">
                    <button type="submit" class="btn btn-sm btn-info"><i class="fa fa-search"></i> TÌM KIẾM</button>
                    <?php /*$url=$_SERVER['REQUEST_URI'];
                                $get_request=explode("?", $url);
                                $u = (!empty($get_request[1]))? "?".$get_request[1] : "" ;
                            /admin/supplier/export{{$u}}
                                */
                    ?>
                </div>
            </div>
        </div>
        {!! Form::close()!!}
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <i class="fa fa-align-justify"></i> Danh Sách Phiếu <span
                                class="badge badge-pill badge-danger"> {{$data_list->total()}}</span>
                    </div>
                    <div class="card-block">
                        <table class="table table-sm table-bordered table-striped dataTable">
                            <thead>
                            <tr>
                                <th>Mã Phiếu</th>
                                <th>Tên Khách</th>
                                <th>Tên Trong Hồ Sơ</th>
                                <th>Tài liệu</th>
                                <th>Số điện thoại</th>
                                <th>Ngày trả hồ sơ</th>
                                <th>Người tạo</th>
                                <th>TT Phiếu</th>
                                <th>TT NCC</th>
                                <th>TT KH</th>
                                <th>Tuỳ chọn</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($data_list as $list):
                                $OrderSupplier = $list->ordersuppliers;
                                ?>


                            <tr>
                                <td><?php echo $list['code']; ?></td>
                                <td><?php echo $list->Customer()->name; ?></td>
                                <td><?php echo $list['name_docs']; ?></td>
                                <td><?php echo $list['name']; ?>
                                    @if($list['approved']=='2')
                                        <label style="font-size:10px;" class="badge badge-success">DONE</label>
                                    @endif
                                    @if($list['approved']=='1')
                                        <div><label style="font-size:10px;" class="badge badge-secondary ajax_pending"
                                                    idx="{{$list['id']}}"
                                                    data-toggle="tooltip"><i
                                                        class="fa fa-circle text-secondary"></i></label>
                                        </div>
                                    @endif
                                </td>
                                <td><?php echo $list['phone']; ?></td>
                                <td><?php echo $list['ngaytrahoso']; ?></td>
                                <td><?php echo $list->User()['name']; ?></td>
                                <td>
                                    {{ App\MrData::toPricePrint($OrderSupplier->tong) }}
                                </td>
                                <td>
                                        <?php $is_delete = true; ?>
                                    @if($OrderSupplier['approved']=='2' && $OrderSupplier['approved_2']=='2')
                                            <?php $is_delete = false; ?>
                                        <div><label style="font-size:10px;" class="badge badge-success"
                                                    data-toggle="tooltip" title="DONE"><i
                                                        class="fa fa-circle text-success"></i></label> {{ App\MrData::toPricePrint($OrderSupplier->phidichthuat) }}
                                        </div>
                                    @else
                                        <div><label style="font-size:10px;" class="badge badge-secondary"
                                                    data-toggle="tooltip" title="PENDING"><i
                                                        class="fa fa-circle text-secondary"></i></label> {{ App\MrData::toPricePrint($OrderSupplier->phidichthuat) }}
                                        </div>
                                    @endif
                                </td>
                                <td>
                                    @foreach($list->OrderCustomer() as $OrderCustomer)
                                        @if($OrderCustomer['approved']=='1')
                                            <div><label style="font-size:10px;" class="badge badge-secondary"
                                                        data-toggle="tooltip" title="PENDING"><i
                                                            class="fa fa-circle text-secondary"></i></label> {{ App\MrData::toPricePrint($list->tong) }}
                                            </div>
                                        @endif
                                        @if($OrderCustomer['approved']=='2')
                                                <?php $is_delete = false; ?>
                                            <div><label style="font-size:10px;" class="badge badge-success"
                                                        data-toggle="tooltip" title="DONE"><i
                                                            class="fa fa-circle text-success"></i></label> {{  App\MrData::toPricePrint($list->tong) }}
                                            </div>
                                        @endif
                                    @endforeach
                                </td>
                                <td>
                                    <a style="font-size:12px;padding: 2px " class="btn btn-xs btn-success"
                                       href='/admin/index/edit/<?php echo $list['id'];?>' target="_black"><i
                                                class="fa fa-edit"></i> Sửa </a>
                                    <a style="font-size:12px;padding: 2px  " class="btn btn-xs btn-secondary "
                                       href='/admin/index/pdf/<?php echo $list['id'];?>&_token={{csrf_token()}}'
                                       target="_black"> <i class="fa fa-remove"></i>PDF</a>
                                    @if($list['approved']=='1' && $is_delete)
                                        <a style="font-size:12px;padding: 2px 2px"
                                           class="btn btn-xs btn-danger click_remove "
                                           href='/admin/index/removed/<?php echo $list['id'];?>?_token={{csrf_token()}}'
                                           target="_black"> <i class="fa fa-remove"></i> REMOVE </a>
                                    @endif
                                    @if(Auth::user()->roles=='1')
                                        @if(isset($list['locked']) && $list['locked'])
                                            <a href="/admin/index/unlock/{{$list['id']}}"
                                               style="font-size:12px;padding: 2px " data-toggle="tooltip"
                                               title="Chọn để Mở khóa phiếu" class="btn btn-xs btn-success"
                                               target="_black;">
                                                <i class="fa fa-unlock"></i>
                                            </a>
                                        @else
                                            <a href="/admin/index/lock/{{$list['id']}}"
                                               style="font-size:12px;padding: 2px " data-toggle="tooltip"
                                               title="Chọn để Khóa phiếu" class="btn btn-xs btn-warning"
                                               target="_black;">
                                                <i class="fa fa-lock"></i>
                                            </a>
                                        @endif
                                    @endif
                                    <br/>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                        <nav>
                            {!! $data_list->appends($search)->render() !!}
                        </nav>
                    </div>
                </div>
            </div>
            <!--/.col-->
        </div>
        @endsection
        @section('script_js')
            <script src="/js/jquery.flexselect.js"></script>
            <script src="/js/liquidmetal.js"></script>
            <link rel="stylesheet" type="text/css" href="/css/flexselect.css">
            <script type="text/javascript">
                $("document").ready(function () {

                    $('[data-toggle="tooltip"]').tooltip();

                    $(".click_view_search").click(function () {
                        $(".view_search").show();
                        $(this).hide();
                    });
                    $(".click_reset_form").click(function () {
                        $(".view_search").hide();
                        $(".click_view_search").show();
                    });

                    function load_pending() {
                        $(".ajax_pending").each(function () {
                            var th = $(this);
                            $(th).parent().append("<div class='my-loading' style='font-size:10px;font-weight:bold'>Loading...<div>");
                            $.get("/admin/index/ajaxthree/" + $(this).attr("idx"), function (result) {
                                $(th).parent().children('.my-loading').remove();
                                if (Number.isInteger(result * 1)) {
                                    $(th).html("Pending: " + result + "%");
                                } else {
                                    if (result == '100%') {
                                        $(th).removeClass('badge-secondary').addClass('badge-success').html("DONE");
                                    }
                                }
                            });
                        });
                    }

                    if ($("label").hasClass("ajax_pending")) {
                        <?php
                        if (!$access_token):
                            ?>
                        window.open("/admin/index/ajaxone");
                        <?php endif; ?>
                            window.onbeforeunload = load_pending();
                    }
                    $("select.select_flex").flexselect();
                    // $("select.cid_supplier").flexselect();
                    /* $.ajax({
                         url:"/admin/index/ajaxone",
                         type:"get",
                         success:function(r){
                             if(r.trim()=='success'){
                                 load_pending();
                             }
                         },
                         error:function(e){
                             console.log(e);
                         }
                     });*/
                });
            </script>
@endsection
