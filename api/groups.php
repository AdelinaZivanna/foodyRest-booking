<?php
require('../inc/functions/functions.php');

$functions = new functions_Group();

$id = $_GET['id'] ?? null;

if ($id) {
    $data = $functions->getGroupById($conn, $id);

    if ($data) {
        $create_response = [
            'status' => true,
            'message' => "Data group ditemukan",
            'data' => $data
        ];
    } else {
        $create_response = [
            'status' => false,
            'message' => "Tidak ada group dengan id $id",
            'data' => null
        ];
    }

} else {
    $data = $functions->getAllGroups($conn);
    $create_response = [
        'status' => true,
        'message' => "Semua data group ditampilkan",
        'data' => $data
    ];
}

header("Access-Control-Allow-Origin: *");
header('Content-Type: application/json; charset=utf-8');
echo json_encode($create_response);
