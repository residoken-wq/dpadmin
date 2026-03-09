<div class='body'>
    <style type="text/css">
        .body
        {

            font-size: 13px;
            color: #000;
            width: 100%;
            margin:0px;
            padding: 0px;
            float: left;
            position: relative;
            font-family:  Arial, Tahoma, Helvetica;

        }

        .main
        {
            width: 100%;

            margin: 0 auto;
            overflow: hidden;
        }
        .text-right{
            float: right;
            border: 1px solid #ddd;
            text-align: right;
            display: inline-block;
            width: 100px;
            position: relative;

        }
        div{
          width:100%;
          display: inline-block;
        }
        header
        {
            font-weight: bold;
        }
        header h1, header p
        {
            text-transform: uppercase;
            font-size: 11px;
            margin:0px;
        }
        .left
        {
            width: 59%;
            float: left;
            border-right: 1px dotted #9e9a9a;
            padding-right: 1%;
        }
        .left h2, .left h3, .left h4
        {
            text-align: center;
            margin:0px;
        }
        h1,h3,h2,h4{
            margin:0px;
        }
        article  div  b
        {
            float: right;
            text-align: right;
            padding: 0px;

        }

        article h5{
            display: inline-block;
            width: 36%;

            margin: 1px 0px;
        }
        article strong
        {
            text-transform: uppercase;
            font-weight: normal;
        }
        .bottom
        {
            width: 100%;
            overflow: hidden;
        }
        .bottom  p
        {
            margin:0px;
            padding: 0px;
        }
        .bottom div span
        {
            padding: 0px;
            margin:0px;
        }
        .note
        {

            margin: 10px 0;
            font-weight: bold;
        }
        .right
        {
            width: 39%;
            float: right;
        }
        .right h2, .right h3, .right h4
        {
            text-align: center;
        }
        .right article h5
        {

        }
        .table{

        }
        .col{

           height: 20px;
           overflow: hidden;

        }
        b
        {
            font-weight: bold;
        }

        .price-table{
            font-weight: bold;
        }
        .price-table div{
            border-bottom: 1px dotted #000;
        }
        table .border-bottom{
            border-bottom: 1px dotted #000;
            text-align: center;

        }
        table{
            padding: 0px;
            margin: 0px;
            width: 100%;
        }
        table tr td{
            padding: 0px;
            margin: 0px;

            font-size:13px;
        }
        table tr .td-first{
            width: auto;
            overflow: hidden;
            display: inline-block;
            white-space: nowrap;
        }
    </style>

  <div class="main">
    <header>
      <div class="left">
            <h1>
                CÔNG TY TNHH-TM-DV-TV VÀ DỊCH THUẬT KHẢI PHONG
            </h1>
            <p>
                182 Nhật Tảo, Phường 8, Quận 10
            </p>

            <p>
                Hotline: 0902983483  -  0932417833
            </p>
      </div>

      <div class="right">
            <img style="width:100px;height:30px" src="data:image/png;base64,{{DNS1D::getBarcodePNG($data['id'], "C39+",3,33,array(1,1,0)) }}" />
      </div>
    </header>
        <section>
            <div class="main">

                <h2 style="text-align: center">PHIẾU DỊCH THUẬT

                </h2>
                <h3 style="text-align: center">SỐ: {{$data['code']}}</h3>
                <h4 style="text-align: center">Ngày: {{date('d/m/Y')}}</h4>


                <article>



                    <table  >
                            <tr>
                                    <td class="td-first" >
                                       Tên khách hàng:
                                    </td>
                                    <td class="border-bottom">
                                       <b >{{$data->Customer()['name']}}</b>
                                    </td>
                                    <td class="td-first">
                                       ĐT
                                    </td>
                                    <td class="border-bottom">
                                         <b>{{$data->Customer()['phone']}}</b>
                                    </td>
                            </tr>
                        </table>
                        <table  >
                            <tr>
                                    <td class="td-first">
                                       Loại văn kiện:
                                    </td>
                                    <td class="border-bottom">
                                       <b>{{$data['name']}}</b>
                                    </td>
                                    <td class="td-first">
                                    Số lượng:
                                    </td>
                                    <td class="border-bottom">
                                         <b> {{$data['name_number']}}</b>
                                    </td>
                            </tr>
                        </table>

                          <table  >
                            <tr>
                                    <td class="td-first">
                                      Tên trong hồ sơ:
                                    </td>
                                    <td class="border-bottom">
                                       <b>{{$data['name_docs']}}</b>
                                    </td>

                            </tr>
                        </table>

                          <table  >
                            <tr>
                                    <td class="td-first">
                                      Số bản dịch:
                                    </td>
                                    <td class="border-bottom">
                                       <b>{{$data['sobandich']}}</b>
                                    </td>

                            </tr>
                        </table>


                   @if(count($data->OrderCustomer())>0)
                  <?php $OrderCustomer=$data->OrderCustomer()[0];?>
                          @endif
                       @if(count($data->OrderSupplier())>0)
                  <?php $OrderSupplier=$data->OrderSupplier()[0];?>
                  @endif


                    <table  >
                            <tr>
                                    <td class="td-first">
                                      Ngày trả hồ sơ:
                                    </td>
                                    <td class="border-bottom">
                                       <b>{{$data['ngaytrahoso']}} {{$data['giotrahoso']}}</b>
                                    </td>

                            </tr>
                        </table>



                    <div>
                        <span> <b>{{$OrderSupplier['ghichu']}}</b></span>

                    </div>
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
                               {{App\MrData::toPricePrint($OrderCustomer['phidichthuat'])}}
                            </div>
                              <div class="col col-2">
                               {{App\MrData::toPricePrint($OrderCustomer['congchung'])}}
                            </div>
                              <div class="col col-3">
                               {{App\MrData::toPricePrint($OrderCustomer['daucongty'])}}
                            </div>
                              <div class="col col-4">
                               {{App\MrData::toPricePrint($OrderCustomer['saoy'])}}
                            </div>
                              <div class="col col-5">
                               {{App\MrData::toPricePrint($OrderCustomer['ngoaivu'])}}
                            </div>
                              <div class="col col-6">
                               {{App\MrData::toPricePrint($OrderCustomer['phivanchuyen'])}}
                            </div>
                            <div class="col col-7">
                                 {{App\MrData::toPricePrint($OrderCustomer['vat'])}}

                            </div>
                              <div class="col col-8">
                               {{App\MrData::toPricePrint($OrderCustomer['tong'])}}
                            </div>

                            <div  class="col col-9">
                               {{App\MrData::toPricePrint($OrderCustomer['tamung'])}}
                            </div>
                            <div class="col col-110">
                               {{App\MrData::toPricePrint($OrderCustomer['conglai'])}}
                            </div>



                        </div>
                    </div>


                    <p class="note">
                        <i>
                            -	Biên nhận này chỉ có giá trị trong 1 tháng
                        </i><i>
                            -	Quý khách mang theo biên nhận này khi đến nhận hồ sơ
                        </i>
                    </p>
                    <div style="text-align: right">
                        <br/><br/><br/><br/><br/>
                        Người lập phiếu <br/><br/><br/><br/>
                         {{$data->User()['name']}}
                    </div>
                </article>

            </div>

