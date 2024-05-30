<?php include "components/header.php" ?>
<?php include "components/navbar.php" ?>
<div class="centro">
    <div class="container">
        <div class="left">
            <input type="file" id="subirfoto" name="subirfoto" accept="image/png, image/jpeg" style="display: none;"/>
            <img id="foto" src="<?php echo $user_foto; ?>" alt="img-avatar">
            <h2><?php echo "$user_username"; ?></h2>
            <h3><?php echo ucwords(mb_strtolower($user_rolname)); ?></h3>
        </div>
        <div class="right">
            <div class="datos">
                <p class="info">Correo electrónico</p> <span><?php echo $user_correo; ?></span>
            </div>
            <div class="datos">
                <p class="info">Nombre</p> <span><?php echo $user_nombre; ?></span>
            </div>
            <div class="datos">
                <p class="info">Apellidos</p> <span><?php echo ucwords($user_apellidos); ?></span>
            </div>
            <div class="datos">
                <p class="info">Cargo</p> <span><?php echo ucwords(mb_strtolower($user_rolname)); ?></span>
            </div>
            <div class="datos">
                <p class="info">Cambiar contraseña</p> <span><button onclick="window.location.href = 'changePassword.php'">Cambiar</button></span>
            </div>
            <?php
            if($user_rol > 0 && $user_rol < 3){ 
                echo '
            <div class="datos">
                <p class="info">Cambiar horario</p> <span><button onclick="window.location.href = `cambiarHorario.php`">Cambiar</button></span>
            </div>';
            }
            ?>
        </div>
    </div>
</div>
<script>
$('#foto').click(function(){ $('#subirfoto').trigger('click'); });
</script>
<?php include "components/footer.php" ?>