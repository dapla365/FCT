<?php include "components/header.php" ?>
<?php include "components/navbar.php" ?>

<div class="body">
    <div class="gallery">
        <?php
        $a = "SELECT * FROM usuarios WHERE rol>=1 AND rol<=2;";
        $a = mysqli_query($mysqli, $a);
        while ($row = mysqli_fetch_assoc($a)) {
            $id = $row['id'];
            $username = mb_strtolower($row['username']);
            $nombre = ucfirst(mb_strtolower($row['nombre']));
            $foto = $row['foto'];

            echo "   
            <a href='peluqueros2.php?peluquero={$id}' class='person'>
                <img src='$foto' alt='$nombre'>
                <p>$nombre</p>
            </a>";
        }
        ?>
    </div>
</div>

<?php include "components/footer.php" ?>