<?php include "components/header.php"; ?>
<?php include "components/navbar.php"; ?>

<?php
$a = "SELECT * FROM citas WHERE peluquero=$user_id OR usuario=$user_id;";
$a = mysqli_query($mysqli, $a);
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
    $peluquero_nombre = ucfirst(mb_strtolower($rowb['nombre']));
    $peluquero_apellido = ucwords(mb_strtolower($rowb['apellidos']));

    /* INFO USUARIO */
    $c = "SELECT * FROM usuarios WHERE id=$usuario;";
    $c = mysqli_query($mysqli, $c);
    $rowc = mysqli_fetch_assoc($c);
    $usuario_nombre = ucfirst(mb_strtolower($rowc['nombre']));
    $usuario_apellido = ucwords(mb_strtolower($rowc['apellidos']));

    echo "        
        <div class='cita'>
            <p>Peluquero: $peluquero_nombre $peluquero_apellido</p>
            <p>Usuario: $usuario_nombre $usuario_apellido</p>
            <p>Fecha: $fecha</p>
            <p>Hora: $hora</p>
        </div><br>
    ";
}

?>


<?php include "components/footer.php"; ?>