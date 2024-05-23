<?php include "components/header.php" ?>
<?php include "components/navbar.php" ?>

<?php
if (isset($_GET['user'])) {
    $id = htmlspecialchars($_GET['user']);
    if ($user_nivel > 5) {
        $a = "SELECT * FROM usuarios WHERE id=$id;";
        $a = mysqli_query($mysqli, $a);
        while ($row = mysqli_fetch_assoc($a)) {
            $username = $row["username"];
            $rol = $row["rol"];

            $b="SELECT nombre FROM roles WHERE id=$rol";          
            $b = mysqli_query($mysqli, $b);
            $b = mysqli_fetch_assoc($b);
            $rol_name = ucwords(mb_strtolower($b['nombre']));
        }
    } else {
        header("Location: index.php");
    }
}
?>

<div class="body">
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
    <h2>Editar usuario</h2>
    <div class="form__container">
        <div class="form__group">
            <label for="user">Usuario</label>
            <input type="text" name="user" value="<?php echo "$username";?>" disabled>
        </div>

        <div class="form__group">
            <label for="rol">Rol</label>
            <select id="rol" name="rol">
                <?php 
                $a="SELECT nombre FROM roles";     
                $a = mysqli_query($mysqli, $a);
        
                echo "<option value='$rol_name'>$rol_name</option>";

                while($row = mysqli_fetch_assoc($a)){
                  $option = ucwords(mb_strtolower($row['nombre']));
                  if($rol_name != $option){
                    echo "<option value='$option'>$option</option>";
                  }
                }
                ?>
            </select>
        </div>

      <div class="form__group">
        <label for="pass">Restablecer contraseña</label>
        <input type="checkbox" name="pass">
      </div>
      <div class="form__group">
        <input type="submit" class="form_submit" name="editar" value="Editar">
    </div>
      <?php 

if(isset($_POST['editar'])) 
  {
    if($user_nivel <= 5){
      echo "<p><strong>Error: </strong>¡No tienes permisos para editar al usuario!</p>";
    }else{      
      $rol = mb_strtoupper(htmlspecialchars($_POST['rol']));
      $pass = htmlspecialchars($_POST['pass']);

      $a = "SELECT id FROM roles WHERE nombre LIKE '$rol'";
      $a = mysqli_query($mysqli, $a);
      $rolnuevo = mysqli_fetch_assoc($a)['id'];
      
      $query = "UPDATE usuarios SET rol = '{$rolnuevo}' WHERE id = {$id}";
      if(isset($_POST['pass'])){
        $pass = $username.$id;
        $pass_hash = password_hash($pass, PASSWORD_DEFAULT);

        $query = "UPDATE usuarios SET rol = '{$rolnuevo}', contrasena = '{$pass_hash}' WHERE id = {$id}";
      }

      $a = mysqli_query($mysqli, $query);
      if (!$a) {
          echo "<p><strong>Error: </strong>Algo ha ido mal editando al usuario: ". mysqli_error($mysqli)."</p>";
      }
      else
      {
        if(isset($_POST['pass'])){
          echo "<p> ¡Usuario editado con éxito!.</p>";
          echo "<script>alert('La nueva contraseña del usuario $username es: $pass');</script>";
        }else{
          header("Refresh:3; url=admin.php");
          echo "<p> ¡Usuario editado con éxito!. Redirigiendo...</p>";
          echo "<p> Si no redirige puedes hacer <a href='usuarios.php'>click aquí</a></p>";
        }
      }      
    }
  }
?>
    </div>
</form> 

</div>

<?php include "components/footer.php" ?>