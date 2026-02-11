 <?php
session_start();
require_once '../inc/functions/config.php';
require_once '../inc/functions/functions_user.php';

if (!isset($_SESSION['user_id']) || !isset($_GET['id'])) {
    header("Location: dashboard.php");
    exit;
}

$id = $_GET['id'];
$reservasi = getDetailReservasiUser($db, $id, $_SESSION['user_id']);

if (!$reservasi) {
    header("Location: dashboard.php");
    exit;
}

include '../inc/header_user.php';
?>

<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800 font-weight-bold">Detail Reservasi</h1>

    <div class="card shadow border-0">
        <div class="card-body">
            <table class="table table-borderless">
                <tr>
                    <th width="30%">Meja</th>
                    <td><?php echo $reservasi['nama_meja'] ?> (<?php echo $reservasi['kapasitas'] ?> orang)</td>
                </tr>
                <tr>
                    <th>Tanggal</th>
                    <td><?php echo date('d M Y', strtotime($reservasi['tanggal'])) ?></td>
                </tr>
                <tr>
                    <th>Jam</th>
                    <td><?php echo $reservasi['jam'] ?></td>
                </tr>
                <tr>
                    <th>Status</th>
                    <td>
                        <span class="badge badge-info text-uppercase">
                            <?php echo $reservasi['status'] ?>
                        </span>
                    </td>
                </tr>
            </table>

            <div class="text-right">
                <a href="dashboard.php" class="btn btn-secondary btn-sm">
                    ← Kembali
                </a>
            </div>
        </div>
    </div>
</div>

<?php include '../inc/footer_user.php'; ?>
