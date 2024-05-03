<?php include "components/header.php"; ?>
<?php include "components/navbar.php"; ?>
<?php
if (isset($_GET['fecha']) && isset($_GET['hora']) && isset($_GET['peluquero'])) { //* COMPROBAR LOS DATOS DE LA URL
    $fecha = htmlspecialchars($_GET['fecha']);
    $hora = htmlspecialchars($_GET['hora']);
    $peluquero = htmlspecialchars($_GET['peluquero']);

    if (in_array($hora, $horas_disponibles) && in_array($peluquero, $peluqueros_totales)) { //* COMPROBAR QUE LA HORA Y LOS PELUQUEROS SON VÁLIDOS.
        $a = "SELECT * FROM citas c, usuarios u WHERE c.peluquero = u.id AND c.fecha = $fecha AND c.hora = '$hora' AND u.id = $peluquero;";
        $a = mysqli_query($mysqli, $a);
        if (mysqli_num_rows($a) <= 0) {     //* COMPROBAR QUE EL PELUQUERO NO TIENE CITA A ESA HORA

            //* AÑADIR CITA
            $a = "INSERT INTO citas (fecha, hora, peluquero, usuario) VALUES ('{$fecha}','{$hora}','{$peluquero}','{$user_id}')";
            $a = mysqli_query($mysqli, $a);
            if (!$a) {
                echo "<p><strong>Error: </strong>Algo ha ido mal añadiendo la incidencia: " . mysqli_error($mysqli) . "</p>";
            } else {
                header("Refresh:3; url=index.php");
                echo "<p> ¡Cita añadida con éxito!. Redirigiendo...</p>";
                echo "<p> Si no redirige puedes hacer <a href='index.php'>click aquí</a></p>";
            }
        }else {
            echo "<p><strong>Error: </strong>¡Ese peluquero ya tiene una cita a esa hora!</p>";
        }
    } else {
        echo "<p><strong>Error: </strong>¡Cita con peluquero seleccionado incorrecta!</p>";
    }
} else {
    $pagina = $_SERVER['HTTP_REFERER'];
    header("Location: $pagina");
}
?>
<?php include "components/footer.php"; ?>