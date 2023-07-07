<?php
// editar_pozo.php

include_once('conexion.php');
session_start();

if (isset($_GET['id'])) {
    $idPozo = $_GET['id'];

    // Consultar el pozo por su ID
    $consulta = "SELECT * FROM pozos WHERE id = '$idPozo'";
    $resultado = mysqli_query($conexion, $consulta);

    if ($fila = mysqli_fetch_assoc($resultado)) {
        // El pozo se encontró correctamente
        $nombrePozo = $fila['nombre'];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Obtener los datos enviados por el formulario de edición
            $nuevoNombre = $_POST['nombre'];

            // Validar los datos (aquí puedes agregar tus propias validaciones)

            // Preparar la consulta para actualizar el pozo
            $consultaActualizar = "UPDATE pozos SET nombre = '$nuevoNombre' WHERE id = '$idPozo'";

            // Ejecutar la consulta de actualización
            $resultadoActualizar = mysqli_query($conexion, $consultaActualizar);

            if ($resultadoActualizar) {
                // El pozo se actualizó correctamente
                // Redirigir al index.php o mostrar un mensaje de éxito
                header('Location: index.php?success=1');
                exit();
            } else {
                // Ocurrió un error al actualizar el pozo
                // Mostrar un mensaje de error o redirigir al index.php con un mensaje de error
                header('Location: index.php?error=1');
                exit();
            }
        }

        // Mostrar el formulario de edición
        ?>
        <!DOCTYPE html>
        <html>
        <head>
            <title>Editar Pozo</title>
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
        
        <div class="position-absolute w-50 top-50 start-50 translate-middle">
            <h1>Editar Pozo</h1>
            <form action="editar.php?id=<?php echo $idPozo; ?>" method="POST">
                <div class="form-group">
                    <label for="nombre">Nombre del pozo:</label>
                    <input type="text" class="form-control" id="nombre" name="nombre" value="<?php echo $nombrePozo; ?>" required>
                </div>
                <button type="submit" class="btn btn-primary">Guardar cambios</button>
                <a href="index.php" class="boton-rojo">REGRESAR</a>
            </form>
        </div>
        
        </body>
        </html>
        <?php
    } else {
       
        header('Location: index.php?error=1');
        exit();
    }
} else {
   
    header('Location: index.php?error=1');
    exit();
}
?>
