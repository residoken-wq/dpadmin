<div class='body'>
    <style type="text/css">
        .body {

            font-size: 13px;
            color: #000;
            width: 2480px;
            height: 1748px;
            margin: 0px;
            padding: 0px;
            float: left;
            position: relative;
            font-family: Arial, Tahoma, Helvetica;

        }

        .main {
            width: 95%;

            margin: 0 auto;
            overflow: hidden;
        }

        .text-right {
            float: right;
            border: 1px solid #ddd;
            text-align: right;
            display: inline-block;
            width: 100px;
            position: relative;

        }

        div {
            width: 100%;
            display: inline-block;
        }

        header {
            font-weight: bold;
        }

        header h1, header p {
            text-transform: uppercase;
            font-size: 11px;
            margin: 0px;
        }

        .left {
            width: 59%;
            float: left;
            /*  border-right: 1px dotted #9e9a9a; */
            padding-right: 1%;
        }

        .left h2, .left h3, .left h4 {
            text-align: center;
            margin: 0px;
        }

        h1, h3, h2, h4 {
            margin: 0px;
        }

        article div b {
            float: right;
            text-align: right;
            padding: 0px;

        }

        article h5 {
            display: inline-block;
            width: 36%;

            margin: 1px 0px;
        }

        article strong {
            text-transform: uppercase;
            font-weight: normal;
        }

        .bottom {
            width: 100%;
            overflow: hidden;
        }

        .bottom p {
            margin: 0px;
            padding: 0px;
        }

        .bottom div span {
            padding: 0px;
            margin: 0px;
        }

        .note {

            margin: 10px 0;
            font-weight: bold;
        }

        .right {
            width: 39%;
            float: right;
        }

        .right h2, .right h3, .right h4 {
            text-align: center;
        }

        .right article h5 {

        }

        .table {

        }

        .col {

            height: 20px;
            overflow: hidden;

        }

        b {
            font-weight: bold;
        }

        .price-table {
            font-weight: bold;
        }

        .price-table div {
            border-bottom: 1px dotted #000;
        }

        table .border-bottom {
            border-bottom: 1px dotted #000;
            text-align: center;

        }

        table {
            padding: 0px;
            margin: 0px;
            width: 100%;
        }

        table th {
            font-size: 14px;
            height: 25px;
        }

        table tr td {
            padding: 0px;
            margin: 0px;

            font-size: 13px;
        }

        table tr .td-first {
            width: auto;
            overflow: hidden;
            display: inline-block;
            white-space: nowrap;
        }

        .table-border {
            border: 1px solid black;
            width: auto;
            display: inline-block;
            padding: 15px;
            border-collapse: collapse;
        }

        .tg {
            border-collapse: collapse;
            border-spacing: 0;
        }

        .tg td {
            border-color: black;
            border-style: solid;
            border-width: 1px;
            overflow: hidden;
            padding: 10px 5px;
            word-break: normal;
        }

        .tg th {
            border-color: black;
            border-style: solid;
            border-width: 1px;
            font-weight: bold;
            overflow: hidden;
            padding: 10px 5px;
            word-break: normal;
        }

        .tg .tg-baqh {
            font-size: 18px;
            text-align: center;
            vertical-align: top;
            width: 120px;
            height: 18px
        }

        .tg .tg-lqy6 {
            font-size: 18px;
            text-align: right;
            vertical-align: top
        }

        .tg .tg-0lax {
            font-size: 18px;
            text-align: left;
            vertical-align: top
        }
    </style>

    <div class="main" style="width: 2480px; height: 1748px">
        <header>
            <div class="left">
                <h1>
                    CÔNG TY TNHH-TM-DV-TV VÀ DỊCH THUẬT KHẢI PHONG
                </h1>
                <p>
                    182 Nhật Tảo, Phường 8, Quận 10
                </p>

                <p>
                    Hotline: 0902983483 - 0932417833
                </p>
            </div>

            <div class="right" style="float:right; right:0px">
                <img style="width:100px;height:30px; float:right"
                     src="data:image/png;base64,<?php echo e(DNS1D::getBarcodePNG($data['id'], "C39+",3,33,array(1,1,0))); ?>"/>
            </div>
        </header>
        <section>
            <div class="main">

                <h2 style="text-align: center">BIÊN NHẬN DỊCH THUẬT

                </h2>
                <h3 style="text-align: center">SỐ: <?php echo e($data['code']); ?></h3>
                <h4 style="text-align: center">Ngày: <?php echo e(date('d/m/Y')); ?></h4>


                <article>


                    <table>
                        <tr>
                            <td class="td-first" style="width: 100px">
                                Tên khách hàng:
                            </td>
                            <td style="width: 350px">
                                <b><?php echo e($data->Customer()['name']); ?></b>
                            </td>
                            <td class="td-first">
                                ĐT:
                            </td>
                            <td>
                                <b><?php echo e($data->Customer()['phone']); ?></b>
                            </td>
                        </tr>
                    </table>
                    <table>
                        <tr>
                            <td class="td-first" style="width: 100px">
                                Loại văn kiện:
                            </td>
                            <td style="width: 350px">
                                <b><?php echo e($data['name']); ?></b>
                            </td>
                            <td class="td-first">
                                Số lượng:
                            </td>
                            <td>
                                <b> <?php echo e($data['name_number']); ?></b>
                            </td>
                        </tr>
                    </table>

                    <table>
                        <tr>
                            <td class="td-first" style="width: 100px">
                                Tên trong hồ sơ:
                            </td>
                            <td style="text-align: left">
                                <b>  <?php echo e($data['name_docs']); ?></b>
                            </td>

                        </tr>
                    </table>

                    <table>
                        <tr>
                            <td class="td-first" style="width: 100px">
                                Số bản dịch:
                            </td>
                            <td style="text-align: left">
                                <b>  <?php echo e($data['sobandich']); ?></b>
                            </td>

                        </tr>
                    </table>


                    <?php if(count($data->OrderCustomer())>0): ?>
                        <?php $OrderCustomer = $data->OrderCustomer()[0];

                        ?>
                    <?php endif; ?>
                    <?php if(count($data->OrderSupplier())>0): ?>
                        <?php $OrderSupplier = $data->OrderSupplier()[0];?>
                    <?php endif; ?>


                    <table>
                        <tr>
                            <td class="td-first" style="width: 100px">
                                Ngày trả hồ sơ:
                            </td>
                            <td style="text-align: left">
                                <b>  <?php echo e($data['ngaytrahoso']); ?> <?php echo e($data['giotrahoso']); ?></b>
                            </td>

                        </tr>
                    </table>

                    <table>
                        <tr>
                            <td class="td-first" style="width: 100px">
                                Công chứng:
                            </td>
                            <td style="text-align: left">
                                <b>    <?php echo e($OrderSupplier['ghichu']); ?></b>
                            </td>

                        </tr>
                    </table>

                    <div>
                    <!--  <span> <b><?php echo e($OrderSupplier['ghichu']); ?></b></span> -->

                    </div>
                    <br>
                    <div>
                    <!--
                    <table style="text-align: center; border: 0.5px solid black">
                        <tr>
                            <td class="table-border" style="height:20px; font-size: 13px; font-weight: bold">Phí dịch thuật </th>
                            <td class="table-border" style="height:20px; font-size: 13px; font-weight: bold">Công chứng </th>
                            <td class="table-border" style="height:20px; font-size: 13px; font-weight: bold">Dấu Công ty </th>
                            <td class="table-border" style="height:20px; font-size: 13px; font-weight: bold">Sao y </th>
                            <td class="table-border" style="height:20px; font-size: 13px; font-weight: bold">Ngoại vụ </th>
                            <td class="table-border" style="height:20px; font-size: 13px; font-weight: bold">Vận chuyển </th>
                            <td class="table-border" style="height:20px; font-size: 13px; font-weight: bold">Thành tiền </th>
                        </tr>

                        <tr>
                            <td class="table-border"><?php echo e(App\MrData::toPricePrint($OrderCustomer['phidichthuat'])); ?> </td>
                            <td class="table-border"><?php echo e(App\MrData::toPricePrint($OrderCustomer['congchung'])); ?> </td>
                            <td class="table-border"><?php echo e(App\MrData::toPricePrint($OrderCustomer['daucongty'])); ?> </td>
                            <td class="table-border"><?php echo e(App\MrData::toPricePrint($OrderCustomer['saoy'])); ?> </td>
                            <td class="table-border"><?php echo e(App\MrData::toPricePrint($OrderCustomer['ngoaivu'])); ?> </td>
                            <td class="table-border"><?php echo e(App\MrData::toPricePrint($OrderCustomer['phivanchuyen'])); ?> </td>
                            <td class="table-border"><?php echo e(App\MrData::toPricePrint($OrderCustomer['tong'])); ?> </td>
                        </tr>

                        <tr class="table-border">
                          <td colspan="6" style="text-align: right">VAT </td>
                          <td class="table-border"><?php echo e(App\MrData::toPricePrint($OrderCustomer['vat'])); ?> </td>
                        </tr>

                        <tr class="table-border">
                          <td colspan="6" style="text-align: right">Tổng tiền thanh toán </td>
                          <td class="table-border"><?php echo e(App\MrData::toPricePrint($OrderCustomer['tong'])); ?> </td>
                        </tr>

                        <tr class="table-border">
                          <td colspan="6" style="text-align: right">Tạm ứng </td>
                          <td class="table-border"><?php echo e(App\MrData::toPricePrint($OrderCustomer['tamung'])); ?> </td>
                        </tr>

                        <tr class="table-border">
                          <td colspan="6" style="text-align: right">Còn lại </td>
                          <td class="table-border"><?php echo e(App\MrData::toPricePrint($OrderCustomer['conglai'])); ?> </td>
                        </tr>

                    </table> -->

                        <table class="tg">
                            <thead>
                            <tr>
                                <th class="tg-baqh">Phí dịch thuật</th>
                                <th class="tg-baqh">Công chứng</th>
                                <th class="tg-baqh">Dấu Công ty</th>
                                <th class="tg-baqh">Sao y</th>
                                <th class="tg-baqh">Ngoại vụ</th>
                                <th class="tg-baqh">Vận chuyển</th>
                                <th class="tg-baqh">Thành tiền</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td class="tg-baqh"><?php echo e(App\MrData::toPricePrint($OrderCustomer['phidichthuat'])); ?></td>
                                <td class="tg-baqh"><?php echo e(App\MrData::toPricePrint($OrderCustomer['congchung'])); ?></td>
                                <td class="tg-baqh"><?php echo e(App\MrData::toPricePrint($OrderCustomer['daucongty'])); ?></td>
                                <td class="tg-baqh"><?php echo e(App\MrData::toPricePrint($OrderCustomer['saoy'])); ?></td>
                                <td class="tg-baqh"><?php echo e(App\MrData::toPricePrint($OrderCustomer['ngoaivu'])); ?></td>
                                <td class="tg-baqh"><?php echo e(App\MrData::toPricePrint($OrderCustomer['phivanchuyen'])); ?></td>
                                <td class="tg-baqh" style="text-align: right"><?php echo e(App\MrData::toPricePrint($OrderCustomer['tong']-$OrderCustomer['vat'])); ?></td>
                            </tr>
                            <tr>
                                <td class="tg-lqy6" colspan="6" style="padding-right:2px">VAT</td>
                                <td class="tg-baqh" style="text-align: right"><?php echo e(App\MrData::toPricePrint($OrderCustomer['vat'])); ?> </td>
                            </tr>
                            <tr>
                                <td class="tg-lqy6" colspan="6" style="padding-right:2px">Tổng tiền thanh toán</td>
                                <td class="tg-baqh" style="text-align: right"><?php echo e(App\MrData::toPricePrint($OrderCustomer['tong'])); ?></td>
                            </tr>
                            <tr>
                                <td class="tg-lqy6" colspan="6" style="padding-right:2px">Tạm ứng</td>
                                <td class="tg-baqh" style="text-align: right"><?php echo e(App\MrData::toPricePrint($OrderCustomer['tamung'])); ?></td>
                            </tr>
                            <tr>
                                <td class="tg-lqy6" colspan="6" style="padding-right:2px">Còn lại</td>
                                <td class="tg-baqh" style="text-align: right"><?php echo e(App\MrData::toPricePrint($OrderCustomer['conglai'])); ?></td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                <!--
                    <div class="bottom">

                        <div style="width:31%;float:left;" class="table" >
                                  <div class="col col-1">
                                        Phí dịch thuật:
                                 </div>
                                  <div class="col col-2">
                                    Công chứng:
                                 </div>
                                 <div class="col col-3">
                                     Dấu công ty:
                                </div>
                                <div class="col col-4">
                                    Sao y:
                                </div>
                                <div class="col col-5">Ngoại vụ:</div>
                                <div class="col col-6">Phí VC:</div>
                                <div class="col col-7">VAT</div>
                                <div class="col col-8">Tổng cộng:</div>
                                <div class="col col-9">Tạm ứng:</div>
                                <div class="col col-10"> Còn lại:</div>

                        </div>
                         <div style="width:35%;float:left;text-align: right;" class="table price-table">

                            <div class="col col-1">
                               <?php echo e(App\MrData::toPricePrint($OrderCustomer['phidichthuat'])); ?>

                        </div>
                          <div class="col col-2">
