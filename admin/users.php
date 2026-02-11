<?php
session_start();

$page = basename($_SERVER['PHP_SELF']);

include '../inc/functions/config.php';
include '../inc/functions/functions_admin.php';
include '../inc/header.php';

if(isset($_GET['hapus'])){
    deleteUser($db, $_GET['hapus']);
    echo "<script>window.location='users.php'</script>";
    exit;
}

$users = getAllUsers($db);
?>

<div class="container-fluid">

    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Data Users</h1>
    </div>

    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="table-responsive">

                <table class="table table-bordered table-hover">
                    <thead class="thead-light">
                        <tr>
                            <th>Nama</th>
                            <th>Email</th>
                            <th width="100">Role</th>
                            <th width="120">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(count($users) > 0): ?>
                            <?php foreach($users as $u): ?>
                            <tr>
                                <td><?php echo $u['nama'] ?></td>
                                <td><?php echo $u['email'] ?></td>
                                <td>
                                    <?php if($u['role']=='admin'): ?>
                                        <span class="badge badge-primary">Admin</span>
                                    <?php else: ?>
                                        <span class="badge badge-secondary">User</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if($u['role']=='user'): ?>
                                        <a href="?hapus=<?php echo $u['id'] ?>"
                                           onclick="return confirm('Yakin hapus user ini?')"
                                           class="btn btn-danger btn-sm">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    <?php else: ?>
                                        <button class="btn btn-secondary btn-sm" disabled>-</button>
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="5" class="text-center">Belum ada user</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>

            </div>
        </div>
    </div>

</div>

<?php include '../inc/footer.php'; ?>
