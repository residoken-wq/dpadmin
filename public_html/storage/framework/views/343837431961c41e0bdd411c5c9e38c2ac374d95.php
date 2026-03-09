 <?php $__env->startSection('content'); ?>

            <ol class="breadcrumb">
                <li class="breadcrumb-item"> Trang chủ </li>
                <li class="breadcrumb-item"><a href="">BÁO CÁO LỢI NHUẬN  </a>
                </li>
               
              
            </ol>


        <div class="container-fluid">
             <?php echo Form::open(['method'=>'get']); ?>

         
           
           
            <div class="row view_search" >

                                  <div class="col-sm-3">
                                     <div class="form-group">
                                                    <label for="name">heo: </label>
 
  <?php echo Form::select('filter',$filter,@$search['filter'],['class'=>"form-control" ,"autocomplete"=>"off"]); ?>                                                  
                                                </div>
                                            </div>

                                  <div class="col-sm-3">
                                     <div class="form-group">
                                                    <label for="name">Từ  Ngày  </label>
 <?php echo Form::text('date_from',@$search['date_from'],['class'=>"form-control" ,'id'=>"from","autocomplete"=>"off"]); ?>


                                                </div>
                                            </div>
                                   <div class="col-sm-3">
                                     <div class="form-group">
                                                    <label for="name">Đến Ngày  </label>
 <?php echo Form::text('date_to',@$search['date_to'],['class'=>"form-control" ,'id'=>'to',"autocomplete"=>"off"]); ?>


                                                </div>
                                            </div>
                   
                 <div class="col-sm-12">
                      <div class="form-group">
                      <button type="submit" class="btn btn-sm btn-warning"><i class="fa fa-ban"></i> TÌM KIẾM  </button>
                        
                         <button type="submit" class="btn btn-sm btn-success" name='export' value='excel'><i class="fa fa-export"></i> EXPORT EXCEL </button>
                  </div>
                </div>
                  
        </div>

            

            <?php echo Form::close(); ?>

         
           
         </div>  
         
 


        <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-header">
                                    <i class="fa fa-align-justify"></i> LỢI NHUẬN  : 
                                       
                                         <span class="badge badge-pill badge-danger"> <?php echo e($data_list->total()); ?></span> 

                                </div>
                                <div class="card-block">
                                     <table class="table table-sm  table-bordered table-striped dataTable">
                                        <thead>
                                            <tr>
                                                <th>  

                                                 <?php if($search['filter']=='1'): ?>
                                                     Ngày
                                                    <?php endif; ?>
                                                     <?php if($search['filter']=='2'): ?>
                                                     Tháng 
                                                    <?php endif; ?>
                                                     <?php if($search['filter']=='3'): ?>
                                                     Năm 
                                                    <?php endif; ?>

                                                </th>
                                                   <th> Tổng số tiền Phiếu  </th>
                                                <th> Tổng Số tiền Chi  </th>
                                                <th> Tổng Số tiền Thu </th> 
                                                 <th> Lợi nhuận  </th> 
                                                  <th> Số tiền lỗ   </th> 
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach($data_list as $list):?>
                                                
                                            <tr>
                                                <td>
                                                    <?php if($search['filter']=='1'): ?>
                                                    <?php $value= Date("d-m-Y",strtotime($list['my_date'])); ?>
                                                     <?php echo e(Date("d-m-Y",strtotime($list['my_date']))); ?>

                                                    <?php endif; ?>
                                                     <?php if($search['filter']=='2'): ?>
                                                      <?php $value= Date("m",strtotime($list['my_date'])); ?>
                                                     <?php echo e(Date("m",strtotime($list['my_date']))); ?>

                                                     -
                                                     <?php $value= Date("Y",strtotime($list['my_date'])); ?>
                                                     <?php echo e(Date("Y",strtotime($list['my_date']))); ?>

                                                    <?php endif; ?>
                                                     <?php if($search['filter']=='3'): ?>
                                                      <?php $value= Date("Y",strtotime($list['my_date'])); ?>
                                                     <?php echo e(Date("Y",strtotime($list['my_date']))); ?>

                                                    <?php endif; ?>
                                                </td>
                                                <?php 
                                                    $thu= (int)$list->TongThu($search['filter'])['total'];
                                                    $chi= (int)$list->TongChi($search['filter'])['total'];
                                                    $tongphieu_K=(int)$list->TongPhieuCustomer($search['filter'])['total'];

                                                     $tongphieu_NCC= (int)$list->TongPhieuSupplier($search['filter'])['total'];

                                                    $tongphieu=$tongphieu_K + $tongphieu_NCC;

                                                  ?>

                                                  <td> 

                                                    <?php if(false): ?>
                                                          Tổng Phiếu: 
                                                          <strong>
                                                          <?php echo e(App\MrData::toPrice($tongphieu)); ?>

                                                        </strong>

                                                          <br />
                                                    <?php endif; ?>


                                                  Tổng Phiếu Khách:    
                                                   <strong> 
                                                    <?php echo e(App\MrData::toPrice($tongphieu_K)); ?>

                                                  </strong>
                                                    <br />
                                                  Tổng Phiếu NCC: 
                                                  <strong>
                                                    <?php echo e(App\MrData::toPrice($tongphieu_NCC)); ?>

                                                    </strong>

                                                </td>

                                                <td> <?php echo e(App\MrData::toPrice($chi)); ?>


                                                </td>
                                                <td>  
                                                  <?php echo e(App\MrData::toPrice($thu)); ?>

                                                   </td> 
                                                     <td>  
                                                  
                                                  <?php if($thu > $chi): ?>
                                                    <?php echo e(App\MrData::toPrice($thu-$chi)); ?>

                                                  <?php endif; ?>
                                                   </td> 
                                                   <td>
                                                     <?php if($chi > $thu): ?>
                                                    <?php echo e(App\MrData::toPrice($chi-$thu)); ?>

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



                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-header">
                                    <i class="fa fa-align-justify"></i> THÔNG KÊ - Tổng Số Tiền  : 
                                       
                                </div>
                                <div class="card-block">
                                     <table class="table  table-bordered table-striped dataTable">
                                        
                                        <tbody>
                                            
                                            <tr> 
                                                <td>
                                                    Phiếu Khách Hàng 
                                                </td>
                                                  
                                                <td> 
                                                  <?php echo e(App\MrData::toPrice($tongKH['total'])); ?>

                                                </td>
                                            </tr>
                                               
                                            <tr> 
                                                <td>
                                                    Phiếu Nhà Cung Câp 
                                                </td>
                                                
                                                <td> 
                                                    <?php echo e(App\MrData::toPrice($tongNCC['total'])); ?>

                                                </td>
                                            </tr>
                                           
                                             <tr>
                                                <td>
                                                   Đã Thu
                                                </td>
                                                

                                                <td> 
                                                    <?php echo e(App\MrData::toPrice($TONGTHU['total'])); ?>

                                                </td>
                                            </tr>
                                              <tr>
                                                <td>
                                                   Đã Thu ( Tạo  Phiếu Thu )
                                                </td>
                                                
                                                
                                                <td> 
                                                    <?php echo e(App\MrData::toPrice($TONGTHU_2['total'])); ?>

                                                </td>
                                            </tr>
                                             <tr>
                                                <td>
                                                   Phải Thu
                                                </td>
                                                
                                                <td> 
                                                  <?php echo e(App\MrData::toPrice($CONLAI['total'])); ?>

                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    Đã Chi
                                                </td>
                                                
                                                <td> 
                                                  <?php echo e(App\MrData::toPrice($TONGCHI['total'])); ?>

                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    Lợi nhuận
                                                </td>
                                                
                                                <td> 
                                                  <?php echo e(App\MrData::toPrice($LOINHUAN)); ?>

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
     <script type="text/javascript" src="/admin/bower_components/time-picker/dist/time-picker.js"></script>
        <script type="text/javascript" src="/admin/bower_components/jqueryui-datepicker/datepicker.js"></script>
     
        <link rel="stylesheet" type="text/css" href="/admin/bower_components/jqueryui-datepicker/datepicker.css">
           <link rel="stylesheet" type="text/css" href="/admin/bower_components/time-picker/dist/time-picker.css">
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


                
                  var dateFormat = "mm/dd/yy",
                      from = $( "#from" )
                        .datepicker({
                          defaultDate: "-2w",
                          changeMonth: true,
                          numberOfMonths: 3
                          
                        })
                        .on( "change", function() {
                          to.datepicker( "option", "minDate", getDate( this ) );
                        }),
                      to = $( "#to" ).datepicker({
                        defaultDate: "-2w",
                        changeMonth: true,
                        numberOfMonths: 3

                      })
                      .on( "change", function() {
                        from.datepicker( "option", "maxDate", getDate( this ) );
                      });
                 
                    function getDate( element ) {
                      var date;
                      try {
                        date = $.datepicker.parseDate( dateFormat, element.value );
                      } catch( error ) {
                        date = null;
                      }
                 
                      return date;
                    }



            });
        </script>
        
    <?php $__env->stopSection(); ?>
<?php echo $__env->make("admin.admin", \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>