<meta charset="UTF-8">
                                     <table class="table table-sm  table-bordered table-striped dataTable">
                                        <thead>
                                            <tr>
                                               <th>  

                                                 @if($search['filter']=='1')
                                                     Ngày
                                                    @endif
                                                     @if($search['filter']=='2')
                                                     Tháng 
                                                    @endif
                                                     @if($search['filter']=='3')
                                                     Năm 
                                                    @endif

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
                                                    @if($search['filter']=='1')
                                                    <?php $value= Date("d-m-Y",strtotime($list['my_date'])); ?>
                                                     {{Date("d-m-Y",strtotime($list['my_date']))}}
                                                    @endif
                                                     @if($search['filter']=='2')
                                                      <?php $value= Date("m",strtotime($list['my_date'])); ?>
                                                     {{Date("m",strtotime($list['my_date']))}}
                                                     -
                                                     <?php $value= Date("Y",strtotime($list['my_date'])); ?>
                                                     {{Date("Y",strtotime($list['my_date']))}}
                                                    @endif
                                                     @if($search['filter']=='3')
                                                      <?php $value= Date("Y",strtotime($list['my_date'])); ?>
                                                     {{Date("Y",strtotime($list['my_date']))}}
                                                    @endif
                                                </td>
                                                

                                                 


                                                <td> {{ ($thu['tong'])}}

                                                </td>
                                                <td>  
                                                  {{ ($thu['tamung'])}}
                                                   </td> 
                                                     <td>  
                                                  
                                                 
                                                    {{ ($thu['total'])}}
                                                 
                                                   </td> 
                                                 
                                            </tr>
                                           
                                           <?php 

                                            endif;
                                                endforeach;?>
                                           
                                        </tbody>
                                    </table>
                                   
                                 