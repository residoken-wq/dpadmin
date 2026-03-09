<meta charset="UTF-8">
                                    <table>
                                        <thead>
                                            <tr>
                                               
                                                <th>Ten NCC </th>
                                                <th> Cong No </th>
                                                <th> Ngay Tao   </th>
                                               
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach($data_list as $list):?>
                                                
                                            <tr>
                                               
                                                <td>
                                                    <?php echo ($Supplier=App\Model\Supplier::find($list->cid_supplier))? htmlentities($Supplier['name']) :"";?>
                                                   
                                                        
                                                    </td>
                                             
                                                 <td><?php echo App\MrData::toPrice($list['total']);?></td>
                                                  
                                                <td><?php echo $list['created_at'];?></td>
                                           

                                              
                                                
                                            </tr>
                                           
                                           <?php endforeach;?>
                                           
                                        </tbody>
                                    </table>
                              