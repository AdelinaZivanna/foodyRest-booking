<?php
session_start();
require_once '../inc/functions/config.php';
require_once '../inc/functions/functions_admin.php';

if (!isset($_SESSION['login']) || $_SESSION['role'] !== 'admin') {
    header('Location: ../login.php');
    exit;
}

if (!isset($_GET['id'])) {
    header('Location: meja.php');
    exit;
}

$id = $_GET['id'];
$meja = getMejaById($db, $id);

if (!$meja) {
    header('Location: meja.php');
    exit;
}

if (isset($_POST['update'])) {
    updateMeja($db, $id, $_POST['nama_meja'], $_POST['kapasitas']);
    header('Location: meja.php');
    exit;
}

include '../inc/header.php';
?>

<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Edit Meja</h1>

    <div class="card shadow mb-4">
        <div class="card-body">

            <form method="POST">
                <div class="form-group">
                    <label>Nama Meja</label>
                    <input type="text" name="nama_meja"
                           class="form-control"
                           value="<?php echo ($meja['nama_meja']) ?>"
                           required>
                </div>

                <div class="form-group">
                    <label>Kapasitas</label>
                    <input type="number" name="kapasitas"
                           class="form-control"
                           value="<?php echo $meja['kapasitas'] ?>"
                           required>
                </div>

                <button name="update" class="btn btn-warning">
                    Update Meja
                </button>
                <a href="meja.php" class="btn btn-secondary">
                    Batal
                </a>
            </form>

        </div>
    </div>
</div>

<?php include '../inc/footer.php'; ?>
