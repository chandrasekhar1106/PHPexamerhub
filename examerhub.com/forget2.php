<?php
session_start();

//============= Variables for Database ===================
$hostname = “localhost”;
$username = “root”;
$password = “”;
$database = “examerhub”;
//========================================================

//Connection…
$link = mysql_connect($hostname, $username, $password);

//Set Database
mysql_select_db($database,$link);

//Read Form Data from Page1
$u = $_POST[’email’];

$query = “select * from student where emailid=’$u'”;
$result = mysql_query($query);

$row = mysql_fetch_array($result);
$toemailaddress=$row[’email’];
$password=$row[‘password’];

ini_set(‘display_errors’, 1);
error_reporting(~0);

$toemailaddress = “”;
$subjectline = “Check email for Your Password”;
$body =”Your Password is : “.$password;

ob_start();
require_once(‘./class.phpmailer.php’);
$mail = new PHPMailer();
$mail->IsSMTP();
$mail->CharSet=”UTF-8”;
$mail->SMTPSecure = ‘ssl’;
$mail->Host = ‘smtp.gmail.com’;
$mail->Port = 465;
$mail->Username = ‘you@gmail.com’;
$mail->Password = ‘gmailpassword’;
$mail->SMTPAuth = true;

$mail->From = ‘From Email Address’;
$mail->FromName = ‘From Name’;
$mail->AddAddress(“$toemailaddress”);

$mail->IsHTML(true);
$mail->Subject    = “$subjectline”;
$mail->AltBody    = “To Read Email use HTML View”;
$mail->Body    = “$body”;

$t = $mail->Send();
//echo $t;
$_SESSION[‘msg’]=”Check email for password”;
header(‘Location: forget.php’);

?>