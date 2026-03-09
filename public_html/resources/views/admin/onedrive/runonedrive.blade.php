@extends("admin.admin")
 @section('content')

            <ol class="breadcrumb">
                <li class="breadcrumb-item"> Trang chủ </li>
                <li class="breadcrumb-item"><a href="">Danh sách thư mục trên OneDrive </a>
                </li>
               
              
            </ol>

        <div class="container-fluid">
                 
           
           
           
 


<div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-header">
                                    <i class="fa fa-align-justify"></i> Danh Sách Thư mục 
                                </div>
                                <div class="card-block">
                                     <table class="table table-sm  table-bordered table-striped dataTable">
                                        <thead>
                                            <tr>
                                                <th>Tên Thư Mục </th>
                                                <th> Thông Tin </th>
                                                <th> Số bản dịch hiện có  </th>
                                                <th> Phiếu Dịch   </th>
                                                <th> Tuỳ chọn </th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            <?php foreach($shared as $list):
                                                $list=(array)$list;
                                                ?>
                                            @if(!empty($list))  
                                            <tr>
                                                <td>
                                        
                                                    {{ $list['name']}}
                                                </td>
                                                <td>
                                        
                                                    {{ $list['from']->name }} <br />
                                                    {{ $list['created_time'] }} <br />
                                                    {{ $list['updated_time'] }}

                                                </td>
                                                <td>
                                        
                                                    {{$list['count']}}
                                                </td>
                                                <td>
                                        
                                                  asdf
                                                </td>
                                                <td>
                                                    tuy chon 
                                                </td>

                                            </tr>
                                            @endif
                                           <?php endforeach;?>
                                           
                                        </tbody>
                                    </table>
                                    
                                </div>
                            </div>
                        </div>
                        <!--/.col-->
                    </div>
     @endsection
    @section('script_js') 
        <script type="text/javascript">
            $("document").ready(function(){
               
            });
        </script>
        
    @endsection