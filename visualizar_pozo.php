<?php
include 'conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $idMedicion = $_POST['idMedicion'];
    $nuevaMedicion = $_POST['medicion'];
    $nuevaFecha = $_POST['fecha'];

    $query = "UPDATE mediciones SET psi='$nuevaMedicion', fecha='$nuevaFecha' WHERE idMedicion='$idMedicion'";
    $result = mysqli_query($conexion, $query);

    if ($result) {
        header("Location: visualizar_pozo.php?id=" . $_GET['id'] . "&success=1");
        exit();
    } else {
        header("Location: visualizar_pozo.php?id=" . $_GET['id'] . "&error=1");
        exit();
    }
}

if (isset($_GET['id'])) {
    $idPozo = $_GET['id'];

    $consultaPozo = "SELECT nombre FROM pozos WHERE id = '$idPozo'";
    $resultadoPozo = mysqli_query($conexion, $consultaPozo);
    $filaPozo = mysqli_fetch_assoc($resultadoPozo);
    $nombrePozo = $filaPozo['nombre'];

    $consultaMediciones = "SELECT idMedicion, psi, fecha FROM mediciones WHERE idPozo = '$idPozo'";
    $resultadoMediciones = mysqli_query($conexion, $consultaMediciones);
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>PDVSA</title>
    <link rel="stylesheet" href="css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
</head>
<body>
<nav class="navbar">
    <div class="container-fluid">
        <a class="navbar-brand" href="index.php">
            <img src="./img/logo.png" alt="Logo" width="180" height="50" class="d-inline-block align-text-top">
        </a>
    </div>
</nav>
<div class="table-container">
    <h1>Mediciones PSI: <?php echo $nombrePozo; ?></h1>

    <?php
    if (isset($_GET['success']) && $_GET['success'] == 1) {
        echo '
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            La medición se ha actualizado correctamente.
            <button type="button" class="btn-close" data-dismiss="alert" aria-label="Close"></button>
        </div>
        ';
    }
    if (isset($_GET['error']) && $_GET['error'] == 1) {
        echo '
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            Ha ocurrido un error al actualizar la medición.
            <button type="button" class="btn-close" data-dismiss="alert" aria-label="Close"></button>
        </div>
        ';
    }
    if (isset($_GET['delete_success']) && $_GET['delete_success'] == 1) {
        echo '
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            La medición se ha eliminado correctamente.
            <button type="button" class="btn-close" data-dismiss="alert" aria-label="Close"></button>
        </div>
        ';
    }
    if (isset($_GET['delete_error']) && $_GET['delete_error'] == 1) {
        echo '
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            Ha ocurrido un error al eliminar la medición.
            <button type="button" class="btn-close" data-dismiss="alert" aria-label="Close"></button>
        </div>
        ';
    }
    ?>

    <table class="table table-hover">
        <thead>
        <tr>
            <th class="text-center">Medición PSI</th>
            <th class="text-center">Fecha</th>
            <th class="text-center">Acciones</th>
        </tr>
        </thead>
        <tbody>
        <?php
        while ($filaMediciones = mysqli_fetch_assoc($resultadoMediciones)) {
            echo "<tr>";
            echo "<td class='text-center'>" . $filaMediciones['psi'] . "</td>";
            echo "<td class='text-center'>" . $filaMediciones['fecha'] . "</td>";
            echo "<td class='text-center'>
                    <button type='button' class='btn btn-primary' data-toggle='modal' data-target='#modalEditarMedicion" . $filaMediciones['idMedicion'] . "'>Editar</button>
                    <button type='button' class='btn btn-danger' data-toggle='modal' data-target='#modalEliminarMedicion" . $filaMediciones['idMedicion'] . "'>Eliminar</button>
                    </td>";
            echo "</tr>";
        }
        ?>
        </tbody>
    </table>
</div>

<?php
// Generar los modales fuera del bucle while
mysqli_data_seek($resultadoMediciones, 0); // Reiniciar el puntero del resultado

while ($filaMediciones = mysqli_fetch_assoc($resultadoMediciones)) {
    // Modal para editar la medición
    echo "<div class='modal fade' id='modalEditarMedicion" . $filaMediciones['idMedicion'] . "'>
            <div class='modal-dialog'>
                <div class='modal-content'>
                    <div class='modal-header'>
                        <h5 class='modal-title'>Editar Medición</h5>
                        <button type='button' class='close' data-dismiss='modal'>&times;</button>
                    </div>
                    <div class='modal-body'>
                        <form action='visualizar_pozo.php?id=" . $idPozo . "' method='POST'>
                            <div class='form-group'>
                                <label for='medicion'>Medición PSI:</label>
                                <input type='number' step='any' class='form-control' id='medicion' name='medicion' value='" . $filaMediciones['psi'] . "' required>
                            </div>
                            <div class='form-group'>
                                <label for='fecha'>Fecha:</label>
                                <input type='date' class='form-control' id='fecha' name='fecha' value='" . $filaMediciones['fecha'] . "' required>
                            </div>
                            <input type='hidden' id='idMedicion' name='idMedicion' value='" . $filaMediciones['idMedicion'] . "'>
                            <button type='submit' class='btn btn-primary'>Guardar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>";

    // Modal para eliminar la medición
    echo "<div class='modal fade' id='modalEliminarMedicion" . $filaMediciones['idMedicion'] . "'>
            <div class='modal-dialog'>
                <div class='modal-content'>
                    <div class='modal-header'>
                        <h5 class='modal-title'>Eliminar Medición</h5>
                        <button type='button' class='close' data-dismiss='modal'>&times;</button>
                    </div>
                    <div class='modal-body'>
                        <p>¿Estás seguro de que deseas eliminar esta medición?</p>
                    </div>
                    <div class='modal-footer'>
                        <button type='button' class='btn btn-secondary' data-dismiss='modal'>Cancelar</button>
                        <a href='eliminar_medicion.php?id=" . $filaMediciones['idMedicion'] . "&idPozo=" . $idPozo . "' class='btn btn-danger'>Eliminar</a>
                   </div>
            </div>
        </div>
    </div>";
}
?>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>
