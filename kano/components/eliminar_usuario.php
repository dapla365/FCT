<?php include "user-data2.php" ?>

<?php 
     if(isset($_GET['user']))
     {
        $a = htmlspecialchars($_GET['user']);
        if($user_nivel > 5 && $user_id != $a){    
            $b = "SELECT * FROM usuarios WHERE id = '$a'";
            $b = mysqli_query($mysqli, $b);
            $rowb = mysqli_fetch_assoc($b);
            $rol = $rowb["rol"];
            if($rol > 1 && $rol < 4){
                $espeluquero = true;
            }else{
                $c= "DELETE FROM usuarios WHERE id = '{$a}'"; 
                $c= mysqli_query($mysqli, $c);

                $pagina = $_SERVER['HTTP_REFERER'];
                header("Location: $pagina");
            }
        }

     }
     else if(isset($_GET['peluquero'])){
        $a = htmlspecialchars($_GET['peluquero']);

        $b = "DELETE FROM citas WHERE usuario = '{$a}' OR peluquero = '{$a}'";
        $b= mysqli_query($mysqli, $b);

        $c= "DELETE FROM usuarios WHERE id = '{$a}'"; 
        $c= mysqli_query($mysqli, $c);

        header("Location: ../admin.php");
     }

?>

<script>
    function peluquero(id) {
        if(confirm("Este usuario es peluquero. ¿Desea eliminar todas sus citas también?")){
            location.href = `eliminar_usuario.php?peluquero=${id}`;
        }else{
            location.href = `../perfil.php`;
        }
    }
    <?php 
        if($espeluquero){
            echo "peluquero($a);";
        }
    ?>
</script>