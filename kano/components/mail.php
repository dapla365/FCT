<?php 
require "../PHPMailer/src/Exception.php";
require "../PHPMailer/src/PHPMailer.php";
require "../PHPMailer/src/SMTP.php";
require "secret.php";
include "conexion.php";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if(isset($_GET['reset']) && isset($_GET['correo'])){

}
else if(isset($_GET['correo']) && isset($_GET['fecha']) && isset($_GET['hora']) && isset($_GET['peluquero'])){
    $correo = htmlspecialchars($_GET['correo']);
    $fecha = htmlspecialchars($_GET['fecha']);
    $hora = htmlspecialchars($_GET['hora']);
    $peluquero = htmlspecialchars($_GET['peluquero']);
    $peluquero_apellido = " ";

    $a = "SELECT * FROM usuarios WHERE id = $peluquero AND rol > 0 AND rol < 3;";
    $a = mysqli_query($mysqli, $a);
    if (mysqli_num_rows($a) > 0) {
        $rowa = mysqli_fetch_assoc($a);
        $peluquero = ucwords(mb_strtolower($rowa['nombre']));
        $peluquero_apellido .= ucwords(mb_strtolower($rowa['apellidos']));
    }
    $mail= new PHPMailer();
    $mail->isSMTP();
    $mail->Host="smtp.gmail.com";
    $mail->Port=465;
    $mail->SMTPDebug = "0";
    $mail->SMTPSecure = "ssl";
    $mail->SMTPAuth=true;
    $mail->Username="davidplaza03@iesamachado.org";
    $mail->Password="$mail_password";
    $mail->setFrom("davidplaza03@iesamachado.org","David Plaza");
    $mail->addAddress("$correo");
    $mail->Subject="KANO - Confirmacion de cita";

    $msg = "
    <h2>Datos de la cita</h2>7
    <p>Fecha: <strong>$fecha</strong></p>
    <p>Hora: <strong>$hora</strong></p>
    <p>Peluquero: <strong>$peluquero $peluquero_apellido</strong></p>
    ";

    $mail->Body=$msg;
    $mail->isHTML(true);

    if(!$mail->send()){echo $mail->ErrorInfo;}
    else {
        header("Location:../confirmarCita.php?confirmado=true");
    }

}else{
    header("Location: ../index.php");
}

/*

$mail= new PHPMailer();
$mail->isSMTP();
$mail->Host="smtp.gmail.com";
$mail->Port=465;
$mail->SMTPDebug = "0";
$mail->SMTPSecure = "ssl";
$mail->SMTPAuth=true;
$mail->Username="davidplaza03@iesamachado.org";
$mail->Password="$mail_password";
$mail->setFrom("davidplaza03@iesamachado.org","David Plaza");
$mail->addAddress("plazadiazdavid@gmail.com","David");
$mail->Subject="OLEEEE";
$mail->msgHTML("Hola soy un mensaje");

if(!$mail->send()){echo $mail->ErrorInfo;}
else {
    echo "Correo enviado correctamente!";
}
*/
?>

