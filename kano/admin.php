<?php include "components/header.php" ?>
<?php include "components/navbar.php" ?>
<?php
session_start();
if ($user_nivel <= 5) {
    header("Location: index.php");
}
if (isset($_GET['filtro'])) {
    $filtro = htmlspecialchars($_GET['filtro']);
} else {
    $filtro = null;
}

?>
<div class="centro">
    <div class="container">
        <h2>Usuarios</h2>

        <div class="panel">
            <div class="panel-heading">
                <span>Filtrar </span>
                <input id="filtro" type="text">
                <?php 
                    if($filtro != null) {
                        echo "<i onclick='location.href = `admin.php`' class='bi bi-x-circle-fill'></i>";
                    }
                ?>
            </div>
        </div>

        <table>
            <thead>
                <tr>
                    <th scope='col'>FOTO</th>
                    <th scope='col'><a href="
                    <?php
                    $enlace = "admin.php?orderby=id";
                    if ($filtro != null) {
                        $enlace .= "&filtro=" . $filtro;
                    }
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
                                                if ($filtro != null) {
                                                    $enlace .= "&filtro=" . $filtro;
                                                }
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
                                                if ($filtro != null) {
                                                    $enlace .= "&filtro=" . $filtro;
                                                }
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
                                                if ($filtro != null) {
                                                    $enlace .= "&filtro=" . $filtro;
                                                }
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
                                                if ($filtro != null) {
                                                    $enlace .= "&filtro=" . $filtro;
                                                }
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
                                                if ($filtro != null) {
                                                    $enlace .= "&filtro=" . $filtro;
                                                }
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
                function contains_all_letters($filter, $haystack)
                {
                    // Convierte ambas cadenas a minúsculas para una comparación insensible a mayúsculas/minúsculas
                    $haystack = strtolower($haystack);
                    $filter = strtolower($filter);

                    // Recorre cada letra del filtro
                    foreach (str_split($filter) as $letter) {
                        // Si una letra del filtro no está presente en la cadena, devuelve false
                        if (strpos($haystack, $letter) === false) {
                            return false;
                        }
                    }
                    return true;
                }


                if (isset($_GET["orderby"]) && isset($_GET["type"])) {
                    //! CON ORDEN 
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
                            if (isset($_GET['filtro'])) {
                                $filtro = htmlspecialchars($_GET['filtro']);
                                $filtro = strtolower($filtro);
                                if (
                                    contains_all_letters($filtro, strtolower($username)) || contains_all_letters($filtro, strtolower($correo))
                                    || contains_all_letters($filtro, strtolower($nombre)) || contains_all_letters($filtro, strtolower($apellidos))
                                    || contains_all_letters($filtro, strtolower($rol_name))
                                ) {
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
                                            <a href='reservas.php?user={$id}'><i class='bi bi-calendar-event-fill'></i></a>
                                            <a href='cambiarHorario.php?user={$id}'><i class='bi bi-calendar2-date-fill'></i></a>
                                            <a onclick='eliminarUsuario($id)'><i class='bi bi-trash-fill'></i></a>  
                                        </td>
                                    </tr>";
                                }
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
                                        <a href='reservas.php?user={$id}'><i class='bi bi-calendar-event-fill'></i></a>
                                        <a href='cambiarHorario.php?user={$id}'><i class='bi bi-calendar2-date-fill'></i></a>
                                        <a onclick='eliminarUsuario($id)'><i class='bi bi-trash-fill'></i></a>  
                                    </td>
                                </tr>";
                            }
                        } else {
                            if (isset($_GET['filtro'])) {
                                $filtro = htmlspecialchars($_GET['filtro']);
                                $filtro = strtolower($filtro);
                                if (
                                    contains_all_letters($filtro, strtolower($username)) || contains_all_letters($filtro, strtolower($correo))
                                    || contains_all_letters($filtro, strtolower($nombre)) || contains_all_letters($filtro, strtolower($apellidos))
                                    || contains_all_letters($filtro, strtolower($rol_name))
                                ) {
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
                                            <a href='reservas.php?user={$id}'><i class='bi bi-calendar-event-fill'></i></a>
                                            <a onclick='eliminarUsuario($id)'><i class='bi bi-trash-fill'></i></a>  
                                        </td>
                                    </tr>";
                                }
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
                                        <a href='reservas.php?user={$id}'><i class='bi bi-calendar-event-fill'></i></a>
                                        <a onclick='eliminarUsuario($id)'><i class='bi bi-trash-fill'></i></a>  
                                    </td>
                                </tr>";
                            }
                        }
                    }
                } else {
                    //! SIN ORDEN 
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
                            //! VISTA DE PELUQUERO 
                            if (isset($_GET['filtro'])) {
                                //! CON FILTRO 
                                $filtro = htmlspecialchars($_GET['filtro']);
                                $filtro = strtolower($filtro);
                                if (
                                    contains_all_letters($filtro, strtolower($username)) || contains_all_letters($filtro, strtolower($correo))
                                    || contains_all_letters($filtro, strtolower($nombre)) || contains_all_letters($filtro, strtolower($apellidos))
                                    || contains_all_letters($filtro, strtolower($rol_name))
                                ) {
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
                                            <a href='reservas.php?user={$id}'><i class='bi bi-calendar-event-fill'></i></a>
                                            <a href='cambiarHorario.php?user={$id}'><i class='bi bi-calendar2-date-fill'></i></a>
                                            <a onclick='eliminarUsuario($id)'><i class='bi bi-trash-fill'></i></a>  
                                        </td>
                                    </tr>";
                                }
                            } else {
                                //! SIN FILTRO 
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
                                        <a href='reservas.php?user={$id}'><i class='bi bi-calendar-event-fill'></i></a>
                                        <a href='cambiarHorario.php?user={$id}'><i class='bi bi-calendar2-date-fill'></i></a>
                                        <a onclick='eliminarUsuario($id)'><i class='bi bi-trash-fill'></i></a>  
                                    </td>
                                </tr>";
                            }
                        } else {
                            //! SIN SER PELUQUERO 
                            if (isset($_GET['filtro'])) {
                                //! CON FILTRO 
                                $filtro = htmlspecialchars($_GET['filtro']);
                                $filtro = strtolower($filtro);
                                if (
                                    contains_all_letters($filtro, strtolower($username)) || contains_all_letters($filtro, strtolower($correo))
                                    || contains_all_letters($filtro, strtolower($nombre)) || contains_all_letters($filtro, strtolower($apellidos))
                                    || contains_all_letters($filtro, strtolower($rol_name))
                                ) {
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
                                            <a href='reservas.php?user={$id}'><i class='bi bi-calendar-event-fill'></i></a>
                                            <a href='cambiarHorario.php?user={$id}'><i class='bi bi-calendar2-date-fill'></i></a>
                                            <a onclick='eliminarUsuario($id)'><i class='bi bi-trash-fill'></i></a>  
                                        </td>
                                    </tr>";
                                }
                            } else {
                                //! SIN FILTRO 
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
                                        <a href='reservas.php?user={$id}'><i class='bi bi-calendar-event-fill'></i></a>
                                        <a onclick='eliminarUsuario($id)'><i class='bi bi-trash-fill'></i></a>  
                                    </td>
                                </tr>";
                            }
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
    document.getElementById('filtro').addEventListener('keypress', function(event) {
        if (event.key === 'Enter') {
            event.preventDefault();
            let inputValue = document.getElementById('filtro').value;
            if (inputValue == "") {
                window.location.href = `admin.php`;
            } else {
                window.location.href = `admin.php?filtro=${encodeURIComponent(inputValue)}`;
            }
        }
    });
</script>

<?php include "components/footer.php" ?>