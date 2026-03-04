<?php
require_once __DIR__ . '/../data/db.php';
session_start();

$db = new Database();
$conn = $db->getConnection();

$user = $_POST['user'] ?? '';
$pass = $_POST['pass'] ?? '';

$stmt = $conn->prepare("SELECT id FROM usuarios WHERE username = ? AND password = ? LIMIT 1");
$stmt->bind_param("ss", $user, $pass);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $_SESSION['admin_logged'] = true;
    header("Location: ../web/admin.php");
    exit();
} else {
    echo "<script>alert('Datos incorrectos'); window.location='../web/login.php';</script>";
    exit();
}
?>