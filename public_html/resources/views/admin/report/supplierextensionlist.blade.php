@extends("admin.admin")
@section('content')

    <ol class="breadcrumb">
        <li class="breadcrumb-item"> Trang chủ</li>
        <li class="breadcrumb-item"><a href="">Phiếu dịch của NCC PHÍ DỊCH THUẬT : {{$supplier['name']}}</a>
        </li>


    </ol>


    <div class="container-fluid">
        {!! Form::open(['method'=>'post',"url"=>url()->full()]) !!}

        <br/>

        <div class="row view_search">


            <div class="col-sm-12">
                <div class="form-group">

                    <button type="submit" class="btn btn-sm btn-success" name='export' value='excel'><i
                                class="fa fa-export"></i> EXPORT EXCEL
                    </button>
                    <button type="submit" class="btn btn-sm btn-primary" name='pdf' value='pdf'><i
                                class="fa fa-export"></i> EXPORT PDF
                    </button>
                </div>
            </div>

        </div>


        {!! Form::close()!!}


        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <i class="fa fa-align-justify"></i> Phiếu dịch của NCC:: {{$supplier['name']}} <span
                                class="badge badge-pill badge-danger"> {{$data_list->total()}}</span>
                    </div>
                    <div class="card-block">
                        <table class="table table-sm  table-bordered table-striped dataTable">
                            <thead>
                            <tr>
                                <th>Mã Phiếu</th>
                                <th>Tên Khách</th>
                                <th>Tên Trong Hồ Sơ</th>
                                <th> Tài liệu</th>


                                <th> TT NCC</th>
                                <th> Tổng tiền</th>
                                <th> Tuỳ chọn</th>
                                <th> Đã chi đầy đủ</th>
                                <th class="text-center">
                                    <input type="checkbox" name="" class="check_all">
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php $t1 = 0;
                            foreach($data_list as $list):?>

                            <tr>
                                <td><?php echo $list['code'];?></td>
                                <td><?php echo $list->Customer()->name;?></td>

                                <td><?php echo $list['name_docs'];?></td>
                                <td><?php echo $list['name'];?></td>

                                <td>
                                    <?php $is_delete = true;?>
                                    @foreach($list->OrderSupplier() as $OrderSupplier)

                                        @if($OrderSupplier['approved']=='2' && $OrderSupplier['approved_2']=='2')
                                            <?php $is_delete = false;?>
                                            <label style="font-size:10px;" class="badge badge-success">DONE</label>
                                        @else
                                            <label style="font-size:10px;" class="badge badge-secondary">PENDING</label>

                                        @endif
                                    @endforeach
                                </td>
                                <td><?php
                                    $t1 = $t1 + (int)$list->OrderSupplier()[0]['phidichthuat'];
                                    echo App\MrData::toPrice($list->OrderSupplier()[0]['phidichthuat']);?></td>

                                <td>


                                    <a style="font-size:12px;padding: 2px " class="btn btn-xs btn-success"
                                       href='/admin/index/edit/<?php echo $list['id'];?>'><i class="fa fa-edit"></i> Sửa
                                    </a>


                                    <a style="font-size:12px;padding: 2px  " class="btn btn-xs btn-secondary "
                                       href='/admin/index/pdf/<?php echo $list['id'];?>&_token={{csrf_token()}}'
                                       target="_black"> <i class="fa fa-remove"></i>PDF</a>


                                    <br/>

                                </td>
                                <td>

                                    <a style="font-size:12px;padding: 2px  "
                                       class="btn btn-xs btn-primary approvedcustomer_click "
                                       href='/admin/index/approvedsupplierextension/<?php echo $list['id'];?>&_token={{csrf_token()}}'
                                       target="_black"> <i class="fa fa-check"></i> Đã chi</a>

                                </td>

                                <td class="text-center">
                                    <input type="checkbox"
                                           value='/admin/index/approvedsupplierextension/<?php echo $list['id'];?>&_token={{csrf_token()}}'
                                           class="list_check_box" idx="{{$list['id']}}"/>
                                </td>
                            </tr>

                            <?php endforeach;?>
                            <tr>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td>
                                    <strong>
                                        <?php

                                        echo App\MrData::toPrice($t1);?>
                                    </strong>
                                </td>
                                <td>
                                </td>
                                <td>
                                </td>
                                <td>

                                    <input style="width: 63px;padding: 0px" type="button" name="" value="Đã nhận"
                                           class="click_action_all btn btn-sm btn-danger">

                                </td>

                            </tr>
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
                    $(".check_all").change(function () {
                        if ($(this).prop("checked")) {
                            $(".list_check_box").prop("checked", true);
                        } else {
                            $(".list_check_box").prop("checked", false);
                        }
                    });
                    $(".click_action_all").click(function () {
                        if (confirm("Phiếu này đã nhận đầy đủ các Phiếu đã click chọn.? ")) {
                            $(".list_check_box").each(function () {
                                if ($(this).prop("checked")) {
                                    $(this).parent().html("<p class='text text-danger'>Loading....</p>");
                                    $.get($(this).val(), function () {
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
                    $(".approvedcustomer_click").click(function () {
                        if (confirm("Phiếu này đã nhận đầy đủ? ")) {
                            $.get($(this).attr("href"), function () {
                                window.location.href = window.location.href;
                            });

                        }
                        return false;
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
                        <?php if(!$access_token):?>
                        window.open("/admin/index/ajaxone");
                        <?php endif;?>



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
