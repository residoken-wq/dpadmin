 <header class="app-header navbar">
        <button class="navbar-toggler mobile-sidebar-toggler d-lg-none mr-auto" type="button">☰</button>
        <a class="navbar-brand" href="#"></a>
        <button class="navbar-toggler sidebar-minimizer d-md-down-none" type="button">☰</button>

        <ul class="nav navbar-nav d-md-down-none">
            <li class="nav-item px-3">
                <a class="nav-link" href="/admin/index/index">Tạo Phiếu Dịch</a>
            </li>
            @if(Auth()->user()->roles=='1')
            <li class="nav-item px-3">
                <a class="nav-link" href="/admin/users/lists">Quản lý Nhân Viên </a>
            </li>
            @endif
             <li class="nav-item px-3">

                <h6 class="mx-auto"> <span class='badge badge-pill badge-info' style="color:white">Ngày: {{date("d-m-Y H:i:s")}}</span></h6>
            </li>
        </ul>
        <ul class="nav navbar-nav ml-auto">
            
            <li class="nav-item ">
                <a class="nav-link nav-link" data-toggle="dropdown" href="" role="button" aria-haspopup="true" aria-expanded="false">
                    
                    <span class="d-md-down-none">{{@Auth::user()['name']}}</span> |
                </a>
                
            </li>

             <li class="nav-item ">
                <a class="nav-link  nav-link" href="/auth/logout" >
                  
                    <span class="d-md-down-none"> Thoát </span>
                </a>
                
            </li>
        </ul>
     

    </header>