<?php
session_start();

$page = basename($_SERVER['PHP_SELF']);

require_once '../inc/functions/config.php';
require_once '../inc/functions/functions_user.php';

$user_id = $_SESSION['user_id'];

if(isset($_POST['add'])){
    addToCart($db, $user_id, $_POST['menu_id'], $_POST['qty']);
    header("Location: menu.php"); exit;
}

if (isset($_POST['remove'])) {
    removeFromCart($db, $user_id, $_POST['menu_id']);
    header("Location: menu.php"); exit;
}

$menus = getActiveMenu($db);
$cartItems = getCartItems($db, $user_id);
include '../inc/header_user.php';
?>

<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Pilih Menu Lezat</h1>
        <button class="btn btn-success shadow-sm" data-toggle="modal" data-target="#cartModal">
            <i class="fas fa-shopping-cart mr-2"></i>Keranjang (<?php echo count($cartItems) ?>)
        </button>
    </div>

    <div class="row">
        <?php foreach($menus as $m): ?>
        <div class="col-md-3 mb-4">
            <div class="card shadow-sm h-100 border-0">
                <div class="card-body text-center">
                    <h6 class="font-weight-bold"><?php echo $m['nama_menu'] ?></h6>
                    <p class="text-success mb-3">Rp <?php echo number_format($m['harga']) ?></p>
                    <form method="POST">
                        <input type="hidden" name="menu_id" value="<?php echo $m['id'] ?>">
                        <div class="input-group input-group-sm mb-2">
                            <div class="input-group-prepend"><span class="input-group-text">Qty</span></div>
                            <input type="number" name="qty" class="form-control" value="1" min="1">
                        </div>
                        <button name="add" class="btn btn-primary btn-sm btn-block">Tambah ke Keranjang</button>
                    </form>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</div>

<div class="modal fade" id="cartModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-light">
                <h5 class="modal-title">Pesanan Kamu</h5>
                <button class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body p-0">
                <table class="table table-hover mb-0">
                    <thead class="thead-light text-xs uppercase">
                        <tr><th>Menu</th><th>Qty</th><th>Subtotal</th></tr>
                    </thead>
<tbody>
<?php $total = 0; foreach($cartItems as $item): 
    $sub = $item['harga'] * $item['qty']; 
    $total += $sub; ?>
    <tr>
        <td><?php echo $item['nama_menu'] ?></td>
        <td><?php echo $item['qty'] ?></td>
        <td class="text-right">
            Rp <?php echo number_format($sub) ?>
            <form method="POST" class="d-inline">
                <input type="hidden" name="menu_id" value="<?php echo $item['menu_id'] ?>">
                <button name="remove" class="btn btn-sm btn-link text-danger p-0 ml-2">
                    <i class="fas fa-trash"></i>
                </button>
            </form>
        </td>
    </tr>
<?php endforeach; ?>
</tbody>

                </table>
                <?php if(empty($cartItems)): ?>
                    <p class="text-center p-4">Keranjang kosong, yuk pesan dulu!</p>
                <?php else: ?>
                    <div class="p-3 text-right bg-light">
                        <h6 class="font-weight-bold">Total: Rp <?php echo number_format($total) ?></h6>
                    </div>
                <?php endif; ?>
            </div>
            <div class="modal-footer">
                <button class="btn btn-link btn-sm text-muted" data-dismiss="modal">Tambah Lagi</button>
                <?php if(!empty($cartItems)): ?>
                    <a href="booking.php" class="btn btn-primary">Lanjut Pilih Meja &rarr;</a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?php include '../inc/footer_user.php'; ?>