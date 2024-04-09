<?php include "components/header.php" ?>
<?php include "components/navbar.php" ?>

<div class="peluqueros">
    <div class="centro">
        <form action="" method="post">
            <div class="form-group">
                <label for="calendario" class="form-label">Fecha</label>
                <input name="calendario" id='calendario' />
            </div>
            <div class="form-group">
                <label for="horas" class="form-label">Horas disponibles</label>
                <select id="horas" name="horas" class="form-control" disabled></select>
            </div>
            <div class="form-group">
                <input type="submit" name="crear" value="Añadir">
            </div>
            <?php
            if (isset($_POST['crear'])) {
                $calendar = htmlspecialchars($_POST['calendario']);
                $horas = htmlspecialchars($_POST['horas']);

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
                    //* REVISAMOS QUE LA HORA SELECCIONADA ESTÁ DISPONIBLE
                    if (in_array($horas, $horas_disponibles)) {

                        $a = "SELECT * FROM citas WHERE fecha = $calendar AND hora = '$horas';";
                        $a = mysqli_query($mysqli, $a);
                        if (mysqli_num_rows($a) <= 0) {
                            echo "cualquiera"; //TODO RANDOM PARA QUE SE ELIJA UN PELUQUERO.
                        } else {
                            while ($row = mysqli_fetch_assoc($a)) {
                                $peluquero = $row['peluquero'];
                                echo "$peluquero <br>"; //? ID DE LOS PELUQUEROS QUE TIENEN CITA COGIDA A ESA HORA.  
                            }
                        }
                        /* 
                        $a = "INSERT INTO citas (fecha, hora, peluquero, usuario) VALUES (" . $calendar . ",'{$horas}','{$peluquero}','{$user_id}')";
                        $a = mysqli_query($mysqli, $a);
                        if (!$a) {
                            echo "<p><strong>Error: </strong>Algo ha ido mal añadiendo la incidencia: " . mysqli_error($mysqli) . "</p>";
                        } else {
                            header("Refresh:3; url=index.php");
                            echo "<p> ¡Cita añadida con éxito!. Redirigiendo...</p>";
                            echo "<p> Si no redirige puedes hacer <a href='index.php'>click aquí</a></p>";
                        }*/
                    } else {
                        echo "<p><strong>Error: </strong>¡Tiene que elegir una hora disponible!</p>";
                    }
                }
            }
            ?>
        </form>
    </div>
</div>

<?php include "components/footer.php" ?>