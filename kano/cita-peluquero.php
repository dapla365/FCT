<?php
include "components/header.php";
include "components/navbar.php";
require_once 'components/conexion.php';

if (isset($_GET['peluquero'])) {
    $peluquero = mb_strtolower(htmlspecialchars($_GET['peluquero']));
}else{
    header('Location: peluqueros.php');
}
?>

<div class="peluqueros">
    <div class="centro">
        <?php
        $a = "SELECT * FROM usuarios WHERE id=$peluquero;";
        $a = mysqli_query($mysqli, $a);
        while ($row = mysqli_fetch_assoc($a)) {
            $rol = $row['rol'];
            if($rol < 1) header('Location: peluqueros.php');
            
            $id = $row['id'];
            $username = mb_strtolower($row['username']);
            $nombre = ucfirst(mb_strtolower($row['nombre']));
            $foto = $row['foto'];

            echo "        
            <div class='peluquero'>
                <a href='cita-peluquero.php?peluquero={$id}'>
                    <div class='foto'>
                        <img src='$foto' alt='$nombre'>
                    </div>
                    <div class='nombre'>
                        <h2>$nombre</h2>
                    </div>
                </a>
            </div>";
        }
        ?>
    </div>
</div>

<?php include "components/footer.php" ?>