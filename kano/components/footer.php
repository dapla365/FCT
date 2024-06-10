<?php
session_start();
if ($_SERVER['PHP_SELF'] != "") {
    $url = explode("/", $_SERVER['PHP_SELF']);
    $url = $url[2];
    if ($url != 'index.php') {
        echo '    
    <script src="js/navbar.js"></script>';
    }
}
?>

<footer style="position:fixed; left:0px; bottom:0px; width: 100%; display: flex; justify-content: space-between; align-content: center; padding: 20px; background: rgb(221, 221, 221);">
    <a style="text-decoration: none; color: #3d3d3d; font-weight: bold;" href="privacidad.php">Política de
        privacidad</a>
    <a style="text-decoration: none; color: #3d3d3d; font-weight: bold;" href="terminos.php">Términos de uso</a>
</footer>
</body>

</html>