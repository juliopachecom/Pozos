<?php
include 'conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $medicion = $_POST['medicion'];
    $fecha = $_POST['fecha'];
    $idPozo = $_POST['idPozo'];

    $query = "INSERT INTO mediciones (psi, fecha, idPozo) VALUES ('$medicion', '$fecha', '$idPozo')";
    $result = mysqli_query($conexion, $query);

    if ($result) {
        header("Location: index.php?success_medicion=1");
        exit();
    } else {
        header("Location: index.php?error_medicion=1");
        exit();
    }
}
?>
