<?php
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/functions_admin.php';

class message_Alert {
    public static function alertMessage() {
        if (isset($_SESSION['message'])) {
            echo '
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                ' . $_SESSION['message'] . '
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>';
            unset($_SESSION['message']);
        }
    }
}

function loginUser($db, $email, $password) {

    $stmt = $db->prepare("SELECT * FROM users WHERE email=? LIMIT 1");
    $stmt->execute([$email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if($user && password_verify($password, $user['password'])){
        $_SESSION['login']   = true;
        $_SESSION['role']    = 'user';
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['nama']    = $user['nama'];
        $_SESSION['email']   = $user['email'];
        $_SESSION['role']    = $user['role'];

        return ['status' => 'success', 'role' => $user['role']];
    }

    return ['status' => 'error', 'message' => 'Email atau Password salah!'];
}

function registerUser($db, $nama, $email, $password) {
    $cek = $db->prepare("SELECT id FROM users WHERE email=?");
    $cek->execute([$email]);

    if($cek->rowCount() > 0){
        return ['status' => 'error', 'message' => 'Email sudah terdaftar!'];
    }

    $hash = password_hash($password, PASSWORD_DEFAULT);
    $stmt = $db->prepare("INSERT INTO users (nama, email, password, role) VALUES (?, ?, ?, 'user')");
    
    if($stmt->execute([$nama, $email, $hash])){
        return ['status' => 'success'];
    }
    return ['status' => 'error', 'message' => 'Gagal mendaftar.'];
}