<?php
session_start();

$page = basename($_SERVER['PHP_SELF']);

require_once '../inc/functions/functions.php';
include '../inc/header_user.php';

$user_id = $_SESSION['user_id'];
$history = getUserFullHistory($db, $user_id);
?>

<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Riwayat Reservasi & Pesanan</h1>

    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover" id="dataTable" width="100%" cellspacing="0">
                    <thead class="bg-light">
                        <tr>
                            <th>Jadwal</th>
                            <th>Meja</th>
                            <th>Total Bayar</th>
                            <th>Status Bayar</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(empty($history)): ?>
                            <tr>
                                <td colspan="6" class="text-center">Belum ada riwayat pesanan.</td>
                            </tr>
                        <?php endif; ?>

                        <?php foreach($history as $h): ?>
                        <tr>
                            <td>
                                <strong><?php echo date('d M Y', strtotime($h['tanggal'])) ?></strong><br>
                                <small class="text-muted"><i class="fas fa-clock"></i> <?php echo $h['jam'] ?></small>
                            </td>
                            <td><?php echo $h['nama_meja'] ?></td>
                            <td>Rp <?php echo number_format($h['total_harga'] ?? 0) ?></td>
                            <td>
                                <?php 
                                    $status = $h['status_pembayaran'];
                                    if($status == 'lunas') echo '<span class="badge badge-success p-2">Lunas</span>';
                                    elseif($status == 'menunggu_konfirmasi') echo '<span class="badge badge-info p-2">Dicek Admin</span>';
                                    else echo '<span class="badge badge-warning p-2">Belum Bayar</span>';
                                ?>
                            </td>
                            <td>
                                <?php if($status == 'belum_bayar'): ?>
                                    <a href="pembayaran.php?id=<?php echo $h['transaksi_id'] ?>" class="btn btn-sm btn-primary">
                                        Bayar Sekarang
                                    </a>
                                <?php else: ?>
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

<?php include '../inc/footer_user.php'; ?>