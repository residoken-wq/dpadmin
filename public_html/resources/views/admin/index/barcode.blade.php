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
            <div class="col-sm-12">
                <div class="form-group">
                    <label for="name">Mã Barcode: </label>
                    {!! Form::text('barcode',@$search['barcode'],['class'=>"form-control",'id'=>'barcode' ]) !!}
                </div>
            </div>

            <div class="col-sm-3">
                <div class="form-group">

                </div>
            </div>
            <div class="col-sm-12">
                <div class="form-group">
                    <button type="submit" class="btn btn-sm btn-warning"><i class="fa fa-ban"></i> TÌM KIẾM</button>
                </div>
            </div>
        </div>


        {!! Form::close()!!}


        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <i class="fa fa-align-justify"></i> Danh Sách Phiếu:
                    </div>
                    <div class="card-block">
                        <table class="table table-sm  table-bordered table-striped dataTable">
                            <thead>
                            <tr>
                                <th>Mã Phiếu</th>
                                <th> Thông tin</th>


                                <th> TT Phiếu</th>
                                <th> TT NCC</th>
                                <th> TT KH</th>
                                <th> Tuỳ chọn</th>
                                <th> NCC</th>
                                <th> KH</th>
                                <th class="text-center">
                                    [Đã nhận All] NCC
                                    <input type="checkbox" name="" class="check_all">
                                </th>
                                <th class="text-center">
                                    [Đã nhận All] KH
                                    <input type="checkbox" name="" class="check_all_kh">
                                </th>
                            </tr>
                            </thead>
                            <?php $s = $k = $tt_kh = 0;?>
                            <tbody>
                            @foreach($data_list as $list)

                                <tr>
                                    <td>{{$list['code']}}</td>
                                    <td>
                                        Tên Khách: {{ $list->Customer()->name }} <br/>
                                        Tên Trong Hồ Sơ: {{ $list['name_docs'] }}<br/>
                                        Tài liệu: {{ $list['name'] }}
                                    </td>


                                    <td>
                                        @if($list['approved']=='1')
                                            <label style="font-size:10px;" class="badge badge-secondary ajax_pending"
                                                   idx="{{$list['id']}}">PENDING</label>
                                        @endif
                                        @if($list['approved']=='2')
                                            <label style="font-size:10px;" class="badge badge-success">DONE</label>
                                        @endif

                                        <br/>

                                        Tổng: {{App\MrData::toPrice((int)$list->OrderSupplier()[0]['tong']+(int)$list->OrderCustomer()[0]['tong'])}}

                                    </td>
                                    <td>
                                        @php
                                            $is_delete = true;
                                            $total_ncc = (int)$list->OrderSupplier()[0]['tong'];
                                        @endphp
                                        @foreach($list->OrderSupplier() as $OrderSupplier)
                                            @if($OrderSupplier['approved']=='2' && $OrderSupplier['approved_2']=='2')
                                                <?php $is_delete = false;?>
                                                <label style="font-size:10px;" class="badge badge-success">DONE</label>
                                            @else
                                                <label style="font-size:10px;"
                                                       class="badge badge-secondary">PENDING</label>
                                            @endif
                                        @endforeach
                                        <br/>
                                        Tổng: {{ App\MrData::toPrice($total_ncc) }}
                                    </td>
                                    <td>
                                        @foreach($list->OrderCustomer() as $OrderCustomer)
                                            @if($OrderCustomer['approved']=='1')
                                                <label style="font-size:10px;"
                                                       class="badge badge-secondary">PENDING</label>
                                            @endif
                                            @if($OrderCustomer['approved']=='2')
                                                <?php $is_delete = false;?>
                                                <label style="font-size:10px;" class="badge badge-success">DONE</label>
                                            @endif
                                        @endforeach
                                        <br/>
                                        @php
                                            $total_ttkh = (int)$list->OrderCustomer()[0]['tong']-(int)$list->OrderCustomer()[0]['tamung'];
                                        @endphp
                                        Tổng: {{ App\MrData::toPrice($total_ttkh) }}
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

                                        <br/>

                                    </td>
                                    <td>
                                        @if((int)$list->OrderSupplier()[0]['approved']==1)
                                            <a style="font-size:12px;padding: 2px  "
                                               class="btn btn-xs btn-primary approvedcustomer_click "
                                               href='/admin/index/approvedsupplier/<?php echo $list['id'];?>&_token={{csrf_token()}}'
                                               target="_black"> <i class="fa fa-check"></i> Đã nhận </a>


                                        @endif

                                    </td>
                                    <td>
                                        @if((int)$list->OrderCustomer()[0]['approved']==1)
                                            <a style="font-size:12px;padding: 2px  "
                                               class="btn btn-xs btn-info approvedcustomer_click "
                                               href='/admin/index/approvedcustomer/<?php echo $list['id'];?>&_token={{csrf_token()}}'
                                               target="_black"> <i class="fa fa-check"></i> Đã nhận </a>
                                        @endif

                                    </td>
                                    <td class="text-center">
                                        @if( (int)$list->OrderSupplier()[0]['approved']==1)
                                            <input type="checkbox"
                                                   ncc='/admin/index/approvedsupplier/<?php echo $list['id'];?>&_token={{csrf_token()}}'
                                                   class="list_check_box" idx="{{$list['id']}}"/>
                                        @endif
                                    </td>

                                    <td class="text-center">
                                        @if((int)$list->OrderCustomer()[0]['approved']==1 )
                                            <input type="checkbox"
                                                   kh='/admin/index/approvedcustomer/<?php echo $list['id'];?>&_token={{csrf_token()}}'

                                                   class="list_check_box_kh" idx="{{$list['id']}}"/>
                                        @endif
                                    </td>
                                </tr>

                                @php
                                    $s = $s + (int)$list->OrderSupplier()[0]['tong'];
                                    $k = $k + (int)$list->OrderCustomer()[0]['tong'];
                                    $tt_kh = $tt_kh + $total_ttkh;
                                @endphp
                                @endforeach
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td>
                                        <strong>{{App\MrData::toPrice($k+$s)}}</strong>
                                    </td>
                                    <td>
                                        <strong>{{App\MrData::toPrice($s)}}</strong>
                                    </td>
                                    <td>
                                        <strong>{{App\MrData::toPrice($tt_kh)}}</strong>
                                    </td>
                                    <td></td>
                                    <td></td>
                                    <td></td>


                                    <td>

                                        <input style="width: 80px;padding: 0px" type="button" name=""
                                               value="Đã nhận NCC"
                                               class="click_action_all btn btn-sm btn-danger">

                                    </td>

                                    <td>

                                        <input style="width: 80px;padding: 0px" type="button" name="" value="Đã nhận KH"
                                               class="click_action_all_kh btn btn-sm btn-danger">

                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <nav>


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
            <script src="/js/tag.js"></script>
            <link rel="stylesheet" type="text/css" href="/css/flexselect.css">
            <link rel="stylesheet" type="text/css" href="/js/tag.css">
            <script type="text/javascript">
                $("document").ready(function () {
                    $(".check_all").change(function () {
                        if ($(this).prop("checked")) {
                            $(".list_check_box").prop("checked", true);
                        } else {
                            $(".list_check_box").prop("checked", false);
                        }
                    });
                    $(".click_action_all").click(function () {
                        if (confirm("Nhà cung cấp - Phiếu này đã nhận đầy đủ các Phiếu đã click chọn.? ")) {
                            $(".list_check_box").each(function () {
                                if ($(this).prop("checked")) {
                                    $(this).parent().html("<p class='text text-danger'>Loading....</p>");
                                    $.get($(this).attr("ncc"), function () {
                                    });
                                    //  $.get($(this).attr("kh"),function(){});
                                }
                            });
                            $(document).ajaxComplete(function () {
                                window.location.href = window.location.href;
                            });


                        }
                        return false;
                    });


                    $(".check_all_kh").change(function () {
                        if ($(this).prop("checked")) {
                            $(".list_check_box_kh").prop("checked", true);
                        } else {
                            $(".list_check_box_kh").prop("checked", false);
                        }
                    });
                    $(".click_action_all_kh").click(function () {
                        if (confirm("Khách hàng - Phiếu này đã nhận đầy đủ các Phiếu đã click chọn.? ")) {
                            $(".list_check_box_kh").each(function () {
                                if ($(this).prop("checked")) {
                                    $(this).parent().html("<p class='text text-danger'>Loading....</p>");

                                    $.get($(this).attr("kh"), function () {
                                    });
                                }
                            });
                            $(document).ajaxComplete(function () {
                                window.location.href = window.location.href;
                            });


                        }
                        return false;
                    });
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

                    $(".approvedcustomer_click").click(function () {
                        if (confirm("Phiếu này đã nhận đầy đủ? ")) {

                            $.get($(this).attr("href"), function () {

                                window.location.href = window.location.href;
                            });

                        }
                        return false;
                    });


                    $('#barcode').tagsinput({
                        maxTags: 201
                    });


                });
            </script>

@endsection
