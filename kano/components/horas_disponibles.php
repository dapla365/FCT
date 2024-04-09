<?php require_once "conexion.php"; ?>
<?php include "info.php"; ?>
<?php
/* 
    id INT PRIMARY KEY AUTO_INCREMENT,
    fecha VARCHAR(255) NOT NULL,
    hora VARCHAR(255) NOT NULL,
    peluquero INT NOT NULL,
    usuario INT NOT NULL,
    realizada BOOLEAN DEFAULT FALSE
*/

// Obtener el valor del primer select
$opcion = htmlspecialchars($_POST['opcion']);
$peluquero = htmlspecialchars($_POST['peluquero']);

// Consulta para obtener las opciones dependientes de la tabla 'citas'
$a = "SELECT * FROM citas WHERE fecha = '$opcion' AND peluquero = '$peluquero';";
$a = mysqli_query($mysqli, $a);

// Generar las opciones para el segundo select
$options = '';

if (mysqli_num_rows($a) <= 0) {
    foreach ($horas_disponibles as $x) {
        $options .= "<option value='$x'>$x</option>";
    }
} else {
    // HORAS OCUPADAS
    $horas_ocupadas = array();

    while ($row = mysqli_fetch_assoc($a)) {
        $hora = $row['hora'];
        array_push($horas_ocupadas, $hora);
    }

    $result = array_diff($horas_disponibles, $horas_ocupadas);

    // QUITAR HORAS NO DISPONIBLES
    foreach ($result as $x) {
        $options .= "<option value='$x'>$x</option>";
    }
}


echo $options;

mysqli_close($mysqli);
?>
