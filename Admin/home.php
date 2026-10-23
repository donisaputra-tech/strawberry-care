<?php
session_start();
if ($_SESSION['level'] != 'Admin') {
    header("location: ../login.php");
    exit;
}
?>
