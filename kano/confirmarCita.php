<?php include "components/header.php"; ?>
<?php include "components/navbar.php"; ?>
<div class="centro">
    <div class="container">
    <?php
    if (isset($_GET['fecha']) && isset($_GET['hora']) && isset($_GET['peluquero'])) { //* COMPROBAR LOS DATOS DE LA URL
        $fecha = htmlspecialchars($_GET['fecha']);
        $hora = htmlspecialchars($_GET['hora']);
        $peluquero = htmlspecialchars($_GET['peluquero']);

        if (in_array($hora, $horas_disponibles) && in_array($peluquero, $peluqueros_totales)) { //* COMPROBAR QUE LA HORA Y LOS PELUQUEROS SON VÁLIDOS.
            $a = "SELECT * FROM citas WHERE fecha = $fecha AND hora = '$hora' AND peluquero = $peluquero;";
            $a = mysqli_query($mysqli, $a);
            if (mysqli_num_rows($a) <= 0) {     //* COMPROBAR QUE EL PELUQUERO NO TIENE CITA A ESA HORA

                //* AÑADIR CITA
                $a = "INSERT INTO citas (fecha, hora, peluquero, usuario) VALUES ('{$fecha}','{$hora}','{$peluquero}','{$user_id}')";
                $a = mysqli_query($mysqli, $a);
                if (!$a) {
                    echo "<p><strong>Error: </strong>Algo ha ido mal añadiendo la incidencia: " . mysqli_error($mysqli) . "</p>";
                } else {
                    //* ENVIAR CORREO
                    
                    $b = "SELECT * FROM citas WHERE usuario=$user_id AND hora='$hora' AND fecha='$fecha' AND peluquero=$peluquero;";
                    $b = mysqli_query($mysqli, $b);
                    $row = mysqli_fetch_assoc($b);
                    $reserva = $row['id'];
                    header("Location: components/mail.php?reserva=$reserva&correo=$user_correo&fecha=$fecha&hora=$hora&peluquero=$peluquero");
                }
            }else {
                echo "<p><strong>Error: </strong>¡Ese peluquero ya tiene una cita a esa hora!</p>";
            }
        } else {
            echo "<p><strong>Error: </strong>¡Cita con peluquero seleccionado incorrecta!</p>";
        }
    }else if (isset($_GET['confirmado'])) { //* EMAIL ENVIADO CORRECTAMENTE Y CITA AÑADIDA CON ÉXITO.
        header("Refresh:3; url=index.php");
        echo "<h2 class='sin_citas'> ¡Cita añadida con éxito!. Redirigiendo...</h2>";
        echo "<p class='sin_citas'> Si no redirige puedes hacer&nbsp;<a href='index.php'>click aquí</a></p>";
    }
    
    else {
        $pagina = $_SERVER['HTTP_REFERER'];
        header("Location: $pagina");
    }
    ?>
    </div>
</div>
<?php include "components/footer.php"; ?>