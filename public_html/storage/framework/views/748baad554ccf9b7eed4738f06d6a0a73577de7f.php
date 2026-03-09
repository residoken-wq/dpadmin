<meta charset="UTF-8">
<style type="text/css">
    .my_a {
        border: 0px;
        text-align: center;
    }

    .my_b {
        border: 0px;
        text-align: center;
    }

    table {
        border-collapse: collapse;
    }

    td, th {
        font-size: 14px;
        padding: 10px;
        border: 1px solid black;
    }
</style>

<table border="1">
    <thead>
    <tr>
        <th colspan="9" align="center" class="my_b">


            <strong>
                BÁO CÁO CÔNG NỢ
            </strong>

        </th>
    </tr>
    <?php if(!empty($search) && !empty($search['date_from']) && !empty($search['date_to'])):?>
    <tr>
        <th colspan="9" align="center">
            TỪ NGÀY: <?php echo $search['date_from']?> -
            <?php echo $search['date_to']?>
        </th>
    </tr>
    <?php endif?>
    <tr>
        <th colspan="9" align="center" class="my_a">
            <?php if(!empty($name_customer)):?>
            TÊN KHÁCH: <strong><?php echo htmlentities($name_customer);?></strong>
            <?php endif;?>
        </th>
    </tr>

    <tr>
        <th colspan="9"></th>
    </tr>
    <tr>
        <th> Mã phiếu</th>
        <th>Tên khách</th>
        <th>Tên Trong HS</th>
        <th> Tài liệu</th>


        <th> TT KH</th>
        <th> Tổng tiền</th>

        <th> Tạm ứng</th>
        <th> Còn lại</th>
        <th> Barcode</th>


    </tr>


    </thead>
    <tbody>

    <?php $t1 = $t2 = $t3 = 0;
    foreach($data_list as $list):?>

    <tr>
        <td><?php echo $list['code'];?></td>
        <td><?php echo htmlentities($list->Customer()->name);?></td>

        <td><?php echo htmlentities($list['name_docs']);?></td>
        <td><?php echo htmlentities($list['name']);?></td>

        <td>
            <?php foreach($list->OrderCustomer() as $OrderCustomer):?>
            <?php if($OrderCustomer['approved'] == '1'):?>
            <label style="font-size:10px;" class="badge badge-secondary">PENDING</label>
            <?php endif;?>
            <?php if($OrderCustomer['approved'] == '2'):?>
            <?php $is_delete = false;?>
            <label style="font-size:10px;" class="badge badge-success">DONE</label>
            <?php endif;?>
            <?php endforeach;?>

        </td>
        <td><?php

            $tong = $list->tong ?? 0;
            $t1 = $t1 + $tong;
            echo App\MrData::toPrice($tong);
            ?></td>
        <td><?php
            $tamung = $list->tamung;
            $t2 = $t2 + $tamung;
            echo App\MrData::toPrice($tamung);
            ?></td>
        <td><?php
            $conlai = $tong - $tamung;
            $t3 = $t3 + $conlai;
            echo App\MrData::toPrice($conlai);
            ?></td>
        <td><img style="width:100px;height:30px; float:right"
                     src="data:image/png;base64,<?php echo e(DNS1D::getBarcodePNG($list['id'], "C39+",3,33,array(1,1,0))); ?>"/></td>

    </tr>

    <?php endforeach;?>
    <tr>
        <td colspan="5"><strong>Tổng</strong></td>
        <td>
            <strong>
                <?php echo App\MrData::toPrice($t1);?>
            </strong>

        </td>
        <td>
            <strong>
                <?php echo App\MrData::toPrice($t2);?>
            </strong>
        </td>
        <td>
            <strong>
                <?php echo App\MrData::toPrice($t3);?>
            </strong>
        </td>
        <td></td>

    </tr>
    </tbody>
</table>
