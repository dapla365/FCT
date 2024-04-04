<?php include "components/header.php" ?>
<?php include "components/navbar.php" ?>

<div class="peluqueros">
    <div class="centro">
        <?php
        $a = "SELECT * FROM usuarios WHERE rol>=1;";
        $a = mysqli_query($mysqli, $a);
        while ($row = mysqli_fetch_assoc($a)) {
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