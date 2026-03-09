 <?php $__env->startSection('content'); ?>

            <ol class="breadcrumb">
                <li class="breadcrumb-item"> Trang chủ </li>
                <li class="breadcrumb-item"><a href="">Danh sách được Shared trên OneDrive </a>
                </li>
               
              
            </ol>

        <div class="container-fluid">
                 
           
           
           
 


<div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-header">
                                    <i class="fa fa-align-justify"></i> 
                                    <a href="/admin/index/runonedrive">
                                    <- Quay lại Danh Sách Thư mục 
                                </a>
                                </div>
                                <div class="card-block">
                                     <table class="table table-sm  table-bordered table-striped dataTable">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Tên Thư Mục </th>
                                                <th> Thông Tin </th>
                                             
                                             
                                            </tr>
                                        </thead>

                                        <tbody>
                                            <?php foreach($shared as $list):
                                                $list=(array)$list;



                                                ?>
                                            <?php if(!empty($list)): ?>  
                                            <tr>
                                                <td>
                                        
                                                    <?php echo e($list['id']); ?>

                                                </td>
                                                <td>
                                        
                                                    <?php echo e($list['name']); ?> 
                                                </td>
                                                <td>
                                        
                                                    <?php echo e($list['from']->name); ?> <br />
                                                   Thời gian tạo: <?php echo e($list['created_time']); ?> <br />
                                                   Thời gian sửa: <?php echo e($list['updated_time']); ?>


                                                </td>
                                               

                                            </tr>
                                            <?php endif; ?>
                                           <?php endforeach;?>
                                           
                                        </tbody>
                                    </table>
                                    
                                </div>
                            </div>
                        </div>
                        <!--/.col-->
                    </div>
     <?php $__env->stopSection(); ?>
    <?php $__env->startSection('script_js'); ?> 
        <script type="text/javascript">
            $("document").ready(function(){
               
            });
        </script>
        
    <?php $__env->stopSection(); ?>
<?php echo $__env->make("admin.admin", \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>