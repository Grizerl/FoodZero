<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Admin | FoodZero</title>
  <link rel="icon" type="image/png" href="{{ asset('assets/images/Brand.png') }}">
  <!-- Google Font: Inter -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap">
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
  <!-- FoodZero brand theme (must come after adminlte.min.css) -->
  <link rel="stylesheet" href="@assetv('assets/css/admin.css')">
</head>
<body class="hold-transition sidebar-mini layout-fixed">
  @php
    // `active` for the sidebar entry (and the group) of the current section.
    $is = fn (string ...$routes) => request()->routeIs(...$routes);
  @endphp
  <div class="wrapper">
    <!-- Preloader -->
    <div class="preloader flex-column justify-content-center align-items-center">
      <img class="animation__shake" src="{{ asset('assets/images/Brand.png') }}" alt="FoodZero" height="60" width="60">
    </div>
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
      <!-- Left navbar links -->
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" data-widget="pushmenu" href="#" role="button" aria-label="Toggle the sidebar"><i class="fas fa-bars"></i></a>
        </li>
        <li class="nav-item d-none d-md-inline-block">
          <a href="{{ route('dashboard') }}" class="nav-link">Home</a>
        </li>
        <li class="nav-item d-none d-md-inline-block">
          <a href="{{ route('post.index') }}" class="nav-link">Blog</a>
        </li>
        <li class="nav-item d-none d-md-inline-block">
          <a href="{{ route('menu.index') }}" class="nav-link">Menu</a>
        </li>
        <li class="nav-item d-none d-md-inline-block">
          <a href="{{ route('reservation.index') }}" class="nav-link">Reservation</a>
        </li>
        <li class="nav-item d-none d-md-inline-block">
          <a href="{{ route('newsletters.index') }}" class="nav-link">Newsletter</a>
        </li>
        <li class="nav-item d-none d-md-inline-block">
          <a href="{{ route('members.index') }}" class="nav-link">Users</a>
        </li>
      </ul>
      <!-- Right navbar links -->
      <ul class="navbar-nav ml-auto">
        <li class="nav-item">
          <a class="nav-link nav-link--site" href="{{ route('home.page') }}" target="_blank" rel="noopener">View site <i class="fas fa-arrow-up-right-from-square" aria-hidden="true"></i></a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
          <a class="nav-link" data-widget="fullscreen" href="#" role="button" aria-label="Toggle full screen">
            <i class="fas fa-expand-arrows-alt"></i>
          </a>
        </li>
      </ul>
    </nav>
    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
      <!-- Brand: leads to the admin home; the public site has its own "View site" link -->
      <a class="brand-link" href="{{ route('dashboard') }}" aria-label="FoodZero admin home">
          <svg class="brand-mark" width="30" height="30" viewBox="0 0 34 34" fill="none" aria-hidden="true" focusable="false">
              <circle cx="17" cy="17" r="16" stroke="currentColor" stroke-width="2" opacity=".5"/>
              <path d="M10 24c-.5-8 4.5-13.5 14-14.5.5 9.5-4.5 14.5-14 14.5Z" fill="currentColor"/>
              <path d="M10 24c3.2-4.6 6.6-7.7 10.6-9.8" stroke="#233000" stroke-width="1.6" stroke-linecap="round"/>
          </svg>
          <span class="brand-text">FoodZero</span>
          <span class="brand-badge">Admin</span>
      </a>
      <!-- Sidebar -->
      <div class="sidebar">
        <div class="user-panel d-flex">
          <div style="user-select: none;" class="info">
            <span class="user-name">{{ Auth::user()->name }}</span>
            <span class="user-role">Administrator Console</span>
          </div>
        </div>
        <nav>
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <li class="nav-item">
            <a href="{{ route('dashboard') }}" class="nav-link @if ($is('dashboard')) active @endif">
              <i class="nav-icon fa-solid fa-house"></i>
              <p>Home</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link @if ($is('post.*')) active @endif">
              <i class="nav-icon fa-solid fa-newspaper"></i>
              <p>
                Blog
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route('post.index') }}" class="nav-link @if ($is('post.index', 'post.edit')) active @endif">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Blog Collection</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('post.create') }}" class="nav-link @if ($is('post.create')) active @endif">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Create New Post</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link @if ($is('category.*')) active @endif">
              <i class="nav-icon fa-solid fa-layer-group"></i>
              <p>
                Category
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route('category.index') }}" class="nav-link @if ($is('category.index', 'category.edit')) active @endif">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Category Collection</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('category.create') }}" class="nav-link @if ($is('category.create')) active @endif">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Create New Category</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link @if ($is('menu.*')) active @endif">
              <i class="nav-icon fa-solid fa-utensils"></i>
              <p>
                Menu
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route('menu.index') }}" class="nav-link @if ($is('menu.index', 'menu.edit')) active @endif">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Menu List</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('menu.create') }}" class="nav-link @if ($is('menu.create')) active @endif">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Create New Dish</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item">
            <a href="{{ route('reservation.index') }}" class="nav-link @if ($is('reservation.*')) active @endif">
              <i class="nav-icon fa-solid fa-book-bookmark"></i>
              <p>Reservation</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ route('newsletters.index') }}" class="nav-link @if ($is('newsletters.*')) active @endif">
              <i class="nav-icon fa-solid fa-envelope"></i>
              <p>Newsletter</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link @if ($is('members.*')) active @endif">
              <i class="nav-icon fa-solid fa-users"></i>
              <p>
                Users
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route('members.index') }}" class="nav-link @if ($is('members.index', 'members.edit')) active @endif">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Registered Users</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('members.create') }}" class="nav-link @if ($is('members.create')) active @endif">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Create New User</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="sidebar-section-label">Site</li>
          <li class="nav-item">
            <a href="{{ route('home.page') }}" class="nav-link" target="_blank" rel="noopener">
              <i class="nav-icon fa-solid fa-arrow-up-right-from-square"></i>
              <p>View site</p>
            </a>
          </li>
          <li class="nav-item">
            <form action="{{ route('logout') }}" method="post">
              @csrf
                <button class="nav-link" type="submit">
                    <i class="nav-icon fa-solid fa-right-from-bracket"></i>
                    <p>Exit Account</p>
                </button>
            </form>
          </li>
        </ul>
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
<!-- jQuery UI (sortable widgets used by dashboard.js) -->
<script src="/admin/plugins/jquery-ui/jquery-ui.min.js"></script>
<script>$.widget.bridge('uibutton', $.ui.button)</script>
<!-- Bootstrap 4 -->
<script src="/admin/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="/admin/dist/js/adminlte.js"></script>
<!-- Loading the jQuery Colorbox plugin for modal windows (minimized version) -->
<script type="text/javascript" src="/admin/dist/js/jquery.colorbox-min.js"></script>
<!-- Loading Font Awesome for icon usage on the page -->
<script src="https://kit.fontawesome.com/46a432ef36.js" crossorigin="anonymous"></script>
<!-- Loading the JS for the dashboard page functionality -->
<script src="/admin/dist/js/pages/dashboard.js"></script>
<!-- Loading the TinyMCE editor for text editors on the page -->
<script src="https://cdn.tiny.cloud/1/{{ config('services.tinymce.key') ?: 'no-api-key' }}/tinymce/7/tinymce.min.js" referrerpolicy="origin"></script>
<!-- Loading the elFinder plugin for the file manager (used via standalone popup) -->
<script type="text/javascript" src="/packages/barryvdh/elfinder/js/standalonepopup.min.js"></script>
<!-- Project admin scripts (TinyMCE / elFinder wiring) -->
<script src="/admin/js/admin.js"></script>
</body>
</html>
