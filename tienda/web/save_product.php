<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Capturamos los datos del formulario
    $name = $_POST['name'];
    $category = $_POST['category'];
    $price = $_POST['price'];
    $image = $_POST['image'];
    $description = $_POST['description'];


    $sql = "INSERT INTO productos (name, category, price, image, description) 
            VALUES ('$name', '$category', '$price', '$image', '$description')";

    if ($conn->query($sql) === TRUE) {
       
        header("Location: admin.php?status=success");
    } else {
        echo "Error al guardar: " . $conn->error;
    }
}
?>