<?php
$conn = new mysqli('localhost', 'root', '', 'sbadmin2_starterkit');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

?>
