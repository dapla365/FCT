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










<div class="centro">
    <div class="container">
        <?php
        $a = "SELECT * FROM citas WHERE peluquero=$user_id OR usuario=$user_id;";
        $a = mysqli_query($mysqli, $a);

        if (mysqli_num_rows($a) <= 0) {
            echo "<a href='disponibles.php' class='sin_citas'><i class='bi bi-calendar-fill'></i> No hay citas para reservar</a>";
        } else {
            while ($row = mysqli_fetch_assoc($a)) {
                $id = $row['id'];
                $fecha = $row['fecha'];
                $hora = $row['hora'];
                $realizada = $row['realizada'];
                $peluquero = $row['peluquero'];
                $usuario = $row['usuario'];

                /* INFO PELUQUERO */
                $b = "SELECT * FROM usuarios WHERE id=$peluquero;";
                $b = mysqli_query($mysqli, $b);
                $rowb = mysqli_fetch_assoc($b);
                $peluquero_nombre = ucwords(mb_strtolower($rowb['nombre']));
                $peluquero_apellido = ucwords(mb_strtolower($rowb['apellidos']));

                /* INFO USUARIO */
                $c = "SELECT * FROM usuarios WHERE id=$usuario;";
                $c = mysqli_query($mysqli, $c);
                $rowc = mysqli_fetch_assoc($c);
                $usuario_nombre = ucwords(mb_strtolower($rowc['nombre']));
                $usuario_apellido = ucwords(mb_strtolower($rowc['apellidos']));

                echo "        
            <div class='cita' id='$id'>
                <div class='cita_datos'>
                    <p class='cita_peluquero'><i class='bi bi-scissors'></i> $peluquero_nombre $peluquero_apellido</p>
                    <p class='cita_usuario'><i class='bi bi-person-standing'></i> $usuario_nombre $usuario_apellido</p>
                </div>
                <div class='cita_datos'>
                    <p class='cita_fecha'><i class='bi bi-calendar-event-fill'></i> $fecha</p>
                    <p class='cita_hora'><i class='bi bi-clock-fill'></i> $hora</p>
                </div>
                <div class='cita_opciones'>
                    <a href='eliminar_reserva.php?reserva={$id}'><i class='bi bi-trash3-fill'></i></a>
                </div>
            </div>
            ";
            }
        }
        ?>
    </div>
</div>

<?php include "components/footer.php"; ?>