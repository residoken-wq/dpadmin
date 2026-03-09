 <?php $__env->startSection('content'); ?>

            <ol class="breadcrumb">
                <li class="breadcrumb-item"> Trang chủ </li>
                <li class="breadcrumb-item"><a href="">Quản lý Nhân Viên</a>
                </li>
               
              
            </ol>


        <div class="container-fluid">
           <?php echo Form::open(['method'=>'get']); ?>

         
           
           
            <div class="row view_search" >

                    <div class="col-sm-12">
                                     <div class="form-group">
                                                    <label for="name"> Tên  nhân viên       </label>
 <?php echo Form::text('name',@$search['name'],['class'=>"form-control col-sm-4" ]); ?>


                                                </div>
                                            </div>
                   
                 <div class="col-sm-5">
                      <div class="form-group">
                      <button type="submit" class="btn btn-sm btn-warning"><i class="fa fa-ban"></i> TÌM KIẾM  </button>
                         <?php /*$url=$_SERVER['REQUEST_URI'];
                                $get_request=explode("?", $url);
                                $u = (!empty($get_request[1]))? "?".$get_request[1] : "" ;
                            /admin/supplier/export{{$u}}
                                */
                            ?>
                       
                  </div>
                </div>
                  
        </div>

            

            <?php echo Form::close(); ?>



<div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-header">
                                    <i class="fa fa-align-justify"></i> Danh Sách nhân viên  <span class="badge badge-pill badge-danger"> <?php echo e($data_list->total()); ?></span> 
                                </div>
                                <div class="card-block">
                                    <table class="table table-sm">
                                        <thead>
                                            <tr>
                                                <th>Tên NV   </th>
                                                <th> Tên Đăng Nhập  </th>
                                                  <th> Phần Quyền </th>
                                                <th> Số điện thoại  </th>
                                                <th> Email  </th>
                                       
                                                <th> Tuỳ chọn </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach($data_list as $list):?>
                                                
                                            <tr>
                                                <td><?php echo $list['name'];?></td>
                                                 <td><?php echo $list['username'];?></td>
                                                  <td>
                                                      <?php if($list['roles']=='1'): ?>
                                                        <h6 class="badge badge-primary">Admin</h6>
                                                      <?php else: ?>
                                                        <h6 class="badge badge-info">Nhân Viên </h6>
                                                      <?php endif; ?>

                                                  </td>
                                                    <td><?php echo $list['phone'];?></td>
                                                      <td><?php echo $list['email'];?></td>
                                                      
                                                <td>
                                                    <a class="btn btn-sm btn-success" href='/admin/users/edit/<?php echo $list['id'];?>'><i class="fa fa-edit"></i> Sửa </a><br /><br />
                                                    <a style='display:none' class="btn btn-sm btn-danger click_remove" href='/admin/users/remove?id=<?php echo $list['id'];?>&_token=<?php echo e(csrf_token()); ?>'> <i class="fa fa-remove"></i> Xoá  </a>
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