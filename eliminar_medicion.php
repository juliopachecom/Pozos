<?php
include 'conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $idMedicion = $_GET['id'];

    // Eliminar la medición de la tabla mediciones
    $consulta = "DELETE FROM mediciones WHERE idMedicion = $idMedicion";
    $resultado = mysqli_query($conexion, $consulta);

    if ($resultado) {
        // Redirigir a la página de visualización del pozo con un parámetro de éxito
        header("Location: visualizar_pozo.php?id=" . $_GET['idPozo']);
        exit();
    } else {
        // Mostrar mensaje de error si la eliminación falla
        echo "Error al eliminar la medición: " . mysqli_error($conexion);
    }
} else {
    // Redirigir si se accede directamente al archivo sin enviar datos por GET
    header("Location: index.php");
    exit();
}
?>
