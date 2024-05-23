<?php include "components/header.php" ?>
<?php include "components/navbar.php" ?>

<?php
session_start();
if ($nivel <= 5) {
    $pagina = $_SERVER['HTTP_REFERER'];
    header("Location: $pagina");
}

/*
    id INT PRIMARY KEY AUTO_INCREMENT,
    id VARCHAR(255),
    username VARCHAR(50) NOT NULL,
    contrasena VARCHAR(255),
    correo VARCHAR(255) NOT NULL,
    nombre VARCHAR(255) NOT NULL,
    apellidos VARCHAR(255) NOT NULL,
    rol INT DEFAULT 0,
    foto VARCHAR(255) DEFAULT "images/defecto.png"
*/
?>
<div class="centro">
    <div class="container">
        <h2>Usuarios</h2>
        <table>
            <thead>
                <th>FOTO</th>
                <th>ID</th>
                <th>USERNAME</th>
                <th>CORREO</th>
                <th>NOMBRE</th>
                <th>APELLIDOS</th>
                <th>ROL</th>
                <th colspan="2">OPERACIONES</th>
            </thead>
            <tbody>
        <?php
        $a="SELECT * FROM usuarios;";     
        $a = mysqli_query($mysqli, $a);
    
        while($row = mysqli_fetch_assoc($a)){
            $id = $row['id'];
            $user_id = $row['user_id'];
            $username = $row['username'];
            $correo = $row['correo'];
            $nombre = $row['nombre'];
            $apellidos = $row['apellidos'];
            $rol = $row['rol'];
            $foto = $row['foto'];
            if($user_id != $id){
                echo "<tr>";
                echo `
                    <td class="image"><img src="$foto" alt="foto"></td>
                    <td class="id">$id</td>
                    <td class="username">$username</td>
                    <td class="correo">$correo</td>
                    <td class="nombre">$nombre</td>
                    <td class="apellidos">$apellidos</td>
                    <td class="rol">$rol</td>
    
                    <td class="editar"><a href='editar_rol.php?user={$id}'><i class='bi bi-pencil'></i></a></td>
                    <td class="citas"><a href='editar_citas.php?user={$id}'><i class='bi bi-calendar-event-fill'></i></a></td>
                    `;
                echo "</tr>";
            }
        }
        ?>
            </tbody>
        </table>
    </div>
</div>


<?php include "components/footer.php" ?>