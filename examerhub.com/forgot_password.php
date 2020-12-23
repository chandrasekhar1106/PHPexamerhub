<html>
<body>
<head>
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" >

<!-- Optional theme -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" >

<link rel="stylesheet" href="styles.css" >

<!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<div class="container">
<form class="form-signin" method="POST">
        <h2 class="form-signin-heading">Forgot Password</h2>
        <div class="input-group">
	  <span class="input-group-addon" id="basic-addon1">@</span>
	  <input type="text" name="username" class="form-control" placeholder="Username" required>
	</div>
	<br />
        <button class="btn btn-lg btn-primary btn-block" type="submit">Forgot Password</button>
        <a class="btn btn-lg btn-primary btn-block" href="login.php">Login</a>
		<?php 
if(isset($_POST['submit'])){
// check for valid email address
$email = $_POST['email'];

if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
     $error[] = 'Please enter a valid email address';
}

// checks if the username is in use

$check = $mysqli->query("SELECT emailid FROM student WHERE emailid = '$email'");
$check2 = $check->num_rows;

//if the name exists it gives an error
if ($check2 == 0) {
$error[] = 'Sorry, Your emails doesn't exists in our record;
}
		
		
      </form>
	  </div>
	  </body>
	  </html>
	  <style>
	  body {
  padding-top: 40px;
  padding-bottom: 40px;
  background-color: #eee;
}

.form-signin {
  max-width: 330px;
  padding: 15px;
  margin: 0 auto;
}
.form-signin .form-signin-heading,
.form-signin .checkbox {
  margin-bottom: 10px;
}
.form-signin .checkbox {
  font-weight: normal;
}
.form-signin .form-control {
  position: relative;
  height: auto;
  -webkit-box-sizing: border-box;
     -moz-box-sizing: border-box;
          box-sizing: border-box;
  padding: 10px;
  font-size: 16px;
}
.form-signin .form-control:focus {
  z-index: 2;
}
.form-signin input[type="email"] {
  margin-bottom: -1px;
  border-bottom-right-radius: 0;
  border-bottom-left-radius: 0;
}
.form-signin input[type="password"] {
  margin-bottom: 10px;
  border-top-left-radius: 0;
  border-top-right-radius: 0;
}
	  
	  </style>