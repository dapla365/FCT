
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

<footer></footer>
</body>
</html>