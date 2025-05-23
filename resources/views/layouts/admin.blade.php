<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3//admin/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <title>Admin|Panel System Control Center</title>
  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="/admin/plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Tempusdominus Bootstrap 4 -->
  <link rel="stylesheet" href="/admin/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="/admin/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- JQVMap -->
  <link rel="stylesheet" href="/admin/plugins/jqvmap/jqvmap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="/admin/dist/css/adminlte.min.css">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="/admin/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="/admin/plugins/daterangepicker/daterangepicker.css">
  <link href="/admin/dist/css/colorbox.css" rel="stylesheet">
</head>
<body class="hold-transition sidebar-mini layout-fixed">
  <div class="wrapper">
    <!-- Preloader -->
    <div class="preloader flex-column justify-content-center align-items-center">
      <img class="animation__shake" src="/admin/dist/img/AdminLTELogo.png" alt="AdminLTELogo" height="60" width="60">
    </div>
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
      <!-- Left navbar links -->
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
          <a href="{{ route('dashboard') }}" class="nav-link">Home</a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
          <a href="{{ route('post.index') }}" class="nav-link">Blog</a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
          <a href="{{ route('menu.index') }}" class="nav-link">Menu</a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
          <a href="{{ route('reservation.index') }}" class="nav-link">Reservation</a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
          <a href="{{ route('members.index') }}" class="nav-link">Users</a>
        </li>
      </ul>
      <!-- Right navbar links -->
      <ul class="navbar-nav ml-auto">
        <li class="nav-item">
          <a class="nav-link" data-widget="fullscreen" href="#" role="button">
            <i class="fas fa-expand-arrows-alt"></i>
          </a>
        </li>
      </ul>
    </nav>
    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
      <!-- Brand Logo -->
      <a style="user-select: none;" class="brand-link ">
          <img src="/admin/dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
          <span class="brand-text font-weight-light">{{Auth::user()->name}}</span>
      </a>
      <!-- Sidebar -->
      <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
          <div style="user-select: none;" class="info">
            <a class="d-block ml-2">Administrator Console</a>
          </div>
        </div>
        <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <li class="nav-item">
            <a href="{{ route('dashboard') }}" class="nav-link">
              <i class="fa-solid fa-house"></i>
              <p>
                Home
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="fa-solid fa-newspaper"></i>
              <p>
                Blog
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route('post.index') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                    <p>
                      Blog Collection
                    </p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('post.create') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                    <p>
                      Create New Post
                    </p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="fa-solid fa-layer-group"></i>
              <p>
                Category
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route('category.index') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                    <p>
                      Category Collection
                    </p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('category.create') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                    <p>
                      Create New Category
                    </p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="fa-solid fa-menorah"></i>
              <p>
                Menu
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route('menu.index') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                    <p>
                      Menu List
                    </p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('menu.create') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                    <p>
                      Create New Dish
                    </p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item">
            <a href="{{ route('reservation.index') }}" class="nav-link">
              <i class="fa-solid fa-book-bookmark"></i> 
                <p>
                  Reservation
                </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="fa-solid fa-users-rays"></i>
                <p>
                  Users
                  <i class="right fas fa-angle-left"></i>
                </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route('members.index') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>
                    Registered Users
                  </p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('members.create') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>
                    Create New User
                  </p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item mt-2">
            <form action="{{ route('logout') }}" method="post">
              @csrf
                <button style="border: none;" class="nav-link" type="submit">
                    <i class="fa-solid fa-right-from-bracket"></i>
                    <p>
                      Exit Account
                    </p> 
                </button>
            </form>
          </li>
        </nav>
      </div>
    </aside>
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      @yield('content')
    </div>
  </div>
<!-- jQuery -->
<script src="/admin/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="/admin/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="/admin/dist/js/adminlte.js"></script>
<!-- Loading the main JS for the AdminLTE dashboard panel -->
<script src="/admin/admin.js"></script>
<!-- Loading the jQuery Colorbox plugin for modal windows (minimized version) -->
<script type="text/javascript" src="/admin/dist/js/jquery.colorbox-min.js"></script>
<!-- Loading Font Awesome for icon usage on the page -->
<script src="https://kit.fontawesome.com/46a432ef36.js" crossorigin="anonymous"></script>
<!-- Loading the JS for the dashboard page functionality -->
<script src="/admin/dist/js/pages/dashboard.js"></script>
<!-- Loading the TinyMCE editor for text editors on the page -->
<script src="https://cdn.tiny.cloud/1/u3xget8b6g00f5okf2wfwg4jua3611mxzrrt0smpk6js3e98/tinymce/7/tinymce.min.js" referrerpolicy="origin"></script>
<!-- Duplicate loading of the jQuery Colorbox plugin (minimized version) for possible reuse -->
<script type="text/javascript" src="/admin/dist/js/jquery.colorbox-min.js"></script>
<!-- Loading the elFinder plugin for the file manager (used via standalone popup) -->
<script type="text/javascript" src="/packages/barryvdh/elfinder/js/standalonepopup.min.js"></script>
<!-- Repeating the loading of the main JS for the AdminLTE dashboard panel -->
<script src="./admin/js/admin.js"></script>
</body>
</html>


