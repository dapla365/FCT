<?php 
require "../PHPMailer/src/Exception.php";
require "../PHPMailer/src/PHPMailer.php";
require "../PHPMailer/src/SMTP.php";
require "secret.php";
include "conexion.php";
include "firma.php";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if(isset($_GET['reset']) && isset($_GET['correo'])){

}
else if(isset($_GET['reserva']) && isset($_GET['correo']) && isset($_GET['fecha']) && isset($_GET['hora']) && isset($_GET['peluquero'])){
    $reserva = htmlspecialchars($_GET['reserva']);
    $correo = htmlspecialchars($_GET['correo']);
    $fecha = htmlspecialchars($_GET['fecha']);
    $hora = htmlspecialchars($_GET['hora']);
    $peluquero = htmlspecialchars($_GET['peluquero']);
    $peluquero_apellido = " ";

    $a = "SELECT * FROM usuarios WHERE id = $peluquero AND rol > 0 AND rol < 3;";
    $a = mysqli_query($mysqli, $a);
    if (mysqli_num_rows($a) > 0) {
        $rowa = mysqli_fetch_assoc($a);
        $peluquero = ucwords(strtolower($rowa['nombre']));
        $peluquero_apellido .= ucwords(strtolower($rowa['apellidos']));
    }
    $mail= new PHPMailer();
    $mail->isSMTP();
    $mail->Host="smtp.gmail.com";
    $mail->Port=465;
    $mail->SMTPDebug = "0";
    $mail->SMTPSecure = "ssl";
    $mail->SMTPAuth=true;
    $mail->Username="$mail_email";
    $mail->Password="$mail_password";
    $mail->setFrom("$mail_email","$mail_name");
    $mail->addAddress("$correo");
    $mail->Subject="KANO - Confirmacion de cita";

    $enlace = "$mail_cancel_url?reserva=$reserva";
    $msg = "
    <h2>Datos de la cita</h2>
    <p>Fecha: <strong>$fecha</strong></p>
    <p>Hora: <strong>$hora</strong></p>
    <p>Peluquero: <strong>$peluquero $peluquero_apellido</strong></p>
    <p>Para cancelar la cita, haz click en el siguiente enlace: $enlace</p>
    ";

    $mail->Body=$msg.$firma;
    $mail->isHTML(true);

    if(!$mail->send()){echo $mail->ErrorInfo;}
    else {
        header("Location:../confirmarCita.php?confirmado=true");
    }

}else{
    header("Location: ../index.php");
}
?>

