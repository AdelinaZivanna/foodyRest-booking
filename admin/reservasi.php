<?php
session_start();

$page = basename($_SERVER['PHP_SELF']);

require_once '../inc/functions/config.php';
require_once '../inc/functions/functions_admin.php';

if (!isset($_SESSION['login']) || $_SESSION['role'] !== 'admin') {
    header('Location: ../login.php');
    exit;
}

if (isset($_GET['aksi'], $_GET['id'])) {
    handleReservasiAction($db, $_GET['aksi'], $_GET['id']);
    header("Location: reservasi.php");
    exit;
}

$reservations = getAllReservations($db);

include '../inc/header.php';
?>

<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800 font-weight-bold">Manajemen Reservasi</h1>
    </div>

    <div class="card shadow mb-4 border-0">
        <div class="card-header py-3 bg-white">
            <h6 class="m-0 font-weight-bold text-primary">Daftar Semua Reservasi</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover" id="dataTable" width="100%" cellspacing="0">
                    <thead class="thead-light">
                        <tr>
                            <th>Pelanggan</th>
                            <th>Jadwal</th>
                            <th>Meja</th>
                            <th>Status</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($reservations)) : ?>
                            <?php foreach ($reservations as $r) : ?>
                            <tr>
                                <td class="align-middle">
                                    <span class="font-weight-bold text-gray-800"><?php echo $r['user_name'] ?></span><br>
                                    <small class="text-muted"><?php echo $r['email'] ?></small>
                                </td>
                                <td class="align-middle">
                                    <i class="fas fa-calendar-alt fa-sm mr-1"></i> <?php echo date('d M Y', strtotime($r['tanggal'])) ?><br>
                                    <i class="fas fa-clock fa-sm mr-1"></i> <?php echo $r['jam'] ?>
                                </td>
                                <td class="align-middle">
                                    <span class="badge badge-info px-2 py-1"><?php echo $r['nama_meja'] ?></span><br>
                                    <small><?php echo $r['kapasitas'] ?> Orang</small>
                                </td>
                                <td class="align-middle">
                                    <?php
                                    if ($r['status'] == 'pending') {
                                        echo '<span class="badge badge-warning p-2">Pending</span>';
                                    } elseif ($r['status'] == 'dikonfirmasi') {
                                        echo '<span class="badge badge-success p-2">Dikonfirmasi</span>';
                                    } elseif ($r['status'] == 'selesai') {
                                        echo '<span class="badge badge-secondary p-2">Selesai</span>';
                                    } else {
                                        echo '<span class="badge badge-danger p-2">Dibatalkan</span>';
                                    }
                                    ?>
                                </td>
                                <td class="text-center align-middle">
                                    <div class="btn-group">
                                        <?php if ($r['status'] == 'pending') : ?>
                                            <a href="?aksi=konfirmasi&id=<?php echo $r['id'] ?>" class="btn btn-sm btn-success shadow-sm" title="Konfirmasi">
                                                <i class="fas fa-check"></i>
                                            </a>
                                            <a href="?aksi=batal&id=<?php echo $r['id'] ?>" class="btn btn-sm btn-danger shadow-sm" title="Batalkan">
                                                <i class="fas fa-times"></i>
                                            </a>
                                        
                                        <?php elseif ($r['status'] == 'dikonfirmasi') : ?>
                                            <a href="?aksi=selesai&id=<?php echo $r['id'] ?>" class="btn btn-sm btn-info shadow-sm" onclick="return confirm('Tamu sudah selesai? Meja akan dikosongkan.')">
                                                <i class="fas fa-sign-out-alt mr-1"></i> Selesaikan
                                            </a>

                                        <?php else : ?>
                                            <span class="text-muted small">-</span>
                                        <?php endif; ?>
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        <?php else : ?>
                            <tr><td colspan="5" class="text-center">Belum ada data reservasi.</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php include '../inc/footer.php'; ?>