<?php
include ('inc/functions/functions.php');
$functions = new functions_User();

$get_method = $_SERVER['REQUEST_METHOD'];

switch ($get_method)
{
case 'GET':

    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        $group = $functions->getUserById($conn, $id);

        if ($group === null) {
            $create_response = array(
                'status' => false,
                'message' => 'Data user tidak ditemukan',
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
            'data' => $functions->getAllUsers($conn)
        );
        echo $functions->set_response($create_response, 200);
        break;
    }

    case 'POST':
        $username   = $_POST['username'];
        $password   = $_POST['password'];
        $email      = $_POST['email'];
        $first_name = $_POST['first_name'];
        $last_name  = $_POST['last_name'];
        $company    = $_POST['company'];
        $phone      = $_POST['phone'];

        $created = $functions->addUser($conn, $username, $password, $email, $first_name, $last_name, $company, $phone);

        if ($created) {
            $response = array(
                'status'  => true,
                'message' => 'Data User berhasil ditambahkan'
            );
            $code = 200;
        } else {
            $response = array(
                'status'  => false,
                'message' => 'Data User gagal ditambahkan'
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