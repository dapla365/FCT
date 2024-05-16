<?php include "components/header.php"; ?>
<?php include "components/navbar.php"; ?>

<div class="centro">
    <div class="container">
        <?php
        if (isset($_GET['fecha'])) {
            $fecha = htmlspecialchars($_GET['fecha']);
            $peluqueros_ocupados_hora = array();
            $peluqueros_libres = array();

            foreach ($horas_disponibles as $x) {    //* OBTENEMOS LOS PELUQUEROS OCUPADOS DE ESE DIA POR CADA HORA.
                $a = "SELECT * FROM citas WHERE fecha = '$fecha' AND hora = '$x';";
                $a = mysqli_query($mysqli, $a);
                if (mysqli_num_rows($a) > 0) {

                    while($rowa = mysqli_fetch_assoc($a)){
                        $peluquero_id = $rowa['peluquero'];

                        $lista = array();
                        if ($peluqueros_ocupados_hora[$x] != null) {
                            $lista = $peluqueros_ocupados_hora[$x];
                        }
                        array_push($lista, $peluquero_id);
                        $peluqueros_ocupados_hora[$x] = $lista;
                    }
                } else {
                    $peluqueros_ocupados_hora[$x] = null;
                }
            }
            foreach ($horas_disponibles as $x) {    //* OBTENEMOS LOS PELUQUEROS LIBRES DE ESE DIA POR CADA HORA.
                if ($peluqueros_ocupados_hora[$x] != null && $peluqueros_ocupados_hora[$x] < $peluqueros_totales) {
                    //* EN ESA HORA NO ESTAN TODOS LOS PELUQUEROS LIBRES
                    $r[$x] = array_diff($peluqueros_totales, $peluqueros_ocupados_hora[$x]);

                    $peluqueros_libres[$x] = $r[$x];
                    
                } else {
                    $peluqueros_libres[$x] = $peluqueros_totales;
                }
            }
            foreach ($horas_disponibles as $x) {    //* MOSTRAMOS LOS PELUQUEROS LIBRES DE ESE DIA POR CADA HORA.
                $a = $peluqueros_libres[$x];
                foreach ($peluqueros_libres[$x] as $peluquero_libre) {
                    $c = "SELECT * FROM usuarios WHERE id = $peluquero_libre;";
                    $c = mysqli_query($mysqli, $c);
                    $rowc = mysqli_fetch_assoc($c);
                    $peluquero_nombre = ucwords(mb_strtolower($rowc['nombre']));
                    $peluquero_apellido = ucwords(mb_strtolower($rowc['apellidos']));

                    echo "        
                    <a href='confirmarCita.php?fecha=$fecha&hora=$x&peluquero=$peluquero_libre' class='cita' id='$fecha-$x'>
                        <p class='cita_peluquero'><i class='bi bi-scissors'></i> $peluquero_nombre $peluquero_apellido</p>
                        <p class='cita_fecha'><i class='bi bi-calendar-event-fill'></i> $fecha</p>
                        <p class='cita_hora'><i class='bi bi-clock-fill'></i> $x</p>
                    </a>";
                }
            }
        } else {
            header("Location: disponibles.php");
        }
        ?>
    </div>
</div>

<?php include "components/footer.php"; ?>