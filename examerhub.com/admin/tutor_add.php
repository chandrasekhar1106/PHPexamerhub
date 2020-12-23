<?php
error_reporting(0);
session_start();
include_once '../database/connect.php';

if (!isset($_SESSION['admname'])) {
    $_GLOBALS['message'] = "Session Timeout.Click here to <a href=\"index.php\">Re-LogIn</a>";
} else if (isset($_REQUEST['logout'])) {

    unset($_SESSION['admname']);
    header('Location: index.php');
} 
else if (isset($_REQUEST['home'])) {

    header('Location: dashboard.php');
} else if (isset($_REQUEST['delete'])) {
 
    unset($_REQUEST['delete']);
    $hasvar = false;
    foreach ($_REQUEST as $variable) {
        if (is_numeric($variable)) { //it is because, some session values are also passed with request
            $hasvar = true;

            if (!@executeQuery("delete from tutor_add where id=$variable")) {
                if (mysql_errno () == 1451) //Children are dependent value
                    $_GLOBALS['message'] = "Too Prevent accidental deletions, system will not allow propagated deletions.<br/><b>Help:</b> If you still want to delete this subject, then first delete the tests that are conducted/dependent on this subject.";
                else
                    $_GLOBALS['message'] = mysql_errno();
            }
        }
    }
    if (!isset($_GLOBALS['message']) && $hasvar == true)
        $_GLOBALS['message'] = "Selected Tutor/s are successfully Deleted";
    else if (!$hasvar) {
        $_GLOBALS['message'] = "First Select the Tutor/s to be Deleted.";
    }
} else if (isset($_REQUEST['savem'])) {

    if (empty($_REQUEST['t_name']) || empty($_REQUEST['expertice']) || empty($_REQUEST['experience']) || empty($_REQUEST['contact'])) {
        $_GLOBALS['message'] = "Some of the required Fields are Empty.Therefore Nothing is Updated";
    } else {
        $query = "update tutor_add set t_name='" . htmlspecialchars($_REQUEST['t_name'], ENT_QUOTES) . "', expertice='" . htmlspecialchars($_REQUEST['expertice'], ENT_QUOTES) . "' , experience='" . htmlspecialchars($_REQUEST['experience'], ENT_QUOTES) . "' , contact='" . htmlspecialchars($_REQUEST['contact'], ENT_QUOTES) . "'where id=" . $_REQUEST['tutor_add'] . ";";
        if (!@executeQuery($query))
            $_GLOBALS['message'] = mysql_error();
        else
            $_GLOBALS['message'] = "Tutor Information is Successfully Updated.";
    }
    closedb();
}
else if (isset($_REQUEST['savea'])) {
  
    $result = executeQuery("select max(id) as sub from tutor_add");
    $r = mysql_fetch_array($result);
    if (is_null($r['sub']))
        $newstd = 1;
    else
        $newstd=$r['sub'] + 1;

    $result = executeQuery("select t_name as sub from tutor_add where t_name='" . htmlspecialchars($_REQUEST['t_name'], ENT_QUOTES) . "';");
    // $_GLOBALS['message']=$newstd;
    if (empty($_REQUEST['t_name']) || empty($_REQUEST['expertice']) || empty($_REQUEST['experience']) || empty($_REQUEST['contact'])) {
        $_GLOBALS['message'] = "Some of the required Fields are Empty";
    } else if (mysql_num_rows($result) > 0) {
        $_GLOBALS['message'] = "Sorry Tutor Already Exists.";
    } else {
        $query = "insert into tutor_add values($newstd,'" . htmlspecialchars($_REQUEST['t_name'], ENT_QUOTES) . "','" . htmlspecialchars($_REQUEST['expertice'], ENT_QUOTES) . "', '" . htmlspecialchars($_REQUEST['experience'], ENT_QUOTES) . "', '" . htmlspecialchars($_REQUEST['contact'], ENT_QUOTES) . "',NULL)";
        if (!@executeQuery($query)) {
            if (mysql_errno () == 1062) //duplicate value
                $_GLOBALS['message'] = "Given Tutor Name voilates some constraints, please try with some other name.";
            else
                $_GLOBALS['message'] = mysql_error();
        }
        else
            $_GLOBALS['message'] = "Successfully New Tutor is Created.";
    }
    closedb();
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Subject Management System</title>
</head>
<link href="assets/bootstrap/css/bootstrap.min.css" rel="stylesheet" />
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-y3tfxAZXuh4HwSYylfB+J125MxIs6mR5FOHamPBG064zB+AFeWH94NdvaCBm8qnd" crossorigin="anonymous">
<script type="text/javascript" src="../validate.js" ></script>
<link rel="icon" type="image/x-icon" href="assets/custom/img/hat.png">
<link href="menu.css" rel="stylesheet" />
<script src="menu.js"></script>
<script src="assets/bootstrap/js/bootstrap.min.js"></script>
<body>
<?php
if (isset($_SESSION['admname'])) {
// Navigations
?>
<div class="container-fluid navbar navbar-fixed-top" > <!--container starts-->
<div class="panel"  style="background-color:#34495E; " ><!-- panel starts-->
<form name="submng" action="tutor_add.php" method="post">
<div class="row" > <!--row for header logo and logout-->
<div class="col-lg-6"><!--column for header logo -->
<div class="pull-left">
<img src="assets/custom/img/logo.jpg" class="img-responsive"  />
</div>
</div>
<div class="col-lg-6"><!--column for header  logout-->
<div class="pull-right">
<input type="submit" value="LogOut" name="logout"  title="Log Out" class="btn btn-link " onclick="return confirm('Are you sure you want to Logout');"/>
<input type="submit" value="Home" name="home"  title="Home" class="btn btn-link " />
</div>
</div> <!--logout colum close-->
</div> <!--header row close-->
<div class="row hidden-sm hidden-xs" style="margin-bottom:-37px;" > <!--row for dropdown-->
<nav class="navbar navbar" role="navigation" >
<div class="container-fluid">
<!-- Brand and toggle get grouped for better mobile display -->
<div class="navbar-header">
<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-megadropdown-tabs">
<span class="sr-only">Toggle navigation</span>
<span class="icon-bar"></span>
<span class="icon-bar"></span>
<span class="icon-bar"></span>
</button>
<a class="navbar-brand" href="#"></a>
</div>
<!-- Collect the nav links, forms, and other content for toggling -->
<div class="collapse navbar-collapse" id="bs-megadropdown-tabs" >
<ul class="nav navbar-nav pull-left" >
<li class="dropdown mega-dropdown active" ></li>
<a href="#" class="dropdown-toggle btn btn-primary" data-toggle="dropdown"  >Dashboard <span class="caret"></span></a>	
<div class="dropdown-menu mega-dropdown-menu"  style="margin-left:10px; ">
<div class="container-fluid">
<!-- Tab panes -->
<div class="tab-content">
<div class="tab-pane active" id="practicetest">
<ul class="nav-list list-inline">
<li><a href="sub.php"><img src="assets/custom/img/subject.png" height="80" width="100"><span>Subject Management</span></a></li>
<li><a href="testm.php"><img src="assets/custom/img/test1.png" height="80" width="100"><span>Test Management</span></a></li>
<li><a href="testm.php"><img src="assets/custom/img/qtn1.jpg" height="80" width="100"><span>Question Management</span></a></li>
<li><a href="res.php"><img src="assets/custom/img/rslt.png" height="80" width="100"><span>Result Management</span></a></li>
<li><a href="usr.php"><img src="assets/custom/img/user.png" height="80" width="100"><span>User Management</span></a></li> 
<!-- <li><a href="studymaterial.php"><img src="assets/custom/img/study.jpg" height="80" width="150"><span>Study Material</span></a></li> -->  
</ul>
</div>
</div>
</div>
<!-- Nav tabs -->
</div>		
</li>
</ul>
<ul class="nav navbar-nav pull-right" style=" margin-right:30px;">
<?php
    //navigation for Add option
    if (isset($_REQUEST['add'])) {
?>
<input type="submit" value="Cancel" class="btn btn-primary" name="cancel" class="subbtn" title="Cancel"/>
<input type="submit" value="Save" class="btn btn-primary" name="savea"  onClick="validatesubform('submng')" title="Save the Changes"/>
<?php
    } else if (isset($_REQUEST['edit'])) { //navigation for Edit option
?>
<input type="submit" value="Cancel" name="cancel" class="btn btn-primary" title="Cancel"/>
<input type="submit" value="Save" name="savem" class="btn btn-primary" onClick="validatesubform('submng')" title="Save the changes"/>
<?php
    } else {  //navigation for Default
?>
<input type="submit" value="Add"  class="btn btn-primary" name="add" class="btn btn-primary" title="Add"/>
<input type="submit" value="Delete" name="delete" class="btn btn-primary" title="Delete"/>
<?php
}
} 
?>
</ul>
</div><!-- /.navbar-collapse -->
</div><!-- /.container-fluid -->
</nav> <!--nav close-->
</div> <!--row for menu close for lg and md-->
<!--menu for sm and xm-->
<div class="row hidden-lg hidden-md" style="margin-bottom:20px;">
<div class="dropdown pull-left btn btn-primary" style="margin-left:20px; color:#FFF;">
<a href="#" data-toggle="dropdown" class="dropdown-toggle" style="color:#FFF; ">Dashboard<b class="caret"></b></a>
<ul class="dropdown-menu">
<li><a href="sub.php"><img src="assets/custom/img/subject.png" width="50" height="30" />Subject Management</a></li>
<li><a href="testm.php"><img src="assets/custom/img/test1.png" width="50" height="30" style="margin-left:-40px;" />Test Management</a></li>
<li><a href="testm.php"><img src="assets/custom/img/qtn1.jpg" width="50" height="30"  />Question Management</a></li>
<li><a href="usr.php"><img src="assets/custom/img/user.png" width="50" height="30" style="margin-left:-30px;"  />User Management</a></li>
<!--  <li><a href="studymaterial.php"><img src="assets/custom/img/study.jpg" width="50" height="30"  style="margin-left:-40px;" />Study Material</a></li>-->
</ul>
</div>
<div class="pull-right" style="margin-right:20px;">
 <?php
    //navigation for Add option
    if (isset($_REQUEST['add'])) {
?>
<input type="submit" value="Cancel" class="btn btn-primary" name="cancel" class="subbtn" title="Cancel"/>
<input type="submit" value="Save" class="btn btn-primary" name="savea"  onClick="validatesubform('submng')" title="Save the Changes"/>
<input type="submit" value="LogOut" class="btn btn-primary" name="logout"  title="Log Out"/>
<?php
    } else if (isset($_REQUEST['edit'])) { //navigation for Edit option
?>
<input type="submit" value="Cancel" name="cancel" class="btn btn-primary" title="Cancel"/>
<input type="submit" value="Save" name="savem" class="btn btn-primary" onClick="validatesubform('submng')" title="Save the changes"/>
<input type="submit" value="LogOut" name="logout" class="btn btn-primary" title="Log Out"/>
<?php
    } else {  //navigation for Default
?>
<input type="submit" value="Add"  class="btn btn-primary" name="add" class="btn btn-primary" title="Add"/>
<input type="submit" value="Delete" name="delete" class="btn btn-primary" title="Delete"/>
<input type="submit" value="LogOut" name="logout" class="btn btn-primary" title="Log Out"/>
<?php 
}
?>
</div> 
</div> <!--menu for mobile close here-->
</div><!--mobile menu row close here-->
</div><!-- panel close-->
</div> <!--container close-->
<div class="container" style="margin-top:200px;"> <!-- container for add subject-->
<?php
if ($_GLOBALS['message']) {
    echo "<div class=\"message\"><p style=\"color:#000; font-size:20px; color:#00F; height:100px;\">" . $_GLOBALS['message'] . "</style></div>";
}
?>
<?php
if (isset($_SESSION['admname'])) {?>
<!-- panel body for add subject-->
<?php
}
?>
<?php
if (isset($_SESSION['admname'])) {
if (isset($_REQUEST['add'])) {
?>
<div class="panel panel-primary"style="margin-top:-80px" >
<div class="panel-heading panel-primary" ><center><p style="color:#FFF; font-size:20px; ">Add Tutor</center></div>
<div class="panel-body">              
<div class="row">
<div class="form-group col-md-6" style="margin-bottom:10px;">
<label for="password"></label>
<div class="input-group">
<input type="text" name="t_name" value="" onKeyUp="isalphanum(this)" autocomplete="off"  size="16" class="form-control" placeholder="Tutor Name"  />
<span class="input-group-btn">
<label class="btn "></label>
</span>
</div>
</div>
</div>
<!-- Content Field -->
<div class="row">
<div class="form-group col-md-6" style="margin-bottom:10px;">
<label for="password"></label>
<div class="input-group">
<textarea name="expertice" value=""  autocomplete="off"  size="16" class="form-control"placeholder="Expertice"  ></textarea>
<span class="input-group-btn">
<label class="btn "></label>
</span>
</div>
</div>
</div>

<div class="row">
<div class="form-group col-md-6" style="margin-bottom:10px;">
<label for="password"></label>
<div class="input-group">
<input type="text" name="experience" value="" onKeyUp="isalphanum(this)" autocomplete="off"  size="16" class="form-control" placeholder="Experience"  />
<span class="input-group-btn">
<label class="btn "></label>
</span>
</div>
</div>
</div>

<div class="row">
<div class="form-group col-md-6" style="margin-bottom:10px;">
<label for="password"></label>
<div class="input-group">
<input type="text" name="contact" value="" onKeyUp="isalphanum(this)" autocomplete="off"  size="16" class="form-control" placeholder="Contact No"  />
<span class="input-group-btn">
<label class="btn "></label>
</span>
</div>
</div>
</div>
</div>
<?php
} else if (isset($_REQUEST['edit'])) {
$result = executeQuery("select id,t_name,expertice,experience,contact from tutor_add where t_name='" . htmlspecialchars($_REQUEST['edit'], ENT_QUOTES) . "';");
if (mysql_num_rows($result) == 0) {
header('submng.php');
} else if ($r = mysql_fetch_array($result)) {
?>
<div class="panel panel-primary" style="margin-top:-80px">
<div class="panel-heading panel-primary" ><center><p style="color:#000; font-size:20px; color:#FFF;">Edit Tutor Details</center></div>
<div class="panel-body"> 
<div class="row">
<div class="form-group col-md-6" style="margin-bottom:10px;">
<label>Tutor name</label>
<label for="password"></label>
<div class="input-group">
<input type="text" name="t_name" value="<?php echo htmlspecialchars_decode($r['t_name'], ENT_QUOTES); ?>"  onKeyUp="isalphanum(this)"  autocomplete="off"  size="16" class="form-control" placeholder="Tutor Name"  />
<span class="input-group-btn">
<label class="btn "></label>
</span>
</div>
</div>
</div>
<div class="row">
<div class="form-group col-md-6" style="margin-bottom:10px;">
<label>Expertice</label>
<label for="password"></label>
<div class="input-group">
<textarea name="expertice" value=""  autocomplete="off"  size="16" class="form-control" placeholder="Expertice"  ><?php echo htmlspecialchars_decode($r['expertice'], ENT_QUOTES); ?></textarea><input type="hidden" name="subject" value="<?php echo $r['id']; ?>"/>
<span class="input-group-btn">
<label class="btn "></label>
</span>
</div>
</div>
</div>

<div class="row">
<div class="form-group col-md-6" style="margin-bottom:10px;">
<label>Experience</label>
<label for="password"></label>
<div class="input-group">
<input type="text" name="experience" value="<?php echo htmlspecialchars_decode($r['experience'], ENT_QUOTES); ?>" onKeyUp="isalphanum(this)" autocomplete="off"  size="16" class="form-control" placeholder="Experience"  />
<span class="input-group-btn">
<label class="btn "></label>
</span>
</div>
</div>
</div>

<div class="row">
<div class="form-group col-md-6" style="margin-bottom:10px;">
<label>Contact</label>
<label for="password"></label>
<div class="input-group">
<input type="text" name="contact" value="<?php echo htmlspecialchars_decode($r['contact'], ENT_QUOTES); ?>" onKeyUp="isalphanum(this)" autocomplete="off"  size="16" class="form-control" placeholder="Contact No"  />
<span class="input-group-btn">
<label class="btn "></label>
</span>
</div>
</div>
</div>
</div>
<br>
<br>
<?php
closedb();
}
} else {
$result = executeQuery("select * from tutor_add order by id;");
                if (mysql_num_rows($result) == 0) {
                    echo "<h3 style=\"color:#0000cc;text-align:center;\">No Tutor Yet..!</h3>";
                } else {
                    $i = 0;
?>
<div class="panel panel-primary" style="margin-top:-80px">
<div class="panel-heading panel-primary"><center><p style="color:#000; font-size:20px; color:#FFF;">Tutor Management</center></div>
<div class="panel-body"> 
<div class="table-responsive-vertical shadow-z-1 ">
<!-- Table starts here -->
<table id="table" class="table table-hover table-mc-light-blue">
<thead>
<tr style="background-color:#C0C0C0">
<th>&nbsp;</th>
<th><p style="color:#000; font-size:16px;">Tutor Name</th>
<th><p style="color:#000; font-size:16px;">Expertice</th>
<th><p style="color:#000; font-size:16px;">Experience</th>
<th><p style="color:#000; font-size:16px;">Contact</th>
<th><p style="color:#000; font-size:16px;">Edit</th>
</tr>
</thead>
<tbody>
					<?php
						while ($r = mysql_fetch_array($result)) {
						$i = $i + 1;
						if ($i % 2 == 0) {
                            echo "<tr class=\"alt\">";
                        } else {
                            echo "<tr>";
                        }
                        echo " <td data-title=\"ID\" style=\"text-align:center;\"><input type=\"checkbox\" name=\"d$i\" value=\"" . $r['id'] . "\" /></td><td>" . htmlspecialchars_decode($r['t_name'], ENT_QUOTES)
                        . "</td><td>" . htmlspecialchars_decode($r['expertice'], ENT_QUOTES) . "</td><td>" . htmlspecialchars_decode($r['experience'], ENT_QUOTES) . "</td><td>" . htmlspecialchars_decode($r['contact'], ENT_QUOTES) . "</td>"
                        . "<td data-title=\"Name\" class=\"tddata\"><a title=\"Edit " . htmlspecialchars_decode($r['stdname'], ENT_QUOTES) . "\"href=\"tutor_add.php?edit=" . htmlspecialchars_decode($r['t_name'], ENT_QUOTES) . "\"><span class=\"glyphicon glyphicon-pencil\"></span></a></td></tr>";
						}
					?>
</tbody>
</table>
</div>
<?php
}
closedb();
}
}
?>
</div>
</div> <!--panel close-->
</div> <!--container close-->
<?php
if (isset($_SESSION['admname'])) {
?>
<div class="container-fluid">
<div class="panel panel-footer" style="background-color:#34495E;">
<center><b><p style="font-size:100%; color:#FFF;">Copy right 2018 © All rights are reserved and designed by Parrovphins</p></b></center></p>
<?php
}
?>
</div>
</div>
</form>

<script type="text/javascript" src="assets/custom/js/jquery-1.8.2.min.js"></script>
<script type="text/javascript" src="assets/custom/js/modernizr.custom.js"></script>		
<script type="text/javascript" src="assets/bootstrap/js/bootstrap.min.js"></script>	
<!-- JS Implementing Plugins -->           
<script type="text/javascript" src="assets/custom/js/jquery.flexslider-min.js"></script>
<script type="text/javascript" src="assets/custom/js/modernizr.js"></script>
<script type="text/javascript" src="assets/custom/js/jquery.cslider.js"></script> 
<script type="text/javascript" src="assets/custom/js/back-to-top.js"></script>
<script type="text/javascript" src="assets/custom/js/jquery.sticky.js"></script>
<!-- JS Page Level -->           
<script type="text/javascript" src="assets/custom/js/app.js"></script>
<script type="text/javascript">
    jQuery(document).ready(function() {
      	App.init();
        App.initSliders();
        Index.initParallaxSlider();
    });
</script>
</body>
</html>