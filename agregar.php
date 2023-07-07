<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $nombre = $_POST['nombre'];

    include 'conexion.php';

    $consulta = "INSERT INTO pozos (nombre) VALUES ('$nombre')";

 
    $resultado = mysqli_query($conexion, $consulta);

    if ($resultado) {
      
        header('Location: index.php?success=1');
        exit();
    } else {

        header('Location: index.php?error=1');
        exit();
    }
} else {

    header('Location: index.php');
    exit();
}
?>
