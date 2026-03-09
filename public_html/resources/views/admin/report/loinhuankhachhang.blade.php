@extends("admin.admin")
 @section('content')

            <ol class="breadcrumb">
                <li class="breadcrumb-item"> Trang chủ </li>
                <li class="breadcrumb-item"><a href="">BÁO CÁO DOANH SỐ KHÁCH HÀNG </a>
                </li>
               
              
            </ol>



        <div class="container-fluid">
             {!! Form::open(['method'=>'get']) !!}
         
           
           
            <div class="row view_search" >

                      <div class="col-sm-3">
                                     <div class="form-group">
                                                    <label for="name">Khách hàng:  </label>
 
  {!! Form::select('customer',$customer,@$search['customer'],['class'=>"form-control cid_customer" ,"autocomplete"=>"off"]) !!}                                                  
                                                </div>
                                            </div>


                                  <div class="col-sm-3">
                                     <div class="form-group">
                                                    <label for="name">theo: </label>
 
  {!! Form::select('filter',$filter,@$search['filter'],['class'=>"form-control" ,"autocomplete"=>"off"]) !!}                                                  
                                                </div>
                                            </div>

                                  <div class="col-sm-3">
                                     <div class="form-group">
                                                    <label for="name">Từ  Ngày  </label>
 {!! Form::text('date_from',@$search['date_from'],['class'=>"form-control" ,'id'=>"from","autocomplete"=>"off"]) !!}

                                                </div>
                                            </div>
                                   <div class="col-sm-3">
                                     <div class="form-group">
                                                    <label for="name">Đến Ngày  </label>
 {!! Form::text('date_to',@$search['date_to'],['class'=>"form-control" ,'id'=>'to',"autocomplete"=>"off"]) !!}

                                                </div>
                                            </div>
                   
                 <div class="col-sm-12">
                      <div class="form-group">
                      <button type="submit" class="btn btn-sm btn-warning"><i class="fa fa-ban"></i> TÌM KIẾM  </button>
                        
                         <button type="submit" class="btn btn-sm btn-success" name='export' value='excel'><i class="fa fa-export"></i> EXPORT EXCEL </button>
                  </div>
                </div>
                  
        </div>

            

            {!! Form::close()!!}
         
           
         </div>  
         
 


        <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-header">
                                    <i class="fa fa-align-justify"></i> DOANH SỐ  : <strong class="text text-danger"> {{$cus['name']}} </strong>  ( {{$cus['is_kl']=='2'?' Khách Lẻ':'Khách hàng '}})
                                       
                                         <span class="badge badge-pill badge-danger"> {{$data_list->total()}}</span> 
                                         


                                         
                                </div>
                                <div class="card-block">
                                     <table class="table table-sm  table-bordered table-striped dataTable">
                                        <thead>
                                            <tr>
                                                <th>  

                                                 @if($search['filter']=='1')
                                                     Ngày
                                                    @endif
                                                     @if($search['filter']=='2')
                                                     Tháng 
                                                    @endif
                                                     @if($search['filter']=='3')
                                                     Năm 
                                                    @endif

                                                </th>
                                                
                                                <th> Tổng Số tiền Thu </th>
                                                <th> Tam ứng  </th> 
                                                 <th>  Tổng </th> 
                                              
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach($data_list as $list):?>
                                                <?php 
                                                    $thu= $list->KH_TongThu($search['filter'],$cus->id);
                                                    
                                                    if(!empty($thu['tong'])):
                                                  ?>
                                            <tr>
                                                <td>
                                                    @if($search['filter']=='1')
                                                    <?php $value= Date("d-m-Y",strtotime($list['my_date'])); ?>
                                                     {{Date("d-m-Y",strtotime($list['my_date']))}}
                                                    @endif
                                                     @if($search['filter']=='2')
                                                      <?php $value= Date("m",strtotime($list['my_date'])); ?>
                                                     {{Date("m",strtotime($list['my_date']))}}
                                                     -
                                                     <?php $value= Date("Y",strtotime($list['my_date'])); ?>
                                                     {{Date("Y",strtotime($list['my_date']))}}
                                                    @endif
                                                     @if($search['filter']=='3')
                                                      <?php $value= Date("Y",strtotime($list['my_date'])); ?>
                                                     {{Date("Y",strtotime($list['my_date']))}}
                                                    @endif
                                                </td>
                                                

                                                 


                                                <td> {{ App\MrData::toPrice($thu['tong'])}}

                                                </td>
                                                <td>  
                                                  {{ App\MrData::toPrice($thu['tamung'])}}
                                                   </td> 
                                                     <td>  
                                                  
                                                 
                                                    {{ App\MrData::toPrice($thu['total'])}}
                                                 
                                                   </td> 
                                                 
                                            </tr>
                                            
                                           <?php 

                                            endif;
                                          endforeach;?>
                                           
                                        </tbody>
                                    </table>
                                    <nav>
                                       {!! $data_list->appends($search)->render() !!}
                                       
                                    </nav>
                                </div>
                            </div>
                        </div>

                         <div class="col-lg-12">
                            <div class="card">
                                <div class="card-header">
                                    <i class="fa fa-align-justify"></i> Tổng Doanh Số: 
                                         <?php 

                                         $total =App\Model\OrderCustomer::select(DB::raw(" sum(tong) AS tong, SUM(tamung) as tamung ,sum(tong-tamung) as total"))->whereRaw(" cid_customer={$cus->id} ")->first(); ?>


                                         
                                </div>
                                <div class="card-block">
                                     <table class="table table-sm  table-bordered table-striped dataTable">
                                        <thead>
                                           
                                        </thead>
                                        <tbody>
                                          <tr>
                                                
                                                
                                               
                                               
                                                 
                                              
                                            </tr>
                                            <tr>
                                                
                                                 <th> Tổng Số tiền Thu </th>

                                                <td >
                                                  <h5  class="text text-primary">
                                                 {{ App\MrData::toPrice($total['tong'])}}
                                                 </h5>

                                                </td>
                                            </tr>
                                            <tr>
                                               <th> Tam ứng  </th> 
                                                <td>  
                                                  <h5  class="text text-primary">
                                                  {{ App\MrData::toPrice($total['tamung'])}}
                                                </h5>
                                                   </td> 
                                            </tr>
                                            <tr>
                                              <th>  Tổng </th> 
                                                     <td>  
                                                  <h5  class="text text-primary">
                                                 
                                                    {{ App\MrData::toPrice($total['total'])}}
                                                  </h5>
                                                 
                                                   </td> 
                                                 
                                            </tr>
                                          
                                           
                                        </tbody>
                                    </table>
                                    <nav>
                                      
                                       
                                    </nav>
                                </div>
                            </div>
                        </div>
                        <!--/.col-->
                    </div>



     @endsection
    @section('script_js') 
     <script type="text/javascript" src="/admin/bower_components/time-picker/dist/time-picker.js"></script>
        <script type="text/javascript" src="/admin/bower_components/jqueryui-datepicker/datepicker.js"></script>
       <script src="/js/jquery.flexselect.js"></script> 
         <script src="/js/liquidmetal.js"></script>
        <link rel="stylesheet" type="text/css" href="/css/flexselect.css">

        <link rel="stylesheet" type="text/css" href="/admin/bower_components/jqueryui-datepicker/datepicker.css">
           <link rel="stylesheet" type="text/css" href="/admin/bower_components/time-picker/dist/time-picker.css">
        <script type="text/javascript">
            $("document").ready(function(){
                $(".click_view_search").click(function(){
                    
                    $(".view_search").show();
                    $(this).hide();
                });
                $(".click_reset_form").click(function(){
                      $(".view_search").hide();
                      $(".click_view_search").show();
                });


                
                  var dateFormat = "mm/dd/yy",
                      from = $( "#from" )
                        .datepicker({
                          defaultDate: "-2w",
                          changeMonth: true,
                          numberOfMonths: 3
                          
                        })
                        .on( "change", function() {
                          to.datepicker( "option", "minDate", getDate( this ) );
                        }),
                      to = $( "#to" ).datepicker({
                        defaultDate: "-2w",
                        changeMonth: true,
                        numberOfMonths: 3

                      })
                      .on( "change", function() {
                        from.datepicker( "option", "maxDate", getDate( this ) );
                      });
                 
                    function getDate( element ) {
                      var date;
                      try {
                        date = $.datepicker.parseDate( dateFormat, element.value );
                      } catch( error ) {
                        date = null;
                      }
                 
                      return date;
                    }

                       $("select.cid_customer").flexselect();

            });
        </script>
        
    @endsection