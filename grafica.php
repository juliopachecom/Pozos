<?php
include 'conexion.php';

if (isset($_GET['id'])) {
    $idPozo = $_GET['id'];

    // Obtener el nombre del pozo
    $consultaPozo = "SELECT nombre FROM pozos WHERE id = '$idPozo'";
    $resultadoPozo = mysqli_query($conexion, $consultaPozo);
    $filaPozo = mysqli_fetch_assoc($resultadoPozo);
    $nombrePozo = $filaPozo['nombre'];

    // Obtener todas las mediciones del pozo
    $consultaTodasMediciones = "SELECT psi, fecha FROM mediciones WHERE idPozo = '$idPozo'";
    $resultadoTodasMediciones = mysqli_query($conexion, $consultaTodasMediciones);

    // Preparar los datos para la gráfica
    $labels = array(); // Fechas
    $data = array(); // Mediciones PSI

    while ($filaMediciones = mysqli_fetch_assoc($resultadoTodasMediciones)) {
        $labels[] = $filaMediciones['fecha'];
        $data[] = $filaMediciones['psi'];
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Gráfica de Mediciones del Pozo</title>
    <link rel="stylesheet" href="css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
<center><h1><b>POZOS PETROLEROS</b></h1></center>
    <form>
        <label for="fechaInicio">Fecha de inicio:</label>
        <input type="date" id="fechaInicio" name="fechaInicio">
        <label for="fechaFin">Fecha de fin:</label>
        <input type="date" id="fechaFin" name="fechaFin" required >
        <button type="button" onclick="filtrarMediciones()">Filtrar</button>
    </form>


<div style="width: 800px; height: 400px;">
    <canvas id="chart"></canvas>
</div>
</div>
<script>
    var labels = <?php echo json_encode($labels); ?>;
    var data = <?php echo json_encode($data); ?>;

    // Función para filtrar las mediciones según las fechas seleccionadas
    function filtrarMediciones() {
        var fechaInicio = document.getElementById('fechaInicio').value;
        var fechaFin = document.getElementById('fechaFin').value;

        // Obtener índices de las fechas que se encuentran dentro del rango seleccionado
        var indicesFiltrados = [];
        for (var i = 0; i < labels.length; i++) {
            if (labels[i] >= fechaInicio && labels[i] <= fechaFin) {
                indicesFiltrados.push(i);
            }
        }

        // Filtrar los datos de las mediciones según los índices
        var labelsFiltrados = indicesFiltrados.map(function(index) {
            return labels[index];
        });
        var dataFiltrados = indicesFiltrados.map(function(index) {
            return data[index];
        });

        // Actualizar la gráfica con los datos filtrados
        chart.data.labels = labelsFiltrados;
        chart.data.datasets[0].data = dataFiltrados;
        chart.update();
    }

    var ctx = document.getElementById('chart').getContext('2d');
    var chart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: labels,
            datasets: [{
                label: 'Mediciones PSI',
                data: data,
                borderColor: 'blue',
                fill: false
            }]
        },
        options: {
            scales: {
                x: {
                    display: true,
                    title: {
                        display: true,
                        text: 'Fecha'
                    }
                },
                y: {
                    display: true,
                    title: {
                        display: true,
                        text: 'Medición PSI'
                    }
                }
            }
        }
    });
    
</script>

</body>
</html>
