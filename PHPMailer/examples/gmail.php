<?php


if(!isset($to))
	$to = 'anochenson@gmail.com';

if(!isset($songId))
	$songId=2;

$attachment = "songs/$songId.zip"; 

date_default_timezone_set("America/New_York");

require '../PHPMailerAutoload.php';

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
$mail->Username = "safedeliveryservice1@gmail.com";
$mail->Password = "mturk12345";
$mail->setFrom('safedeliveryservice1@gmail.com', 'Safe Delivery');
$mail->addReplyTo('safedeliveryservice1@gmail.com', 'Safe Delivery');
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