<?php echo e(App\MrData::toPricePrint($OrderCustomer['congchung'])); ?>

                        </div>
                          <div class="col col-3">
<?php echo e(App\MrData::toPricePrint($OrderCustomer['daucongty'])); ?>

                        </div>
                          <div class="col col-4">
<?php echo e(App\MrData::toPricePrint($OrderCustomer['saoy'])); ?>

                        </div>
                          <div class="col col-5">
<?php echo e(App\MrData::toPricePrint($OrderCustomer['ngoaivu'])); ?>

                        </div>
                          <div class="col col-6">
<?php echo e(App\MrData::toPricePrint($OrderCustomer['phivanchuyen'])); ?>

                        </div>
                        <div class="col col-7">
<?php echo e(App\MrData::toPricePrint($OrderCustomer['vat'])); ?>


                        </div>
                          <div class="col col-8">
<?php echo e(App\MrData::toPricePrint($OrderCustomer['tong'])); ?>

                        </div>

                        <div  class="col col-9">
<?php echo e(App\MrData::toPricePrint($OrderCustomer['tamung'])); ?>

                        </div>
                        <div class="col col-110">
<?php echo e(App\MrData::toPricePrint($OrderCustomer['conglai'])); ?>

                        </div>



                    </div> -->
            </div>


            <p class="note">
                <i>
                    - Biên nhận này chỉ có giá trị trong 1 tháng
                </i>
                <br>
                <i>
                    - Quý khách mang theo biên nhận này khi đến nhận hồ sơ
                </i>
            </p>
            <div style="text-align: right">

                Người lập phiếu <br/><br/><br/><br/>
                <?php echo e($data->User()['name']); ?>

            </div>
            </article>

    </div>

