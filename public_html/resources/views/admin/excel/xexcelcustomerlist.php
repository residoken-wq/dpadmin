<meta charset="UTF-8">
                                    <table class="table table-sm  table-bordered table-striped dataTable" border='0'>
                                       <thead>
                                             <tr>
                                                <th colspan="8" align="center" style="border:0px;text-align: center;">
                                                    <h2>BÁO CÁO CÔNG NỢ </h2>
                                                </th>
                                            </tr>
                                            <?php if(!empty($search) && !empty($search['date_from']) && !empty($search['date_to'])):?>
                                            <tr>
                                                <th colspan="8" align="center" style="border:0px;text-align: center;">
                                                    TỪ NGÀY: <?php echo $search['date_from']?> - 
                                                    <?php echo $search['date_to']?>
                                                </th>
                                            </tr>
                                            <?php endif?>
                                            <tr>
                                                <th colspan="8" align="center" style="border:0px;text-align: center;">
                                                    TÊN KHÁCH: <strong><?php echo $name_customer;?></strong>
                                                </th>
                                            </tr>
                                           
                                            <tr>
                                              <th colspan="8" style="border:0px;"></th>
                                            </tr>
                                             <tr>
                                                <th> Mã phiếu </th>
                                                <th>Tên khách   </th>
                                                <th>Tên Trong HS </th>
                                                <th> Tài liệu  </th>
                                            
                                          
                                              
                                              
                                                <th> TT KH  </th>
                                                <th> Tổng tiền </th>

                                                <th> Tạm ứng</th>
                                                <th> Còn lại   </th>

                                               
                                            </tr>


                                       </thead>
                                        <tbody>
                                           
                                            <?php $t1=$t2=$t3=0; 
                                            foreach($data_list as $list):?>
                                                
                                            <tr>
                                                <td><?php echo $list['code'];?></td>
                                                <td><?php echo $list->Customer()->name;?></td>
                                             
                                                 <td><?php echo $list['name_docs'];?></td>
                                                    <td><?php echo $list['name'];?></td>
                                                
                                                <td>
                                                    <?php foreach($list->OrderCustomer() as $OrderCustomer):?>
                                                        <?php if($OrderCustomer['approved']=='1'):?>
                                                            <label style="font-size:10px;" class="badge badge-secondary">PENDING</label>
                                                        <?php endif;?>
                                                        <?php if($OrderCustomer['approved']=='2'):?>
                                                         <?php $is_delete=false;?>
                                                            <label style="font-size:10px;" class="badge badge-success">DONE</label>
                                                        <?php endif;?>
                                                    <?php endforeach;?>
                                                    
                                                </td>
                                                 <td><?php
                                                  $t1=$t1+(int)$list->OrderCustomer()[0]['tong'];
                                                  echo ($list->OrderCustomer()[0]['tong']);?></td>
                                                 <td><?php
                                                 $t2=$t2+(int)$list->OrderCustomer()[0]['tamung'];
                                                  echo ($list->OrderCustomer()[0]['tamung']);?></td>
                                                 <td><?php 
                                                 $t3=$t3+(int) (int)$list->OrderCustomer()[0]['tong']-(int)$list->OrderCustomer()[0]['tamung'];
                                                 echo ( (int)$list->OrderCustomer()[0]['tong']-(int)$list->OrderCustomer()[0]['tamung']);?></td>
                                              

                                            </tr>
                                           
                                           <?php endforeach;?>
                                            <tr>
                                                <td></td>
                                                <td></td>
                                                 <td></td>
                                                  <td></td>
                                                   <td><strong></strong></td>
                                              
                                                 <td>
                                                    <strong>
                                                         <?php echo ($t1);?>
                                                    </strong>

                                                    </td>
                                                 <td>
                                                    <strong>
                                                        <?php echo ($t2);?>
                                                    </strong>
                                                </td>
                                                 <td>
                                                    <strong>
                                                           <?php echo ( $t3);?>
                                                    </strong>
                                                </td>
                                              

                                            </tr>
                                        </tbody>
                                    </table>
                                   <style type="text/css">
                                   table {
                                        border-collapse: collapse;
                                    }
                                       td,th{
                                        font-size:12px;
                                        padding: 10px;
                                        border: 1px solid #ddd;
                                       }
                                   </style>