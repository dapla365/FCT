<?php include "components/header.php" ?>
<?php include "components/navbar.php" ?>

<div class="perfil">
    <div class="centro">
        <p>
            <?php
                echo $user_id;
                echo $user_username;
                echo $user_correo;
                echo $user_nombre;
                echo $user_apellidos;
                echo $user_rol;
                echo "<img src='$user_foto' alt='$user_username'> ";
            ?>
    
        </p>
    </div>
</div>

<?php include "components/footer.php" ?>