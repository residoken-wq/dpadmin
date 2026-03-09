@extends("admin.admin")
 @section('content')

            <ol class="breadcrumb">
                <li class="breadcrumb-item"> Trang chủ </li>
                <li class="breadcrumb-item"><a href="">Quản lý Phiếu Chi theo {{$value}} </a>
                </li>
               
              
            </ol>


        <div class="container-fluid">
           
           
           
         
 

<div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-header">
                                    <i class="fa fa-align-justify"></i> Danh Sách Phiếu chi: <strong>{{$detail_supplier['name']}} </strong>|  <strong>{{$value}} </strong><span class="badge badge-pill badge-danger"> {{$data_list->total()}}</span> 
                                </div>
                                <div class="card-block">
                                     <table class="table table-sm  table-bordered table-striped dataTable">
                                        <thead>
                                            <tr>
                                                <th>Người chi tiền  </th>
                                                <th> Số tiền  </th>
                                                <th> Nhân viên xử lý   </th>
                                                <th> Lý do   </th>
                                                <th> Ghi chú </th>
                                                
                                                <th> Tuỳ chọn </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach($data_list as $list):?>
                                                
                                            <tr>
                                                <td><?php echo $list['nguoichi'];?></td>
                                                  <td><?php echo App\MrData::toPrice($list['price']);?></td>
                                                    <td><?php echo $list->User()['name'];?></td>
                                                      <td><?php echo $list['lydo'];?></td>
                                                        <td><?php echo $list['ghichu'];?></td>
                                                         
                                                <td>
                                                    
                                                      <a  style="font-size:12px;padding: 2px "   href='/admin/index/edit/{{$list["cid_form"]}}'> Phiếu Dịch  </a>
                                              
                                                </td>

                                            </tr>
                                           
                                           <?php endforeach;?>
                                           
                                        </tbody>
                                    </table>
                                    <nav>
                                        {!! $data_list->appends($search)->render() !!}
                                       
                                    </nav>
                                </div>
                            </div>
                        </div>
                        <!--/.col-->
                    </div>
     @endsection
    @section('script_js') 
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
            });
        </script>
        
    @endsection