<?php
error_reporting(0);
session_start();
        if(!isset($_SESSION['admname'])){
            $_GLOBALS['message']="Session Timeout.Click here to <a href=\"index.php\">Re-LogIn</a>";
        }
        else if(isset($_REQUEST['logout'])){
           unset($_SESSION['admname']);
            $_GLOBALS['message']="You are Loggged Out Successfully.";
            header('Location: index.php');
        }else if (isset($_REQUEST['home'])) {

    header('Location: dashboard.php');
}
		?>


<?php
$conn=new PDO('mysql:host=localhost; dbname=examerhub', 'root', '') or die(mysql_error());
if(isset($_POST['submit'])!=""){
  $name=$_FILES['photo']['name'];
  $size=$_FILES['photo']['size'];
  $type=$_FILES['photo']['type'];
  $temp=$_FILES['photo']['tmp_name'];
  $caption1=$_POST['caption'];
  $link=$_POST['link'];
  move_uploaded_file($temp,"files/".$name);
$query=$conn->query("insert into upload(name)values('$name')");
if($query){
header("location:upload.php");
}
else{
die(mysql_error());
}
}
?>
<html>
<head>

<title>Admin Dashboard</title>
<link href="menu.css" rel="stylesheet"/>
<head></head><script src="menum.js"></script>
<link href="menu.css" rel="stylesheet"/>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-y3tfxAZXuh4HwSYylfB+J125MxIs6mR5FOHamPBG064zB+AFeWH94NdvaCBm8qnd" crossorigin="anonymous">
<link href="assets/bootstrap/css/bootstrap.min.css" rel="stylesheet">
<link rel="icon" type="img/png" href="assets/custom/img/hat.png">
<link rel="stylesheet" href="assets/custom/css/flexslider.css" type="text/css" media="screen">    	
<link rel="stylesheet" href="assets/custom/css/parallax-slider.css" type="text/css">
<link rel="stylesheet" href="assets/font-awesome-4.0.3/css/font-awesome.min.css" type="text/css">
<script type="text/javascript" src="../examerHub/menu.js"></script>
<link  rel="stylesheet" href="style.css" type="text/css">
<!-- Custom styles for this template -->
<link href="assets/custom/css/business-plate.css" rel="stylesheet">
<link rel="shortcut icon" href="assets/custom/ico/favicon.ico">
</head>

<link href="css/bootstrap.css" rel="stylesheet" type="text/css" media="screen">
<link rel="stylesheet" type="text/css" href="css/DT_bootstrap.css">
<script src="js/jquery.js" type="text/javascript"></script>
<script src="js/bootstrap.js" type="text/javascript"></script>
<script type="text/javascript" charset="utf-8" language="javascript" src="js/jquery.dataTables.js"></script>
<script type="text/javascript" charset="utf-8" language="javascript" src="js/DT_bootstrap.js"></script>
</head>
<body>
 <?php
      if(isset($_GLOBALS['message'])) {
            echo "<div class=\"message\">".$_GLOBALS['message']."</div>";
        }
        ?>
        <?php
if (isset($_SESSION['admname'])) {
// Navigations
?>
<form name="dashboard" action="dashboard.php" method="post">
<div class="container-fulid my-container">
	<div class="panel" style="background-color:#34495E">
		<div class="row">
			<div class="col-lg-6">
				<div class="pull-left">
				<img src="assets/custom/img/logo.jpg" class="img-responsive"  />
				</div>
			</div>
			<div class="col-lg-6">
				<div class="pull-right">
					<input type="submit" value="LogOut" name="logout"  title="Log Out" class="btn btn-link " onclick="return confirm('Are you sure you want to Logout');"/>
					<input type="submit" value="Home" name="home"  title="Home" class="btn btn-link " />
				</div>
			</div>
		</div>
		<br />
	</div>
</div>
<?php
}?>

<?php
if (isset($_SESSION['admname'])) {
// Navigations
?>
	    <div class="row-fluid">
	        <div class="span12">
	            <div class="container">
		<br/>
		<br/>
		<br/>
			<form enctype="multipart/form-data" action="" name="form" method="post">
				Select File
					<input type="file" class="btn" name="photo" id="photo" /></td><br>
					
					<input type="submit" class="btn btn-primary" name="submit" id="submit" value="Submit" />
			
			</form>
		<br/>
		<br/>
		
	</div>
	</div>
	</div>
	<br/>
	
<div class="container-fluid">
<div class="panel panel-footer" style="background-color:#34495E">
<center><b><p style="font-size:100%; color:#FFF;">Copy right 2018 © All rights are reserved and designed by Parrovphins</p></b></center></p>
</div>
</div>
<?php
}
?>
</div>

	
	
</body>
</html>