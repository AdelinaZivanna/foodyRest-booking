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

        $id   = $_POST['id'];
        $username   = $_POST['username'];
        $password   = $_POST['password'];
        $email      = $_POST['email'];
        $first_name = $_POST['first_name'];
        $last_name  = $_POST['last_name'];
        $company    = $_POST['company'];
        $phone      = $_POST['phone'];
        $edit_groups = $functions->updateUser($conn, $id, $username, $password, $email, $first_name, $last_name, $company, $phone);

        if ($edit_groups == false) 
        {
            $create_response = array(
                'status'=> false,
                'message' => 'Data user can not update'
            );
            $http_code = 400;
        }
        else
        {
            $create_response = array(
                'status'=> true,
                'message' => 'Data user update successfully'
            );
            $http_code = 200;
        }

        echo $functions->set_response($create_response, $http_code);
        break;

    default:

    $create_response = array(
        'status'=> false,
        'message'=> 'Method not allowed!',
        );

        echo $functions->set_response($create_response, 404);
    break;
}

?>