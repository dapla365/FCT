<?php include "components/header.php"; ?>
<?php include "components/navbar.php"; ?>

<div class="centro">
    <div class="container">
        <?php
        if (isset($_GET['fecha'])) {
            $fecha = htmlspecialchars($_GET['fecha']);
            $fecha_hoy = date('d/m/Y');
            echo '<h2>' . formatDate($fecha) . '</h2>';

            if ($fecha >= $fecha_hoy) {
                $a = "SELECT * FROM citas WHERE fecha='$fecha' AND usuario IS NULL;";
                $a = mysqli_query($mysqli, $a);
                if (mysqli_num_rows($a) > 0) {
                    while ($row = mysqli_fetch_assoc($a)) {
                        $id = $row['id'];
                        $fecha = $row['fecha'];
                        $hora = $row['hora'];
                        $peluquero = $row['peluquero'];

                        /* INFO PELUQUERO */
                        $b = "SELECT * FROM usuarios WHERE id=$peluquero;";
                        $b = mysqli_query($mysqli, $b);
                        $rowb = mysqli_fetch_assoc($b);
                        $peluquero_nombre = ucwords(mb_strtolower($rowb['nombre']));
                        $peluquero_apellido = ucwords(mb_strtolower($rowb['apellidos']));

                        if ($fecha == $fecha_hoy) {
                            $hora_hoy = date("H:i", time());
                            $hh_hoy = explode(":", $hora_hoy)[0];
                            $mm_hoy = explode(":", $hora_hoy)[1];
                            $hh = explode(":", $hora)[0];
                            $mm = explode(":", $hora)[1];
                            if ($hh > $hh_hoy || ($hh == $hh_hoy && $mm > $mm_hoy)) {
                                echo "        
                            <a href='confirmarCita.php?fecha=$fecha&hora=$hora&peluquero=$peluquero' class='cita' id='$fecha-$hora'>
                                <p class='cita_peluquero'><i class='bi bi-scissors'></i> $peluquero_nombre&nbsp;<span class='apellidos'>$peluquero_apellido<span></p>
                                <p class='cita_fecha'><i class='bi bi-calendar-event-fill'></i> $fecha</p>
                                <p class='cita_hora'><i class='bi bi-clock-fill'></i> $hora</p>
                            </a>";
                            }
                        } else {
                            echo "        
                            <a href='confirmarCita.php?fecha=$fecha&hora=$hora&peluquero=$peluquero' class='cita' id='$fecha-$hora'>
                                <p class='cita_peluquero'><i class='bi bi-scissors'></i> $peluquero_nombre&nbsp;<span class='apellidos'>$peluquero_apellido<span></p>
                                <p class='cita_fecha'><i class='bi bi-calendar-event-fill'></i> $fecha</p>
                                <p class='cita_hora'><i class='bi bi-clock-fill'></i> $hora</p>
                            </a>";
                        }
                    }
                } else {
                    //* NO HAY CITAS ESE DIA */
                    echo "<a href='disponibles.php' class='sin_citas'><i class='bi bi-calendar-fill'></i> No hay citas en esta fecha</a>";
                }
            } else {
                //* CITAS PASADAS AL DIA EN QUE ESTAMOS */
                echo "<a href='disponibles.php' class='sin_citas'><i class='bi bi-calendar-fill'></i> Has seleccionado una fecha pasada</a>";
            }
        } else {
            header("Location: disponibles.php");
        }


        function formatDate($date)
        {
            $dateParts = explode('/', $date);
            if (count($dateParts) !== 3) {
                return 'Formato de fecha no válido';
            }

            list($day, $month, $year) = $dateParts;
            $months = [
                1 => 'enero', 2 => 'febrero', 3 => 'marzo', 4 => 'abril',
                5 => 'mayo', 6 => 'junio', 7 => 'julio', 8 => 'agosto',
                9 => 'septiembre', 10 => 'octubre', 11 => 'noviembre', 12 => 'diciembre'
            ];

            if (!checkdate($month, $day, $year)) {
                return 'Fecha no válida';
            }

            return intval($day) . ' de ' . $months[intval($month)] . ' del ' . $year;
        }
        ?>
    </div>
</div>

<?php include "components/footer.php"; ?>