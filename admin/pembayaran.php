<?php
session_start();

$page = basename($_SERVER['PHP_SELF']);

include '../inc/functions/config.php';
include '../inc/functions/functions_admin.php';

if (isset($_GET['aksi']) && isset($_GET['id'])) {
    $id_transaksi = $_GET['id'];
    
    if ($_GET['aksi'] == 'terima') {
        if (konfirmasiPembayaran($db, $id_transaksi)) {
            echo "<script>alert('Pembayaran Berhasil Dikonfirmasi!'); window.location='pembayaran.php';</script>";
        }
    } elseif ($_GET['aksi'] == 'tolak') {
        if (tolakPembayaran($db, $id_transaksi)) {
            echo "<script>alert('Pembayaran Ditolak!'); window.location='pembayaran.php';</script>";
        }
    }
}

$payments = getAllPayments($db);
include '../inc/header.php';
?>

<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800 font-weight-bold">Validasi Pembayaran</h1>

    <div class="card shadow mb-4 border-0">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="bg-light">
                        <tr>
                            <th>Pelanggan</th>
                            <th>Metode</th>
                            <th>Total Tagihan</th>
                            <th>Bukti Transfer</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($payments as $p): ?>
                        <tr>
                            <td class="align-middle font-weight-bold"><?php echo $p['user_name'] ?></td>
                            <td class="align-middle"><?php echo $p['nama_metode'] ?></td>
                            <td class="align-middle">Rp <?php echo number_format($p['total_bayar']) ?></td>
                            <td class="align-middle text-center">
                                <a href="../assets/img/bukti/<?php echo $p['bukti_bayar'] ?>" target="_blank">
                                    <img src="../assets/img/bukti/<?php echo $p['bukti_bayar'] ?>" width="80" class="img-thumbnail shadow-sm">
                                </a>
                            </td>
                            <td class="align-middle">
                                <?php if($p['status_pembayaran'] == 'menunggu_konfirmasi'): ?>
                                    <span class="badge badge-warning">Perlu Dicek</span>
                                <?php elseif($p['status_pembayaran'] == 'lunas'): ?>
                                    <span class="badge badge-success">Lunas</span>
                                <?php else: ?>
                                    <span class="badge badge-secondary">Belum Bayar</span>
                                <?php endif; ?>
                            </td>
                            <td class="align-middle">
                                <?php if($p['status_pembayaran'] == 'menunggu_konfirmasi'): ?>
                                    <a href="?aksi=terima&id=<?php echo $p['transaksi_id'] ?>" class="btn btn-success btn-sm" onclick="return confirm('Terima pembayaran ini?')">
                                        <i class="fas fa-check"></i>
                                    </a>
                                    <a href="?aksi=tolak&id=<?php echo $p['transaksi_id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Tolak pembayaran ini?')">
                                        <i class="fas fa-times"></i>
                                    </a>
                                <?php else: ?>
                                    <span class="text-muted small">Selesai</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php include '../inc/footer.php'; ?>