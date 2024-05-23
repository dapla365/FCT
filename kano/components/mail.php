<?php 
require "../PHPMailer/src/Exception.php";
require "../PHPMailer/src/PHPMailer.php";
require "../PHPMailer/src/SMTP.php";
require "secret.php";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
 
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


?>

