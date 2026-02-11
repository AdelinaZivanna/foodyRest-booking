<?php
session_start();

$page = basename($_SERVER['PHP_SELF']);

session_destroy();
header('Location: ../login.php');
exit;
?>