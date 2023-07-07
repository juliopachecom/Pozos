<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $idPozo = $_POST['idPozo'];
    $nuevoNombre = $_POST['nombreModificar'];

    include 'conexion.php';

    $consulta = "UPDATE pozos SET nombre = '$nuevoNombre' WHERE id = '$idPozo'";

    $resultado = mysqli_query($conexion, $consulta);

    if ($resultado) {
       
        header('Location: index.php');
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
