<?php include "user-data2.php" ?>

<?php 
     if(isset($_GET['user']))
     {
        $a= htmlspecialchars($_GET['user']);
        if($user_nivel > 5 && $user_id != $a){      
            $c= "DELETE FROM usuarios WHERE id = '{$a}'"; 
            $c= mysqli_query($mysqli, $c);
        }
        $pagina = $_SERVER['HTTP_REFERER'];
        header("Location: $pagina");
     }

?>