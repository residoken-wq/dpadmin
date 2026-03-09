@extends("admin.admin")
 @section('content')

            <ol class="breadcrumb">
                <li class="breadcrumb-item"> Trang chủ </li>
                <li class="breadcrumb-item"><a href=""> Thêm mới sản phẩm mới.  </a>
                </li>
               
              
            </ol>


        <div class="container-fluid">
                    
           {!! Form::open(['method'=>'post','files'=>true]) !!}

                   @if(count($errors)>0)

                        <div class="alert alert-danger">
                            <ul>
                                @foreach($errors->all() as $error)
                                <li>{{$error}}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    @if(!empty(session('success')))
                    <div class="alert alert-primary">
                            <ul>
                                <li>
                                        <p>{!!session('success')!!}</p>
                                </li>   
                                   
                                </ul>
                        </div>
                    @endif
            <div class="col-sm-12">
                                <div class="card">
                                    <div class="card-header">
                                        <strong>Thông tin sản phẩm   </strong>
                                        <small>Form</small>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">

                                           
                                            <div class="col-sm-10">
                                                <div class="form-group">
                                                    <label for="name">Tên  </label>
 {!! Form::text('name',@$data['name'],['class'=>"form-control "]) !!}
    <span style="color:red">*</span>
                                                  
                                                </div>
                                            </div>
                                              



                                             <div class="col-sm-5">
                                                <div class="form-group">
                                                    <label for="name">Mã sản phẩm  </label>
 {!! Form::text('code',@$data['code'],['class'=>"form-control "]) !!}
    <span style="color:red">*</span>
                                                  
                                                </div>
                                            </div>
                                          <div class="col-sm-5">
                                                <div class="form-group">
                                                    <label for="name"> Số lượng tồn  </label>
 {!! Form::number('in_stock',@$data['in_stock'],['class'=>"form-control "]) !!}
    <span style="color:red">*</span>
                                                  
                                                </div>
                                            </div>
                                           
                                           <div class="col-sm-5">
                                                <div class="form-group">
                                                    <label for="name">Giá thị trường  </label>
 {!! Form::number('saleprice',@$data['saleprice'],['class'=>"form-control "]) !!}
    <span style="color:red">*</span>
                                                  
                                                </div>
                                            </div>
                                             <div class="col-sm-5">
                                                <div class="form-group">
                                                    <label for="name">Giá bán  </label>
 {!! Form::number('price',@$data['price'],['class'=>"form-control "]) !!}
    <span style="color:red">*</span>
                                                  
                                                </div>
                                            </div>
                                              
                                              

                                             


                                          

                                        </div>
                                       
                                    </div>
                                </div>

               
                            </div>
                            <div class="col-sm-12">
                                        <div class="card">
                                            <div class="card-header">
                                                <strong>Tuỳ chọn  </strong>
                                                <small>Form</small>
                                            </div>
                                            <div class="card-body">
                                                <div class="row">

                                                    

                                                   <div class="col-sm-5">

                                             <div class="form-group row">
                                                <div class='col-sm-4'>
                                                    <label for="name"> Trạng thái  </label>
                                                </div>
                                                <div class='col-sm-5'>
                                                    <div class="radio">
                                                            <label>
 {!! Form::radio('status','1', (($data['status']=='1')? true : false) ) !!} Hiển thị 
                                                            </label>
                                                     </div>
                                                    <div class="radio">
                                                            <label>
 {!! Form::radio('status','2', (($data['status']=='2')? true : false) ) !!} Ẩn  
                                                            </label>
                                                     </div>
                                                </div>
                                                   
                                                </div>

                                            </div>
                                             <div class="col-sm-5">

                                             <div class="form-group row">
                                                <div class='col-sm-4'>
                                                    <label for="name"> Sản phẩm HOT </label>
                                                </div>
                                                <div class='col-sm-6'>
                                                    <div class="radio">
                                                            <label>
 {!! Form::radio('is_hot','1', (($data['is_hot']=='1')? true : false) ) !!} Không 
                                                            </label>
                                                     </div>
                                                    <div class="radio">
                                                            <label>
 {!! Form::radio('is_hot','2', (($data['is_hot']=='2')? true : false) ) !!} Có   
                                                            </label>
                                                     </div>
                                                </div>
                                                   
                                                </div>

                                            </div>

                                                    

                                                     <div class="col-sm-5">

                                             <div class="form-group row">
                                                <div class='col-sm-4'>
                                                    <label for="name"> Sản phẩm Mới  </label>
                                                </div>
                                                <div class='col-sm-6'>
                                                    <div class="radio">
                                                            <label>
 {!! Form::radio('is_new','1', (($data['is_new']=='1')? true : false) ) !!} Không 
                                                            </label>
                                                     </div>
                                                    <div class="radio">
                                                            <label>
 {!! Form::radio('is_new','2', (($data['is_new']=='2')? true : false) ) !!} Có   
                                                            </label>
                                                     </div>
                                                </div>
                                                   
                                                </div>

                                            </div>
                                            


                                             <div class="col-sm-10">

                                                            <div class="form-group">
                                                                <label for="name"> Danh mục  </label>
             {!! Form::select('cid_cate',@$cid_cate,@$data['cid_cate'],['class'=>"form-control my_cate"]) !!}
                  <span style="color:red">*</span>                                               
                                                               
                                                            </div>

                                                     </div>




                                          <div class="col-sm-5">

                                                            <div class="form-group">
                                                                <label for="name"> Màu sắc  </label>
             {!! Form::select('cid_color',@$cid_color,@$data['cid_color'],['class'=>"form-control cid_color"]) !!}
                                                           
                                                               
                                                            </div>

                                                     </div>



                                                      <div class="col-sm-5">

                                                            <div class="form-group">
                                                                <label for="name"> Loại  </label>
             {!! Form::select('cid_type',@$cid_type,@$data['cid_type'],['class'=>"form-control cid_type"]) !!}
                                                           
                                                               
                                                            </div>

                                                     </div>



                                                    

                                                </div>
                                               
                                            </div>
                                        </div>

               
                            </div>

                          

                             <div class="col-sm-12">
                                        <div class="card">
                                            <div class="card-header">
                                                <strong>Hình ảnh   </strong>
                                                <small>Form</small>
                                            </div>
                                            <div class="card-body">
                                                <div class="row">

                                                    <div class="col-sm-10">

                                                        <div class="form-group">
                                                            <label for="name">  Hình ảnh  </label>
    {!! Form::file('picture',['class'=>'main_picture form-control','accept'=>'image/*']) !!}
                                                        <div class="view_picture"></div>
                                                        </div>
                                                         <span style="color:red">*</span>


                                            
                                                
                                            
                                                      

                                                           <div class="form-group">
                                                            <label for="name">  Các hình ảnh khác     </label>
    {!! Form::file('multi_picture[]',['class'=>' form-control main_picture','accept'=>'image/*','id'=>'','multiple'=>'multiple']) !!}
                                                        <div class="view_picture"></div>
                                                        </div>



                                                    </div>
                                                    
                                                    

                                                </div>
                                               
                                            </div>
                                        </div>

               
                            </div>


                               <div class="col-sm-12">
                                        <div class="card">
                                            <div class="card-header">
                                                <strong>Chí tiết sản phẩm    </strong>
                                                <small>Form</small>
                                            </div>
                                            <div class="card-body">
                                                <div class="row">

                                                   <div class="col-sm-10">
                                                <div class="form-group">
                                                    <label for="name">Mô tả  </label>
 {!! Form::textarea('description',@$data['description'],['class'=>"form-control "]) !!}
  
                                                  
                                                </div>
                                            </div>

                                              <div class="col-sm-10">
                                                <div class="form-group">
                                                    <label for="name">Nội dung  </label>
 {!! Form::textarea('content',@$data['content'],['class'=>"form-control ",'id'=>'content']) !!}
  
                                                  
                                                </div>
                                            </div>
                                         
                                                    

                                                </div>
                                               
                                            </div>
                                        </div>

               
                            </div>   



                             <div class="col-sm-12">
                                        <div class="card">
                                            <div class="card-header">
                                                <strong>SEO  </strong>
                                                <small>Form</small>
                                            </div>
                                            <div class="card-body">
                                                <div class="row">

                                                    <div class="col-sm-10">

                                                        <div class="form-group">
                                                            <label for="name"> Title  </label>
 {!! Form::text('seo_title',@$data['seo_title'],['class'=>"form-control "]) !!}
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="name"> Description  </label>
   {!! Form::textarea('seo_description',@$data['seo_description'],['class'=>"form-control "]) !!}
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="name"> Keyword </label>
  {!! Form::textarea('seo_keyword',@$data['seo_keyword'],['class'=>"form-control "]) !!}
                                                        </div>
                                                       

                                                    </div>
                                                    
                                                    

                                                </div>
                                               
                                            </div>
                                            <div class="card-footer">
                                               
                                                <button type="submit" class="btn btn-sm btn-primary"><i class="fa fa-dot-circle-o"></i> LƯU </button>
                                                <button type="reset" class="btn btn-sm btn-danger"><i class="fa fa-ban"></i> LÀM LẠI </button>
                                            </div>
                                        </div>

               
                            </div>
                    {!! Form::close() !!}

             </div>
    @endsection
    @section('script_js') 
        <script type="text/javascript">
           
            initEditor('content');
            $(document).ready(function(){
                   /* $(".my_cate").change(function(){
                        $.get("/admin/product/subcate?id="+$(this).val(),function(result){
                            $(".my_sub_cate").html(result);
                        });

                    });
                   
                        if($(".my_cate").val()!==''){
                            $.get("/admin/product/subcate?id="+$('.my_cate').val(),function(result){
                                $(".my_sub_cate").html(result);
                            });
                        }*/
                   
            });
            
        </script>
    @endsection