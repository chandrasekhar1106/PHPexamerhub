<?php

require 'PHPMailer/PHPMailerAutoload.php';
$mail = new PHPMailer();
$mail->Host = 'smtp.gmail.com';
$mail->SMTPAuth = 'true';
$mail->Username = 'salian.nisha94@gmail.com';
$mail->Password = 'saanvi24salian';
$mail->SMTPSecure = 'tls';
$mail->Port = 587;
$mail->SetFrom='salian.nisha94@gmail.com';
$mail->FromName='Nisha S';
$mail->addAddress($row["email"]);
//$mail->addReplyTo('Noreply@','');
$mail->isHTML(true);
$mail->Subject='Test mail';
$mail->Body = 'This is your password <br><h1> Hello</h1>';
//$mail->AltBody = "This is plain text version of the email content";
if($mail->send())
{
	echo 'Mail Sent';
}
else
{
	echo "Mail Sending Failed";
}
?>
