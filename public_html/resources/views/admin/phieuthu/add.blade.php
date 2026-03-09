@extends("admin.admin")
 @section('content')

            <ol class="breadcrumb">
                <li class="breadcrumb-item"> Trang chủ </li>
                <li class="breadcrumb-item"><a href="">Tạo mới PHIẾU THU  </a>
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
                                        <strong> Thông tin tạo PHIẾU THU  </strong>
                                        <small>Form</small>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">

                                           <div class="col-sm-10">

                                                <div class="form-group">
                                                    <label for="name">Số tiền :  </label>

                                                             <div class='input-group'>
                                                                 {!! Form::number('price',@$data['price'],[ 'min' => 0,'class'=>'form-control my_price ','id'=>'price'])!!}

                                                                <div class="input-group-addon">
                                                                  VNĐ
                                                                </div>

                                                            </div>
                                                             <p class='view_myprice'></p>

                                   @if($errors->has("price"))
                        <div class="alert alert-danger">* {{$errors->first("price")}}</div>
                       @endif


                                                </div>

                                            </div>
                                            <div class="col-sm-10">

                                                <div class="form-group">
                                                    <label for="name">Tên người nhận tiền :  </label>
        {!! Form::text('nguoinhantien',@$data['nguoinhantien'],['class'=>'form-control','autocomplete'=>'on'])!!}
                       @if($errors->has("nguoinhantien"))
                        <div class="alert alert-danger">* {{$errors->first("nguoinhantien")}}</div>
                       @endif


                                                </div>

                                            </div>


                                             <div class="col-sm-10">

                                                <div class="form-group">
                                                    <label for="name">Lý do :  </label>
        {!! Form::textarea('lydo',@$data['lydo'],['class'=>'form-control','rows'=>4])!!}



                                                </div>

                                            </div>

                                             <div class="col-sm-10">

                                                <div class="form-group">
                                                    <label for="name">Ghi chú  :  </label>
        {!! Form::textarea('ghichu',@$data['ghichu'],['class'=>'form-control','rows'=>4])!!}
                                                </div>

                                            </div>

                                        </div>

                                    </div>
                                </div>


                            </div>


                             <div class="col-sm-12">

                                            <div class="card-footer">
                                                <input type='hidden' name='_token' value='{{ csrf_token()}}' />
                                                <button type="submit" class="btn btn-sm btn-primary"><i class="fa fa-dot-circle-o"></i> LƯU </button>
                                                <button type="reset" class="btn btn-sm btn-danger"><i class="fa fa-ban"></i> LÀM LẠI </button>
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
