@extends("admin.admin")
 @section('content')

            <ol class="breadcrumb">
                <li class="breadcrumb-item"> Trang chủ </li>
                <li class="breadcrumb-item"><a href="">Quản lý Khách Hàng</a>
                </li>
               
              
            </ol>


        <div class="container-fluid">
           {!! Form::open(['method'=>'get']) !!}
         
           
           
            <div class="row view_search" >

                    <div class="col-sm-3">
                                     <div class="form-group">
                                                    <label for="name"> Tên  Khách Hàng  </label>
 {!! Form::text('name',@$search['name'],['class'=>"form-control" ]) !!}

                                                </div>
                                            </div>
                                             <div class="col-sm-3">
                                     <div class="form-group">
                                                    <label for="name"> Tuỳ chọn  </label>
 {!! Form::select('is_kl',$is_kl,@$search['is_kl'],['class'=>"form-control" ]) !!}

                                                </div>
                                            </div>
                   
                 <div class="col-sm-12">
                      <div class="form-group">
                      <button type="submit" class="btn btn-sm btn-warning"><i class="fa fa-ban"></i> TÌM KIẾM  </button>
                         <?php /*$url=$_SERVER['REQUEST_URI'];
                                $get_request=explode("?", $url);
                                $u = (!empty($get_request[1]))? "?".$get_request[1] : "" ;
                            /admin/supplier/export{{$u}}
                                */
                            ?>
                       
                  </div>
                </div>
                  
        </div>

            

            {!! Form::close()!!}


<div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-header">
                                    <i class="fa fa-align-justify"></i> Danh Sách Khách Hàng<span class="badge badge-pill badge-danger"> {{$data_list->total()}}</span> 
                                </div>
                                <div class="card-block">
                                     <table class="table table-sm  table-bordered table-striped dataTable">
                                        <thead>
                                            <tr>
                                                <th>Mã KH  </th>
                                                <th>Tên KH  </th>
                                                <th>Mã số thuế </th>
                                                <th> Số điện thoại  </th>
                                                <th> Email  </th>
                                                <th> Địa chỉ </th>
                                                 <th> Công ty </th>
                                                <th> Tuỳ chọn </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach($data_list as $list):?>
                                                
                                            <tr>
                                                <td><?php echo $list['code'];?></td>
                                                  <td><?php echo $list['name'];?></td>
                                                   <td><?php echo $list['fax'];?></td>
                                                    <td><?php echo $list['phone'];?></td>
                                                      <td><?php echo $list['email'];?></td>
                                                        <td><?php echo $list['address'];?></td>
                                                          <td><?php echo $list['company'];?></td>
                                                <td>
                                                    <a class="btn btn-sm btn-success" href='/admin/customer/edit/<?php echo $list['id'];?>'><i class="fa fa-edit"></i> Sửa </a><br /><br />
                                                    @if(count($list->Form())==0)
                                                    <a class="btn btn-sm btn-danger click_remove" href='/admin/customer/remove?id=<?php echo $list['id'];?>&_token={{csrf_token()}}'> <i class="fa fa-remove"></i> Xoá  </a>
                                                    @endif
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