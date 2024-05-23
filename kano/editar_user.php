<?php include "components/header.php" ?>
<?php include "components/navbar.php" ?>

<?php
if (isset($_GET['user'])) {
    $id = htmlspecialchars($_GET['user']);
    if ($user_nivel > 5) {
        $a = "SELECT * FROM usuarios WHERE id=$id;";
        $a = mysqli_query($mysqli, $a);
        while ($row = mysqli_fetch_assoc($a)) {
            print_r($row);
        }
    } else {
        header("Location: index.php");
    }
}
?>
<?php include "components/footer.php" ?>