<?php include "components/header.php"; ?>
<?php include "components/navbar.php"; ?>

<div class="centro">
    <div class="container">
        <?php

        //*TODO COMPROBAR QUE LA FECHA ES VALIDA
        if (isset($_GET['fecha'])) {
            $fecha = htmlspecialchars($_GET['fecha']);
            $peluqueros_ocupados = array();

            foreach ($horas_disponibles as $x) {

                //* OBTENEMOS LOS PELUQUEROS QUE TIENEN ESA HORA OCUPADA DE ESE DIA.
                $a = "SELECT * FROM citas WHERE fecha = '$fecha' AND hora = '$x';";
                $a = mysqli_query($mysqli, $a);
                $rowa = mysqli_fetch_assoc($a);
                $peluquero_id = $rowa['peluquero'];

                array_push($peluqueros_ocupados, array($x, $peluquero_id));
            }
            foreach ($peluqueros_ocupados as $horas) {
                //* COMPROBAMOS QUE EL PELUQUERO TIENE LIBRE ESA HORA.
                $r = array_diff_assoc($peluqueros_totales, $horas);

                foreach ($r as $peluquero_libre) {
                    $c = "SELECT * FROM usuarios WHERE id = $peluquero_libre;";
                    $c = mysqli_query($mysqli, $c);
                    $rowc = mysqli_fetch_assoc($c);
                    $peluquero_nombre = ucwords(mb_strtolower($rowc['nombre']));
                    $peluquero_apellido = ucwords(mb_strtolower($rowc['apellidos']));

                    echo "        
                    <div class='cita' id='$fecha-$x'>
                        <p class='cita_peluquero'><i class='bi bi-scissors'></i> $peluquero_nombre $peluquero_apellido</p>
                        <p class='cita_fecha'><i class='bi bi-calendar-event-fill'></i> $fecha</p>
                        <p class='cita_hora'><i class='bi bi-clock-fill'></i> $x</p>
                    </div>
                    ";
                }
            }
        } else {
            header("Location: disponibles.php");
        }
        ?>
    </div>
</div>

<?php include "components/footer.php"; ?>