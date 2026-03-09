@extends("admin.admin")
@section('content')

    <ol class="breadcrumb">
        <li class="breadcrumb-item"> Trang chủ</li>
        <li class="breadcrumb-item"><a href="">Quản lý Công nợ của NCC PHÍ DỊCH VỤ </a>
        </li>


    </ol>


    <div class="container-fluid">
        {!! Form::open(['method'=>'get']) !!}


        <div class="row view_search">

            <div class="col-sm-3">
                <div class="form-group">
                    <label for="name">Tên NCC: </label>
                    {!! Form::select('cid_supplier',$cid_supplier,@$search['cid_supplier'],['class'=>"form-control cid_supplier" ]) !!}

                </div>
            </div>

            <div class="col-sm-3">
                <div class="form-group">
                    <label for="name">Từ Ngày </label>
                    {!! Form::text('date_from',@$search['date_from'],['class'=>"form-control" ,'id'=>"from","autocomplete"=>"off"]) !!}

                </div>
            </div>
            <div class="col-sm-3">
                <div class="form-group">
                    <label for="name">Đến Ngày </label>
                    {!! Form::text('date_to',@$search['date_to'],['class'=>"form-control" ,'id'=>'to',"autocomplete"=>"off"]) !!}

                </div>
            </div>
            <div class="col-sm-3">
                <div class="form-group">
                    <label for="name">Sắp xếp : </label>
                    {!! Form::select('cid_sort',$cid_sort,@$search['cid_sort'],['class'=>"form-control cid_sort" ]) !!}

                </div>
            </div>

            <div class="col-sm-12">
                <div class="form-group">
                    <button type="submit" class="btn btn-sm btn-primary"><i class="fa fa-search"></i> TÌM KIẾM</button>
                    <?php /*$url=$_SERVER['REQUEST_URI'];
                                $get_request=explode("?", $url);
                                $u = (!empty($get_request[1]))? "?".$get_request[1] : "" ;
                            /admin/supplier/export{{$u}}
                                */
                    ?>
                    <button type="submit" class="btn btn-sm btn-success" name='export' value='excel'><i
                                class="fa fa-file-excel-o"></i> EXPORT EXCEL
                    </button>
                </div>
            </div>

        </div>


        {!! Form::close()!!}


        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <i class="fa fa-align-justify"></i> Danh Sách Công nợ của
                        NCC: {{App\MrData::toPrice($tongso['total'])}} <span
                                class="badge badge-pill badge-danger"> {{$data_list->total()}}</span>
                    </div>
                    <div class="card-block">
                        <table class="table table-sm  table-bordered table-striped dataTable">
                            <thead>
                            <tr>

                                <th>Tên NCC</th>
                                <th> Công nợ</th>
                                <th> Ngày tạo phiếu</th>
                                <th> Tuỳ chọn</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach($data_list as $list):?>

                            <tr>

                                <td><?php echo $list->Supplier()['name'];?></td>

                                <td><?php echo App\MrData::toPrice($list['total']);?></td>

                                <td><?php echo $list['created_at'];?></td>


                                <td>


                                    <?php $uu = [];
                                    foreach ($search as $k => $v) {
                                        $uu[] = "$k=$v";
                                    }

                                    ?>
                                    <a style="font-size:12px;padding: 2px " target="_black"
                                       class="btn btn-xs btn-success"
                                       href='/admin/report/supplierlist/<?php echo $list['cid_supplier'];?>?<?php echo implode("&", $uu)?>'><i
                                                class="fa fa-edit"></i> Danh sách Phiêu </a>


                                    <br/>

                                </td>

                            </tr>

                            <?php endforeach;?>

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
            <script type="text/javascript" src="/admin/bower_components/time-picker/dist/time-picker.js"></script>
            <script type="text/javascript" src="/admin/bower_components/jqueryui-datepicker/datepicker.js"></script>

            <link rel="stylesheet" type="text/css" href="/admin/bower_components/jqueryui-datepicker/datepicker.css">
            <link rel="stylesheet" type="text/css" href="/admin/bower_components/time-picker/dist/time-picker.css">

            <script src="/js/jquery.flexselect.js"></script>
            <script src="/js/liquidmetal.js"></script>
            <link rel="stylesheet" type="text/css" href="/css/flexselect.css">
            <script type="text/javascript">
                $("document").ready(function () {
                    $(".click_view_search").click(function () {

                        $(".view_search").show();
                        $(this).hide();
                    });
                    $(".click_reset_form").click(function () {
                        $(".view_search").hide();
                        $(".click_view_search").show();
                    });


                    $("select.cid_supplier").flexselect();
                    $.datepicker.setDefaults($.datepicker.regional["fr"]);

                    var dateFormat = "mm/dd/yy",
                        from = $("#from")
                            .datepicker({
                                defaultDate: "-2w",
                                changeMonth: true,
                                numberOfMonths: 3

                            })
                            .on("change", function () {
                                to.datepicker("option", "minDate", getDate(this));
                            }),
                        to = $("#to").datepicker({
                            defaultDate: "-2w",
                            changeMonth: true,
                            numberOfMonths: 3

                        })
                            .on("change", function () {
                                from.datepicker("option", "maxDate", getDate(this));
                            });

                    function getDate(element) {
                        var date;
                        try {
                            date = $.datepicker.parseDate(dateFormat, element.value);
                        } catch (error) {
                            date = null;
                        }

                        return date;
                    }


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
