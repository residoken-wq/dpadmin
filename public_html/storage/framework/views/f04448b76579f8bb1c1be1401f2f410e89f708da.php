 <?php $__env->startSection('content'); ?>

            <ol class="breadcrumb">
                <li class="breadcrumb-item"> Trang chủ </li>
                <li class="breadcrumb-item"><a href="">Danh sách  OneDrive </a>
                </li>
               
              
            </ol>

        <div class="container-fluid">
                 
           
           
           
 


<div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-header">
                                    <i class="fa fa-align-justify"></i> Danh Sách Thư mục 
                                </div>
                                <div class="card-block">
                                     <table class="table table-sm  table-bordered table-striped dataTable">
                                        <thead>
                                            <tr>
                                                <th> Tên Thư Mục </th>
                                                
                                            </tr>
                                        </thead>

                                        <tbody>
                                            
                                            <tr>
                                                <td>
                                                        <a href="/admin/index/runonedrive?type=root">Thư mục gốc </a>
                                                   
                                                </td>
                                                

                                            </tr>
                                           <tr>
                                                <td>
                                                        <a href="/admin/index/runonedrive?type=shared">Thư mục Shared  </a>
                                                   
                                                </td>
                                                

                                            </tr>
                                           
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