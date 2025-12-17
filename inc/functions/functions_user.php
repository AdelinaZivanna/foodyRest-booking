<?php

class functions_User {
function getAllUsers($conn) {
    $query = $conn->query("SELECT * FROM `users`");
    $users = [];
    while ($row = $query->fetch_object()) {
        $users[] = $row;
    }
    return $users;
}

function deleteUser($conn, $id) {
    $check_exist_group = $this->getUserById($conn, $id);
    if ($check_exist_group === null) {
        return false;
    } else {
    $sql = "DELETE FROM `users` WHERE id='{$id}'";
    return $conn->query($sql);
    }
}

function processDeleteUser($conn) {
    if (isset($_GET['action']) && $_GET['action'] == 'hapus' && isset($_GET['id'])) {
        $id = $_GET['id'];
        if ($this->deleteUser($conn, $id)) {
            $_SESSION['message'] = "Data berhasil dihapus!";
            echo '<script>window.location.href = "users.php"</script>';
            exit;
        }
    }
}

function addUser($conn, $username, $password, $email, $first_name, $last_name, $company, $phone) {
    $random_number = rand();

    $query = "INSERT INTO `users` (id, ip_address, username, password, email, activation_selector, activation_code, forgotten_password_selector, forgotten_password_code, forgotten_password_time, 
        remember_selector, remember_code, created_on, last_login, active, 
        first_name, last_name, company, phone
    ) VALUES (
        NULL, '$random_number', '$username', '$password', '$email',
        '$random_number', '$random_number',
        '$random_number', '$random_number', '$random_number',
        '$random_number', '$random_number', '$random_number', '$random_number', '1',
        '$first_name', '$last_name', '$company', '$phone'
    )";

    return $conn->query($query);
}

function processAddUser($conn) {
    if (isset($_POST['submit'])) {
        $username   = $_POST['username'];
        $password   = $_POST['password'];
        $email      = $_POST['email'];
        $first_name = $_POST['first_name'];
        $last_name  = $_POST['last_name'];
        $company    = $_POST['company'];
        $phone      = $_POST['phone'];

        if ($this->addUser($conn, $username, $password, $email, $first_name, $last_name, $company, $phone)) {
            $_SESSION['message'] = "Data berhasil ditambahkan!";
            echo '<script>window.location.href = "users.php"</script>';
            exit;
        }
    }
}

function getUserById($conn, $id) {
    $query = $conn->query("SELECT * FROM users WHERE id='$id'");
    return $query->fetch_object();
}

function updateUser($conn, $id, $username, $email, $firstName, $lastName, $company, $phone) {
    $check_exist_group = $this->getUserById($conn, $id);
    if ($check_exist_group === null) {
        return false;
    }else {
    $query = "UPDATE users 
              SET username='$username', email='$email', 
                  first_name='$firstName', last_name='$lastName', 
                  company='$company', phone='$phone' 
              WHERE id='$id'";
    return $conn->query($query);
    }
}

function set_response($data, $code = 200)
{
    http_response_code($code);
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json; charset=utf-8');
    return json_encode($data);
}

function processEditUser($conn) {
    if (isset($_POST['update'])) {
        $id        = $_POST['id'];
        $username  = $_POST['username'];
        $email     = $_POST['email'];
        $firstName = $_POST['first_name'];
        $lastName  = $_POST['last_name'];
        $company   = $_POST['company'];
        $phone     = $_POST['phone'];

        if ($this->updateUser($conn, $id, $username, $email, $firstName, $lastName, $company, $phone)) {
            $_SESSION['message'] = "Data berhasil diupdate!";
            echo '<script>window.location.href = "users.php"</script>';
            exit;
        }
    }
}

}

?>