<?php
session_start();
require_once '../inc/functions/config.php';
require_once '../inc/functions/functions_admin.php';

if (!isset($_SESSION['login']) || $_SESSION['role'] !== 'admin') {
    header('Location: ../login.php');
    exit;
}

if (!isset($_GET['id'])) {
    header('Location: menu.php');
    exit;
}

$id = $_GET['id'];
$menu = getMenuById($db, $id);

if (!$menu) {
    header('Location: menu.php');
    exit;
}

if (isset($_POST['update'])) {
    updateMenu(
        $db,
        $id,
        $_POST['nama_menu'],
        $_POST['deskripsi'],
        $_POST['harga'],
        $_POST['status']
    );
    header('Location: menu.php');
    exit;
}

include '../inc/header.php';
?>

<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800 font-weight-bold">Edit Menu</h1>

    <div class="card shadow border-0 col-md-8">
        <div class="card-body">
            <form method="POST">
                <div class="form-group">
                    <label>Nama Menu</label>
                    <input type="text" name="nama_menu"
                           class="form-control"
                           value="<?php echo $menu['nama_menu'] ?>" required>
                </div>

                <div class="form-group">
                    <label>Deskripsi</label>
                    <textarea name="deskripsi" class="form-control" required><?php echo $menu['deskripsi'] ?></textarea>
                </div>

                <div class="form-group">
                    <label>Harga</label>
                    <input type="number" name="harga"
                           class="form-control"
                           value="<?php echo $menu['harga'] ?>" required>
                </div>

                <div class="form-group">
                    <label>Status</label>
                    <select name="status" class="form-control">
                        <option value="tersedia" <?php echo $menu['status']=='tersedia'?'selected':'' ?>>
                            Tersedia
                        </option>
                        <option value="habis" <?php echo $menu['status']=='habis'?'selected':'' ?>>
                            Habis
                        </option>
                    </select>
                </div>

                <div class="text-right">
                    <a href="menu.php" class="btn btn-secondary btn-sm">Batal</a>
                    <button type="submit" name="update"
                            class="btn btn-primary btn-sm">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include '../inc/footer.php'; ?>
