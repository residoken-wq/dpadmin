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
 <?php echo Form::select('cid_user',$cid_user,@$search['cid_user'],['class'=>"form-control col-sm-4" ]); ?>


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
                                                <td>ID</td>
                                                <th> Action   </th>
                                                <th> Số Phiếu  </th>
                                                  <th> Tên Người dùng  </th>
                                             
                                                <th> Tuỳ chọn </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach($data_list as $list):?>
                                                
                                            <tr>
                                                <td><?php echo $list['id'];?></td>
                                                 <td><?php echo $list['name'];?></td>
                                                   <td>
                                                      <a href="/admin/index/edit/<?php echo $list->Form()['id'];?>">
                                                      <?php echo $list->Form()['code'];?>
                                                        </a>

                                                      </td>
                                                    <td>
                                                       <a href="/admin/users/edit/<?php echo $list->User()['id'];?>">
                                                        <?php echo $list->User()['name'];?>
                                                      </a>
                                                      </td>
                                                      <td><?php echo $list['created_at'];?></td>
                                                      
                                       

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
     <script type="text/javascript" src="/admin/bower_components/time-picker/dist/time-picker.js"></script>
        <script type="text/javascript" src="/admin/bower_components/jqueryui-datepicker/datepicker.js"></script>
     
        <link rel="stylesheet" type="text/css" href="/admin/bower_components/jqueryui-datepicker/datepicker.css">
           <link rel="stylesheet" type="text/css" href="/admin/bower_components/time-picker/dist/time-picker.css">

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
                 $("select.cid_user").flexselect();
            });
        </script>
        
    <?php $__env->stopSection(); ?>
<?php echo $__env->make("admin.admin", \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>