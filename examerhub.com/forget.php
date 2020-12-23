<?php session_start() ?>
<html>
<head>
<title> Forgot Password Recovery by Email</title>
</head>
<body>

<h2> Forgot Password Recovery by Email</h2>

<form method=”post” action=”forget2.php”>
Enter Email address : <input type=”text” name=”email”>
<br><br>
<input type=”submit” value=”Send me Password”>
</form>
<br>
<?php
if(isset($_SESSION[‘msg’]))
{
echo $_SESSION[‘msg’];
unset($_SESSION[‘msg’]);
}
?>
</body>
</html>