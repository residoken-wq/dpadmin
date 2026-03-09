@extends("admin.admin")
 @section('content')

            <ol class="breadcrumb">
                <li class="breadcrumb-item"> Trang chủ </li>
                <li class="breadcrumb-item"><a href="">Thư mục OneDrive </a>
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
                                                
                                                ?>
                                            @if($list->isFolder())  
                                                    <tr>
                                                        <td>
                                                
                                                            {{ $list->getId()}}
                                                        </td>
                                                        <td>
                                                            <a href='/admin/index/runonedrive?id={{$list->getId()}}'>
                                                            {{ $list->getName()}}  ( <small>size: {{ $list->getSize() }}</small>)
                                                             </a>
                                                        </td>
                                                        <td>
                                                
                                                           
                                                           Thời gian tạo: {{ $list->getCreatedTime() }} <br />
                                                           Thời gian sửa: {{ $list->getUpdatedTime() }}

                                                        </td>
                                                    

                                                                <?php 
                                                                   /* $folder     = $onedrive->fetchObject($list->getId());
                                                                    if($folder->isFolder()){
                                                                        echo count($folder->fetchChildObjects() );
                                                                   }*/
                                                                ?>

                                                    
                                                       

                                                    </tr>
                                            @else

                                                    <tr>
                                                        <td>
                                                
                                                            {{ $list->getId()}}
                                                        </td>
                                                        <td>
                                                           
                                                            {{ $list->getName()}}  ( <small>size: {{ $list->getSize() }}</small>)
                                                            
                                                        </td>
                                                        <td>
                                                
                                                           
                                                           Thời gian tạo: {{ $list->getCreatedTime() }} <br />
                                                           Thời gian sửa: {{ $list->getUpdatedTime() }}

                                                        </td>
                                                    

                                                                <?php 
                                                                   /* $folder     = $onedrive->fetchObject($list->getId());
                                                                    if($folder->isFolder()){
                                                                        echo count($folder->fetchChildObjects() );
                                                                   }*/
                                                                ?>

                                                    
                                                       

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