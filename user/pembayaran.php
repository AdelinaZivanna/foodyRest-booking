<?php
session_start();

$page = basename($_SERVER['PHP_SELF']);

require_once '../inc/functions/config.php';
require_once '../inc/functions/functions_user.php';

$transaksi_id = $_GET['id'] ?? null;
$data = getTransactionDetail($db, $transaksi_id);

if (!$data || $data['user_id'] != $_SESSION['user_id']) {
    header("Location: riwayat.php"); exit;
}

if (isset($_POST['bayar'])) {
    $ext = pathinfo($_FILES['bukti']['name'], PATHINFO_EXTENSION);
    $file_name = "bukti_" . $transaksi_id . "_" . time() . "." . $ext;
    
    if (move_uploaded_file($_FILES['bukti']['tmp_name'], "../assets/img/bukti/" . $file_name)) {
        tambahPembayaran($db, $transaksi_id, $_POST['metode_id'], $data['total_harga'], $file_name);
        echo "<script>alert('Berhasil!'); window.location='riwayat.php';</script>";
    }
}
include '../inc/header_user.php';
?>

<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-lg-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3 bg-primary">
                    <h6 class="m-0 font-weight-bold text-white text-center">STRUK RESERVASI #<?php echo $data['id'] ?></h6>
                </div>
                <div class="card-body">
                    <div class="text-center mb-4">
                        <h4 class="font-weight-bold text-gray-800">FoodyRest</h4>
                        <p class="small">Nota Pemesanan - <?php echo date('d M Y', strtotime($data['tanggal'])) ?></p>
                    </div>

                    <div class="row small mb-3">
                        <div class="col-6">
                            <strong>Pelanggan:</strong> <?php echo $data['nama_user'] ?><br>
                            <strong>Meja:</strong> <?php echo $data['nama_meja'] ?>
                        </div>
                        <div class="col-6 text-right">
                            <strong>Jam:</strong> <?php echo $data['jam'] ?><br>
                            <strong>Status:</strong> <span class="badge badge-warning"><?php echo $data['status_pembayaran'] ?></span>
                        </div>
                    </div>

                    <table class="table table-sm text-gray-900">
                        <thead>
                            <tr>
                                <th>Menu</th>
                                <th class="text-center">Qty</th>
                                <th class="text-right">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($data['items'] as $item): ?>
                            <tr>
                                <td><?php echo $item['nama_menu'] ?></td>
                                <td class="text-center"><?php echo $item['qty'] ?></td>
                                <td class="text-right">Rp <?php echo number_format($item['harga'] * $item['qty']) ?></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                        <tfoot>
                            <tr class="font-weight-bold" style="font-size: 1.1rem;">
                                <td colspan="2" class="text-right">TOTAL BAYAR:</td>
                                <td class="text-right text-success">Rp <?php echo number_format($data['total_harga']) ?></td>
                            </tr>
                        </tfoot>
                    </table>

                    <hr>

                    <form method="POST" enctype="multipart/form-data" class="mt-4">
                        <div class="form-group">
                            <label class="font-weight-bold small">Pilih Metode Pembayaran</label>
                                <?php $metodeList = getActiveMetodePembayaran($db); ?>

                                <select name="metode_id" class="form-control form-control-sm" required>
                                    <option value="">-- Pilih Metode Pembayaran --</option>
                                    <?php foreach($metodeList as $m): ?>
                                        <option value="<?php echo $m['id'] ?>">
                                            <?php echo $m['nama_metode'] ?> (<?php echo $m['keterangan'] ?>)
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                        </div>
                        <div class="form-group">
                            <label class="font-weight-bold small">Upload Bukti Transfer</label>
                            <input type="file" name="bukti" class="form-control-file small" required>
                        </div>
                        <button name="bayar" class="btn btn-primary btn-block shadow-sm">
                            <i class="fas fa-upload fa-sm"></i> Kirim Konfirmasi Pembayaran
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include '../inc/footer_user.php'; ?>