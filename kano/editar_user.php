<?php include "components/header.php" ?>
<?php include "components/navbar.php" ?>

<?php
if (isset($_GET['user'])) {
  $user = htmlspecialchars($_GET['user']);
  if ($user_nivel > 5) {
    $a = "SELECT * FROM usuarios WHERE id=$user;";
    $a = mysqli_query($mysqli, $a);
    while ($row = mysqli_fetch_assoc($a)) {
      $username = $row["username"];
      $rol_antiguo = $row["rol"];

      $b = "SELECT nombre FROM roles WHERE id=$rol_antiguo";
      $b = mysqli_query($mysqli, $b);
      $b = mysqli_fetch_assoc($b);
      $rol_name = ucwords(strtolower($b['nombre']));
    }
  } else {
    header("Location: index.php");
  }
}
?>

<div class="body">
  <form action="" method="post">
    <h2>Editar usuario</h2>
    <div class="form__container">
      <div class="form__group">
        <label for="user">Usuario</label>
        <input type="text" name="user" value="<?php echo "$username"; ?>" disabled>
      </div>

      <div class="form__group">
        <label for="rol">Rol</label>
        <select id="rol" name="rol">
          <?php
          $a = "SELECT nombre FROM roles";
          $a = mysqli_query($mysqli, $a);

          echo "<option value='$rol_name'>$rol_name</option>";

          while ($row = mysqli_fetch_assoc($a)) {
            $option = ucwords(strtolower($row['nombre']));
            if ($rol_name != $option) {
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
        <input type="submit" class="form_submit" name="editar" value="editar">
      </div>
      <?php

      if (isset($_POST['editar'])) {
        if ($user_nivel <= 5) {
          echo "<p><strong>Error: </strong>¡No tienes permisos para editar al usuario!</p>";
        } else {
          $rol = strtoupper(htmlspecialchars($_POST['rol']));
          $pass = htmlspecialchars($_POST['pass']);

          $a = "SELECT id FROM roles WHERE nombre LIKE '$rol'";
          $a = mysqli_query($mysqli, $a);
          $rolnuevo = mysqli_fetch_assoc($a)['id'];

          if (($rol_antiguo > 1 || $rol_antiguo < 4) && ($rolnuevo < 2 || $rolnuevo > 3)) {
            $espeluquero = true;
            if (isset($_POST['pass'])) {
              $respass = true;
              $pass = $username . $user;
            }
          } else {
            $query = "UPDATE usuarios SET rol = '{$rolnuevo}' WHERE id = {$user}";
            if (isset($_POST['pass'])) {
              $pass = $username . $user;
              $pass_hash = password_hash($pass, PASSWORD_DEFAULT);

              $query = "UPDATE usuarios SET rol = '{$rolnuevo}', contrasena = '{$pass_hash}' WHERE id = {$user}";
            }

            $a = mysqli_query($mysqli, $query);
            if (!$a) {
              echo "<p><strong>Error: </strong>Algo ha ido mal editando al usuario: " . mysqli_error($mysqli) . "</p>";
            } else {
              if (isset($_POST['pass'])) {
                echo "<p> ¡Usuario editado con éxito!.</p>";
                echo "
          <script>
            if (confirm('La nueva contraseña del usuario $username es: $pass')) {
              location.href = 'admin.php';
            }else{
              location.href = 'admin.php';
            }         
          </script>";
              } else {
                header("Refresh:3; url=admin.php");
                echo "<p> ¡Usuario editado con éxito!. Redirigiendo...</p>";
                echo "<p> Si no redirige puedes hacer <a href='admin.php'>click aquí</a></p>";
              }
            }
          }
        }
      }
      else if(isset($_GET['peluquero'])){
        if ($user_nivel <= 5) {
            echo "<p><strong>Error: </strong>¡No tienes permisos para editar al usuario!</p>";
        } else {
          $user = htmlspecialchars($_GET['peluquero']);
          $rolnuevo = htmlspecialchars($_GET['rol']);

          //* ELIMINAR CITAS DEL PELUQUERO
          $b = "DELETE FROM citas WHERE peluquero = '{$user}'";
          $b= mysqli_query($mysqli, $b);

          $query = "UPDATE usuarios SET rol = '{$rolnuevo}' WHERE id = {$user}";
            if (isset($_GET['pass'])) {
              $pass = htmlspecialchars($_GET['pass']);
              $pass_hash = password_hash($pass, PASSWORD_DEFAULT);

              $query = "UPDATE usuarios SET rol = '{$rolnuevo}', contrasena = '{$pass_hash}' WHERE id = {$user}";
            }

            $a = mysqli_query($mysqli, $query);
            if (!$a) {
              echo "<p><strong>Error: </strong>Algo ha ido mal editando al usuario: " . mysqli_error($mysqli) . "</p>";
            } else {
              if (isset($_GET['pass'])) {
                echo "<p> ¡Usuario editado con éxito!.</p>";
                echo "
          <script>
            if (confirm('La nueva contraseña del usuario $username es: $pass')) {
              location.href = 'admin.php';
            }else{
              location.href = 'admin.php';
            }         
          </script>";
              } else {
                header("Refresh:3; url=admin.php");
                echo "<p> ¡Usuario editado con éxito!. Redirigiendo...</p>";
                echo "<p> Si no redirige puedes hacer <a href='admin.php'>click aquí</a></p>";
              }
            }
        }
     }
      ?> 
    </div>
  </form>
</div>
<script>
    function peluquero(id, rol) {
        if(confirm("Este usuario es peluquero. ¿Desea eliminar todas sus citas también?")){
            location.href = `editar_user.php?peluquero=${id}&rol=${rol}`;
        }else{
            location.href = `admin.php`;
        }
    }
    function peluquero2(id, rol, pass) {
        if(confirm("Este usuario es peluquero. ¿Desea eliminar todas sus citas también?")){
            location.href = `editar_user.php?peluquero=${id}&rol=${rol}&pass=${pass}`;
        }else{
            location.href = `admin.php`;
        }
    }
    <?php 
        if($espeluquero){
          if($respass){
            echo "peluquero2($user, $rolnuevo, '$pass');";
          }else{
            echo "peluquero($user, $rolnuevo);";
          }
        }
    ?>
</script>
<?php include "components/footer.php" ?>