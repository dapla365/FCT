<?php include "components/header.php"; ?>
<?php include "components/secret.php"; ?>
<div class="body">
    <form method="post" action="<?php echo htmlspecialchars($_SERVER[" PHP_SELF"]); ?>">
        <h2>Iniciar Sesión</h2>
        <p>¿Aún no tienes cuenta? <a href="register.php">Regístrate</a></p>

        <div class="form__container">
            <div class="form__group">
                <input type="text" name="nombre" placeholder=" " required>
                <label for="nombre">Usuario:</label>
                <span class="form_line"></span>
            </div>
            <div class="form__group">
                <input type="password" name="contrasena" placeholder=" " required>
                <label for="contrasena">Contraseña:</label>
                <span class="form_line"></span>
            </div>
            <input class="form_submit" type="submit" value="Iniciar Sesión">
            <div id="g_id_onload" data-client_id="<?php echo $client_id; ?>"
                data-login_uri="<?php echo $redirect_uris; ?>" data-auto_prompt="false">
            </div>
            <div class="g_id_signin" data-type="standard" data-shape="rectangular" data-theme="outline"
                data-text="signin_with" data-size="large" data-locale="es_ES">
            </div>
        </div>

        <?php
        
if ($_SERVER["REQUEST_METHOD"] === "POST"){
    require_once 'components/conexion.php';
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
            // Aquí puedes manejar el inicio de sesión del usuario, por ejemplo, crear una sesión
            echo $userid ." - " . $email." - ". $given_name." - ". $family_name." - " . $picture;

            $sql_usuario="SELECT * FROM usuarios WHERE user_id = '$userid' OR correo = '$email'";
            $result_user = mysqli_query($mysqli, $sql_usuario);
            if(mysqli_num_rows($result_user)>0){
                session_set_cookie_params(360);
                session_start();

                //USUARIO (CORREO O NOMBRE)
                $y="SELECT * FROM usuarios WHERE user_id = '$userid'";
                $x="SELECT * FROM usuarios WHERE correo = '$email'";
                $y = mysqli_query($mysqli, $y);
                if(mysqli_num_rows($y)>0){
                    $_SESSION['usuario']=$row['user_id'];
                }else{
                    $x = mysqli_query($mysqli, $x);
                    if(mysqli_num_rows($x)>0){
                        while($row = mysqli_fetch_assoc($x)){
                            $_SESSION['usuario']=$row['username'];
                        }
                    }
                }
                
                header("Location: index.php");
    
                mysqli_close($mysqli);
                
            }else{
                //* REGISTRAR USUARIO
                $autousername = strtolower(substr($given_name, 3) . substr($family_name, 3));
                $sql = "INSERT INTO usuarios (user_id, username, correo, nombre, apellidos, foto) VALUES ('$user_id', '$autousername', '$email', '$given_name', '$family_name', '$picture')";

                if ($mysqli->query($sql) === TRUE) {
                    echo "<p> Registro exitoso. Redirigiendo...</p>";
                    echo "<p> Si no redirige puedes hacer <a href='index.php'>click aquí</a></p>";
                    
                    session_set_cookie_params(360);
                    session_start();
                    $_SESSION['usuario']=$nombre;

                    header("Refresh:3; url=index.php");
                }
            }
        } else {
            // Token no válido
            echo json_encode(['success' => false, 'message' => 'Token invalido']);
        }
    }else{
        $nombre = mb_strtolower(htmlspecialchars($_POST["nombre"]));
        $contrasena=htmlspecialchars($_POST["contrasena"]);
        
        if(!empty($nombre) && !empty($contrasena)){
            

            $sql_usuario="SELECT * FROM usuarios WHERE username = '$nombre' OR correo = '$nombre'";

            $result_user = mysqli_query($mysqli, $sql_usuario);

            if(mysqli_num_rows($result_user)>0 ){
                mysqli_free_result($result_user);

                //Esta registrado
                $sql_contrasena="SELECT contrasena FROM usuarios WHERE username = '$nombre' OR correo = '$nombre'";

                $result_pass = mysqli_query($mysqli, $sql_contrasena);
                $contrasena_bd = mysqli_fetch_array($result_pass, MYSQLI_NUM);
            
                if(password_verify($contrasena, $contrasena_bd[0])){
                    mysqli_free_result($result_pass);

                    session_set_cookie_params(360);
                    session_start();

                    //USUARIO (CORREO O NOMBRE)
                    $y="SELECT * FROM usuarios WHERE username = '$nombre'";
                    $x="SELECT * FROM usuarios WHERE correo = '$nombre'";
                    $y = mysqli_query($mysqli, $y);
                    if(mysqli_num_rows($y)>0){
                        $_SESSION['usuario']=$nombre;
                    }else{
                        $x = mysqli_query($mysqli, $x);
                        if(mysqli_num_rows($x)>0){
                            while($row = mysqli_fetch_assoc($x)){
                                $_SESSION['usuario']=$row['username'];
                            }
                        }
                    }
                    
                    header("Location: index.php");
        
                    mysqli_close($mysqli);
                }else{
                    mysqli_free_result($result_pass);
                    echo "<p><strong>Error: </strong>usuario o contraseña incorrecta.</p>";
                }
            }else{
                mysqli_free_result($result_user);
                echo "<p><strong>Error: </strong>usuario o contraseña incorrecta.</p>";
            }
        }
        else{
            echo "<p><strong>Error: </strong>rellene todos los campos.</p>";
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
<?php include "components/footer.php"; ?>