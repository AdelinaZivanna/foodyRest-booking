<?php 

class functions_Group {

    function getAllGroups($conn) {
    $query = $conn->query("SELECT * FROM `groups`");
    $groups = [];
    while ($row = $query->fetch_object()) {
        $groups[] = $row;
    }
    return $groups;
}

function deleteGroup($conn, $id) {
    $check_exist_group = $this->getGroupById($conn, $id);
    if ($check_exist_group === null) {
        return false;
    } else {
    $sql = "DELETE FROM `groups` WHERE id='{$id}'";
    return $conn->query($sql);
    }
}





function processDeleteGroup($conn) {
    if (isset($_GET['action']) && $_GET['action'] == 'hapus' && isset($_GET['id'])) {
        $id = $_GET['id'];
        if ($this->deleteGroup($conn, $id)) {
            $_SESSION['message'] = "Data berhasil dihapus!";
            echo '<script>window.location.href = "groups.php"</script>';
            exit; 
        }
    }
}

function addGroup($conn, $name, $description) {
    $query = "INSERT INTO `groups` (id, name, description) VALUES (null, '$name', '$description')";
    return $conn->query($query);
}

function processAddGroup($conn) {
    if (isset($_POST['submit'])) {
        $get_name = $_POST['name'];
        $get_description = $_POST['description'];

        if($this->addGroup($conn, $get_name, $get_description)) {
            $_SESSION['message'] = "Data berhasil ditambahkan!";
            echo '<script>window.location.href = "groups.php"</script>';
            exit;
        }
    }
}

function getGroupById($conn, $id) {
    $query = $conn->query("SELECT * FROM `groups` WHERE id='$id'");
    return $query->fetch_object();
}

function set_response($data, $code = 200)
{
    http_response_code($code);
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json; charset=utf-8');
    return json_encode($data);
}

function updateGroup($conn, $id, $name, $description) {
    $check_exist_group = $this->getGroupById($conn, $id);
    if ($check_exist_group === null) {
        return false;
    }else {
    $query = "UPDATE `groups` SET name='$name', description='$description' WHERE id='$id'";
    return $conn->query($query);
    }
}

function processEditGroup($conn) {
    if (isset($_POST['update'])) {
        $id          = $_POST['id'];
        $name        = $_POST['name'];
        $description = $_POST['description'];

        if ($this->updateGroup($conn, $id, $name, $description)) {
            $_SESSION['message'] = "Data berhasil diupdate!";
            echo '<script>window.location.href = "groups.php"</script>';
            exit;
        }
    }
}
}


?>