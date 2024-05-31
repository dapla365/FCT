<?php include "components/header.php"; ?>
<?php include "components/navbar.php"; ?>
<div class="centro">
    <div class="container">
    <?php
    if (isset($_GET['fecha']) && isset($_GET['hora']) && isset($_GET['peluquero'])) { //* COMPROBAR LOS DATOS DE LA URL
        $fecha = htmlspecialchars($_GET['fecha']);
        $hora = htmlspecialchars($_GET['hora']);
        $peluquero = htmlspecialchars($_GET['peluquero']);

        if($fecha < date('d/m/Y')){
            echo "<p><strong>Error: </strong>¡Esa fecha no es actual!</p>";
            return;
        }
        if($fecha == date("d/m/Y")){
            $hora_hoy = date("H:i", time());
            $hh = explode(":", $hora)[0]; 
            $mm = explode(":", $hora)[1]; 
            $hh_hoy = explode(":", $hora_hoy)[0]; 
            $mm_hoy = explode(":", $hora_hoy)[1]; 
    
            if($hh < $hh_hoy || ($hh == $hh_hoy && $mm < $mm_hoy)){
                echo "<p><strong>Error: </strong>¡Esa hora no es actual!</p>";
                return;
            }
        } 

        $a = "SELECT * FROM citas WHERE fecha = '$fecha' AND hora = '$hora' AND peluquero = $peluquero AND usuario IS NULL;";
        $a = mysqli_query($mysqli, $a);
        if (mysqli_num_rows($a) > 0) {    
            $row = mysqli_fetch_array($a); 
            $id_cita = $row["id"];

            //* AÑADIR USUARIO A LA CITA
            $a = "UPDATE citas SET usuario='$user_id' WHERE id='$id_cita';";
            $a = mysqli_query($mysqli, $a);

            header("Location: components/mail.php?reserva=$id_cita&correo=$user_correo&fecha=$fecha&hora=$hora&peluquero=$peluquero");
        }else {
            echo "<p><strong>Error: </strong>¡Ese peluquero ya tiene una cita asignada a esa hora!</p>";
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