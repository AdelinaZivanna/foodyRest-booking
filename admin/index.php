<?php
session_start();

$page = basename($_SERVER['PHP_SELF']);

include '../inc/functions/config.php';
include '../inc/functions/functions_admin.php';
include '../inc/header.php';

$totalToday   = countTodayReservations($db);
$totalMenu    = countActiveMenu($db);
$pendingPay   = countPendingPayments($db);
$totalUser    = countCustomers($db);
$latestRes    = getLatestReservations($db);
?>


<div class="container-fluid">

    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800 font-weight-bold">Dashboard Admin</h1>
        <div class="text-muted">
            <i class="fas fa-calendar-alt mr-2"></i><?php echo date('l, d F Y') ?>
        </div>
    </div>

    <div class="row">

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2 border-0">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Reservasi Hari Ini</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $totalToday ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-utensils fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2 border-0">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Menu Tersedia</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $totalMenu ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-book-open fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2 border-0">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Menunggu Bayar</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $pendingPay ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-wallet fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2 border-0">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Total Pelanggan</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $totalUser ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-users fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="card shadow mb-4 border-0">
                <div class="card-header py-3 d-flex justify-content-between align-items-center bg-white">
                    <h6 class="m-0 font-weight-bold text-primary">Reservasi Terbaru</h6>
                    <a href="reservasi.php" class="btn btn-sm btn-outline-primary shadow-sm">Lihat Semua</a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover border-bottom">
                            <thead class="bg-light">
                                <tr>
                                    <th>Nama Pelanggan</th>
                                    <th>Tanggal</th>
                                    <th>Jam</th>
                                    <!-- <th class="text-center">Status Reservasi</th> -->
                                </tr>
                            </thead>
                            <tbody>
                                <?php if(!empty($latestRes)): ?>
                                    <?php foreach($latestRes as $r): ?>
                                    <tr>
                                        <td><?php echo $r['nama'] ?></td>
                                        <td><?php echo date('d M Y', strtotime($r['tanggal'])) ?></td>
                                        <td><?php echo $r['jam'] ?></td>
                                        <!-- <td class="text-center">
                                            <?php if($r['status'] == 'pending'): ?>
                                                <span class="badge badge-warning py-2 px-3">Pending</span>
                                            <?php elseif($r['status'] == 'dikonfirmasi'): ?>
                                                <span class="badge badge-success py-2 px-3">Dikonfirmasi</span>
                                            <?php else: ?>
                                                <span class="badge badge-danger py-2 px-3">Dibatalkan</span>
                                            <?php endif; ?>
                                        </td> -->
                                    </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="5" class="text-center py-4">Belum ada reservasi masuk.</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

<?php include '../inc/footer.php'; ?>