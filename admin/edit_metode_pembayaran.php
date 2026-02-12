<?php
session_start();

include '../inc/functions/config.php';
include '../inc/functions/functions_admin.php';

if (!isset($_SESSION['login']) || $_SESSION['role'] !== 'admin') {
    header('Location: ../login.php');
    exit;
}

if (!isset($_GET['id'])) {
    header('Location: metode_pembayaran.php');
    exit;
}

$id = $_GET['id'];
$metode = getMotodeById($db, $id);


if (!$metode) {
    header('Location: metode_pembayaran.php');
    exit;
}

if (isset($_POST['update'])) {
    updateMetodePembayaran(
        $db,
        $id,
        $_POST['nama_metode'],
        $_POST['keterangan'],
        $_POST['status']
    );

    header('Location: metode_pembayaran.php');
    exit;
}

include('../inc/header.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Metode Pembayaran</title>
    <link href="../assets/vendor/fontawesome-free/css/all.min.css" rel="stylesheet">
    <link href="../assets/css/sb-admin-2.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-4">
    <h1 class="h3 mb-4 text-gray-800">Edit Metode Pembayaran</h1>

    <div class="card">
        <div class="card-body">
            <form method="POST">

                <div class="form-group">
                    <label>Nama Metode</label>
                    <input type="text" 
                           name="nama_metode" 
                           class="form-control"
                           value="<?php echo $metode['nama_metode']; ?>"
                           required>
                </div>

                <div class="form-group">
                    <label>Keterangan</label>
                    <textarea name="keterangan"
                              class="form-control"
                              required><?php echo $metode['keterangan']; ?></textarea>
                </div>

                <div class="form-group">
                    <label>Status</label>
                    <select name="status" class="form-control">
                        <option value="aktif"
                            <?php if($metode['status'] == 'aktif') echo 'selected'; ?>>
                            Aktif
                        </option>
                        <option value="nonaktif"
                            <?php if($metode['status'] == 'nonaktif') echo 'selected'; ?>>
                            Nonaktif
                        </option>
                    </select>
                </div>

                <button type="submit" name="update" class="btn btn-primary">
                    Update
                </button>

                <a href="metode_pembayaran.php" class="btn btn-secondary">
                    Batal
                </a>

            </form>
        </div>
    </div>
</div>

<script src="../assets/vendor/jquery/jquery.min.js"></script>
<script src="../assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="../assets/js/sb-admin-2.min.js"></script>

</body>
</html>

<?php include('../inc/footer.php'); ?>
