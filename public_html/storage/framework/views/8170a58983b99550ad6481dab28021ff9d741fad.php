 <?php $__env->startSection('content'); ?>

            <ol class="breadcrumb">
                <li class="breadcrumb-item"> Trang chủ </li>
                <li class="breadcrumb-item"><a href="">Thư mục OneDrive </a>
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
                                                
                                                ?>
                                            <?php if($list->isFolder()): ?>  
                                                    <tr>
                                                        <td>
                                                
                                                            <?php echo e($list->getId()); ?>

                                                        </td>
                                                        <td>
                                                            <a href='/admin/index/runonedrive?id=<?php echo e($list->getId()); ?>'>
                                                            <?php echo e($list->getName()); ?>  ( <small>size: <?php echo e($list->getSize()); ?></small>)
                                                             </a>
                                                        </td>
                                                        <td>
                                                
                                                           
                                                           Thời gian tạo: <?php echo e($list->getCreatedTime()); ?> <br />
                                                           Thời gian sửa: <?php echo e($list->getUpdatedTime()); ?>


                                                        </td>
                                                    

                                                                <?php 
                                                                   /* $folder     = $onedrive->fetchObject($list->getId());
                                                                    if($folder->isFolder()){
                                                                        echo count($folder->fetchChildObjects() );
                                                                   }*/
                                                                ?>

                                                    
                                                       

                                                    </tr>
                                            <?php else: ?>

                                                    <tr>
                                                        <td>
                                                
                                                            <?php echo e($list->getId()); ?>

                                                        </td>
                                                        <td>
                                                           
                                                            <?php echo e($list->getName()); ?>  ( <small>size: <?php echo e($list->getSize()); ?></small>)
                                                            
                                                        </td>
                                                        <td>
                                                
                                                           
                                                           Thời gian tạo: <?php echo e($list->getCreatedTime()); ?> <br />
                                                           Thời gian sửa: <?php echo e($list->getUpdatedTime()); ?>


                                                        </td>
                                                    

                                                                <?php 
                                                                   /* $folder     = $onedrive->fetchObject($list->getId());
                                                                    if($folder->isFolder()){
                                                                        echo count($folder->fetchChildObjects() );
                                                                   }*/
                                                                ?>

                                                    
                                                       

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