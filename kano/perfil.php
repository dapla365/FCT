<?php include "components/header.php" ?>
<?php include "components/navbar.php" ?>

<section class="seccion-perfil-usuario">
    <div class="perfil-usuario-header">
        <div class="perfil-usuario-portada">
            <div class="perfil-usuario-avatar">
                <img src="<?php echo $user_foto;?>" alt="img-avatar">
                <button type="button" class="boton-avatar">
                    <i class="bi bi-image-fill"></i>
                </button>
            </div>
            <button type="button" class="boton-portada">
                <i class="bi bi-image-fill"></i> Cambiar fondo
            </button>
        </div>
    </div>
    <div class="perfil-usuario-body">
        <div class="perfil-usuario-bio">
            <h3 class="titulo"><?php echo "$user_nombre $user_apellidos";?></h3>
            <p class="texto"><?php echo ucfirst(mb_strtolower($user_rolname));?> </p>
        </div>
        <div class="perfil-usuario-footer">
            <ul class="lista-datos">
                <li><i class="icono"></i> Correo:</li>
                <li><i class="icono"></i> Nombre:</li>
                <li><i class="icono"></i> Apellidos:</li>
                <li><i class="icono"></i> Cargo:</li>
            </ul>
            <ul class="datos-right">
                <li><i class="icono"></i><?php echo $user_correo;?></li>
                <li><i class="icono"></i><?php echo $user_nombre;?></li>
                <li><i class="icono"></i><?php echo $user_apellidos;?></li>
                <li><i class="icono"></i><?php echo ucfirst(mb_strtolower($user_rolname)); ?></li>
            </ul>
        </div>
    </div>
</section>

<?php include "components/footer.php" ?>