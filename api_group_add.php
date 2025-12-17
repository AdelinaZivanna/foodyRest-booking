<?php
require_once "inc/functions/functions.php";
$functions = new functions_Group();

$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {

    case 'GET':

    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        $group = $functions->getGroupById($conn, $id);

        if ($group === null) {
            $create_response = array(
                'status' => false,
                'message' => 'Data group tidak ditemukan',
                'data' => null
            );
            echo $functions->set_response($create_response, 404);
            break;
        }

        $create_response = array(
            'status' => true,
            'message' => '',
            'data' => $group
        );
        echo $functions->set_response($create_response, 200);
        break;

    } else {
        $create_response = array(
            'status' => true,
            'message' => '',
            'data' => $functions->getAllGroups($conn)
        );
        echo $functions->set_response($create_response, 200);
        break;
    }

    case 'POST':
        $name        = $_POST['name'];
        $description = $_POST['description'];

        $created = $functions->addGroup($conn, $name, $description);

        if ($created) {
            $response = array(
                'status'  => true,
                'message' => 'Data group berhasil ditambahkan'
            );
            $code = 200;
        } else {
            $response = array(
                'status'  => false,
                'message' => 'Data group gagal ditambahkan'
            );
            $code = 400;
        }

        echo $functions->set_response($response, $code);
        break;

    default:

    $response = array(
        'status'=> false,
        'message'=> 'Method not allowed!',
        );

        echo $functions->set_response($response, 404);
    break;
}
?>