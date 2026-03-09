@extends("admin.admin")
@section('content')

    <ol class="breadcrumb">
        <li class="breadcrumb-item"> Trang chủ</li>
        <li class="breadcrumb-item"><a href="">Quản lý Phiếu Chi theo {{$header_datetime}} </a>
        </li>
    </ol>

    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="card-title col">
                                <i class="fa fa-align-justify"></i> Danh Sách Phiếu chi <span
                                        class="badge badge-pill badge-danger"> {{$data_list->total()}}</span>
                            </div>
                            <div class="px-3">
                                <a href="{{ route('danhsachchiphi',[ 'value' => $value ]) }}"
                                   class="px-4 btn btn-success" data-toggle="tooltip"
                                   title="Lọc theo Tất cả">
                                    Tất cả <span
                                            class="rounded px-2 bg-info">{{ $total['tong']??'' }}</span>
                                </a>
                                <a href="{{ route('danhsachchiphi',[ 'value' => $value, 'is_type' => 'dt' ]) }}"
                                   class="px-4 btn btn-primary position-relative" data-toggle="tooltip"
                                   title="Lọc theo Dịch thuật">
                                    Dịch Thuật <span
                                            class="rounded px-2 bg-info">{{ $total['dichthuat']??'' }}</span>
                                </a>
                                <a href="{{ route('danhsachchiphi',[ 'value' => $value, 'is_type' => 'dv' ]) }}"
                                   class="px-4 btn btn-secondary position-relative" data-toggle="tooltip"
                                   title="Lọc theo Dịch vụ">
                                    Dịch vụ <span
                                            class="rounded px-2 bg-info">{{ $total['dichvu']??'' }}</span>
                                </a>
                            </div>
                        </div>

                    </div>
                    <div class="card-block">
                        <table class="table table-sm  table-bordered table-striped dataTable">
                            <thead>
                            <tr>
                                <th>Người chi tiền</th>
                                <th> Số tiền</th>
                                <th> Nhân viên xử lý</th>
                                <th> Lý do</th>
                                <th> Ghi chú</th>
                                <th> Tuỳ chọn</th>
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
                                    @if((int)$list['cid_form']== 0)
                                        <a class="btn btn-sm btn-success"
                                           href='/admin/phieuchi/edit/<?php echo $list['id'];?>'><i
                                                    class="fa fa-edit"></i> Sửa </a><br/><br/>

                                        <a class="btn btn-sm btn-danger click_remove"
                                           href='/admin/phieuchi/remove?id=<?php echo $list['id'];?>&_token={{csrf_token()}}'>
                                            <i class="fa fa-remove"></i> Xoá </a>
                                    @else
                                        <a style="font-size:12px;padding: 2px "
                                           href='/admin/index/edit/{{$list["cid_form"]}}'> Phiếu Dịch </a>
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
                $("document").ready(function () {
                    $(".click_view_search").click(function () {

                        $(".view_search").show();
                        $(this).hide();
                    });
                    $(".click_reset_form").click(function () {
                        $(".view_search").hide();
                        $(".click_view_search").show();
                    });
                });
            </script>

@endsection
