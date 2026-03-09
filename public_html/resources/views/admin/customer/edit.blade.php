@extends("admin.admin")
 @section('content')

            <ol class="breadcrumb">
                <li class="breadcrumb-item"> Trang chủ </li>
                <li class="breadcrumb-item"><a href="/admin/customer/lists">Danh sách Khách Hàng  </a>
                </li>
               
              
            </ol>

                  @if(!empty(session('success')))
                      

                         <div id='myMessagerSuccess' class="modal" tabindex="1" role="dialog">
                                  <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                      <div class="modal-header">
                                        <h5 class="modal-title">Thông Báo:</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                          <span aria-hidden="true">&times;</span>
                                        </button>
                                      </div>
                                      <div class="modal-body">
                                          <p>{!!session('success')!!}</p>
                                      </div>
                                      <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">OK</button>
                                      
                                      </div>
                                    </div>
                                  </div>
                                </div>
                    @endif   
             
           {!!Form::open(['method'=>'post','class'=>'s'])!!}
        <div class="row container-fluid">
           
          
            <div class="col-xs-12 col-sm-12 col-lg-12">
                                <div class="card">
                                    <div class="card-header">
                                        <strong> Thông tin tạo mới khách hàng  </strong>
                                        <small>Form</small>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            
                                          
                                            <div class="col-sm-10">

                                                <div class="form-group">
                                                    <label for="name"> Tên khách hàng:  </label>
        {!! Form::text('name',@$data['name'],['class'=>'form-control','autocomplete'=>'on'])!!}
                       @if($errors->has("name")) 
                        <div class="alert alert-danger">* {{$errors->first("name")}}</div>
                       @endif                          
                                                      
                                                    
                                                </div>

                                            </div>
                                              <div class="col-sm-10">

                                                <div class="form-group">
                                                    <label> Khách lẻ :
        {!! Form::checkbox('is_kl','2',($data['is_kl']=='1'?false:true))!!}
                                              </label>
                                                    
                                                </div>

                                            </div>

                                             <div class="col-sm-10">

                                                <div class="form-group">
                                                    <label for="name">Công ty:   </label>
        {!! Form::text('company',@$data['company'],['class'=>'form-control'])!!}
                                                  
                                                     
                                                    
                                                </div>

                                            </div>
                                            
                                             <div class="col-sm-10">

                                                <div class="form-group">
                                                    <label for="name">Địa chỉ:  </label>
        {!! Form::text('address',@$data['address'],['class'=>'form-control'])!!}
                                                  
                                                     
                                                    
                                                </div>

                                            </div>
                                             <div class="col-sm-10">

                                                <div class="form-group">
                                                    <label for="name">Mã số thuế :  </label>
        {!! Form::text('fax',@$data['fax'],['class'=>'form-control','autocomplete'=>'on'])!!}
                                             
                                                      
                                                    
                                                </div>

                                            </div>
                                            <div class="col-sm-10">

                                                <div class="form-group">
                                                    <label for="name">Số điện thoại:  </label>
        {!! Form::text('phone',@$data['phone'],['class'=>'form-control'])!!}
                                                  
                                                     
                                                    
                                                </div>

                                            </div>


                                             <div class="col-sm-10">

                                                <div class="form-group">
                                                    <label for="name">Email :  </label>
        {!! Form::email('email',@$data['email'],['class'=>'form-control'])!!}
                                                </div>

                                            </div>
                                              
                                             <div class="col-sm-10">

                                                <div class="form-group">
                                                    <label for="name">Ghi chú :  </label>
        {!! Form::textarea('note',@$data['note'],['class'=>'form-control','rows'=>3])!!}
                                                </div>

                                            </div>
                                            
                                        </div>
                                       
                                    </div>
                                </div>

               
                            </div>

                            
                             <div class="col-sm-12">
                                       
                                            <div class="card-footer">
                                                <input type='hidden' name='_token' value='{{ csrf_token()}}' />
                                                <button type="submit" class="btn btn-sm btn-primary"><i class="fa fa-save"></i> LƯU </button>
                                                <button type="reset" class="btn btn-sm btn-danger"><i class="fa fa-undo"></i> LÀM LẠI </button>
                                            </div>
                                        </div>

               
                            </div>
                 

             </div>
               {!!Form::close()!!}
    @endsection
    @section("script_js")
        <script type="text/javascript">
            $(document).ready(function(){
                $('#myMessagerSuccess').modal('show');
            });
        </script>
    @endsection    