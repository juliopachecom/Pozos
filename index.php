<?php
$imgPath = "img/";
?>

    <!DOCTYPE html>
    <html>
    <head>
        <title>PDVSA</title>
        <link rel="stylesheet" href="css/style.css">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
    </head>
    <body>
    <nav class="navbar">
        <div class="container-fluid">
            <a class="navbar-brand" href="index.php">
                <img src="./img/logo.png" alt="Logo" width="180" height="50" class="d-inline-block align-text-top">
            </a>
        </div>
    </nav>
    <br><br><br>

    <div class="container">
    <center><h1><b>POZOS PETROLEROS</b></h1></center>
    </div>
    <div class="modal fade" id="modalAgregar">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Agregar Pozo</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <form action="agregar.php" method="POST">
                        <div class="form-group">
                            <label for="nombre">Nombre del pozo:</label>
                            <input type="text" class="form-control" id="nombre" name="nombre" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Agregar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalAgregarMedicion">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Agregar Medición</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form action="agregarm.php" method="POST">
                    <div class="form-group">
                        <label for="psi">Medición PSI:</label>
                        <input type="number" step="any" class="form-control" id="medicion" name="medicion" required>
                    </div>
                    <div class="form-group">
                        <label for="fecha">Fecha:</label>
                        <input type="date" class="form-control" id="fecha" name="fecha" value="<?php echo date('Y-m-d'); ?>" required>
                    </div>
                    <input type="hidden" id="idPozo" name="idPozo">
                    <button type="submit" class="btn btn-primary">Agregar</button>
                </form>
            </div>
        </div>
    </div>
</div>



    <div class="">
      <center> <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#modalAgregar">
            Agregar Pozo
        </button></center> 
        <div class="table-container">
        <table class="table table-hover">
            <thead>
                <tr>

                    <th class="">ID del Pozo</th>
                    <th class="">Nombre</th>
                    <th class="">Opciones</th>
                    <th class="">Opciones de Edición</th>
                </tr>
            </thead>
            <tbody>
        <?php
                include 'conexion.php';
                $consulta = "SELECT * FROM pozos";
                $resultados = mysqli_query($conexion, $consulta);
                while ($fila = mysqli_fetch_assoc($resultados)) {
                    echo "<tr>";
                    echo "<td>" . $fila['id'] . "</td>";
                    echo "<td>" . $fila['nombre'] . "</td>";
                    echo "<td>
                    <img src='img/agregar.png' class='icon' data-toggle='modal' data-target='#modalAgregarMedicion' onclick=\"document.getElementById('idPozo').value = " . $fila['id'] . "\" title='Agregar Medicion'>
                    <a href='visualizar_pozo.php?id=" . $fila['id'] . "'><img src='img/view.png' class='icon' title='Visualizar Mediciones'></a>
                    <a href='grafica.php?id=" . $fila['id'] . "'><img src='img/grafic.png' class='icon' title='Gráfica'></a>
                    </td>";
                    
                    echo "<td>
                    <a href='editar.php?id=" . $fila['id'] . "'><img src='img/configuraciones.png' class='icon' title='Modificar'></a>
                    <img src='img/eliminar.png' class='icon' data-toggle='modal' data-target='#modalEliminar" . $fila['id'] . "' title='Eliminar'>
                    </td>";
                    
                    echo "</tr>";
                }
                ?>

    </tbody>
</table>
    </div>
    </div>
    

    <?php
    $resultados = mysqli_query($conexion, $consulta);
    while ($fila = mysqli_fetch_assoc($resultados)) {
        echo "<div class='modal fade' id='modalEliminar" . $fila['id'] . "'>
                <div class='modal-dialog'>
                    <div class='modal-content'>
                        <div class='modal-header'>
                            <h5 class='modal-title'>Eliminar Pozo</h5>
                            <button type='button' class='close' data-dismiss='modal'>&times;</button>
                        </div>
                        <div class='modal-body'>
                            <p>¿Estás seguro de que deseas eliminar el pozo '" . $fila['nombre'] . "'?</p>
                        </div>
                        <div class='modal-footer'>
                            <button type='button' class='btn btn-secondary' data-dismiss='modal'>Cancelar</button>
                            <a href='eliminar.php?id=" . $fila['id'] . "' class='btn btn-danger'>Eliminar</a>
                        </div>
                    </div>
                </div>
            </div>";
    }
    ?>

    <?php
    if (isset($_GET['success']) && $_GET['success'] == 1) {
        echo '
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            El pozo se ha agregado correctamente.
            <button type="button" class="btn-close" data-dismiss="alert" aria-label="Close"></button>
        </div>
        ';
    }
    if (isset($_GET['success_medicion']) && $_GET['success_medicion'] == 1) {
        echo '
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            La medición se ha agregado correctamente.
            <button type="button" class="btn-close" data-dismiss="alert" aria-label="Close"></button>
        </div>
        ';
    }
    ?>




    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    </body>
    </html>