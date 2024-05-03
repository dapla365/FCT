<?php
include "info.php";

$fecha = htmlspecialchars($_POST['fecha']);
$valida = '';
foreach ($horas_disponibles as $x) {

    //* OBTENEMOS LOS PELUQUEROS QUE TIENEN ESA HORA OCUPADA DE ESE DIA.
    $a = "SELECT count(id)'contador' FROM citas WHERE fecha = '$fecha' AND hora = '$x';";
    $a = mysqli_query($mysqli, $a);
    $rowa = mysqli_fetch_assoc($a);
    $peluqueros_ocupados = $rowa['contador'];

    if ($peluqueros_ocupados < sizeof($peluqueros_totales)) {
        //* HAY ALGUNA HORA LIBRE
        $valida = '';
        break;
    } else {
        $valida = 'inactive';
    }
}

echo $valida;

mysqli_close($mysqli);
