<?php
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $idPozo = $_GET['id'];

    include 'conexion.php';

    $consulta = "DELETE FROM pozos WHERE id = $idPozo";

    if (mysqli_query($conexion, $consulta)) {

        header("Location: index.php?success=2");
        exit();
    } else {

        header("Location: index.php?error=1");
        exit();
    }
} else {
    header("Location: index.php");
    exit();
}
?>
