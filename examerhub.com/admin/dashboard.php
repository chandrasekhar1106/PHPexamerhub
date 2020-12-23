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
        }
		?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
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
<div class="container">
<div class = "col-md-4" >
<div class="card-base">
<div class="card-icon"><a href="sub.php" title="Manage Subject" id="widgetCardIcon" class="imagecard"><span class="glyphicon glyphicon-book" style="margin-top:20px;"></span></a>
<div class="card-data widgetCardData"  style="background-color:#34495E">
<h2 class="box-title" style="color:#ff3300; padding-top:30px; font-size:20px;">Manage Subject</h2>
<p class="card-block text-center"  style="padding-top:5px; color:#FFF;" >Here you can add subjects for exam.</p>
<br />
<a href="sub.php" title="Manage Subject" class="anchor btn btn-default" style="background:#3498DB; border: #3498DB; color:#FFF; "> <i   class="fa fa-paper-plane btnc" aria-hidden="true"></i>Click Here </a></div>
</div>
<div class="space"></div>
</div>
</div>
<div class = "col-md-4"   >
<div class="card-base">
<div class="card-icon"><a href="testm.php" title="Manage Test" id="widgetCardIcon" class="imagecard"><span class="glyphicon glyphicon-edit" style="margin-top:20px;"></span></a>
<div class="card-data widgetCardData" style="background-color:#34495E">
<h2 class="box-title" style="color:#ff3300;padding-top:30px; font-size:20px;">Manage Test</h2>
<p class="card-block text-center" style="padding-top:0px; color:#FFF;">Here you can add test for respected subject</p>
<br />
<a href="testm.php" title="Manage Test" class="anchor btn btn-default" style="background:#3498DB; border: #3498DB; color:#FFF;"> <i class="fa fa-paper-plane" aria-hidden="true" ></i> Click Here </a></div>
</div>
<div class="space"></div>
</div>
</div>

<div class = "col-md-4">
<div class="card-base">
<div class="card-icon"><a href="testm.php" title="Manage Question" id="widgetCardIcon" class="imagecard"><span class="glyphicon glyphicon-question-sign" style="margin-top:20px;"></span></a>
<div class="card-data widgetCardData"  style="background-color:#34495E">
<h2 class="box-title" style="color:#ff3300; padding-top:30px; font-size:20px;">Manage Question</h2>
<p class="card-block text-center" style="padding-top:4px; color:#FFF;">Here you can manage Question for related test.</p><br>
<a href="testm.php" title="Manage Question" class="anchor btn btn-default" style="background:#3498DB; border: #3498DB;color:#FFF;"> <i class="fa fa-paper-plane" aria-hidden="true"></i>  Click Here </a></div>
</div>
<div class="space"></div>
</div>
</div>
    
<div class = "col-md-4">
<div class="card-base">
<div class="card-icon"><a href="res.php" title="Manage Results" id="widgetCardIcon" class="imagecard"><span class="glyphicon glyphicon-check" style="margin-top:20px;"></span></a>
<div class="card-data widgetCardData"  style="background-color:#34495E">
<h2 class="box-title" style="color:#ff3300; padding-top:30px; font-size:20px;">Manage Results</h2>
<p class="card-block text-center" style="padding-top:8px; color:#FFF;">Here You can manage Results.</p>
<br />
<a href="res.php" title="Manage Results" class="anchor btn btn-default" style="background:#3498DB; border: #3498DB;color:#FFF;"> <i class="fa fa-paper-plane" aria-hidden="true"></i>  Click Here </a></div>
</div>
<div class="space"></div>
</div>
</div>

<div class = "col-md-4">
<div class="card-base">
<div class="card-icon"><a href="usr.php" title="Manage users" id="widgetCardIcon" class="imagecard"><span class="glyphicon glyphicon-user" style="margin-top:20px;"></span></a>
<div class="card-data widgetCardData"  style="background-color:#34495E">
<h2 class="box-title" style="color:#ff3300; padding-top:30px; font-size:20px;">Manage Users</h2>
<p class="card-block text-center" style="padding-top:8px; color:#FFF;">Here You can manage Users.</p>
<br />
<a href="usr.php" title="Manage Users" class="anchor btn btn-default" style="background:#3498DB; border: #3498DB;color:#FFF;"> <i class="fa fa-paper-plane" aria-hidden="true"></i>  Click Here </a></div>
</div>
<div class="space"></div>
</div>
</div>

<div class = "col-md-4" >
<div class="card-base">
<div class="card-icon"><a href="upload.php" title="Study Materials" id="widgetCardIcon" class="imagecard"><span class="	glyphicon glyphicon-book" style="margin-top:20px;"></a>
<div class="card-data widgetCardData"  style="background-color:#34495E">
<h2 class="box-title" style="color: #F00;padding-top:30px; font-size:20px;">Upload Question</h2>
<p class="card-block text-center" style="padding-top:13px; color:#FFF;">The questions and the file you want to upload must meet the guidelines detailed in this topic</p>
<br/>
<a href="upload.php" title="Study Materials" class="anchor btn btn-default" style="background:#3498DB; border: #3498DB;color:#FFF;"> <i class="fa fa-paper-plane" aria-hidden="true"></i>  Click Here </a></div>
</div>
<div class="space"></div>
</div>
</div>

<div class = "col-md-4" >
<div class="card-base">
<div class="card-icon"><a href="tutor_add.php" title="Study Materials" id="widgetCardIcon" class="imagecard"><span class="	glyphicon glyphicon-book" style="margin-top:20px;"></a>
<div class="card-data widgetCardData"  style="background-color:#34495E">
<h2 class="box-title" style="color: #F00;padding-top:30px; font-size:20px;">Add Tutor</h2>
<p class="card-block text-center" style="padding-top:13px; color:#FFF;">The questions and the file you want to upload must meet the guidelines detailed in this topic</p>
<br/>
<a href="tutor_add.php" title="Study Materials" class="anchor btn btn-default" style="background:#3498DB; border: #3498DB;color:#FFF;"> <i class="fa fa-paper-plane" aria-hidden="true"></i>  Click Here </a></div>
</div>
<div class="space"></div>
</div>
</div>
</div>
</form>

<br />
<div class="container-fluid">
<div class="panel panel-footer" style="background-color:#34495E">
<center><b><p style="font-size:100%; color:#FFF;">Copy right 2018 © All rights are reserved and designed by Parrovphins</p></b></center></p>
</div>
</div>
<?php
}
?>
</div>

<!-- JS Global Compulsory -->			
<script type="text/javascript" src="assets/custom/js/jquery-1.8.2.min.js"></script>
<script type="text/javascript" src="assets/custom/js/modernizr.custom.js"></script>		
<script type="text/javascript" src="assets/bootstrap/js/bootstrap.min.js"></script>	
<!-- JS Implementing Plugins -->           
<script type="text/javascript" src="assets/custom/js/jquery.flexslider-min.js"></script>
<script type="text/javascript" src="assets/custom/js/modernizr.js"></script>
<script type="text/javascript" src="assets/custom/js/jquery.cslider.js"></script> 
<script type="text/javascript" src="assets/custom/js/back-to-top.js"></script>
<script type="text/javascript" src="assets/custom/js/jquery.sticky.js"></script>
</body>
</html>