<?php include "components/header.php" ?>
<?php include "components/navbar.php" ?>

<div class="peluqueros">
        <?php
        $a = "SELECT * FROM usuarios WHERE rol>=1 AND rol<=2;";
        $a = mysqli_query($mysqli, $a);
        while ($row = mysqli_fetch_assoc($a)) {
            $id = $row['id'];
            $username = mb_strtolower($row['username']);
            $nombre = ucfirst(mb_strtolower($row['nombre']));
            $foto = $row['foto'];

            echo "   
            <a href='peluqueros2.php?peluquero={$id}' class='outer-div'>
                <div class='inner-div'>
                    <div class='front'>
                        <img src='$foto' alt='$nombre' class='front__bkg-photo'></img>
                        <p class='front__text'>
                            $nombre
                        </p>
                    </div>
                </div>
            </a>";
        }
        ?>
 </div>

<?php include "components/footer.php" ?>