<?php include "components/header.php" ?>
<?php include "components/secret.php"; 
    require_once "components/conexion.php";?>

<div class="body">
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
    <h2>Añadir usuario</h2>
    <div class="form__container">
        <div class="form__group">
            <input type="text" name="nombre" placeholder=" " required>
            <label for="nombre">Nombre:</label>
            <span class="form_line"></span>
        </div>
        <div class="form__group">
            <input type="text" name="apellidos" placeholder=" " required>
            <label for="apellidos">Apellidos:</label>
            <span class="form_line"></span>
        </div>
        <div class="form__group">
            <input type="email" name="email" placeholder=" " required>
            <label for="email">Correo:</label>
            <span class="form_line"></span>
        </div>
        <div class="form__group">
            <label for="rol">Rol</label>
            <span class="form_line"></span>
            <select id="rol" name="rol">
                <?php 
                $a="SELECT nombre FROM roles";     
                $a = mysqli_query($mysqli, $a);

                while($row = mysqli_fetch_assoc($a)){
                  $option = ucwords(strtolower($row['nombre']));
                echo "<option value='$option'>$option</option>";
                  
                }
                ?>
            </select>
        </div>
        <div class="form__group">
            <input type="password" name="contrasena_uno" placeholder=" " required>
            <label for="contrasena_uno">Contraseña:</label>
            <span class="form_line"></span>
        </div>
        <div class="form__group">
            <input type="password" name="contrasena_dos" placeholder=" " required>
            <label for="contrasena_dos">Repite contraseña:</label>
            <span class="form_line"></span>
        </div>
        <input class="form_submit" type="submit" value="Añadir usuario">
    </div>
    
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
        $nombre = strtolower(htmlspecialchars($_POST["nombre"]));
        $apellidos = strtolower(htmlspecialchars($_POST["apellidos"]));
        $correo = strtolower(htmlspecialchars($_POST["email"]));
        $rol = strtoupper(htmlspecialchars($_POST["rol"]));
        $contrasena_uno = htmlspecialchars($_POST["contrasena_uno"]);
        $contrasena_dos = htmlspecialchars($_POST["contrasena_dos"]);
        $a = "SELECT id FROM roles WHERE nombre LIKE '$rol'";
        $a = mysqli_query($mysqli, $a);
        $rolnuevo = mysqli_fetch_assoc($a)['id'];
        
        if($nombre == "" || $apellidos == "" || $correo == "" || $rol == "" || $contrasena_uno == NULL || $contrasena_dos == NULL){
            echo "<p><strong>Error: </strong>Todos los campos son obligatorios.</p";
            return;
        }
        $username = strtolower(substr($nombre, 0, 3) . substr($apellidos, 0, 3). random_int(10000, 99999)); //* GENERAR USUARIO A PARTIR DE NOMBRE Y APELLIDOS

        //LOGIN CON USUARIO O CORREO
        $sql_usuario="SELECT * FROM usuarios WHERE username ='$username'";
        $result_user = mysqli_query($mysqli, $sql_usuario);
        $sql_correo="SELECT * FROM usuarios WHERE correo = '$correo'";
        $result_correo = mysqli_query($mysqli, $sql_correo);

        if(mysqli_num_rows($result_user)>0 || mysqli_num_rows($result_correo)>0){
            mysqli_free_result($result_user);
            //Esta registrado
            echo "<p><strong>Error: </strong>el usuario ya está registrado.</p>";
        }else{
            if (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
                echo "Esta dirección de correo ($correo) no es válida.";
            }else{
                mysqli_free_result($result_user);
                if($contrasena_uno == $contrasena_dos){
                    // Hash de la contraseña
                    $contrasena_hash = password_hash($contrasena_uno, PASSWORD_DEFAULT);

                    // Insertar usuario en la base de datos
                    $sql = "INSERT INTO usuarios (nombre, apellidos, username, rol, contrasena, correo) VALUES ('$nombre', '$apellidos','$username', '$rolnuevo', '$contrasena_hash', '$correo')";

                    if ($mysqli->query($sql) === TRUE) {

                        echo "<br><p> Has añadido correctamente al usuario. Redirigiendo...</p>";
                        echo "<p> Si no redirige puedes hacer <a href='admin.php'>click aquí</a></p>";
                        header("Refresh:3; url=admin.php");

                    } else {
                        echo "Error en el registro: " . $mysqli->error;
                    }

                    $mysqli->close();
                }else{
                    echo "<p><strong>Error: </strong>las contraseñas no coinciden.</p>";
                }
            }
        }
    
}
?>
</form>
</div>
<script src="https://accounts.google.com/gsi/client" async defer></script>
<script>
    function handleCredentialResponse(response) {
        console.log("Encoded JWT ID token: " + response.credential);
        // Enviar el token al servidor
        fetch('<?php echo $redirect_uris; ?>', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: 'credential=' + encodeURIComponent(response.credential)
        })
            .then(response => response.json())
            .then(data => {
                console.log('Success:', data);
                // Manejar el éxito del inicio de sesión
            })
            .catch((error) => {
                console.error('Error:', error);
                // Manejar el error del inicio de sesión
            });
    }

    window.onload = function () {
        google.accounts.id.initialize({
            client_id: '<?php echo $client_id; ?>',
            callback: handleCredentialResponse
        });
        google.accounts.id.renderButton(
            document.getElementById("buttonDiv"),
            { theme: "outline", size: "large" }  // personaliza el botón
        );
        google.accounts.id.prompt(); // para mostrar el diálogo de inicio de sesión automáticamente
    };
</script>
<?php include "components/footer.php" ?>