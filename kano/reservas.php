<?php include "components/header.php"; ?>
<?php include "components/navbar.php"; ?>
<?php
if (isset($_GET['user'])) {
    $user = htmlspecialchars($_GET['user']);
    if ($user_nivel <= 5) {
        $user = $user_id;
    }
} else {
    $user = $user_id;
}
?>
<div class="centro">
    <div class="container">
        <?php
        $a = "SELECT * FROM citas WHERE peluquero=$user OR usuario=$user;";
        $a = mysqli_query($mysqli, $a);

        if (mysqli_num_rows($a) <= 0) {
            echo "<a href='disponibles.php' class='sin_citas'><i class='bi bi-calendar-fill'></i> No hay citas reservadas</a>";
        } else {
            $disp = TRUE;
            while ($row = mysqli_fetch_assoc($a)) {
                $id = $row['id'];
                $fecha = $row['fecha'];
                $hora = $row['hora'];
                $peluquero = $row['peluquero'];
                $usuario = $row['usuario'];
                $tipo = $row['tipo'];
                $pagado = $row['pagado'];
                $realizada = $row['realizada'];

                if ($usuario != NULL && !$realizada) {
                    $disp = FALSE;

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

                    /* INFO TIPO */
                    $d = "SELECT * FROM tipos WHERE id=$tipo;";
                    $d = mysqli_query($mysqli, $d);
                    $rowd = mysqli_fetch_assoc($d);
                    $tipo_nombre = ucwords(mb_strtolower($rowd['tipo']));
                    $tipo_precio = $rowd['precio'];
                    $tipo_id = $rowd['id'];

                    $pago = 'Sin Pagar: ' . $tipo_precio . "€";
                    if ($user_nivel >= 5) {
                        if ($pagado == TRUE) {
                            //* PAGADO 
                            $pago = 'Pagado';
                        }
                        echo "        
                        <div class='cita' id='$id'>
                            <div class='cita__datos'>
                                <p class='cita_peluquero'><i class='bi bi-scissors'></i> $peluquero_nombre $peluquero_apellido</p>
                                <p class='cita_usuario'><i class='bi bi-person-standing'></i> $usuario_nombre $usuario_apellido</p>
                            </div>
                            <div class='cita__datos'>
                                <p class='cita_fecha'><i class='bi bi-calendar-event-fill'></i> $fecha</p>
                                <p class='cita_hora'><i class='bi bi-clock-fill'></i> $hora</p>
                            </div>
                            <div class='cita__datos'>
                                <select class='cita_tipo'>
                                <option value='$tipo_id'>$tipo_nombre</option>";
                        $d = "SELECT * FROM tipos;";
                        $d = mysqli_query($mysqli, $d);
                        while ($rowd = mysqli_fetch_assoc($d)) {
                            $tipo_nombre2 = ucwords(mb_strtolower($rowd['tipo']));
                            $tipo_id2 = $rowd['id'];
                            if ($tipo_nombre != $tipo_nombre2) {
                                echo "<option value='$tipo_id2'>$tipo_nombre2</option>";
                            }
                        }
                        echo    "</select>
                                <p class='cita_pagado'> $pago </p>
                            </div>
                            <div class='cita_opciones'>
                                <div onclick='realizada($id)'><i class='bi bi-check-lg'></i></div>
                                <div onclick='confirmacion($id)'><i class='bi bi-trash3-fill'></i></div>
                            </div>
                        </div>
                        ";
                    } else {
                        //! VISTA DE USUARIO
                        if ($pagado == TRUE) {
                            //* PAGADO
                            $pago = 'Pagado';
                        }
                        echo "        
                        <div class='cita' id='$id'>
                            <div class='cita__datos'>
                                <p class='cita_peluquero'><i class='bi bi-scissors'></i> $peluquero_nombre $peluquero_apellido</p>
                                <p class='cita_usuario'><i class='bi bi-person-standing'></i> $usuario_nombre $usuario_apellido</p>
                            </div>
                            <div class='cita__datos'>
                                <p class='cita_fecha'><i class='bi bi-calendar-event-fill'></i> $fecha</p>
                                <p class='cita_hora'><i class='bi bi-clock-fill'></i> $hora</p>
                            </div>
                            <div class='cita__datos'>
                                <select class='cita_tipo'>
                                <option value='$tipo_id'>$tipo_nombre</option>";
                        $d = "SELECT * FROM tipos;";
                        $d = mysqli_query($mysqli, $d);
                        while ($rowd = mysqli_fetch_assoc($d)) {
                            $tipo_nombre2 = ucwords(mb_strtolower($rowd['tipo']));
                            $tipo_id2 = $rowd['id'];
                            if ($tipo_nombre != $tipo_nombre2) {
                                echo "<option value='$tipo_id2'>$tipo_nombre2</option>";
                            }
                        }
                        echo "</select>
                                <p class='cita_pagado'> $pago </p>
                            </div>
                            <div class='cita_opciones'>
                                <div onclick='confirmacion($id)'><i class='bi bi-trash3-fill'></i></div>";
                        if ($pagado != TRUE) {
                            echo "<div onclick='pagar($id)'><i class='bi bi-currency-euro'></i></div>";
                        }
                        echo "</div>
                        </div>
                        ";
                    }
                }
            }
            if ($disp) {
                echo "<a href='disponibles.php' class='sin_citas'><i class='bi bi-calendar-fill'></i> No hay citas reservadas</a>";
            }
        }
        ?>
    </div>
</div>

<script>
    function confirmacion(id) {
        if (confirm("¿Estás seguro que quieres eliminar esta reserva?")) {
            location.href = "eliminar_reserva.php?reserva=" + id;
        }
    }

    function realizada(id) {
        if (confirm("¿Confirmas de qué ya se realizó esta cita?")) {
            location.href = "eliminar_reserva.php?realizada=" + id;
        }
    }

    $(document).on("change", function(e) {
        let select = document.querySelectorAll(".cita select");
        select.forEach(o => {
            if (e.target == o) {
                let c = e.target.parentElement.parentElement.id;

                location.href = `${location.origin}/kano/confirmarCita.php?id=${c}&tipo=${o.value}`;
            }
        });
    });
</script>

<?php include "components/footer.php"; ?>