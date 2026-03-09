<div class="sidebar">
            <nav class="sidebar-nav">
                <ul class="nav">
                    
                    <li class="nav-title">
                       Quản lý Công Việc 
                    </li>
                    
                    <li class="nav-item nav-dropdown">
                        <a class="nav-link nav-dropdown-toggle" href="#"><i class="icon-puzzle"></i> Phiếu Dịch Thuật    </a>
                        <ul class="nav-dropdown-items">
                            <li class="nav-item">
                                <a class="nav-link" href="/admin/index/index"><i class="icon-"></i>-<small>Thêm mới</small> </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="/admin/index/lists"><i class="icon-"></i> -<small>Danh sách</small> </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="/admin/index/runonedrive"><i class="icon-"></i> -<small>Onedrive</small> </a>
                            </li>
                             <li class="nav-item">
                                <a class="nav-link" href="/admin/index/barcode"><i class="icon-"></i> -<small>Scan Barcode</small> </a>
                            </li>
                        </ul>
                    </li>
                  
                     <li class="nav-item nav-dropdown">
                        <a class="nav-link nav-dropdown-toggle" href="#"><i class="icon-star"></i> Nhà Cung Cấp   </a>
                        <ul class="nav-dropdown-items">
                            <li class="nav-item">
                                <a class="nav-link" href="/admin/supplier/add"><i class="icon-"></i> -<small>Thêm mới</small> </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="/admin/supplier/lists"><i class="icon-"></i> -<small>Danh sách</small> </a>
                            </li>
                        </ul>
                    </li>

                     <li class="nav-item nav-dropdown">
                        <a class="nav-link nav-dropdown-toggle" href="#"><i class="icon-star"></i> Khách hàng   </a>
                        <ul class="nav-dropdown-items">
                            <li class="nav-item">
                                <a class="nav-link" href="/admin/customer/add"><i class="icon-"></i> -<small>Thêm mới</small> </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="/admin/customer/lists"><i class="icon-"></i> -<small>Danh sách</small> </a>
                            </li>
                        </ul>
                    </li>
                       <li class="divider"></li>

                     <li class="nav-title">
                       TẠO HOÁ ĐƠN 
                    </li>
                    <li class="nav-item nav-dropdown">
                        <a class="nav-link nav-dropdown-toggle" href="#"><i class="icon-equalizer"></i> PHIẾU THU   </a>
                        <ul class="nav-dropdown-items">
                            <li class="nav-item">
                                <a class="nav-link" href="/admin/phieuthu/add" target="_top"><i class="icon-"></i> -<small> Tạo PHIẾU THU </small>  </a>
                            </li>
                              <li class="nav-item">
                                <a class="nav-link" href="/admin/phieuthu/lists" target="_top"><i class="icon-"></i> -<small> Danh Sách PHIẾU THU  </small> </a>
                            </li>
                           
                        </ul>
                        
                    </li>
                    <li class="nav-item nav-dropdown">
                        <a class="nav-link nav-dropdown-toggle" href="#"><i class="icon-equalizer"></i> PHIẾU CHI   </a>
                        <ul class="nav-dropdown-items">
                            <li class="nav-item">
                                <a class="nav-link" href="/admin/phieuchi/add" target="_top"><i class="icon-"></i> -<small> Tạo PHIẾU CHI  </small>  </a>
                            </li>
                              <li class="nav-item">
                                <a class="nav-link" href="/admin/phieuchi/lists" target="_top"><i class="icon-"></i> -<small> Danh Sách PHIẾU CHI  </small> </a>
                            </li>
                           
                        </ul>
                    </li>
                      <?php if(Auth()->user()->roles=='1'): ?>
                    <li class="divider"></li>

                     <li class="nav-title">
                       Báo Cáo 
                    </li>
                    <li class="nav-item nav-dropdown">
                        <a class="nav-link nav-dropdown-toggle" href="#"><i class="icon-equalizer"></i> Báo cáo thống kê   </a>
                        <ul class="nav-dropdown-items">
                            <li class="nav-item">
                                <a class="nav-link" href="/admin/report/tatcaphieu" target="_top"><i class="icon-"></i> -<small> TẤT CẢ PHIẾU </small>  </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="/admin/report/doanhthu" target="_top"><i class="icon-"></i> -<small> DOANH THU </small>  </a>
                            </li>
                              <li class="nav-item">
                                <a class="nav-link" href="/admin/report/chiphi" target="_top"><i class="icon-"></i> -<small>CHI PHÍ  </small> </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="/admin/report/chiphinhacungcap" target="_top"><i class="icon-"></i> -<small>CHI PHÍ NCC  </small> </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="/admin/report/loinhuankhachhang" target="_top"><i class="icon-"></i> -<small>DS Khách hàng </small> </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="/admin/report/loinhuan" target="_top"><i class="icon-"></i> -<small>LỢI NHUẬN </small> </a>
                            </li>
                           
                        </ul>
                    </li>
                     <li class="nav-item nav-dropdown">
                        <a class="nav-link nav-dropdown-toggle" href="#"><i class="icon-equalizer"></i> Công nợ    </a>
                        <ul class="nav-dropdown-items">
                            <li class="nav-item">
                                <a class="nav-link" href="/admin/report/customer" target="_top"><i class="icon-"></i> -<small> Công nợ Khách Hàng </small>  </a>
                            </li>
                              <li class="nav-item">
                                <a class="nav-link" href="/admin/report/supplier" target="_top"><i class="icon-"></i> -<small>Công nợ NCC Dịch Vụ </small> </a>
                            </li>
                            
                              <li class="nav-item">
                                <a class="nav-link" href="/admin/report/supplierextension" target="_top"><i class="icon-"></i> -<small>Công nợ NCC Dịch Thuật  </small> </a>
                            </li>
                            
                        </ul>
                    </li>
                 

                    <li class="divider"></li>

                     <li class="nav-title">
                       Quản lý Hệ Thống 
                    </li>
                    


                    <li class="nav-item nav-dropdown">
                        <a class="nav-link nav-dropdown-toggle" href="#"><i class="icon-star"></i>Quản Lý Nhân Viên</a>
                        <ul class="nav-dropdown-items">
                          
                            <li class="nav-item">
                                <a class="nav-link" href="/admin/users/add" target="_top"><i class="icon-"></i> -<small>Thêm mới</small>  </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="/admin/users/lists" target="_top"><i class="icon-"></i>-<small>Danh sách</small></a>
                            </li>
                           
                            <li class="nav-item">
                                <a class="nav-link" href="/admin/users/log" target="_top"><i class="icon-"></i>-<small>Log nhân viên</small></a>
                            </li>
                        </ul>
                    </li>
                    <?php endif; ?>
                </ul>
            </nav>
        </div>