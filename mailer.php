<?php

//This file sends email to someone through an external service (e.g. gmail)

include_once("config.php");
date_default_timezone_set("America/New_York");
require 'PHPMailer/PHPMailerAutoload.php';

if(!isset($to))
	$to = '';

if(!isset($songId))
	$songId=2;

$attachment = "songs/$songId.zip"; 


$mail = new PHPMailer();
$mail->isSMTP();
//Enable SMTP debugging
// 0 = off (for production use)
// 1 = client messages
// 2 = client and server messages
$mail->SMTPDebug = 0;
//Ask for HTML-friendly debug output
$mail->Debugoutput = 'html';
$mail->Host = 'smtp.gmail.com';



$body = "Thank you for choosing to receive your song through SafeDelivery! Your song is attached.";
$subject = 'SafeDelivery: Your song';

$mail->Port = 587;
$mail->SMTPSecure = 'tls';
$mail->SMTPAuth = true;
$mail->Username = SAFEDELIVERY_UNAME;
$mail->Password = SAFEDELIVERY_PWD;
$mail->setFrom(SAFEDELIVERY_UNAME, 'Safe Delivery');
$mail->addReplyTo(SAFEDELIVERY_UNAME, 'Safe Delivery');
$mail->addAddress($to, '');
$mail->Subject = $subject;
$mail->msgHTML($body, dirname(__FILE__));
$mail->AltBody = 'You must enable HTML email to read this message.';
$mail->addAttachment($attachment);

$res = $mail->send();

//die; // remove if debug

if(!$res) {
    echo "Mailer Error: " . $mail->ErrorInfo;
} else {
    echo "Message sent!";
}
?>
