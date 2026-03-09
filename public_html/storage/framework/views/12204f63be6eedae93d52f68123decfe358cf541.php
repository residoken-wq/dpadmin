<meta charset="UTF-8">
                                    <table>
                                        <thead>
                                            <tr>

                                                <th>Ten Khach </th>
                                                <th> Cong No </th>
                                                <th> Ngay Tao   </th>

                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach($data_list as $list):?>

                                            <tr style="table-border: 1px solid black; table-collapse: collapse">

                                                <td>
                                                    <?php echo ($Customer=App\Model\Customer::find($list->cid_customer))? htmlentities($Customer['name']) :"";?>


                                                    </td>

                                                 <td><?php echo App\MrData::toPrice($list['total']);?></td>

                                                <td><?php echo $list['created_at'];?></td>




                                            </tr>

                                           <?php endforeach;?>

                                        </tbody>
                                    </table>
