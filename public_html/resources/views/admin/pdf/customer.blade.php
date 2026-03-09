<htmlpageheader name="page-header">
  
</htmlpageheader>

<htmlpagecontent name="page-content">
    <style type="text/css">
      @page {
          header: page-header;
          footer: page-footer;
        }

    </style>
        <div class="row container-fluid">
           
            <div class="col-xs-12 col-sm-12 col-lg-12 ">
                                <div class="card">
                                      <div class="card-header">
                                                <strong> Phiếu Dịch   </strong>
                                              
                                            </div>
                                    <div class="card-body">
                                        <div class="row">
                                            
                                            <div class="col-sm-5">

                                                <div class="form-group">
                                                    <label for="name"> Số: </label>
                                                 {{$data['code']}}
        
                                                  
                            
                                                </div>

                                            </div>

                                              
                                            <div class="col-sm-5">

                                                <div class="form-group">
                                                    <label for="name"> Ngày: </label>
                              {{$data['created_at']}}
      
                                                  
                            
                                                </div>

                                            </div>
                                            <div class="col-sm-10">

                                                <div class="form-group">
                                                    <label for="name">Tên Khách Hàng: </label>

                                                  {{$data->Customer()['name']}}

                                                    
                                                </div>

                                            </div>

                                            <div class="col-sm-10">

                                                <div class="form-group">
                                                    <label for="name">Loại văn kiện : </label>
        {{$data['name']}}
                                                  
                                                     
                                                </div>

                                            </div>
                                          
                                            <div class="col-sm-10">

                                                <div class="form-group">
                                                    <label for="name">Tên trong hồ sơ: </label>
        {{$data['name_docs']}}
                                                            
                                                    
                                                </div>

                                            </div>
                                            <div class="col-sm-10">

                                                <div class="form-group">
                                                    <label for="name">Nhà Cung Cấp : </label>
      
                                                    {{$data->Supplier()['name']}}
                                                </div>

                                            </div>

                                            <div class="col-sm-10">

                                                        <div class="form-group">
                                                            <label for="name">Số điện thoại : </label>
               {{$data['phone']}}
                                                        </div>

                                                    </div>

                                                    <div class="col-sm-10">

                                                        <div class="form-group">
                                                            <label for="name">Số bản dịch: </label>
                 {{$data['sobandich']}}
                                                        </div>

                                                    </div>

                                                    <div class="col-sm-10">

                                                        <div class="form-group">
                                                            <label for="name">Ngày trả hồ sơ : </label>
 {{$data['ngaytrahoso']}} - {{$data['giotrahoso']}}
                                 
                                                            
                                                        </div>

                                                    </div>

                                                   
                                       
                                    </div>
                                </div>

               
                            </div>
            </div>
                @if(count($data->OrderCustomer())>0)
                  <?php $OrderCustomer=$data->OrderCustomer()[0];?>
                             <div class="col-xs-12 col-sm-12 col-lg-12">
                                        <div class="card">
                                            <div class="card-header">
                                                <strong> Khách Hàng  </strong>
                                               
                                            </div>
                                            <div class="card-body">
                                                <div class="row">
                                                    


                                                    
                                                    <div class="col-sm-10">

                                                        <div class="form-group">
                                                           
                                                            <label>Phí dịch thuật  :</label>
                                      <strong style="font-weight: bold">
                                                            {{App\MrData::toPrice($OrderCustomer['phidichthuat'])}}
                                                          </strong>
                                                        
                                                        </div>

                                                    </div>
                                                            

                                                    <div class="col-sm-10">

                                                        <div class="form-group">
                                                           
                                                            <label>Công chứng:</label>
                                      <strong style="font-weight: bold">
                                                            {{App\MrData::toPrice($OrderCustomer['congchung'])}}
                                                          </strong>
                                                        
                                                        </div>

                                                    </div>
                                                            
                                                    <div class="col-sm-10">

                                                        <div class="form-group">
                                                           
                                                            <label>Dấu công ty:</label>
                                      <strong style="font-weight: bold">
                                                            {{App\MrData::toPrice($OrderCustomer['daucongty'])}}
                                                          </strong>
                                                        
                                                        </div>

                                                    </div>

                                                  <div class="col-sm-10">

                                                        <div class="form-group">
                                                           
                                                            <label>Sao y:</label>
                                      <strong style="font-weight: bold">
                                                            {{App\MrData::toPrice($OrderCustomer['saoy'])}}
                                                          </strong>
                                                        
                                                        </div>

                                                    </div>

                                                  <div class="col-sm-10">

                                                        <div class="form-group">
                                                           
                                                            <label>Ngoại vụ:</label>
                                      <strong style="font-weight: bold">
                                                            {{App\MrData::toPrice($OrderCustomer['ngoaivu'])}}
                                                          </strong>
                                                        
                                                        </div>

                                                    </div>

                                                  <div class="col-sm-10">

                                                        <div class="form-group">
                                                           
                                                            <label>Phí vận chuyện  :</label>
                                      <strong style="font-weight: bold">
                                                            {{App\MrData::toPrice($OrderCustomer['phivanchuyen'])}}
                                                          </strong>
                                                        
                                                        </div>

                                                    </div>
                                                  <div class="col-sm-10">

                                                        <div class="form-group">
                                                           
                                                            <label>Vat:</label>
                                      <strong style="font-weight: bold">
                                                            {{$OrderCustomer['vat']}} %
                                                          </strong>
                                                        
                                                        </div>

                                                    </div>
                                                 

                                                   <div class="col-sm-10">

                                                        <div class="form-group">
                                                           
                                                            <label>Tổng cộng :</label>
                                      <strong style="font-weight: bold">
                                                            {{App\MrData::toPrice($OrderCustomer['tong'])}}
                                                          </strong>
                                                        
                                                        </div>

                                                    </div>


                                                    <div class="col-sm-10">

                                                        <div class="form-group">
                                                           
                                                            <label>Tạm ứng :</label>
                                      <strong style="font-weight: bold">
                                                            {{App\MrData::toPrice($OrderCustomer['tamung'])}}
                                                          </strong>
                                                        
                                                        </div>

                                                    </div>  
            
                                                  <div class="col-sm-10">

                                                        <div class="form-group">
                                                           
                                                            <label>Còn lại: </label>
                                      <strong style="font-weight: bold">
                                                            {{App\MrData::toPrice($OrderCustomer['conglai'])}}
                                                          </strong>
                                                        
                                                        </div>

                                                    </div>  


           
                                                              <div class="col-sm-10">

                                                        
                                                                    <label>
                                                                
                                                                  @if($OrderCustomer['approved']=='1')
                                                                    Chưa thanh toán
                                                                  @else
                                                                    Đã nhận đủ 
                                                                  @endif
                                                                  
                                                                  </label>
                                                                         


                                                  </div>           
                                                    

                                                </div>
                                               
                                            </div>
                                        </div>

               
                            </div>
                      @endif      

                      @if(count($data->OrderSupplier())>0)
                  <?php $OrderSupplier=$data->OrderSupplier()[0];?>
                             <div class="col-xs-12 col-sm-12 col-lg-12">
                                        <div class="card">
                                            <div class="card-header">
                                                <strong> Nhà Cung Cấp </strong>
                                               
                                            </div>
                                            <div class="card-body">
                                                <div class="row">
                                                    


                                                    
                                                    <div class="col-sm-10">

                                                        <div class="form-group">
                                                           
                                                            <label>Phí dịch thuật  :</label>
                                      <strong style="font-weight: bold">
                                                            {{App\MrData::toPrice($OrderSupplier['phidichthuat'])}}
                                                          </strong>
                                                        
                                                        </div>

                                                    </div>
                                                            

                                                    <div class="col-sm-10">

                                                        <div class="form-group">
                                                           
                                                            <label>Công chứng:</label>
                                      <strong style="font-weight: bold">
                                                            {{App\MrData::toPrice($OrderSupplier['congchung'])}}
                                                          </strong>
                                                        
                                                        </div>

                                                    </div>
                                                            
                                                    <div class="col-sm-10">

                                                        <div class="form-group">
                                                           
                                                            <label>Dấu công ty:</label>
                                      <strong style="font-weight: bold">
                                                            {{App\MrData::toPrice($OrderSupplier['daucongty'])}}
                                                          </strong>
                                                        
                                                        </div>

                                                    </div>

                                                  <div class="col-sm-10">

                                                        <div class="form-group">
                                                           
                                                            <label>Sao y:</label>
                                      <strong style="font-weight: bold">
                                                            {{App\MrData::toPrice($OrderSupplier['saoy'])}}
                                                          </strong>
                                                        
                                                        </div>

                                                    </div>

                                                  <div class="col-sm-10">

                                                        <div class="form-group">
                                                           
                                                            <label>Ngoại vụ:</label>
                                      <strong style="font-weight: bold">
                                                            {{App\MrData::toPrice($OrderSupplier['ngoaivu'])}}
                                                          </strong>
                                                        
                                                        </div>

                                                    </div>

                                                  <div class="col-sm-10">

                                                        <div class="form-group">
                                                           
                                                            <label>Phí vận chuyện  :</label>
                                      <strong style="font-weight: bold">
                                                            {{App\MrData::toPrice($OrderSupplier['phivanchuyen'])}}
                                                          </strong>
                                                        
                                                        </div>

                                                    </div>
                                                  <div class="col-sm-10">

                                                        <div class="form-group">
                                                           
                                                            <label>Vat:</label>
                                      <strong style="font-weight: bold">
                                                            {{$OrderSupplier['vat']}} %
                                                          </strong>
                                                        
                                                        </div>

                                                    </div>
                                                 

                                                   <div class="col-sm-10">

                                                        <div class="form-group">
                                                           
                                                            <label>Tổng cộng :</label>
                                      <strong style="font-weight: bold">
                                                            {{App\MrData::toPrice($OrderSupplier['tong'])}}
                                                          </strong>
                                                        
                                                        </div>

                                                    </div>




           

                                                   
                                                    

                                                </div>
                                               
                                            </div>
                                        </div>

               
                            </div>
                      @endif      
                          <div class="col-sm-10 text-center">
                                                    <img style="width:200px; display: block; margin: 0 auto;" src="data:image/png;base64,{{DNS1D::getBarcodePNG($data['id'], "C39+",3,33,array(1,1,0)) }}" />
                                                    <div style="margin-top: 8px;">
                                                      @if(count($data->OrderCustomer())>0 && $data->OrderCustomer()[0]['approved'] == '2')
                                                          <span style="color: red; font-weight: bold; font-size: 12.5px; border: 2px solid red; padding: 3px 7px; display: inline-block;">ĐÃ THANH TOÁN (PAID)</span>
                                                      @endif
                                                    </div>
                                                  </div>   
               
                            </div>
                 

             </div>
             <style type="text/css">
                  div{padding: 0px !important,margin:0px !important;}
                  {{include(public_path('/admin/admin/css/style.css'))}}
             </style>
  </htmlpagecontent>
 