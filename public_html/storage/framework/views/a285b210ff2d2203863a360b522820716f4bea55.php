 <?php $__env->startSection('content'); ?>

            <ol class="breadcrumb">
                <li class="breadcrumb-item"> Trang chủ </li>
                <li class="breadcrumb-item"><a href="">Tạo mới Khách Hàng  </a>
                </li>
               
              
            </ol>

                  <?php if(!empty(session('success'))): ?>
                      

                         <div id='myMessagerSuccess' class="modal" tabindex="1" role="dialog">
                                  <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                      <div class="modal-header">
                                        <h5 class="modal-title">Thông Báo:</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                          <span aria-hidden="true">&times;</span>
                                        </button>
                                      </div>
                                      <div class="modal-body">
                                          <p><?php echo session('success'); ?></p>
                                      </div>
                                      <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">OK</button>
                                      
                                      </div>
                                    </div>
                                  </div>
                                </div>
                    <?php endif; ?>   
             
           <?php echo Form::open(['method'=>'post','class'=>'s']); ?>

        <div class="row container-fluid">
           
          
            <div class="col-xs-12 col-sm-12 col-lg-12">
                                <div class="card">
                                    <div class="card-header">
                                        <strong> Thông tin tạo mới khách hàng  </strong>
                                        <small>Form</small>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            
                                          
                                            <div class="col-sm-10">

                                                <div class="form-group">
                                                    <label for="name"> Tên khách hàng:  </label>
        <?php echo Form::text('name',@$data['name'],['class'=>'form-control','autocomplete'=>'on']); ?>

                       <?php if($errors->has("name")): ?> 
                        <div class="alert alert-danger">* <?php echo e($errors->first("name")); ?></div>
                       <?php endif; ?>                          
                                                      
                                                    
                                                </div>

                                            </div>

                                            <div class="col-sm-10">

                                                <div class="form-group">
                                                    <label> Khách lẻ :
        <?php echo Form::checkbox('is_kl','2',false); ?>

                                              </label>
                                                    
                                                </div>

                                            </div>

                                             <div class="col-sm-10">

                                                <div class="form-group">
                                                    <label for="name">Công ty:   </label>
        <?php echo Form::text('company',@$data['company'],['class'=>'form-control']); ?>

                                                  
                                                     
                                                    
                                                </div>

                                            </div>

                                             <div class="col-sm-10">

                                                <div class="form-group">
                                                    <label for="name">Địa chỉ:  </label>
        <?php echo Form::text('address',@$data['address'],['class'=>'form-control']); ?>

                                                  
                                                     
                                                    
                                                </div>

                                            </div>



                                             <div class="col-sm-10">

                                                <div class="form-group">
                                                    <label for="name">Mã số thuế :  </label>
        <?php echo Form::text('fax',@$data['fax'],['class'=>'form-control','autocomplete'=>'on']); ?>

                                             
                                                      
                                                    
                                                </div>

                                            </div>
                                            <div class="col-sm-10">

                                                <div class="form-group">
                                                    <label for="name">Số điện thoại:  </label>
        <?php echo Form::text('phone',@$data['phone'],['class'=>'form-control']); ?>

                                                  
                                                     
                                                    
                                                </div>

                                            </div>

                                            
                                             <div class="col-sm-10">

                                                <div class="form-group">
                                                    <label for="name">Email :  </label>
        <?php echo Form::email('email',@$data['email'],['class'=>'form-control']); ?>

                                                </div>

                                            </div>
                                              
                                             <div class="col-sm-10">

                                                <div class="form-group">
                                                    <label for="name">Ghi chú :  </label>
        <?php echo Form::textarea('note',@$data['note'],['class'=>'form-control','rows'=>3]); ?>

                                                </div>

                                            </div>
                                            
                                        </div>
                                       
                                    </div>
                                </div>

               
                            </div>

                            
                             <div class="col-sm-12">
                                       
                                            <div class="card-footer">
                                                <input type='hidden' name='_token' value='<?php echo e(csrf_token()); ?>' />
                                                <button type="submit" class="btn btn-sm btn-primary"><i class="fa fa-save"></i> LƯU </button>
                                                <button type="reset" class="btn btn-sm btn-danger"><i class="fa fa-undo"></i> LÀM LẠI </button>
                                            </div>
                                        </div>

               
                            </div>
                 

             </div>
               <?php echo Form::close(); ?>

    <?php $__env->stopSection(); ?>
    <?php $__env->startSection("script_js"); ?>
        <script type="text/javascript">
            $(document).ready(function(){
                $('#myMessagerSuccess').modal('show');
            });
        </script>
    <?php $__env->stopSection(); ?>    
<?php echo $__env->make("admin.admin", \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>