<!--
            <div class="right">


                <h2>PHIẾU DỊCH THUẬT</h2>
                 <h3>SỐ: {{$data['code']}}</h3>
                <h4>Ngày: {{date('d/m/Y')}}</h4>
                <article>


                     <table  >
                            <tr>
                                    <td class="td-first">
                                      Tên khách hàng:
                                    </td>
                                    <td class="border-bottom">
                                      <b>{{$data->Customer()['name']}}</b>
                                    </td>

                            </tr>
                        </table>
                         <table  >
                            <tr>
                                    <td class="td-first">
                                      Loại văn kiện:
                                    </td>
                                    <td class="border-bottom">
                                     <b>{{$data['name']}}</b>
                                    </td>
                                     <td class="td-first">
                                      Số lượng:
                                    </td>
                                    <td class="border-bottom">
                                     <b> {{$data['name_number']}}</b>
                                    </td>

                            </tr>
                        </table>

                        <table  >
                            <tr>
                                    <td class="td-first">
                                      Tên trong hồ sơ:
                                    </td>
                                    <td class="border-bottom">
                                      <b>{{$data['name_docs']}}</b>
                                    </td>

                            </tr>
                        </table>
                        <table  >
                            <tr>
                                    <td class="td-first">
                                      Số bản dịch:
                                    </td>
                                    <td class="border-bottom">
                                      <b>{{$data['sobandich']}}</b>
                                    </td>

                            </tr>
                        </table>

                         <table  >
                            <tr>
                                    <td class="td-first">
                                      Tên phiên dịch
                                    </td>
                                    <td class="border-bottom">
                                      <b>{{$data->Supplier()['name']}}</b>
                                    </td>

                            </tr>
                        </table>

                    <div>
                        <span>&nbsp;</span> <strong><b>{{$OrderSupplier['ghichu']}}</b></strong>
                    </div>

                    <table  >
                            <tr>
                                    <td class="td-first">
                                      Email
                                    </td>
                                    <td class="border-bottom">
                                      <b>{{$data->Customer()['email']}}</b>
                                    </td>

                            </tr>
                        </table>
                    <table  >
                            <tr>
                                    <td class="td-first">
                                      Ngày trả hồ sơ:
                                    </td>
                                    <td class="border-bottom">
                                    <b>{{$data['ngaytrahoso']}} {{$data['giotrahoso']}}</b>
                                    </td>

                            </tr>
                        </table>


                </article>

                     <img style="width:100px;height:30px"  src="data:image/png;base64,{{DNS1D::getBarcodePNG($data['id'], "C39+",3,33,array(1,1,0)) }}" />

            </div> -->
        </section>
  </div>
</div>
