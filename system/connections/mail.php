<?php 
include_once("PHPMailer/class.phpmailer.php");
include_once("PHPMailer/class.smtp.php");

$mail = new PHPMailer();
$mail->IsSMTP();
//$mail->SMTPSecure = "ssl";
$mail->Host = "smtp.mailtrap.io";
//$mail->Port = 25;
$mail->Port = 465;
$mail->SMTPAuth = true;
$mail->Username = "e225ef29a5abae";
$mail->Password = "bfd5c5a28393c9";
//$mail->SMTPDebug = 1;

$mail->From = "soporte@d-spp.org";
$mail->FromName = "CERT - DSPP";
$mail->AddBCC("yasser.midnight@gmail.com", "correo Oculto");

$correoCert = "cert@spp.coop";


/*
$mail = new PHPMailer();
$mail->IsSMTP();
//$mail->SMTPSecure = "ssl";
$mail->Host = "mail.d-spp.org";
//$mail->Port = 25;
$mail->Port = 587;
$mail->SMTPAuth = true;
$mail->Username = "soporte@d-spp.org";
$mail->Password = "/aung5l6tZ";
$mail->SMTPDebug = 1;

$mail->From = "soporte@d-spp.org";
$mail->FromName = "CERT - DSPP";
$mail->AddBCC("yasser.midnight@gmail.com", "correo Oculto");

$correoCert = "cert@spp.coop";
*/
 ?>