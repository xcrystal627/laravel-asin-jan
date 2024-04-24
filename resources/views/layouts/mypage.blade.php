<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>ヤフカリ</title>
	<link rel="shortcut icon" href="/favicon.ico">

  @include('css.links_my')
  <style type="text/css">
    * {
      box-sizing: border-box !important;
    }

    input[type='checkbox'] {
      width: 16px;
      height: 16px;
    }

    label {
      font-weight: normal !important;
      vertical-align: -25%;
    }

    .form-control,button {
      border-radius: 0px !important;
    }

    .btn-success {
      color: white !important;
      background-color: #17a2b8 !important;
      border-color: #17a2b8 !important;
    }

    .input-group-text {
      vertical-align: -25% !important;
      background-color: transparent;
      border: none;
    }

    a {
      color: #17a2b8;
    }
  </style>
</head>
<body class="hold-transition sidebar-mini layout-fixed sidebar-collapse">
  <div class="wrapper">

    <!-- Preloader -->
    <div class="preloader flex-column justify-content-center align-items-center">
      <img class="animation__shake" src="{{ asset('assets/img/AdminLTELogo.png') }}" alt="AdminLTELogo" height="60" width="60">
    </div>

    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
      <!-- Left navbar links -->
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" data-widget="pushmenu" role="button"><i class="fas fa-bars"></i></a>
        </li>
      </ul>

      <!-- Right navbar links -->
      <ul class="navbar-nav ml-auto">
        <!-- Navbar Search -->
        <li class="nav-item">
          <a class="nav-link" data-widget="navbar-search" href="#" role="button">
            <i class="fas fa-search"></i>
          </a>
          <div class="navbar-search-block">
            <form class="form-inline" id="searchForm" action="{{ route('search') }}">
              <div class="input-group input-group-sm">
                <input class="form-control form-control-navbar" name="key" type="search" placeholder="検索" aria-label="Search" onchange="itemSearch(event);" value="">
                <div class="input-group-append">
                  <button class="btn btn-navbar" type="submit">
                    <i class="fas fa-search"></i>
                  </button>
                  <button class="btn btn-navbar" type="button" data-widget="navbar-search">
                    <i class="fas fa-times"></i>
                  </button>
                </div>
              </div>
            </form>
          </div>
        </li>

        
        <li class="nav-item dropdown">
          <a class="nav-link" data-toggle="dropdown" href="#">
            <i class="fas fa-th-large"></i>
          </a>
          <div class="dropdown-menu dropdown-menu-sm dropdown-menu-right">
            <div class="user-panel mt-2 mb-2 d-flex">
              <!-- <div class="image">
                <img src="{{ asset('assets/img/user2-160x160.jpg') }}" class="img-circle elevation-2" alt="User Image">
              </div> -->
              <div class="info">
                <a href="#" class="d-block">{{ $user->email }}</a>
              </div>
            </div>
            <!-- <div class="dropdown-divider"></div>
            <a href="#" class="dropdown-item">
              <i class="fas fa-envelope mr-2"></i> 4 new messages
              <span class="float-right text-muted text-sm">3 mins</span>
            </a> -->
            <div class="dropdown-divider"></div>   
            <a href="{{ route('logout') }}" class="dropdown-item dropdown-footer">ログアウト <i class="fas fa-arrow-circle-right"></i> </a>
          </div>
        </li>
      </ul>
    </nav>
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
      <!-- Brand Logo -->
      <a href="{{ route('welcome') }}" class="brand-link">
        <img src="{{ asset('assets/img/AdminLTELogo.png') }}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <h4 style="color: white;" class="brand-text"><b>ヤフカリ</b></h4>
      </a>

      <!-- Sidebar -->
      <div class="sidebar">
        
        <!-- Sidebar Menu -->
        <nav class="mt-2">
          <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            <!-- Add icons to the links using the .nav-icon class
                 with font-awesome or any other icon font library --> 
            <li class="nav-item">
              <a href="#" class="nav-link">
                <i class="nav-icon far fa-plus-square"></i>
                <p>
                  商品管理
                  <i class="fas fa-angle-left right"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="{{ asset('/mypage/item_add') }}" class="nav-link">
                    <p>商品追加</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="{{ asset('/mypage/item_list') }}" class="nav-link">                    
                    <p>商品⼀覧</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="{{ asset('/mypage/error_list') }}" class="nav-link">                    
                    <p>エラーリスト</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="{{ asset('/mypage/ext_download') }}" class="nav-link">                    
                    <p>Google拡張システム<br>ダウンロード</p>
                  </a>
                </li>
              </ul>
            </li>
            @if ($user['role'] == 'admin')
            <li class="nav-item">
              <a href="#" class="nav-link">
                <i class="nav-icon fas fa-edit"></i>
                <p>
                  設定
                  <i class="fas fa-angle-left right"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="{{ asset('/mypage/account_manage') }}" class="nav-link">
                    <p>アカウント管理</p>
                  </a>
                </li>
              </ul>
            </li>
            @endif
          </ul>
        </nav>
        <!-- /.sidebar-menu -->
      </div>
      <!-- /.sidebar -->
    </aside>

    <!-- Content Wrapper. Contains page content -->
    @yield('content')
    <!-- /.content-wrapper -->
    <!-- <footer class="main-footer">
      <strong>Copyright &copy; 2014-2021 <a href="#">AdminLTE.io</a>.</strong>
      All rights reserved.
      <div class="float-right d-none d-sm-inline-block">
        <b>Version</b> 3.1.0
      </div>
    </footer> -->

    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
      <!-- Control sidebar content goes here -->
    </aside>
    <!-- /.control-sidebar -->
  </div>
  <!-- ./wrapper -->

<!-- jQuery -->

@yield('script')
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<!-- <script>
  $.widget.bridge('uibutton', $.ui.button)
</script> -->
<!-- Bootstrap 4 -->

</body>
</html>
