<?php
session_start();
require_once '../inc/functions/config.php';
require_once '../inc/functions/functions_user.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit;
}

$user = getUserById($db, $_SESSION['user_id']);

include '../inc/header_user.php';
?>

<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800 font-weight-bold">Profil Saya</h1>

    <div class="row">

        <div class="col-lg-8">
            <div class="card shadow mb-4 border-0">
                <div class="card-header bg-white">
                    <h6 class="font-weight-bold text-primary mb-0">
                        Informasi Akun
                    </h6>
                </div>

                <div class="card-body">
                    <table class="table table-borderless">
                        <tr>
                            <th width="30%">Nama Lengkap</th>
                            <td><?php echo $user['nama'] ?></td>
                        </tr>
                        <tr>
                            <th>Email</th>
                            <td><?php echo $user['email'] ?></td>
                        </tr>
                    </table>

                    <hr>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include '../inc/footer_user.php'; ?>
