<?php
session_start();

$page = basename($_SERVER['PHP_SELF']);

require_once '../inc/functions/config.php';
require_once '../inc/functions/functions_user.php';

$stats = getDashboardStats($db, $_SESSION['user_id']);
$totalReservasi = $stats['total'];
$reservasiAktif = $stats['aktif'];
$recentOrders   = $stats['recent'];

include '../inc/header_user.php';
?>

<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800 font-weight-bold">Dashboard Pelanggan</h1>
        <a href="menu.php" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
            <i class="fas fa-plus fa-sm text-white-50"></i> Buat Pesanan Baru
        </a>
    </div>

    <div class="row">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Reservasi</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $totalReservasi ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-calendar fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Reservasi Aktif</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $reservasiAktif ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-utensils fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-xl-6 col-md-12 mb-4">
            <div class="card bg-gradient-primary text-white shadow">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col">
                            <h5 class="font-weight-bold">Selamat Datang, <?php echo $_SESSION['nama'] ?>!</h5>
                            <p class="mb-0 small">Laper? Yuk pilih menu favoritmu dan booking meja sekarang juga.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-2">
        <div class="col-lg-12">
            <div class="card shadow mb-4 border-0">
                <div class="card-header py-3 bg-white">
                    <h6 class="m-0 font-weight-bold text-primary">Aktivitas Terakhir Kamu</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="bg-light">
                                <tr>
                                    <th>Meja</th>
                                    <th>Tanggal & Jam</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if($recentOrders): foreach($recentOrders as $ro): ?>
                                <tr>
                                    <td><span class="badge badge-info p-2"><?php echo $ro['nama_meja'] ?></span></td>
                                    <td><?php echo date('d M Y', strtotime($ro['tanggal'])) ?> | <?php echo $ro['jam'] ?></td>
                                    <td>
                                        <?php if($ro['status'] == 'pending'): ?>
                                            <span class="badge badge-warning">Menunggu Konfirmasi</span>
                                        <?php elseif($ro['status'] == 'dikonfirmasi'): ?>
                                            <span class="badge badge-success">Dikonfirmasi</span>
                                        <?php elseif($ro['status'] == 'selesai'): ?>
                                            <span class="badge badge-secondary">Selesai</span>
                                        <?php else: ?>
                                            <span class="badge badge-danger">Dibatalkan</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <a href="detail_reservasi.php?id=<?php echo $ro['id'] ?>" class="btn btn-sm btn-outline-primary">Detail</a>
                                    </td>
                                </tr>
                                <?php endforeach; else: ?>
                                    <tr><td colspan="4" class="text-center">Belum ada aktivitas. <a href="menu.php">Ayo pesan sekarang!</a></td></tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include '../inc/footer_user.php'; ?>