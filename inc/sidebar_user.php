<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion">

    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="dashboard.php">
        <div class="sidebar-brand-icon">
            <i class="fas fa-utensils"></i>
        </div>
        <div class="sidebar-brand-text mx-3">FoodyRest</div>
    </a>

    <hr class="sidebar-divider my-0">

    <li class="nav-item <?php if ($page == 'dashboard.php') echo 'active'; ?>">
        <a class="nav-link" href="dashboard.php">
            <i class="fas fa-home"></i>
            <span>Dashboard</span>
        </a>
    </li>

    <li class="nav-item <?php if ($page == 'menu.php') echo 'active'; ?>">
        <a class="nav-link" href="menu.php">
            <i class="fas fa-book-open"></i>
            <span>Menu</span>
        </a>
    </li>

    <li class="nav-item <?php if ($page == 'booking.php') echo 'active'; ?>">
        <a class="nav-link" href="booking.php">
            <i class="fas fa-chair"></i>
            <span>Booking Meja</span>
        </a>
    </li>

    <li class="nav-item <?php if ($page == 'riwayat.php') echo 'active'; ?>">
        <a class="nav-link" href="riwayat.php">
            <i class="fas fa-history"></i>
            <span>Riwayat</span>
        </a>
    </li>

    <hr class="sidebar-divider">

    <li class="nav-item <?php if ($page == 'logout.php') echo 'active'; ?>">
        <a class="nav-link text-danger" href="logout.php">
            <i class="fas fa-sign-out-alt"></i>
            <span>Logout</span>
        </a>
    </li>

</ul>
