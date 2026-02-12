<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.php">
        <div class="sidebar-brand-text mx-3">FoodyRest Admin</div>
    </a>

    <hr class="sidebar-divider my-0">

    <!-- Dashboard -->
    <li class="nav-item <?php if ($page == 'index.php') echo 'active'; ?>">
        <a class="nav-link" href="index.php">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span>
        </a>
    </li>

    <!-- Reservations -->
    <li class="nav-item <?php if ($page == 'reservasi.php') echo 'active'; ?>">
        <a class="nav-link" href="reservasi.php">
            <i class="fas fa-fw fa-calendar-check"></i>
            <span>Reservations</span>
        </a>
    </li>

    <li class="nav-item <?php if ($page == 'meja.php') echo 'active'; ?>">
        <a class="nav-link" href="meja.php">
            <i class="fas fa-fw fa-chair"></i>
            <span>Kelola Meja</span>
        </a>
    </li>

    <!-- Menu -->
    <li class="nav-item <?php if ($page == 'menu.php') echo 'active'; ?>">
        <a class="nav-link" href="menu.php">
            <i class="fas fa-fw fa-utensils"></i>
            <span>Menu</span>
        </a>
    </li>

    <!-- Payments -->
    <li class="nav-item <?php if ($page == 'pembayaran.php') echo 'active'; ?>">
        <a class="nav-link" href="pembayaran.php">
            <i class="fas fa-fw fa-credit-card"></i>
            <span>Payments</span>
        </a>
    </li>

    <li class="nav-item <?php if ($page == 'metode_pembayaran.php') echo 'active'; ?>">
        <a class="nav-link" href="metode_pembayaran.php">
            <i class="fas fa-money-bill"></i>
            <span>Metode Pembayaran</span>
        </a>
    </li>

    <!-- Users -->
    <li class="nav-item <?php if ($page == 'users.php') echo 'active'; ?>">
        <a class="nav-link" href="users.php">
            <i class="fas fa-fw fa-user"></i>
            <span>Users</span>
        </a>
    </li>

    <!-- Logout -->
    <li class="nav-item <?php if ($page == 'logout.php') echo 'active'; ?>">
        <a class="nav-link" href="logout.php">
            <i class="fas fa-fw fa-sign-out-alt"></i>
            <span>Logout</span>
        </a>
    </li>

</ul>
