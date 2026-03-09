<?php $__env->startSection('content'); ?>

    <ol class="breadcrumb">
        <li class="breadcrumb-item"> Trang chủ</li>
        <li class="breadcrumb-item"><a href="">Quản lý Công nợ của Khách Hàng </a>
        </li>
    </ol>


    <div class="container-fluid">
        <?php echo Form::open(['method'=>'get']); ?>

        <div class="row view_search">
            <div class="col-sm-4">
                <div class="form-group">
                    <label for="name">Loại KH: </label>
                    <?php echo Form::select('is_customer',$is_customer,@$search['is_customer'],['class'=>"form-control is_customer" ]); ?>

                </div>
            </div>
            <div class="col-sm-4">
                <div class="form-group">
                    <label for="name">Tên KH: </label>
                    <?php echo Form::select('cid_customer',$cid_customer,@$search['cid_customer'],['class'=>"form-control cid_customer" ]); ?>


                </div>
            </div>
            <div class="col-sm-4">
                <div class="form-group">
                    <label for="name">Tên KH Lẻ: </label>
                    <?php echo Form::select('cid_customer_kl',$cid_customer_kl,@$search['cid_customer_kl'],['class'=>"form-control cid_customer" ]); ?>

                </div>
            </div>
            <div class="col-sm-2">
                <div class="form-group">
                    <label for="name">Từ Ngày </label>
                    <?php echo Form::text('date_from',@$search['date_from'],['class'=>"form-control" ,'id'=>"from","autocomplete"=>"off"]); ?>


                </div>
            </div>
            <div class="col-sm-2">
                <div class="form-group">
                    <label for="date_to">Đến Ngày </label>
                    <?php echo Form::text('date_to',@$search['date_to'],['class'=>"form-control" ,'id'=>'to',"autocomplete"=>"off"]); ?>


                </div>
            </div>
            <div class="col-sm-3">
                <div class="form-group">
                    <label for="ngaytrahoso">Ngày trả hồ sơ</label>
                    <?php echo Form::text('ngaytrahoso',@$search['ngaytrahoso'],['class'=>"form-control" ,'id'=>'ngaytrahoso',"autocomplete"=>"off"]); ?>


                </div>
            </div>
            <div class="col-sm-2">
                <div class="form-group">
                    <label for="buoi">Lọc theo Buổi</label>
                    <?php echo Form::select('cid_buoi',$cid_listbuoi,@$search['cid_buoi'],['class'=>"form-control" ,'id'=>'cid_buoi',"autocomplete"=>"off"]); ?>


                </div>
            </div>
            <div class="col-sm-3">
                <div class="form-group">
                    <label for="name">Sắp xếp</label>
                    <?php echo Form::select('cid_sort',$cid_sort,@$search['cid_sort'],['class'=>"form-control cid_sort" ]); ?>


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


        <?php echo Form::close(); ?>



        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <i class="fa fa-align-justify"></i> Danh Sách Công nợ của Khách
                        Hành: <?php echo e(App\MrData::toPrice($tongso['total'])); ?> <span
                                class="badge badge-pill badge-danger"> <?php echo e($data_list->total()); ?></span>
                    </div>
                    <div class="card-block">
                        <table class="table table-sm  table-bordered table-striped dataTable">
                            <thead>
                            <tr>

                                <th>Tên Khách</th>
                                <th> Công nợ</th>
                                <th> Ngày tạo phiếu</th>
                                <th> Ngày trả hồ sơ</th>
                                <th> Tuỳ chọn</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($data_list as $list): ?>

                            <tr>

                                <td><?php echo $list->Customer()['name']; ?></td>

                                <td><?php echo App\MrData::toPrice($list['total']); ?></td>

                                <td><?php echo $list['created_at']; ?></td>
                                <td><?php echo $list['ngay_tra_ho_so']; ?></td>


                                <td>

                                        <?php $uu = [];
                                        foreach ($search as $k => $v) {
                                            $uu[] = "$k=$v";
                                        }

                                        ?>

                                    <a style="font-size:12px;padding: 2px " target="_black"
                                       class="btn btn-xs btn-success"
                                       href='/admin/report/customerlist/<?php echo $list['cid_customer'];?>?<?php echo implode("&", $uu)?>'><i
                                                class="fa fa-edit"></i> Danh sách Phiếu </a>


                                    <br/>

                                </td>

                            </tr>

                            <?php endforeach; ?>

                            </tbody>
                        </table>
                        <nav>
                            <?php echo $data_list->appends($search)->render(); ?>


                        </nav>
                    </div>
                </div>
            </div>
            <!--/.col-->
        </div>
        <?php $__env->stopSection(); ?>
        <?php $__env->startSection('script_js'); ?>
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


                    $("select.cid_customer").flexselect();


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
                            }),
                        ngaytrahoso = $("#ngaytrahoso").datepicker({
                            defaultDate: "-2w",
                            changeMonth: true,
                            numberOfMonths: 3

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

<?php $__env->stopSection(); ?>

<?php echo $__env->make("admin.admin", \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>