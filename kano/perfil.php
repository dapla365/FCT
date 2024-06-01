<?php include "components/header.php" ?>
<?php include "components/navbar.php" ?>
<div class="centrar">
    <div class="profile-container">
        <div class="profile-header">
            <div class="profile-image">
                <img src="<?php echo $user_foto; ?>" alt="Imagen de perfil" id="profileImg">
                <input type="file" id="fileInput" accept="image/png, image/jpeg">
            </div>
            <div class="profile-details">
                <p><span>Usuario:</span> <?php echo "$user_username"; ?> <button class="edit-btn" onclick="cambiarUsername()">Editar</button></p>
                <p><span>Nombre:</span> <?php echo $user_nombre; ?> <button class="edit-btn" onclick="cambiarNombre()">Editar</button></p>
                <p><span>Apellidos:</span> <?php echo ucwords($user_apellidos); ?> <button class="edit-btn" onclick="cambiarApellidos()">Editar</button></p>
                <p><span>Correo: </span> <?php echo $user_correo; ?> </p>
            </div>
        </div>
        <div class="buttons-container">
            <button class="action-btn change-password-btn" onclick="window.location.href = 'changePassword.php'">Cambiar contraseña</button>
            <?php
            if ($user_rol > 0 && $user_rol < 3) {
                echo '
                <button class="action-btn change-schedule-btn"
                    onclick="window.location.href = `cambiarHorario.php`">Cambiar horario</button>';
            }
            ?>
            <button class="action-btn delete-account-btn" onclick="eliminarCuenta()">Eliminar cuenta</button>
        </div>
    </div>
</div>

<script>
    $('#profileImg').click(function() {
        $('#fileInput').trigger('click');
    });

    function cambiarUsername() {
        let person = prompt('¿Qué usuario quieres ponerte?', 'davpla');
        if (person != null) {
            //CAMBIAR USERNAME
        }
    }

    function cambiarNombre() {
        let person = prompt('¿Qué nombre quieres ponerte?', 'David');
        if (person != null) {
            //CAMBIAR NOMBRE
        }
    }

    function cambiarApellidos() {
        let person = prompt('¿Qué apellidos quieres ponerte?', 'Plaza');
        if (person != null) {
            //CAMBIAR APELLIDOS
        }
    }

    function eliminarCuenta() {
        if (confirm("Estás seguro de que quieres eliminar tu cuenta")) {
            eliminarCuenta2();
        }
    }

    function eliminarCuenta2() {
        let eli = prompt('Escribe ELIMINAR para eliminar tu cuenta definitivamente');
        if (eli.toUpperCase() == 'ELIMINAR') {
            //ELIMINAR CUENTA
        }
    }
</script>
<?php include "components/footer.php" ?>