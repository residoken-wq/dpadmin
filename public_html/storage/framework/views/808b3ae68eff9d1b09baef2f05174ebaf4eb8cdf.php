 <?php $__env->startSection('content'); ?>

            <ol class="breadcrumb">
                <li class="breadcrumb-item"> Trang chủ </li>
                <li class="breadcrumb-item"><a href="">Quản lý Phiếu chi </a>
                </li>


            </ol>

        <div class="container-fluid">
   <?php echo Form::open(['method'=>'get']); ?>




            <div class="row view_search" >

                    <div class="col-sm-4">
                                     <div class="form-group">
                                                    <label for="name"> Tên người chi tiền  </label>
 <?php echo Form::text('name',@$search['name'],['class'=>"form-control col-sm-12" ]); ?>


                                                </div>
                                            </div>
                    <div class="col-sm-4">
                                     <div class="form-group">
                                                    <label for="name"> Tên nhà cung cấp  </label>
 <?php echo Form::text('supplier',@$search['supplier'],['class'=>"form-control col-sm-12" ]); ?>


                                                </div>
                                            </div>

                   <div class="col-sm-4">
                                     <div class="form-group">
                                                    <label for="name"> Tuỳ chọn  </label>
 <?php echo Form::select('options',$options,@$search['options'],['class'=>"form-control col-sm-12" ]); ?>


                                                </div>
                                            </div>

                 <div class="col-sm-5">
                      <div class="form-group">
                      <button type="submit" class="btn btn-sm btn-warning"><i class="fa fa-ban"></i> TÌM KIẾM
                       </button>

                     </div>
                </div>

        </div>



            <?php echo Form::close(); ?>

     </div>
        <div class="container-fluid">







<div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-header">
                                    <i class="fa fa-align-justify"></i> Danh Sách Phiếu chi <span class="badge badge-pill badge-danger"> <?php echo e($data_list->total()); ?></span>
                                </div>
                                <div class="card-block">
                                     <table class="table table-sm  table-bordered table-striped dataTable">
                                        <thead>
                                            <tr>
                                                <th>Người chi tiền  </th>
                                                <th> Số tiền  </th>
                                                <th> Nhân viên xử lý   </th>
                                                <th> Lý do   </th>
                                                <th> Ghi chú </th>
                                                 <th> Ngày tạo </th>
                                                <th> Tuỳ chọn </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach($data_list as $list):?>

                                            <tr>
                                                <td><?php echo $list['nguoichi'];?></td>
                                                  <td><?php echo App\MrData::toPrice($list['price']);?></td>
                                                    <td><?php echo $list->User()['name'];?></td>
                                                      <td><?php echo $list['lydo'];?></td>
                                                        <td><?php echo $list['ghichu'];?></td>
                                                          <td><?php echo $list['created_at'];?></td>
                                                <td>
                                                    <?php if((int)$list['cid_form']== 0): ?>
                                                        <a style="font-size:12px;padding: 2px "   class="btn btn-sm btn-success" href='/admin/phieuchi/edit/<?php echo $list['id'];?>'><i class="fa fa-edit"></i> Sửa </a>

                                                        <a style="font-size:12px;padding: 2px "  class="btn btn-sm btn-danger click_remove" href='/admin/phieuchi/remove?id=<?php echo $list['id'];?>&_token=<?php echo e(csrf_token()); ?>'> <i class="fa fa-remove"></i> Xoá  </a>
                                                    <?php else: ?>
                                                      <a  style="font-size:12px;padding: 2px "   href='/admin/index/edit/<?php echo e($list["cid_form"]); ?>'> Phiếu Dịch  </a>
                                                    <?php endif; ?>
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
            });
        </script>

    <?php $__env->stopSection(); ?>

<?php echo $__env->make("admin.admin", \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>