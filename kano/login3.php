
<?php include "components/header.php"; ?>

<div class="body">
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
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
    </div>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST"){
    $nombre=mb_strtolower(htmlspecialchars($_POST["nombre"]));
    $contrasena=htmlspecialchars($_POST["contrasena"]);
    if(!empty($nombre) && !empty($contrasena)){
        require_once 'components/conexion.php';

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
?>
</form>
</div>
<?php include "components/footer.php"; ?>