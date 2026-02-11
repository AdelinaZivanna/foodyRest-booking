<?php
session_start();

$page = basename($_SERVER['PHP_SELF']);

require_once '../inc/functions/config.php';
require_once '../inc/functions/functions_user.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$cartItems = getCartItems($db, $user_id);

if (empty($cartItems)) {
    echo "<script>alert('Keranjang kosong!'); window.location='menu.php';</script>";
    exit;
}

$tanggal = $_GET['tanggal'] ?? date('Y-m-d');
$jam     = $_GET['jam'] ?? '18:00';
$meja    = getAllMeja($db);
$bookedMeja = getBookedMeja($db, $tanggal, $jam);

if (isset($_POST['booking'])) {
    $id_transaksi = checkoutBooking($db, $user_id, $_POST['meja_id'], $tanggal, $jam, $_POST['jumlah_orang'], $cartItems);
    if ($id_transaksi) {
        header("Location: pembayaran.php?id=$id_transaksi"); exit;
    } else {
        $error = "Gagal memproses booking.";
    }
}
include '../inc/header_user.php';
?>

<div class="container-fluid">
<div class="row">

<div class="col-lg-8">
    <h1 class="h3 mb-4 text-gray-800">Pilih Meja</h1>

    <div class="card shadow mb-4">
        <div class="card-body">
            <form method="GET" class="form-row">
                <div class="col-md-5">
                    <label class="small">Tanggal</label>
                    <input type="date" name="tanggal" class="form-control" value="<?php echo $tanggal ?>" required>
                </div>
                <div class="col-md-5">
                    <label class="small">Jam</label>
                    <input type="time" name="jam" class="form-control" value="<?php echo $jam ?>" required>
                </div>
                <div class="col-md-2 d-flex align-items-end">
                    <button class="btn btn-primary btn-block">Cek</button>
                </div>
            </form>
        </div>
    </div>

    <?php if (isset($error)) : ?>
        <div class="alert alert-danger"><?php echo $error ?></div>
    <?php endif; ?>

    <div class="row">
        <?php foreach ($meja as $m) : 
            $isBooked = in_array($m['id'], $bookedMeja); ?>

            <div class="col-md-4 mb-3">
                <div class="card text-center <?php echo $isBooked ? 'border-danger bg-light' : 'border-success' ?>">
                    <div class="card-body">
                        <h6 class="font-weight-bold"><?php echo $m['nama_meja'] ?></h6>
                        <p class="small text-muted">Kapasitas <?php echo $m['kapasitas'] ?> Orang</p>

                        <?php if ($isBooked) : ?>
                            <button class="btn btn-secondary btn-sm btn-block" disabled>
                                Sudah Dibooking
                            </button>
                        <?php else : ?>
                            <form method="POST">
                                <input type="hidden" name="meja_id" value="<?php echo $m['id'] ?>">
                                <input type="hidden" name="jumlah_orang" value="<?php echo $m['kapasitas'] ?>">
                                <button name="booking" class="btn btn-success btn-sm btn-block">
                                    Pilih Meja
                                </button>
                            </form>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

        <?php endforeach; ?>
    </div>
</div>

<div class="col-lg-4">
    <div class="card shadow border-left-primary sticky-top" style="top:20px">
        <div class="card-header">
            <h6 class="m-0 font-weight-bold text-primary">Ringkasan Pesanan</h6>
        </div>
        <div class="card-body p-0">
            <ul class="list-group list-group-flush">
                <?php $total = 0; foreach ($cartItems as $c) :
                    $subtotal = $c['harga'] * $c['qty'];
                    $total += $subtotal; ?>
                    <li class="list-group-item d-flex justify-content-between small">
                        <?php echo $c['nama_menu'] ?> (x<?php echo $c['qty'] ?>)
                        <span>Rp <?php echo number_format($subtotal) ?></span>
                    </li>
                <?php endforeach; ?>
            </ul>
            <div class="p-3 text-right bg-light">
                <small>Total</small>
                <h5 class="font-weight-bold text-primary mb-0">
                    Rp <?php echo number_format($total) ?>
                </h5>
            </div>
        </div>
    </div>
</div>

</div>
</div>

<?php include '../inc/footer_user.php'; ?>
