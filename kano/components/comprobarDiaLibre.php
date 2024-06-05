<?php
include "user-data2.php";

$type = htmlspecialchars($_POST['type']);
$fecha = htmlspecialchars($_POST['fecha']);
$paste = htmlspecialchars($_POST['paste']);
$peluquero = htmlspecialchars($_POST['peluquero']);

$valida = "a";

//! PARA HORARIO DE PELUQUEROS
if ($type == "horario") {
    session_start();
    if ($user_nivel <= 0) {
        header("Location: index.php");
    }
    $a = "SELECT * FROM citas WHERE fecha = '$fecha' AND peluquero='$peluquero';";
    $a = mysqli_query($mysqli, $a);
    if (mysqli_num_rows($a) > 0) {
        //* HAY CITAS DISPONIBLES EN ESA FECHA */
        $valida = 'available';
    }
} else if ($type == "pegar") {
    //* COMPROBAR QUE ERES PELUQUERO O SUPERIOR
    session_start();
    if ($user_nivel <= 0) {
        header("Location: index.php");
    }
    $a = "SELECT * FROM citas WHERE fecha = '$fecha' AND peluquero='$peluquero';";
    $a = mysqli_query($mysqli, $a);
    if (mysqli_num_rows($a) > 0) {
        //* HAY CITAS DISPONIBLES PARA PEGAR DE ESA FECHA */
        while ($row = mysqli_fetch_array($a)) {
            if ($paste != '' && $paste != null) {
                $hora = $row['hora'];
                $b = "INSERT INTO citas (fecha, hora, peluquero) VALUES ('$paste', '$hora', '$peluquero')";
                mysqli_query($mysqli, $b);
            }
        }
    }
} else if ($type == "delete") {
    session_start();
    if ($user_nivel <= 0) {
        header("Location: index.php");
    }
    $a = "SELECT * FROM citas WHERE fecha = '$fecha' AND peluquero='$peluquero';";
    $a = mysqli_query($mysqli, $a);
    if (mysqli_num_rows($a) > 0) {
        //* HAY CITAS PARA ELIMINAR EN ESA FECHA */
        while ($row = mysqli_fetch_array($a)) {
            $id = $row['id'];
            $c = "DELETE FROM citas WHERE id = '{$id}';";
            $c = mysqli_query($mysqli, $c);
        }
    }
} else {
    if ($peluquero != null && $peluquero != "") {
        //! PARA PELUQUEROS DISPONIBLES
        $a = "SELECT * FROM citas WHERE fecha = '$fecha' AND peluquero='$peluquero' AND usuario IS NULL;";
        $a = mysqli_query($mysqli, $a);
        if (mysqli_num_rows($a) > 0) {
            //* HAY CITAS DISPONIBLES EN ESA FECHA */
            $valida = 'available';
        } else {
            //* NO HAY CITAS DISPONIBLES EN ESA FECHA */
            $b = "SELECT * FROM citas WHERE fecha = '$fecha' AND peluquero='$peluquero';";
            $b = mysqli_query($mysqli, $b);
            if (mysqli_num_rows($b) > 0) {
                $valida = 'filled';
            }
        }
    } else {
        //! PARA CALENDARIO DISPONIBLES
        $a = "SELECT * FROM citas WHERE fecha = '$fecha' AND usuario IS NULL;";
        $a = mysqli_query($mysqli, $a);
        if (mysqli_num_rows($a) > 0) {
            //* HAY CITAS DISPONIBLES EN ESA FECHA */
            $valida = 'available';
        } else {
            //* NO HAY CITAS DISPONIBLES EN ESA FECHA */
            $b = "SELECT * FROM citas WHERE fecha = '$fecha';";
            $b = mysqli_query($mysqli, $b);
            if (mysqli_num_rows($b) > 0) {
                $valida = 'filled';
            }
        }
    }
}
echo $valida;

mysqli_close($mysqli);
