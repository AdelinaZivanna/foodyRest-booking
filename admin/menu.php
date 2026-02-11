<?php
session_start();

$page = basename($_SERVER['PHP_SELF']);

include '../inc/functions/config.php';
include '../inc/functions/functions_admin.php'; 

if(!isset($_SESSION['login']) || $_SESSION['role'] !== 'admin'){
    header('Location: ../login.php');
    exit;
}

if(isset($_POST['add'])){
    tambahMenu($db, $_POST['nama_menu'], $_POST['deskripsi'], $_POST['harga'], $_POST['status']);
    header('Location: menu.php');
    exit;
}

if(isset($_GET['delete'])){
    hapusMenu($db, $_GET['delete']);
    header('Location: menu.php');
    exit;
}

$menus = getAllMenu($db);

include('../inc/header.php'); 
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Menu - Admin</title>
    <link href="../assets/vendor/fontawesome-free/css/all.min.css" rel="stylesheet">
    <link href="../assets/css/sb-admin-2.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-4">
    <h1 class="h3 mb-4 text-gray-800">Daftar Menu</h1>

    <div class="card mb-4">
        <div class="card-body">
            <form method="POST">
                <div class="form-group">
                    <label>Nama Menu</label>
                    <input type="text" name="nama_menu" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>Deskripsi</label>
                    <textarea name="deskripsi" class="form-control" required></textarea>
                </div>
                <div class="form-group">
                    <label>Harga</label>
                    <input type="number" name="harga" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>Status</label>
                    <select name="status" class="form-control">
                        <option value="tersedia">Tersedia</option>
                        <option value="habis">Habis</option>
                    </select>
                </div>
                <button type="submit" name="add" class="btn btn-primary">Tambah Menu</button>
            </form>
        </div>
    </div>

    <table class="table table-bordered table-hover">
        <thead class="thead-light">
            <tr>
                <th>Nama Menu</th>
                <th>Deskripsi</th>
                <th>Harga</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php if(count($menus) > 0): ?>
                <?php foreach($menus as $menu): ?>
                <tr>
                    <td><?php echo $menu['nama_menu'] ?></td>
                    <td><?php echo $menu['deskripsi'] ?></td>
                    <td><?php echo number_format($menu['harga']) ?></td>
                <td>
                    <?php if($menu['status'] == 'tersedia'): ?>
                        <span class="badge badge-success">Tersedia</span>
                    <?php else: ?>
                        <span class="badge badge-danger">Habis</span>
                    <?php endif; ?>
                </td>
                <td>

                    <a href="edit_menu.php?id=<?php echo $menu['id'] ?>"
                    class="badge badge-warning p-2 mr-1">
                    Edit
                    </a>

                    <a href="menu.php?delete=<?php echo $menu['id'] ?>" 
                    class="badge badge-danger p-2" 
                    onclick="return confirm('Hapus menu ini?')">Hapus</a>
                </td>
                </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="6" class="text-center">Belum ada menu.</td>
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
