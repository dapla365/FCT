<?php include "components/header.php" ?>
<?php include "components/navbar.php" ?>

<div class="body">
  <form action="" method="post">
    <h2>Cambiar contraseña</h2>
    <div class="form__container">
        <div class="form__group">
            <input type="text" name="user" placeholder=" " value="<?php echo "$user_username";?>" disabled>
            <label for="user">Usuario</label>
            <span class="form_line"></span>
        </div>
        <div class="form__group">
            <input type="text" name="rol" placeholder=" " value="<?php echo "$user_rolname";?>" disabled>
            <label for="rol">Rol</label>
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
        <input type="submit" name="cambiar" class="form_submit" value="Cambiar">
      
<?php 

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $contrasena_uno = htmlspecialchars($_POST["contrasena_uno"]);
    $contrasena_dos = htmlspecialchars($_POST["contrasena_dos"]);

    if($contrasena_uno == $contrasena_dos){
        // Hash de la contraseña
        $contrasena_hash = password_hash($contrasena_uno, PASSWORD_DEFAULT);
        $sql = "UPDATE usuarios SET contrasena = '{$contrasena_hash}' WHERE username = '{$user_username}'";
          
        if ($mysqli->query($sql) === TRUE) {
            echo "<p> Contraseña cambiada correctamente. Redirigiendo...</p>";
            echo "<p> Si no redirige puedes hacer <a href='index.php'>click aquí</a></p>";

            header("Refresh:3; url=index.php");
        } else {
            echo "Error en el registro: " . $mysqli->error;
        }

        $mysqli->close();
    }else{
        echo "<p><strong>Error: </strong>las contraseñas no coinciden.</p>";
    }
}
?>
    </form> 
</div>


  <?php include "components/footer.php" ?>