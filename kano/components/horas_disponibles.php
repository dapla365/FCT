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

// Generar las opciones para el segundo select
$options = '';

foreach ($horas_disponibles as $x) {

    //* OBTENEMOS LOS PELUQUEROS QUE TIENEN ESA HORA OCUPADA DE ESE DIA.
    $a = "SELECT count(id)'contador' FROM citas WHERE fecha = '$opcion' AND hora = '$x';";
    $a = mysqli_query($mysqli, $a);
    $rowa = mysqli_fetch_assoc($a);
    $peluqueros_ocupados = $rowa['contador'];

    //* OBTENEMOS LA CANTIDAD DE PELUQUEROS QUE HAY.
    $c = "SELECT count(id)'totales' FROM usuarios WHERE rol >= 1 AND rol < 3;";
    $c = mysqli_query($mysqli, $c);
    $rowc = mysqli_fetch_assoc($c);
    $peluqueros_totales = $rowc['totales'];

    if($peluqueros_ocupados < $peluqueros_totales){
        //* HAY ALGUNA HORA LIBRE
        $options .= "<option value='$x'>$x</option>";
    }
}



echo $options;

mysqli_close($mysqli);
?>
