<?php
include 'db.php';
session_start();

$user = $_POST['user'];
$pass = $_POST['pass'];

$sql = "SELECT * FROM usuarios WHERE usuario = '$user' AND password = '$pass'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $_SESSION['admin_logged'] = true;
    header("Location: admin.php");
} else {
    echo "<script>alert('Datos incorrectos'); window.location='login.php';</script>";
}
?>