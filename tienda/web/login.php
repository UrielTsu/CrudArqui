<?php
session_start();
if (isset($_SESSION['admin_logged'])) { header("Location: admin.php"); exit(); }
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Login - TiendaTech</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body class="admin-body" style="display:flex; justify-content:center; align-items:center; height:100vh;">
    <div class="card" style="width: 350px; padding: 2rem;">
        <h2 style="text-align:center;">Iniciar Sesión</h2>
        <form action="../core/auth.php" method="POST">
            <input type="text" name="user" placeholder="Usuario" required style="width:100%; margin-bottom:1rem;">
            <input type="password" name="pass" placeholder="Contraseña" required style="width:100%; margin-bottom:1rem;">
            <button type="submit" class="btn-checkout">Entrar</button>
        </form>
    </div>
</body>
</html>