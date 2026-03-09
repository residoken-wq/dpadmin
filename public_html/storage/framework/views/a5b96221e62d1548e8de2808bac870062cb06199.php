<meta charset="UTF-8">
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
                                                
                                                <th> Tổng Số tiền Thu </th>
                                                <th> Tam ứng  </th> 
                                                 <th>  Tổng </th> 
                                              
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach($data_list as $list):?>
                                                <?php 
                                                    $thu= $list->KH_TongThu($search['filter'],$id_customer);
                                                    
                                                    if(!empty($thu['tong'])):
                                                  ?> 
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
                                                

                                                 


                                                <td> <?php echo e(($thu['tong'])); ?>


                                                </td>
                                                <td>  
                                                  <?php echo e(($thu['tamung'])); ?>

                                                   </td> 
                                                     <td>  
                                                  
                                                 
                                                    <?php echo e(($thu['total'])); ?>

                                                 
                                                   </td> 
                                                 
                                            </tr>
                                           
                                           <?php 

                                            endif;
                                                endforeach;?>
                                           
                                        </tbody>
                                    </table>
                                   
                                 