<meta charset="UTF-8">
                                     <table class="table table-sm  table-bordered table-striped dataTable">
                                        <thead>
                                            <tr>
                                                <th>  

                                                 <?php if($search['filter']=='1'): ?>
                                                     Ngay 
                                                    <?php endif; ?>
                                                     <?php if($search['filter']=='2'): ?>
                                                     Thang  
                                                    <?php endif; ?>
                                                     <?php if($search['filter']=='3'): ?>
                                                     Nam  
                                                    <?php endif; ?>

                                                </th>
                                                 <?php if($search['filter']=='2'): ?>
                                                    <th>
                                                     Nam
                                                    </th>  
                                                    <?php endif; ?>
                                                <th> Tien Chi  </th>
                                                <th> Tien Thu </th> 
                                                 <th> Loi Nhuan  </th> 
                                                  <th> Tien Lo   </th> 
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

                                                    <?php endif; ?>
                                                     <?php if($search['filter']=='3'): ?>
                                                      <?php $value= Date("Y",strtotime($list['my_date'])); ?>
                                                     <?php echo e(Date("Y",strtotime($list['my_date']))); ?>

                                                    <?php endif; ?>
                                                </td>
                                                <?php if($search['filter']=='2'): ?>
                                                    <td>
                                                      
                                                     <?php echo e(Date("Y",strtotime($list['my_date']))); ?>  
                                                 </td>
                                                    <?php endif; ?>
                                                <?php 
                                                    $thu= (int)$list->TongThu($search['filter'])['total'];
                                                    $chi= (int)$list->TongChi($search['filter'])['total'];
                                                  ?>
                                                <td> <?php echo e($chi); ?>


                                                </td>
                                                <td>  
                                                    <?php echo e($thu); ?>

                                                 
                                                   </td> 
                                                     <td>  
                                                  
                                                  <?php if($thu > $chi): ?>

                                                    <?php echo e(($thu-$chi)); ?>

                                                  <?php endif; ?>
                                                   </td> 
                                                   <td>
                                                     <?php if($chi > $thu): ?>
                                                    <?php echo e(($chi-$thu)); ?>

                                                  <?php endif; ?>
                                                </td>
                                            </tr>
                                           
                                           <?php endforeach;?>
                                           
                                        </tbody>
                                    </table>
                                   
                                 