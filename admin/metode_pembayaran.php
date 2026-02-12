<?php
session_start();

$page = basename($_SERVER['PHP_SELF']);

include '../inc/functions/config.php';
include '../inc/functions/functions_admin.php';

if (!isset($_SESSION['login']) || $_SESSION['role'] !== 'admin') {
    header('Location: ../login.php');
    exit;
}

if (isset($_POST['add'])) {
    tambahMetodePembayaran(
        $db,
        $_POST['nama_metode'],
        $_POST['keterangan'],
        $_POST['status']
    );
    header('Location: metode_pembayaran.php');
    exit;
}

if(isset($_GET['delete'])) {
    deleteMetodePembayaran($db, $_GET['delete']);
    header('Location: metode_pembayaran.php');
    exit;
}

$metodes = getAllMetode($db);

include('../inc/header.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Metode Pembayaran - Admin</title>
    <link href="../assets/vendor/fontawesome-free/css/all.min.css" rel="stylesheet">
    <link href="../assets/css/sb-admin-2.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-4">
        <h1 class="h3 mb-4 text-gray-800">Metode Pembayaran</h1>

        <div class="card mb-4">
            <div class="card-body">
                <form method="POST">
                    <div class="form-group">
                        <label>Nama Metode</label>
                        <input type="text" name="nama_metode" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label>Keterangan</label>
                        <textarea name="keterangan" class="form-control" required></textarea>
                    </div>

                    <div class="form-group">
                        <label>Status</label>
                        <select name="status" class="form-control">
                            <option value="aktif">Aktif</option>
                            <option value="nonaktif">Nonaktif</option>
                        </select>
                    </div>
                    <button type="submit" name="add" class="btn btn-primary">
                        Tambah Metode
                    </button>
                </form>
            </div>
        </div>

        <table class="table table-bordered table-hover">
            <thead class="thead-light">
                <tr>
                    <th>Nama Metode</th>
                    <th>Keterangan</th>
                    <th>Status</th>
                    <th width="150">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if(count($metodes) > 0): ?>
                    <?php foreach($metodes as $m): ?>
                    <tr>
                        <td><?php echo $m['nama_metode']; ?></td>
                        <td><?php echo $m['keterangan']; ?></td>
                        <td>
                            <?php if($m['status'] == 'aktif'): ?>
                                <span class="badge badge-success">Aktif</span>
                            <?php else: ?>
                                <span class="badge badge-secondary">Nonaktif</span>
                            <?php endif; ?>
                        </td>

                        <td>
                        <a href="edit_metode_pembayaran.php?id=<?php echo $m['id']; ?>"
                           class="badge badge-warning p-2 mr-1">
                           Edit
                        </a>

                        <a href="metode_pembayaran.php?delete=<?php echo $m['id']; ?>"
                           class="badge badge-danger p-2"
                           onclick="return confirm('Yakin hapus metode ini?')">
                           Hapus
                        </a>
                    </td>
                    </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="4" class="text-center">
                            Belum ada metode pembayaran.
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
<script src="../assets/vendor/jquery/jquery.min.js"></script>
<script src="../assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="../assets/js/sb-admin-2.min.js"></script>
</body>
</html>

<?php
include('../inc/footer.php');
?>