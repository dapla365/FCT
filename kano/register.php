<?php include "components/header.php" ?>
<?php include "components/secret.php"; ?>

<div class="body">
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
    <h2>Registro</h2>
    <p>¿Ya tienes cuenta? <a href="login.php">Iniciar sesión</a></p>

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
            <input type="password" name="contrasena_uno" placeholder=" " required>
            <label for="contrasena_uno">Contraseña:</label>
            <span class="form_line"></span>
        </div>
        <div class="form__group">
            <input type="password" name="contrasena_dos" placeholder=" " required>
            <label for="contrasena_dos">Repite contraseña:</label>
            <span class="form_line"></span>
        </div>
        <input class="form_submit" type="submit" value="Regístrate">
        <div class="google">
            <div class="g_id_signin" data-type="standard" data-shape="rectangular" data-theme="outline"
                data-text="signup_with" data-size="large" data-locale="es_ES">
            </div>
            <div id="g_id_onload" data-client_id="<?php echo $client_id; ?>"
                data-login_uri="<?php echo $redirect_uris; ?>" data-auto_prompt="false">
            </div>
        </div>
    </div>
    
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    require_once "components/conexion.php";
    if(isset($_POST['credential'])){
        $credential = $_POST['credential'];

        //* Verificar el token con Google
        $url = 'https://oauth2.googleapis.com/tokeninfo?id_token=' . $credential;
        $response = file_get_contents($url);
        $payload = json_decode($response, true);

        if (isset($payload['sub'])) {
            $userid = $payload['sub'];
            $email = $payload['email'];
            $given_name = $payload['given_name'];
            $family_name = $payload['family_name'];
            $picture = $payload['picture'];

            $sql_correo="SELECT * FROM usuarios WHERE correo = '$email'";
            $result_correo = mysqli_query($mysqli, $sql_correo);

            $sql_user="SELECT * FROM usuarios WHERE user_id = '$userid'";
            $result_user = mysqli_query($mysqli, $sql_user);

            if(mysqli_num_rows($result_correo)>0){
                //* TIENE CORREO ASOCIADO EN LA BD
                session_set_cookie_params(360);
                session_start();
                while($row = mysqli_fetch_assoc($result_correo)){
                    $_SESSION['usuario']=$row['username'];
                    $bd_id=$row['id'];
                    $bd_user_id = $row['user_id'];
                
                    if($bd_user_id == NULL){
                        //* ACTUALIZAR USUARIO EN BD
                        $sql = "UPDATE usuarios SET user_id = '$userid' WHERE id = $bd_id;";
                        $a = mysqli_query($mysqli, $sql);
                    }
                }
               
                header("Location: index.php");
                mysqli_close($mysqli);
                
            }else if(mysqli_num_rows($result_user)>0){
                //* NO TIENE CORREO ASOCIADO EN LA BD
                while($row = mysqli_fetch_assoc($result_user)){
                    $_SESSION['usuario']=$row['username'];
                    $bd_id=$row['id'];
                    $bd_user_correo = $row['correo'];

                    if($bd_user_correo == NULL){
                        //* ACTUALIZAR USUARIO EN BD
                        $sql = "UPDATE usuarios SET correo = '$email' WHERE id = $bd_id;";
                        $a = mysqli_query($mysqli, $sql);
                    }
                }

                session_set_cookie_params(360);
                session_start();

                header("Location: index.php");
                mysqli_close($mysqli);
            }else{
                //* REGISTRAR USUARIO
                $autousername = strtolower(substr($given_name, 3) . substr($family_name, 3). random_int(10000, 99999));
                $sql = "INSERT INTO usuarios (user_id, username, correo, nombre, apellidos, foto) VALUES ('$userid', '$autousername', '$email', '$given_name', '$family_name', '$picture')";

                if ($mysqli->query($sql) === TRUE) {
                    echo "<p> Registro exitoso. Redirigiendo...</p>";
                    echo "<p> Si no redirige puedes hacer <a href='index.php'>click aquí</a></p>";
                    
                    session_set_cookie_params(360);
                    session_start();
                    $_SESSION['usuario']=$autousername;

                    header("Refresh:3; url=index.php");
                }
            }
        } else {
            // Token no válido
            echo json_encode(['success' => false, 'message' => 'Token invalido']);
        }
    }else{
        $nombre = mb_strtolower(htmlspecialchars($_POST["nombre"]));
        $apellidos = mb_strtolower(htmlspecialchars($_POST["apellidos"]));
        $correo = mb_strtolower(htmlspecialchars($_POST["email"]));
        $contrasena_uno = htmlspecialchars($_POST["contrasena_uno"]);
        $contrasena_dos = htmlspecialchars($_POST["contrasena_dos"]);

        if($nombre == "" || $apellidos == "" || $correo == "" || $username == ""|| $contrasena_uno == NULL || $contrasena_dos == NULL){
            echo "<p><strong>Error: </strong>Todos los campos son obligatorios.</p";
            return;
        }
        $username = strtolower(substr($nombre, 3) . substr($apellidos, 3). random_int(10000, 99999)); //* GENERAR USUARIO A PARTIR DE NOMBRE Y APELLIDOS

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
                    $sql = "INSERT INTO usuarios (nombre, apellidos, username, contrasena, correo) VALUES ('$nombre', '$apellidos','$username', '$contrasena_hash', '$correo')";

                    if ($mysqli->query($sql) === TRUE) {
                        echo "<p> Registro exitoso. Redirigiendo...</p>";
                        echo "<p> Si no redirige puedes hacer <a href='index.php'>click aquí</a></p>";

                        session_set_cookie_params(360);
                        session_start();
                        $_SESSION['darkmode']='white';
                        $_SESSION['usuario']=$username;

                        header("Refresh:3; url=index.php");
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