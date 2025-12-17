<?php
include ('inc/functions/functions.php');
$functions = new functions_Group();

$get_method = $_SERVER['REQUEST_METHOD'];

switch ($get_method)
{
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

        $get_id = $_POST['id'];
        $delete_groups = $functions->deleteGroup($conn, $get_id);

        if ($delete_groups == false) 
        {
            $create_response = array(
                'status'=> false,
                'message' => 'Data user can not deleted'
            );
            $http_code = 400;
        }
        else
        {
            $create_response = array(
                'status'=> true,
                'message' => 'Data user delete successfully'
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