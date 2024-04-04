<?php include "components/header.php" ?>
<?php include "components/navbar.php" ?>
<?php

if (isset($_GET['peluquero'])) {
    $peluquero = mb_strtolower(htmlspecialchars($_GET['peluquero']));

    $a = "SELECT * FROM usuarios WHERE id=$peluquero;";
    $a = mysqli_query($mysqli, $a);
    $row = mysqli_fetch_assoc($a);
    $rol = $row['rol'];
    if ($rol < 1 && $rol > 2) header('Location: peluqueros.php');
} else {
    header('Location: peluqueros.php');
}
?>

<div class="peluqueros">
    <div class="centro">
        <form action="" method="post">
            <div class="form-group">
                <label for="calendar" class="form-label">Fecha</label>
                <input name="calendar" id='calendar' />
            </div>
            <div class="form-group">
                <label for="horas" class="form-label">Horas disponibles</label>
                <select id="horas" name="horas" class="form-control">
                    <?php
                    foreach ($horas_disponibles as $x) {
                        echo "<option value='$x'>$x</option>";
                    }

                    /* $a = "SELECT * FROM citas WHERE peluquero='$peluquero'";
                    $a = mysqli_query($mysqli, $a);
                    while ($row = mysqli_fetch_assoc($a)) {
                        $id = $row['id'];
                        break;
                    }*/

                    ?>
                </select>
            </div>
            <div class="form-group">
                <input type="submit" name="crear" value="Añadir">
            </div>


            <?php
            if (isset($_POST['crear'])) {
                $calendar = htmlspecialchars($_POST['calendar']);
                $horas = htmlspecialchars($_POST['horas']);

                /* REVISA LAS FECHAS POR SI SON NULL */
                /* FECHA SOLUCION */
                if ($calendar == "") {
                    $calendar = 'NULL';
                } else {
                    $calendar = "'" . $calendar . "'";
                }

                if ($horas == "" || $calendar == "" || $calendar == 'NULL') {
                    echo "<p><strong>Error: </strong>¡Tiene que completar los campos obligatorios!</p>";
                } else {
                    /* FALTA COMPROBAR HORAS DISPONIBLES */
                    $a = "INSERT INTO citas (fecha, hora, peluquero, usuario) VALUES (".$fecha_alta.",'{$horas}','{$peluquero}','{$user_id}')";
                    $a = mysqli_query($mysqli, $a);
                    if (!$a) {
                        echo "<p><strong>Error: </strong>Algo ha ido mal añadiendo la incidencia: " . mysqli_error($mysqli) . "</p>";
                    } else {
                        header("Refresh:3; url=index.php");
                        echo "<p> ¡Cita añadida con éxito!. Redirigiendo...</p>";
                        echo "<p> Si no redirige puedes hacer <a href='index.php'>click aquí</a></p>";
                    }
                }
            }
            ?>


        </form>
    </div>
</div>

<?php include "components/footer.php" ?>