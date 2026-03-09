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
            
           border-bottom: 1px dotted #000;
           padding:5px 10px;
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
            
        }
    </style>

  <div class="main">
    <header>
            <h1>
                CÔNG TY TNHH-TM-DV-TV DỊCH THUẬT ĐỈNH PHONG
            </h1>
            <p>
                182 Nhật Tảo, Phường 8, Quận 10
            </p>
            <p>
                ĐT/Fax: 083.8530300
            </p>
            <p>
                HOTLINE: 0902983483-0902983483
            </p>
        </header>
        <section>
            <div class="left">
                <h2>PHIẾU DỊCH THUẬT</h2>
                <h3>SỐ: {{$data['code']}}</h3>
                <h4>Ngày: {{date('d/m/Y')}}</h4>
                <article>
                 
                


                    <div>
                        <span>Tên khách hàng:</span> <span><b>{{$data->Customer()['name']}}</b></span>
                        <span>ĐT &nbsp;&nbsp;</span> <span><b>{{$data->Customer()['phone']}}</b></span>
                    </div>
                    <div>
                        <span>Loại văn kiện:</span> <span><b>{{$data['name']}}</b> số lượng:<b> {{$data['name_number']}}</b></span>
                    </div>
                    <div>
                        <span>Tên trong hồ sơ:</span> <span><b>{{$data['name_docs']}}</b></span>
                    </div>
                    <div>
                        <span>Số bản dịch: </span> <span><b>{{$data['sobandich']}} &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</b></span>
                         @if(count($data->OrderCustomer())>0)
                  <?php $OrderCustomer=$data->OrderCustomer()[0];?>
                          @endif
                       @if(count($data->OrderSupplier())>0)
                  <?php $OrderSupplier=$data->OrderSupplier()[0];?>
                  @endif
                    </div>
                    <div>
                        <span>Ngày trả hồ sơ:</span> <span><b>{{$data['ngaytrahoso']}} {{$data['giotrahoso']}}</b></span>
                       
                    </div>
                    <div>
                        <span> <b>{{$OrderSupplier['ghichu']}}</b></span>
                      
                    </div>
                    <div class="bottom">
                        <div style="width:33%;float:left">
                            <br/><br/><br/><br/><br/>
                            Người lập phiếu <br/><br/><br/><br/>
                             {{Auth::user()->name}}
                        </div>
                       
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
                               {{$OrderCustomer['vat']}}
                            </div>
                              <div class="col col-8">
                               {{App\MrData::toPricePrint($OrderCustomer['tong'])}}
                            </div>

                            <div  class="col col-9">
                               {{App\MrData::toPricePrint($OrderCustomer['tamung'])}}
                            </div>
                            <div class="col col-110">
                               {{App\MrData::toPricePrint($OrderCustomer['conlai'])}}
                            </div>

                                 

                        </div>
                    </div>


                    <p class="note">
                        <i>
                            ( Phiếu này chỉ có giá trị trong 1 tháng)
                        </i>
                    </p>
                           <img style="width:150px;margin-top:0px" src="data:image/png;base64,{{DNS1D::getBarcodePNG($data['id'], "C39+",3,33,array(1,1,0)) }}" />
                </article>
            </div>
            <div class="right">

                  
                <h2>PHIẾU DỊCH THUẬT</h2>
                 <h3>SỐ: {{$data['code']}}</h3>
                <h4>Ngày: {{date('d/m/Y')}}</h4>
                <article>
                    <div>
                        <span>Tên khách hàng:</span> <span><b>{{$data->Customer()['name']}}</b></span>
                    </div>
                    <div>
                        <span>Loại văn kiện:</span> <span><b>{{$data['name']}}</b> số lượng:<b> {{$data['name_number']}}</span>
                    </div>
                    <div>
                        <span>Tên trong hồ sơ:</span> <span><b>{{$data['name_docs']}}</b></span>
                    </div>
                    <div>
                        <span>Số bản dịch: </span> <span><b>{{$data['sobandich']}} </b></span>
                    </div>
                    <div>
                        <span>Tên phiên dịch</span> <span><b>{{$data->Supplier()['name']}}</b></span>
                    </div>
                    <div>
                        <span>&nbsp;</span> <strong><b>{{$OrderSupplier['ghichu']}}</b></strong>
                    </div>
                    <div>
                        <span>Email</span> <strong><b>{{$data->Customer()['email']}}</b></strong>
                    </div>
                    <div>
                        <span>Ngày trả hồ sơ:</span> <strong><b>{{$data['ngaytrahoso']}} {{$data['giotrahoso']}}</b></strong>
                    </div>
                </article>
                
                                                    

                                                    <img style="width:100px;margin-top:30px" src="data:image/png;base64,{{DNS1D::getBarcodePNG($data['id'], "C39+",3,33,array(1,1,0)) }}" />
                                                  
            </div>
        </section>
  </div>
</div>