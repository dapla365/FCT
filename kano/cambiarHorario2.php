<?php include "components/header.php" ?>
<?php include "components/navbar.php" ?>
<?php
session_start();
if ($user_nivel <= 0) {
    header("Location: index.php");
}

if (isset($_GET['peluquero'])) {
    if ($user_nivel <= 5) {
        $peluquero = $user_id;
    } else {
        $peluquero = htmlspecialchars($_GET['peluquero']);
    }
} else {
    $peluquero = $user_id;
}

if (isset($_GET['fecha'])) {
    $fecha = htmlspecialchars($_GET['fecha']);
    $ano = explode("/", $fecha)[2];
    $mes = explode("/", $fecha)[1];
    $dia = explode("/", $fecha)[0];
    $fecha = $ano . "-" . $mes . "-" . $dia;
} else {
    $fecha = date('Y-m-d');
}

?>

<div class="form_centro">
    <div class="form_container">
        <h2>Añadir cita</h2>
        <form action="" method="post">
            <label for="fecha">Fecha:</label>
            <input type="date" name="fecha" id="fecha" min="<?php echo date('Y-m-d'); ?>" max="<?php echo date('Y-m-d', strtotime('+1 month')); ?> " value="<?php echo $fecha ?>" required>
            <label for="fecha">Hora:</label>
            <input type="text" id="hora" name="hora" placeholder="00:00">
            <input type="submit" value="Subir cita">
        </form>
        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $fecha = htmlspecialchars($_POST["fecha"]);
            $hora = htmlspecialchars($_POST["hora"]);

            //* FORMATO FECHA
            $ano = explode("-", $fecha)[0];
            $mes = explode("-", $fecha)[1];
            $dia = explode("-", $fecha)[2];

            $dia = str_pad($dia, 2, "0", STR_PAD_LEFT);
            $mes = str_pad($mes, 2, "0", STR_PAD_LEFT);
            $ano = str_pad($ano, 2, "0", STR_PAD_LEFT);

            $fecha = $dia . "/" . $mes . "/" . $ano;

            //* FORMATO HORA
            $patron = '/^(2[0-3]|[01]?\d):[0-5]\d$/';
            if (preg_match($patron, $hora)) {

                $a = "SELECT * FROM citas WHERE peluquero=$peluquero AND fecha='$fecha' AND hora = '$hora';";
                $a = mysqli_query($mysqli, $a);

                if (mysqli_num_rows($a) > 0) {
                    echo "<p>¡Ya hay una cita ese dia a esa hora!</p>";
                } else {
                    $a = "INSERT INTO citas (fecha, hora, peluquero) VALUES ('$fecha', '$hora', '$peluquero')";
                    if ($mysqli->query($a) === TRUE) {
                        echo "<p>Cita añadida correctamente </p>";
                        header("Refresh:3, url=cambiarHorario2.php?peluquero=" . $peluquero . "&fecha=" . $fecha);
                    }
                }
            } else {
                echo "<p>¡La hora no es válida!</p>";
            }
        }

        ?>
    </div>
</div>


<div class="centro">
    <div class="container">
        <?php
        if (isset($_GET['fecha'])) {
            $fecha = htmlspecialchars($_GET['fecha']);
        } else {
            $fecha = date('dd/mm/YYYY');
        }

        $a = "SELECT * FROM citas WHERE peluquero=$peluquero AND fecha='$fecha';";
        $a = mysqli_query($mysqli, $a);

        if (mysqli_num_rows($a) <= 0) {
            echo "<a href='cambiarHorario.php' class='sin_citas'><i class='bi bi-calendar-fill'></i> No tienes citas todavía</a>";
        } else {
            while ($row = mysqli_fetch_assoc($a)) {
                $id = $row['id'];
                $fecha = $row['fecha'];
                $hora = $row['hora'];

                /* INFO PELUQUERO */
                $b = "SELECT * FROM usuarios WHERE id=$peluquero;";
                $b = mysqli_query($mysqli, $b);
                $rowb = mysqli_fetch_assoc($b);
                $peluquero_nombre = ucwords(strtolower($rowb['nombre']));
                $peluquero_apellido = ucwords(strtolower($rowb['apellidos']));

                echo "
                <div class='cita' id='$id'>
                    <div class='cita_datos'>
                        <p class='cita__peluquero'><i class='bi bi-scissors'></i> $peluquero_nombre $peluquero_apellido</p>
                    </div>
                    <div class='cita__datos'>
                        <p class='cita_fecha'><i class='bi bi-calendar-event-fill'></i> $fecha</p>
                    </div>
                    <div class='cita__datos'>
                        <p class='cita_hora'><i class='bi bi-clock-fill'></i> $hora</p>
                    </div>
                    <div class='cita_opciones'>
                        <div onclick='confirmacion($id)'><i class='bi bi-trash3-fill'></i></div>
                    </div>
                </div>";
            }
        }
        ?>
    </div>
</div>

<script>
    function confirmacion(id) {
        if (confirm("¿Estás seguro que quieres eliminar esta reserva?")) {
            location.href = "eliminar_reserva.php?delete=" + id;
        }
    }
</script>

<?php include "components/footer.php" ?>