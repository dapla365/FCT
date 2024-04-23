<?php include "components/header.php" ?>
<?php include "components/navbar.php" ?>
<?php

if (isset($_GET['peluquero'])) {
    $peluquero = mb_strtolower(htmlspecialchars($_GET['peluquero']));

    $a = "SELECT * FROM usuarios WHERE id=$peluquero;";
    $a = mysqli_query($mysqli, $a);
    $row = mysqli_fetch_assoc($a);
    $rol = $row['rol'];
    if ($rol < 1 || $rol > 2) header('Location: peluqueros.php');
} else {
    header('Location: peluqueros.php');
}
?>
<!--
<section>
    <div id="anterior">
        << /div>
            <div class="semana">
                <div class="dia"><span>Lunes</span>
                    <p></p>
                </div>
                <div class="dia"><span>Martes</span>
                    <p></p>
                </div>
                <div class="dia"><span>Miércoles</span>
                    <p></p>
                </div>
                <div class="dia"><span>Jueves</span>
                    <p></p>
                </div>
                <div class="dia"><span>Viernes</span>
                    <p></p>
                </div>
            </div>
            <div id="siguiente">></div>
</section>
-->


<div class="peluqueros">
    <div class="centro">
        <form action="" method="post">
            <div class="form-group">
                <label for="calendar" class="form-label">Fecha</label>
                <input name="calendar" id='calendar' />
            </div>
            <div class="form-group">
                <label for="hours" class="form-label">Horas disponibles</label>
                <select id="hours" name="hours" class="form-control" disabled>
                    <option value="Elije una fecha">Elije una fecha</option>
                </select>
            </div>
            <div class="form-group">
                <input type="submit" name="crear" value="Añadir">
            </div>
            <?php
            if (isset($_POST['crear'])) {
                $calendar = htmlspecialchars($_POST['calendar']);
                $horas = htmlspecialchars($_POST['hours']);

                //* REVISA LAS FECHAS POR SI SON NULL 
                //* FECHA SOLUCION 
                if ($calendar == "") {
                    $calendar = 'NULL';
                } else {
                    $calendar = "'" . $calendar . "'";
                }

                if ($horas == "" || $calendar == "" || $calendar == 'NULL') {
                    echo "<p><strong>Error: </strong>¡Tiene que completar los campos obligatorios!</p>";
                } else {
                    //TODO FALTA COMPROBAR HORAS DISPONIBLES 
                    $a = "INSERT INTO citas (fecha, hora, peluquero, usuario) VALUES (" . $calendar . ",'{$horas}','{$peluquero}','{$user_id}')";
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