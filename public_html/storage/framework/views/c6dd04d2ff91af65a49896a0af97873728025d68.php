<meta charset="UTF-8">
<table class="table table-sm  table-bordered table-striped dataTable">

    <thead>
    <tr>
        <th colspan="6" align="center">
            <h2>BÁO CÁO CÔNG NỢ </h2>
        </th>
    </tr>
    <tr>
        <th colspan="6" align="center">
            <?php if(!empty($search) && !empty($search['date_from']) && !empty($search['date_to'])):?>
            TỪ NGÀY: <?php echo @$search['date_from']?> -
            <?php echo @$search['date_to']?>
            <?php endif?>
        </th>
    </tr>
    <tr>
        <th colspan="6" align="center">
            TÊN NCC : <strong><?php echo @$name_supplier;?></strong>
        </th>
    </tr>

    <tr>
        <th colspan="6"></th>
    </tr>
    <tr>
        <th>Mã Phiếu</th>
        <th>Tên Khách</th>
        <th>Tên Trong Hồ Sơ</th>
        <th> Tài liệu</th>


        <th> TT NCC</th>
        <th> Tổng tiền</th>

    </tr>


    </thead>


    <tbody>
    <?php $t1 = 0;
    foreach($data_list as $list):?>

    <tr>
        <td><?php echo $list['code'];?></td>
        <td><?php echo htmlentities($list->Customer()->name);?></td>

        <td><?php echo $list['name_docs'];?></td>
        <td><?php echo $list['name'];?></td>

        <td>
            <?php $is_delete = true;?>
            <?php foreach($list->OrderSupplier() as $OrderSupplier):?>

            <?php if($OrderSupplier['approved']=='2' && $OrderSupplier['approved_2']=='2'): ?>
                <?php $is_delete = false;?>
                <label style="font-size:10px;" class="badge badge-success">DONE</label>
            <?php else: ?>
                <label style="font-size:10px;" class="badge badge-secondary">PENDING</label>
            <?php endif; ?>
            <?php endforeach;?>
        </td>
        <td><?php
            $t1 = $t1 + (int)$list->OrderSupplier()[0]['phidichthuat'];
            echo($list->OrderSupplier()[0]['phidichthuat']);?></td>


    </tr>

    <?php endforeach;?>
    <tr>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td>
            <strong>
                <?php

                echo($t1);?>
            </strong>
        </td>


    </tr>
    </tbody>
</table>
<style type="text/css">
    table {
        border-collapse: collapse;
    }

    td, th {
        font-size: 12px;
        padding: 10px;
        border: 1px solid #ddd;
    }
</style>
