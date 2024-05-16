<?php include "components/header.php"; ?>
<?php include "components/navbar.php"; ?>

<div class="centro">
    <div class="container">
        <?php
        if (isset($_GET['fecha']) && isset($_GET['peluquero'])) {
            $fecha = htmlspecialchars($_GET['fecha']);
            $peluquero = htmlspecialchars($_GET['peluquero']);
            
            $a = "SELECT * FROM citas WHERE fecha = '$fecha' AND peluquero='$peluquero';";
            $a = mysqli_query($mysqli, $a);
            if(mysqli_num_rows($a)>0){
                //* HAY CITAS EN ESA FECHA */

                $horas_ocupadas = array();
                while ($row = mysqli_fetch_array($a)) {
                    $hora= $row["hora"];
                    
                }
            }else{
                //* NO HAY CITAS EN ESA FECHA */
                foreach ($horas_disponibles as $x) {    
                    $c = "SELECT * FROM usuarios WHERE id = $peluquero;";
                    $c = mysqli_query($mysqli, $c);
                    $rowc = mysqli_fetch_assoc($c);
                    $peluquero_nombre = ucwords(mb_strtolower($rowc['nombre']));
                    $peluquero_apellido = ucwords(mb_strtolower($rowc['apellidos']));

                    echo "        
                    <a href='confirmarCita.php?fecha=$fecha&hora=$x&peluquero=$peluquero' class='cita' id='$fecha-$x'>
                        <p class='cita_peluquero'><i class='bi bi-scissors'></i> $peluquero_nombre $peluquero_apellido</p>
                        <p class='cita_fecha'><i class='bi bi-calendar-event-fill'></i> $fecha</p>
                        <p class='cita_hora'><i class='bi bi-clock-fill'></i> $x</p>
                    </a>";
                    
                }
            }   
        } else {
            header("Location: peluqueros.php");
        }
        ?>
    </div>
</div>

<?php include "components/footer.php"; ?>