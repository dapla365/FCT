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
            <button class="action-btn change-password-btn" onclick="cambiarPass()">Cambiar contraseña</button>
            <?php
            if ($user_rol > 0 && $user_rol < 3) {
                echo '
                <button class="action-btn change-schedule-btn"
                    onclick="window.location.href = `cambiarHorario.php`">Cambiar horario</button>';
            }
            ?>
            <button class="action-btn delete-account-btn" onclick="eliminarCuenta()">Eliminar cuenta</button>
        </div>
        <p id="mensaje"></p>
    </div>
</div>

<div id="body">
    <form action="" method="post">
        <h2>Cambiar contraseña</h2>
        <div class="form__container">
            <div class="form__group">
                <input type="password" name="contrasena_uno" id="contrasena_uno" placeholder=" " required>
                <label for="contrasena_uno">Contraseña:</label>
                <span class="form_line"></span>
            </div>
            <div class="form__group">
                <input type="password" name="contrasena_dos" id="contrasena_dos" placeholder=" " required>
                <label for="contrasena_dos">Repite contraseña:</label>
                <span class="form_line"></span>
            </div>
            <input type="submit" name="cambiar" class="form_submit" value="Cambiar">

            <?php

            if ($_SERVER["REQUEST_METHOD"] == "POST") {

                $contrasena_uno = htmlspecialchars($_POST["contrasena_uno"]);
                $contrasena_dos = htmlspecialchars($_POST["contrasena_dos"]);

                if ($contrasena_uno == $contrasena_dos) {
                    // Hash de la contraseña
                    $contrasena_hash = password_hash($contrasena_uno, PASSWORD_DEFAULT);
                    $sql = "UPDATE usuarios SET contrasena = '{$contrasena_hash}' WHERE id = '{$user_id}'";
                    if ($mysqli->query($sql) === TRUE) {
                        echo "<p> Contraseña cambiada correctamente. </p>";
                    } else {
                        echo "Error en el registro: " . $mysqli->error;
                    }
                    $mysqli->close();
                } else {
                    echo "<p><strong>Error: </strong>las contraseñas no coinciden.</p>";
                }
            }
            ?>
        </div>
    </form>
</div>

<script>
    $('#profileImg').click(function() {
        $('#fileInput').trigger('click');
    });

    function cambiarPass() {
        if (document.getElementById('body').style.display == 'none' || document.getElementById('body').style.display == '') {
            document.getElementById('body').style.display = 'flex';
        } else {
            document.getElementById('body').style.display = 'none';
        }
    }

    function cambiarUsername() {
        let person = prompt('¿Qué usuario quieres ponerte?', '<?php echo $user_username; ?>');
        if (person != null) {
            //CAMBIAR USERNAME
            $.ajax({
                url: 'components/cambiarPerfil.php',
                method: 'POST',
                data: {
                    type: 'username',
                    user: person
                },
                success: function(data) {
                    document.getElementById('mensaje').innerHTML = data;
                    setTimeout(function() {
                        location.reload();
                    }, 3000);
                }
            });
        }
    }

    function cambiarNombre() {
        let person = prompt('¿Qué nombre quieres ponerte?', '<?php echo $user_nombre; ?>');
        if (person != null) {
            //CAMBIAR NOMBRE
            $.ajax({
                url: 'components/cambiarPerfil.php',
                method: 'POST',
                data: {
                    type: 'nombre',
                    user: person
                },
                success: function(data) {
                    document.getElementById('mensaje').innerHTML = data;
                    setTimeout(function() {
                        location.reload();
                    }, 3000);
                }
            });
        }
    }

    function cambiarApellidos() {
        let person = prompt('¿Qué apellidos quieres ponerte?', '<?php echo $user_apellidos; ?>');
        if (person != null) {
            //CAMBIAR APELLIDOS
            $.ajax({
                url: 'components/cambiarPerfil.php',
                method: 'POST',
                data: {
                    type: 'apellidos',
                    user: person
                },
                success: function(data) {
                    document.getElementById('mensaje').innerHTML = data;
                    setTimeout(function() {
                        location.reload();
                    }, 3000);
                }
            });
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
            $.ajax({
                url: 'components/cambiarPerfil.php',
                method: 'POST',
                data: {
                    type: 'delete',
                    user: person
                },
                success: function(data) {
                    document.getElementById('mensaje').innerHTML = data;
                }
            });
        }
    }
</script>
<?php include "components/footer.php" ?>