@extends("admin.admin")
 @section('content')

            <ol class="breadcrumb">
                <li class="breadcrumb-item"> Trang chủ </li>
                <li class="breadcrumb-item"><a href="">Danh sách được Shared trên OneDrive </a>
                </li>
               
              
            </ol>

        <div class="container-fluid">
                 
           
           
           
 


<div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-header">
                                    <i class="fa fa-align-justify"></i> 
                                    <a href="/admin/index/runonedrive">
                                    <- Quay lại Danh Sách Thư mục 
                                </a>
                                </div>
                                <div class="card-block">
                                     <table class="table table-sm  table-bordered table-striped dataTable">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Tên Thư Mục </th>
                                                <th> Thông Tin </th>
                                             
                                             
                                            </tr>
                                        </thead>

                                        <tbody>
                                            <?php foreach($shared as $list):
                                                $list=(array)$list;



                                                ?>
                                            @if(!empty($list))  
                                            <tr>
                                                <td>
                                        
                                                    {{ $list['id']}}
                                                </td>
                                                <td>
                                        
                                                    {{ $list['name']}} 
                                                </td>
                                                <td>
                                        
                                                    {{ $list['from']->name }} <br />
                                                   Thời gian tạo: {{ $list['created_time'] }} <br />
                                                   Thời gian sửa: {{ $list['updated_time'] }}

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