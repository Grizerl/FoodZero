<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Platform Management</title>
    <link rel="stylesheet" href="/assets/css/auth/dashboard.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
</head>
<body>
    <div class="container">
        <aside class="sidebar">
            <div class="sidebar-header">
                <h2>Admin Panel</h2>
            </div>
            <ul class="menu">
                <li class="menu-item active">
                    <a href="#">
                        <i class="fa fa-home"></i> Home
                    </a>
                </li>
                <li class="menu-item">
                    <a href="#">
                        <i class="fa fa-list"></i> Menu
                    </a>
                </li>
                <li class="menu-item">
                    <a href="#">
                        <i class="fa fa-calendar-check"></i> Reservation
                    </a>
                </li>
                <li class="menu-item">
                    <a href="#">
                        <i class="fa fa-users"></i> Users
                    </a>
                </li>
                <li class="menu-item">
                    <form action="{{ route('logout') }}" method="post">
                        @csrf
                            <button type="submit" class="logout-btn">
                                <i class="fa fa-sign-out-alt"></i> Log out
                            </button>
                    </form>
                </li>
            </ul>
        </aside>
        @yield('content')
    </div>
</body>
</html>
