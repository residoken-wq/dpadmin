@extends("admin.admin")
 @section('content')

            <ol class="breadcrumb">
                <li class="breadcrumb-item"> Trang chủ </li>
                <li class="breadcrumb-item"><a href=""> Sản phẩm  ({{$data_list->total()}})  </a>
                </li>
               
              
            </ol>


        <div class="container-fluid">
           {!! Form::open(['method'=>'get']) !!}
            <input type='hidden' name='is_search' value='1'/>
            <button type='button' style="<?php echo (isset($_GET['is_search'])?'display: none':'display: block')?>" class="btn btn-sm btn-warning click_view_search">Hiển thị tìm kiếm</button>
           
            <div class="row view_search" style="<?php echo (isset($_GET['is_search'])?'display: flex':'display: none')?>">

                    <div class="col-sm-5">
                                     <div class="form-group">
                                                    <label for="name"> Tên sản phẩm     </label>
 {!! Form::text('name',@$search['name'],['class'=>"form-control " ]) !!}

                                                </div>
                                            </div>
                   <div class="col-sm-5">
                                     <div class="form-group">
                                                    <label for="name"> Danh mục      </label>
 {!! Form::select('cid_cate',$cid_cate,@$search['cid_cate'],['class'=>"form-control " ]) !!}

                                                </div>
                                            </div>                           
                 <div class="col-sm-5">
                                     <div class="form-group">
                                                    <label for="name"> Loại      </label>
 {!! Form::select('cid_type',$cid_type,@$search['cid_type'],['class'=>"form-control " ]) !!}

                                                </div>
                                            </div>   


                                             <div class="col-sm-5">
                                     <div class="form-group">
                                                    <label for="name">  Màu sắc     </label>
 {!! Form::select('cid_color',$cid_color,@$search['cid_color'],['class'=>"form-control " ]) !!}

                                                </div>
                                            </div>  
                                            <div class="col-sm-5">
                                     <div class="form-group">
                                                    <label for="name"> Giá từ     </label>
 {!! Form::number('price_from',@$search['price_from'],['class'=>"form-control " ]) !!}

                                                </div>
                                            </div>

                                            <div class="col-sm-5">
                                     <div class="form-group">
                                                    <label for="name"> Đến      </label>
 {!! Form::number('price_to',@$search['price_to'],['class'=>"form-control " ]) !!}

                                                </div>
                                            </div> 
                 <div class="col-sm-5">
                      <div class="form-group">
                      <button type="submit" class="btn btn-sm btn-warning"><i class="fa fa-ban"></i> TÌM KIẾM  </button>
                       <button type="reset" class="btn btn-sm btn-danger click_reset_form"><i class="fa fa-ban"></i> ẨN   </button>
                  </div>
                </div>
                    <div class="col-sm-5">
                            <?php $url=$_SERVER['REQUEST_URI'];
                                $get_request=explode("?", $url);
                                $u = (!empty($get_request[1]))? "?".$get_request[1] : "" ;
                            ?>
                          <a class="btn btn-sm btn-primary" href="/admin/product/export{{$u}}"><i class="fa fa-ban"></i> EXPORT </a>
                </div>
        </div>

            

            {!! Form::close()!!}


<div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-header">
                                    <i class="fa fa-align-justify"></i> Sản phẩm  ( {{$data_list->total()}} )
                                </div>
                                <div class="card-block">
                                    <table class="table table-sm">
                                        <thead>
                                            <tr>
                                                <th>ID </th>
                                                <th>Tên Sản phẩm  </th>
                                                <th> Danh mục  </th>
                                                <th> Hình ảnh  </th>
                                                <th> Trạng thái  </th>
                                              
                                                <th> Tuỳ chọn </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach($data_list as $list):?>
                                                
                                            <tr>
                                                <td><?php echo $list['id'];?></td>
                                                <td>
                                                     <a href='/{{$list->Cate()["alias"]}}/{{$list["alias"]}}' target='_black'>
                                                        <?php echo $list['name'];?>
                                                    </a>
                                                            

                                                        </td>
                                                <td>
                                                    @if($list->Color())
                                                    Màu sắc : {{$list->Color()['name']}}
                                                    @endif
                                                    <br />
                                                      @if($list->Type())
                                                    Loại : {{$list->Type()['name']}}
                                                    @endif   
                                               
                                                     <br/>
                                                 <small>Created at : {{$list['created_at']}}</small><br />
                                                    <small>Updated at : {{$list['updated_at']}}</small>
                                                </td>
                                                <td><img src='/upload/product/small/<?php echo $list['picture'];?>'/>


                                                </td>
                                                <td>
                                                    <?php if($list['status']=='1'):?>
                                                         <a class="text text-primary "> Hiển thị  </a>
                                                    <?php else:?>
                                                         <a class="text text-warning "> ẨN...  </a>
                                                    <?php endif;?>
                                                </td>
                                                
                                                <td>
                                                    <a class="btn btn-sm btn-success" href='/admin/product/edit/<?php echo $list['id'];?>'><i class="fa fa-edit"></i> Sửa </a><br /><br />
                                                    <a class="btn btn-sm btn-danger click_remove" href='/admin/product/remove?id=<?php echo $list['id'];?>&_token={{csrf_token()}}'> <i class="fa fa-remove"></i> Xoá  </a>
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