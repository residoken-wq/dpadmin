 <?php $__env->startSection('content'); ?>

            <ol class="breadcrumb">
                <li class="breadcrumb-item"> Trang chủ </li>
                <li class="breadcrumb-item"><a href="">Quản lý phiếu dịch: <?php echo e($value); ?> </a>
                </li>


            </ol>


        <div class="container-fluid">
           <?php echo Form::open(['method'=>'get']); ?>








            <?php echo Form::close(); ?>



<div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-header">
                                    <i class="fa fa-align-justify"></i> Danh Sách Phiếu <?php echo e($value); ?> <span class="badge badge-pill badge-danger"> <?php echo e($data_list->total()); ?></span>
                                </div>
                                <div class="card-block">
                                    <table class="table table-sm  table-bordered table-striped dataTable">
                                        <thead>
                                            <tr>
                                                <th>Mã Phiếu  </th>
                                                <th>Tên Khách  </th>
                                                <th>Tên Trong Hồ Sơ</th>
                                                <th> Tài liệu  </th>
                                                <th> Số điện thoại   </th>


                                                <th> TT Phiếu </th>
                                                <th> TT NCC  </th>
                                                <th> TT KH  </th>
                                                <th> Tuỳ chọn  </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach($data_list as $list):?>

                                            <tr>
                                                <td><?php echo $list['code'];?></td>
                                                <td><?php echo $list->Customer()->name;?></td>

                                                 <td><?php echo $list['name_docs'];?></td>
                                                    <td><?php echo $list['name'];?></td>
                                                <td><?php echo $list['phone'];?></td>


                                                <td>
                                                    <?php if($list['approved']=='1'): ?>
                                                        <label style="font-size:10px;" class="badge badge-secondary ajax_pending" idx="<?php echo e($list['id']); ?>">PENDING</label>
                                                    <?php endif; ?>
                                                    <?php if($list['approved']=='2'): ?>
                                                         <label style="font-size:10px;" class="badge badge-success">DONE</label>
                                                    <?php endif; ?>

                                                </td>
                                                <td>
                                                    <?php $is_delete=true;?>
                                                   <?php $__currentLoopData = $list->OrderSupplier(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $OrderSupplier): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                                        <?php if($OrderSupplier['approved']=='2' && $OrderSupplier['approved_2']=='2'): ?>
                                                         <?php $is_delete=false;?>
                                                            <label style="font-size:10px;" class="badge badge-success">DONE</label>
                                                        <?php else: ?>
                                                             <label style="font-size:10px;" class="badge badge-secondary">PENDING</label>
                                                        <?php endif; ?>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </td>
                                                <td>
                                                    <?php $__currentLoopData = $list->OrderCustomer(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $OrderCustomer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <?php if($OrderCustomer['approved']=='1'): ?>
                                                            <label style="font-size:10px;" class="badge badge-secondary">PENDING</label>
                                                        <?php endif; ?>
                                                        <?php if($OrderCustomer['approved']=='2'): ?>
                                                         <?php $is_delete=false;?>
                                                            <label style="font-size:10px;" class="badge badge-success">DONE</label>
                                                        <?php endif; ?>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                                </td>
                                                <td>


                                                    <a style="font-size:12px;padding: 2px " class="btn btn-xs btn-success" href='/admin/index/edit/<?php echo $list['id'];?>' target="_black"><i class="fa fa-edit"></i> Sửa </a>


                                                    <a style="font-size:12px;padding: 2px  " class="btn btn-xs btn-secondary " href='/admin/index/pdf/<?php echo $list['id'];?>&_token=<?php echo e(csrf_token()); ?>' target="_black"> <i class="fa fa-remove"></i>PDF</a>


                                                    <?php if($list['approved']=='1' && $is_delete): ?>

                                                        <a style="font-size:12px;padding: 2px 2px" class="btn btn-xs btn-danger click_remove " href='/admin/index/removed/<?php echo $list['id'];?>?_token=<?php echo e(csrf_token()); ?>' target="_black"> <i class="fa fa-remove"></i> REMOVE    </a>

                                                    <?php endif; ?>

                                                 <br />

                                                </td>

                                            </tr>

                                           <?php endforeach;?>

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
         <script src="/js/jquery.flexselect.js"></script>
         <script src="/js/liquidmetal.js"></script>
          <link rel="stylesheet" type="text/css" href="/css/flexselect.css">
        <script type="text/javascript">
            $("document").ready(function(){
                $(".click_view_search").click(function(){

                    $(".view_search").show();
                    $(this).hide();
                });
                $(".click_reset_form").click(function(){
                      $(".view_search").hide();
                      $(".click_view_search").show();
                });
                function load_pending(){



                    $(".ajax_pending").each(function(){
                        var th=$(this);
                         $(th).parent().append("<div class='my-loading' style='font-size:10px;font-weight:bold'>Loading...<div>");
                        $.get("/admin/index/ajaxthree/"+$(this).attr("idx"),function(result){
                            $(th).parent().children('.my-loading').remove();
                            if(Number.isInteger(result*1)){

                                 $(th).html("Pending: "+result+"%");

                            }else{
                                if(result=='100%'){
                                    $(th).removeClass('badge-secondary').addClass('badge-success').html("DONE");
                                }


                            }

                        });
                    });

                }

                if($("label").hasClass("ajax_pending")){
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

    <?php $__env->stopSection(); ?>

<?php echo $__env->make("admin.admin", \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>