<?php
session_start();

$page = basename($_SERVER['PHP_SELF']);

require_once '../inc/functions/config.php';
require_once '../inc/functions/functions_admin.php';

if (!isset($_SESSION['login']) || $_SESSION['role'] !== 'admin') {
    header('Location: ../login.php'); 
    exit;
}

if (isset($_POST['tambah'])) {
    tambahMeja($db, $_POST['nama_meja'], $_POST['kapasitas']);
    header("Location: meja.php");
    exit;
}

if (isset($_GET['hapus'])) {
    hapusMeja($db, $_GET['hapus']);
    header("Location: meja.php");
    exit;
}

$meja = getSemuaMeja($db);

include '../inc/header.php';
?>

<div class="container-fluid">
<h1 class="h3 mb-4">Kelola Meja</h1>

<div class="card shadow mb-4">
<div class="card-body">

<form method="POST" class="form-inline mb-3">
    <input name="nama_meja" class="form-control mr-2" placeholder="Nama Meja" required>
    <input name="kapasitas" type="number" class="form-control mr-2" placeholder="Kapasitas" required>
    <button name="tambah" class="btn btn-primary">Tambah</button>
</form>

<table class="table table-bordered">
<tr>
    <th>Nama Meja</th>
    <th>Kapasitas</th>
    <th>Aksi</th>
</tr>
<?php foreach ($meja as $m): ?>
<tr>
    <td><?php echo $m['nama_meja'] ?></td>
    <td><?php echo $m['kapasitas'] ?></td>
    <td>

        <a href="edit_meja.php?id=<?php echo $m ['id'] ?>"
        class="badge badge-warning p-2 mr-1">
        Edit
        </a>

        <a href="?hapus=<?php echo $m['id'] ?>" class="btn btn-danger btn-sm"
           onclick="return confirm('Hapus meja?')">Hapus</a>
    </td>
</tr>
<?php endforeach; ?>
</table>

</div>
</div>
</div>

<?php include '../inc/footer.php'; ?>
