<?php include "components/header.php" ?>
<?php include "components/navbar.php" ?>
<?php
session_start();
if ($user_nivel <= 5) {
    header("Location: index.php");
}

//TODO AÑADIR FILTRO DE BUSQUEDA
?>
<div class="centro">
    <div class="container">
        <h2>Usuarios</h2>
        <table>
            <thead>
                <tr>
                    <th scope='col'>FOTO</th>
                    <th scope='col'><a href="
                    <?php
                    $enlace = "admin.php?orderby=id";
                    if (htmlspecialchars($_GET["orderby"]) == "id") {
                        if (htmlspecialchars($_GET["type"]) == "DESC") {
                            $enlace .= "&type=ASC";
                        } else {
                            $enlace .= "&type=DESC";
                        }
                    }
                    echo $enlace;
                    ?>">ID
                            <?php
                            if (htmlspecialchars($_GET["orderby"]) == "id") {
                                if (htmlspecialchars($_GET["type"]) == "DESC") {
                                    echo "<i class='bi bi-arrow-up'></i>";
                                } else {
                                    echo "<i class='bi bi-arrow-down'></i>";
                                }
                            } ?></a></th>
                    <th scope='col'><a href="<?php
                                                $enlace = "admin.php?orderby=username";
                                                if (htmlspecialchars($_GET["orderby"]) == "username") {
                                                    if (htmlspecialchars($_GET["type"]) == "DESC") {
                                                        $enlace .= "&type=ASC";
                                                    } else {
                                                        $enlace .= "&type=DESC";
                                                    }
                                                }
                                                echo $enlace;
                                                ?>">USERNAME
                            <?php
                            if (htmlspecialchars($_GET["orderby"]) == "username") {
                                if (htmlspecialchars($_GET["type"]) == "DESC") {
                                    echo "<i class='bi bi-arrow-up'></i>";
                                } else {
                                    echo "<i class='bi bi-arrow-down'></i>";
                                }
                            } ?></a></th>
                    <th scope='col'><a href="<?php
                                                $enlace = "admin.php?orderby=correo";
                                                if (htmlspecialchars($_GET["orderby"]) == "correo") {
                                                    if (htmlspecialchars($_GET["type"]) == "DESC") {
                                                        $enlace .= "&type=ASC";
                                                    } else {
                                                        $enlace .= "&type=DESC";
                                                    }
                                                }
                                                echo $enlace;
                                                ?>">CORREO
                            <?php
                            if (htmlspecialchars($_GET["orderby"]) == "correo") {
                                if (htmlspecialchars($_GET["type"]) == "DESC") {
                                    echo "<i class='bi bi-arrow-up'></i>";
                                } else {
                                    echo "<i class='bi bi-arrow-down'></i>";
                                }
                            } ?></a></th>
                    <th scope='col'><a href="<?php
                                                $enlace = "admin.php?orderby=nombre";
                                                if (htmlspecialchars($_GET["orderby"]) == "nombre") {
                                                    if (htmlspecialchars($_GET["type"]) == "DESC") {
                                                        $enlace .= "&type=ASC";
                                                    } else {
                                                        $enlace .= "&type=DESC";
                                                    }
                                                }
                                                echo $enlace;
                                                ?>">NOMBRE
                            <?php
                            if (htmlspecialchars($_GET["orderby"]) == "nombre") {
                                if (htmlspecialchars($_GET["type"]) == "DESC") {
                                    echo "<i class='bi bi-arrow-up'></i>";
                                } else {
                                    echo "<i class='bi bi-arrow-down'></i>";
                                }
                            } ?></a></th>
                    <th scope='col'><a href="<?php
                                                $enlace = "admin.php?orderby=apellidos";
                                                if (htmlspecialchars($_GET["orderby"]) == "apellidos") {
                                                    if (htmlspecialchars($_GET["type"]) == "DESC") {
                                                        $enlace .= "&type=ASC";
                                                    } else {
                                                        $enlace .= "&type=DESC";
                                                    }
                                                }
                                                echo $enlace;
                                                ?>">APELLIDOS
                            <?php
                            if (htmlspecialchars($_GET["orderby"]) == "apellidos") {
                                if (htmlspecialchars($_GET["type"]) == "DESC") {
                                    echo "<i class='bi bi-arrow-up'></i>";
                                } else {
                                    echo "<i class='bi bi-arrow-down'></i>";
                                }
                            } ?></a></th>
                    <th scope='col'><a href="<?php
                                                $enlace = "admin.php?orderby=rol";
                                                if (htmlspecialchars($_GET["orderby"]) == "rol") {
                                                    if (htmlspecialchars($_GET["type"]) == "DESC") {
                                                        $enlace .= "&type=ASC";
                                                    } else {
                                                        $enlace .= "&type=DESC";
                                                    }
                                                }
                                                echo $enlace;
                                                ?>">ROL
                            <?php
                            if (htmlspecialchars($_GET["orderby"]) == "rol") {
                                if (htmlspecialchars($_GET["type"]) == "DESC") {
                                    echo "<i class='bi bi-arrow-up'></i>";
                                } else {
                                    echo "<i class='bi bi-arrow-down'></i>";
                                }
                            } ?></a></th>
                    <th scope='col'>OPERACIONES</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if (isset($_GET["orderby"]) && isset($_GET["type"])) {
                    $orden = htmlspecialchars($_GET["orderby"]);
                    $type = htmlspecialchars($_GET["type"]);
                    $a = "SELECT * FROM usuarios ORDER BY $orden $type;";
                    $a = mysqli_query($mysqli, $a);
                    while ($row = mysqli_fetch_assoc($a)) {

                        $id = $row['id'];
                        $user_id_new = $row['user_id'];
                        $username = $row['username'];
                        $correo = $row['correo'];
                        $nombre = $row['nombre'];
                        $apellidos = $row['apellidos'];
                        $rol = $row['rol'];
                        $foto = $row['foto'];

                        $b = "SELECT * FROM roles WHERE id=$rol;";
                        $b = mysqli_query($mysqli, $b);
                        $rowb = mysqli_fetch_assoc($b);
                        $rol_name = $rowb["nombre"];


                        if ($rol > 0 && $rol < 3) {
                            echo
                            "<tr> 
                        <td class='image'><img src='$foto' alt='foto' style='width: 100px'></td>
                        <td class='id'>$id</td>
                        <td class='username'>$username</td>
                        <td class='correo'>$correo</td>
                        <td class='nombre'>$nombre</td>
                        <td class='apellidos'>$apellidos</td>
                        <td class='rol'>$rol_name</td>

                        <td class='editar'>
                            <a href='editar_user.php?user={$id}'><i class='bi bi-pencil-fill'></i></a>
                            <a href='editar_citas.php?user={$id}'><i class='bi bi-calendar-event-fill'></i></a>
                            <a href='cambiarHorario.php?user={$id}'><i class='bi bi-calendar2-date-fill'></i></a>
                            <a onclick='eliminarUsuario($id)'><i class='bi bi-trash-fill'></i></a>  
                        </td>
                    </tr>";
                        } else {
                            echo
                            "<tr> 
                        <td class='image'><img src='$foto' alt='foto' style='width: 100px'></td>
                        <td class='id'>$id</td>
                        <td class='username'>$username</td>
                        <td class='correo'>$correo</td>
                        <td class='nombre'>$nombre</td>
                        <td class='apellidos'>$apellidos</td>
                        <td class='rol'>$rol_name</td>

                        <td class='editar'>
                            <a href='editar_user.php?user={$id}'><i class='bi bi-pencil-fill'></i></a>
                            <a href='editar_citas.php?user={$id}'><i class='bi bi-calendar-event-fill'></i></a>
                            <a onclick='eliminarUsuario($id)'><i class='bi bi-trash-fill'></i></a>  
                        </td>
                    </tr>";
                        }
                    }
                } else {
                    $a = "SELECT * FROM usuarios;";
                    $a = mysqli_query($mysqli, $a);
                    while ($row = mysqli_fetch_assoc($a)) {

                        $id = $row['id'];
                        $user_id_new = $row['user_id'];
                        $username = $row['username'];
                        $correo = $row['correo'];
                        $nombre = $row['nombre'];
                        $apellidos = $row['apellidos'];
                        $rol = $row['rol'];
                        $foto = $row['foto'];

                        $b = "SELECT * FROM roles WHERE id=$rol;";
                        $b = mysqli_query($mysqli, $b);
                        $rowb = mysqli_fetch_assoc($b);
                        $rol_name = $rowb["nombre"];

                        if ($rol > 0 && $rol < 3) {
                            echo
                            "<tr> 
                        <td class='image'><img src='$foto' alt='foto' style='width: 100px'></td>
                        <td class='id'>$id</td>
                        <td class='username'>$username</td>
                        <td class='correo'>$correo</td>
                        <td class='nombre'>$nombre</td>
                        <td class='apellidos'>$apellidos</td>
                        <td class='rol'>$rol_name</td>

                        <td class='editar'>
                            <a href='editar_user.php?user={$id}'><i class='bi bi-pencil-fill'></i></a>
                            <a href='editar_citas.php?user={$id}'><i class='bi bi-calendar-event-fill'></i></a>
                            <a href='cambiarHorario.php?user={$id}'><i class='bi bi-calendar2-date-fill'></i></a>
                            <a onclick='eliminarUsuario($id)'><i class='bi bi-trash-fill'></i></a>  
                        </td>
                    </tr>";
                        } else {
                            echo
                            "<tr> 
                        <td class='image'><img src='$foto' alt='foto' style='width: 100px'></td>
                        <td class='id'>$id</td>
                        <td class='username'>$username</td>
                        <td class='correo'>$correo</td>
                        <td class='nombre'>$nombre</td>
                        <td class='apellidos'>$apellidos</td>
                        <td class='rol'>$rol_name</td>

                        <td class='editar'>
                            <a href='editar_user.php?user={$id}'><i class='bi bi-pencil-fill'></i></a>
                            <a href='editar_citas.php?user={$id}'><i class='bi bi-calendar-event-fill'></i></a>
                            <a onclick='eliminarUsuario($id)'><i class='bi bi-trash-fill'></i></a>  
                        </td>
                    </tr>";
                        }
                    }
                }
                ?>
            </tbody>
        </table>
        <div class="agregarUsuarios"><button onclick="window.location.href = 'registerAdmin.php';">Agregar usuario</button></div>
    </div>
</div>
<script>
    function eliminarUsuario(id) {
        if (confirm("¿Estás seguro de que quieres eliminar este usuario?")) {
            window.location.href = "components/eliminar_usuario.php?user=" + id;
        } else {
            return false;
        }
    }
</script>

<?php include "components/footer.php" ?>