<!--
            <div class="right">


                <h2>PHIẾU DỊCH THUẬT</h2>
                 <h3>SỐ: <?php echo e($data['code']); ?></h3>
                <h4>Ngày: <?php echo e(date('d/m/Y')); ?></h4>
                <article>


                     <table  >
                            <tr>
                                    <td class="td-first">
                                      Tên khách hàng:
                                    </td>
                                    <td class="border-bottom">
                                      <b><?php echo e($data->Customer()['name']); ?></b>
                                    </td>

                            </tr>
                        </table>
                         <table  >
                            <tr>
                                    <td class="td-first">
                                      Loại văn kiện:
                                    </td>
                                    <td class="border-bottom">
                                     <b><?php echo e($data['name']); ?></b>
                                    </td>
                                     <td class="td-first">
                                      Số lượng:
                                    </td>
                                    <td class="border-bottom">
                                     <b> <?php echo e($data['name_number']); ?></b>
                                    </td>

                            </tr>
                        </table>

                        <table  >
                            <tr>
                                    <td class="td-first">
                                      Tên trong hồ sơ:
                                    </td>
                                    <td class="border-bottom">
                                      <b><?php echo e($data['name_docs']); ?></b>
                                    </td>

                            </tr>
                        </table>
                        <table  >
                            <tr>
                                    <td class="td-first">
                                      Số bản dịch:
                                    </td>
                                    <td class="border-bottom">
                                      <b><?php echo e($data['sobandich']); ?></b>
                                    </td>

                            </tr>
                        </table>

                         <table  >
                            <tr>
                                    <td class="td-first">
                                      Tên phiên dịch
                                    </td>
                                    <td class="border-bottom">
                                      <b><?php echo e($data->Supplier()['name']); ?></b>
                                    </td>

                            </tr>
                        </table>

                    <div>
                        <span>&nbsp;</span> <strong><b><?php echo e($OrderSupplier['ghichu']); ?></b></strong>
                    </div>

                    <table  >
                            <tr>
                                    <td class="td-first">
                                      Email
                                    </td>
                                    <td class="border-bottom">
                                      <b><?php echo e($data->Customer()['email']); ?></b>
                                    </td>

                            </tr>
                        </table>
                    <table  >
                            <tr>
                                    <td class="td-first">
                                      Ngày trả hồ sơ:
                                    </td>
                                    <td class="border-bottom">
                                    <b><?php echo e($data['ngaytrahoso']); ?> <?php echo e($data['giotrahoso']); ?></b>
                                    </td>

                            </tr>
                        </table>


                </article>

                     <img style="width:100px;height:30px"  src="data:image/png;base64,<?php echo e(DNS1D::getBarcodePNG($data['id'], "C39+",3,33,array(1,1,0))); ?>" />

            </div> -->
    </section>
</div>
</div>
