<?php
error_reporting(0);
session_start();
include_once '../database/connect.php';
/* * ************************ Step 1 ************************ */
if (!isset($_SESSION['admname'])) {
    $_GLOBALS['message'] = "Session Timeout.Click here to <a href=\"index.php\">Re-LogIn</a>";
} else if (isset($_REQUEST['logout'])) {
    /*     * ************************ Step 2 - Case 1 ************************ */
    //Log out and redirect login page
    unset($_SESSION['admname']);
    header('Location: index.php');
} else if (isset($_REQUEST['home'])) {
    /*     * ************************ Step 2 - Case 2 ************************ */
    //redirect to dashboard
    header('Location: dashboard.php');
} 
 else if (isset($_REQUEST['delete'])) {
    /*     * ************************ Step 2 - Case 3 ************************ */
    //deleting the selected users
    unset($_REQUEST['delete']);
    $hasvar = false;
    foreach ($_REQUEST as $variable) {
        if (is_numeric($variable)) { //it is because, some sessin values are also passed with request
            $hasvar = true;

            if (!@executeQuery("delete from student where stdid=$variable")) {
                if (mysql_errno () == 1451) //Children are dependent value
                    $_GLOBALS['message'] = "Too Prevent accidental deletions, system will not allow propagated deletions.<br/><b>Help:</b> If you still want to delete this user, then first manually delete all the records that are associated with this user.";
                else
                    $_GLOBALS['message'] = mysql_errno();
            }
        }
    }
    if (!isset($_GLOBALS['message']) && $hasvar == true)
        $_GLOBALS['message'] = "Selected User/s are successfully Deleted";
    else if (!$hasvar) {
        $_GLOBALS['message'] = "First Select the users to be Deleted.";
    }
} else if (isset($_REQUEST['savem'])) {
    /*     * ************************ Step 2 - Case 4 ************************ */
    //updating the modified values
    if (empty($_REQUEST['cname']) || empty($_REQUEST['password']) || empty($_REQUEST['email'])|| empty($_REQUEST['contactno'])|| empty($_REQUEST['address'])|| empty($_REQUEST['city'])|| empty($_REQUEST['pin'])) {
        $_GLOBALS['message'] = "Some of the required Fields are Empty.Therefore Nothing is Updated";
    } else {
        $query = "update student set stdname='" . htmlspecialchars($_REQUEST['cname'], ENT_QUOTES) . "', stdpassword=ENCODE('" . htmlspecialchars($_REQUEST['password']) . "','oespass'),emailid='" . htmlspecialchars($_REQUEST['email'], ENT_QUOTES) . "',contactno='" . htmlspecialchars($_REQUEST['contactno'], ENT_QUOTES) . "',address='" . htmlspecialchars($_REQUEST['address'], ENT_QUOTES) . "',city='" . htmlspecialchars($_REQUEST['city'], ENT_QUOTES) . "',pincode='" . htmlspecialchars($_REQUEST['pin'], ENT_QUOTES) . "' where stdid='" . htmlspecialchars($_REQUEST['student'], ENT_QUOTES) . "';";
        if (!@executeQuery($query))
            $_GLOBALS['message'] = mysql_error();
        else
            $_GLOBALS['message'] = "User Information is Successfully Updated.";
    }
    closedb();
}
else if (isset($_REQUEST['savea'])) {
    /*     * ************************ Step 2 - Case 5 ************************ */
    //Add the new user information in the database
    $result = executeQuery("select max(stdid) as std from student");
    $r = mysql_fetch_array($result);
    if (is_null($r['std']))
        $newstd = 1;
    else
        $newstd=$r['std'] + 1;

    $result = executeQuery("select stdname as std from student where stdname='" . htmlspecialchars($_REQUEST['cname'], ENT_QUOTES) . "';");


    if (empty($_REQUEST['cname']) || empty($_REQUEST['password']) || empty($_REQUEST['email'])|| empty($_REQUEST['contactno'])|| empty($_REQUEST['address'])|| empty($_REQUEST['city'])|| empty($_REQUEST['pin'])) {
        $_GLOBALS['message'] = "Some of the required Fields are Empty";
    } else if (mysql_num_rows($result) > 0) {
        $_GLOBALS['message'] = "Sorry User Already Exists.";
    } else {
        $query = "insert into student values($newstd,'" . htmlspecialchars($_REQUEST['cname'], ENT_QUOTES) . "',ENCODE('" . htmlspecialchars($_REQUEST['password'], ENT_QUOTES) . "','oespass'),'" . htmlspecialchars($_REQUEST['email'], ENT_QUOTES) . "','" . htmlspecialchars($_REQUEST['contactno'], ENT_QUOTES) . "','" . htmlspecialchars($_REQUEST['address'], ENT_QUOTES) . "','" . htmlspecialchars($_REQUEST['city'], ENT_QUOTES) . "','" . htmlspecialchars($_REQUEST['pin'], ENT_QUOTES) . "')";
        if (!@executeQuery($query)) {
            if (mysql_errno () == 1062) //duplicate value
                $_GLOBALS['message'] = "Given User Name voilates some constraints, please try with some other name.";
            else
                $_GLOBALS['message'] = mysql_error();
        }
        else
            $_GLOBALS['message'] = "Successfully New User is Created.";
    }
    closedb();
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>User Management System</title>
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
if (isset($_SESSION['admname'])) {?>
<form name="rsltmng" action="usr.php" method="post">
<div class="container-fluid navbar navbar-fixed-top">
<div class="panel " style="background-color:#34495E; "> 
<div class="row" >
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
<div class="row hidden-lg hidden-md" style="margin-bottom:20px;">
<div class="dropdown pull-left btn btn-primary" style="margin-left:20px; color:#FFF;">
<a href="#" data-toggle="dropdown" class="dropdown-toggle" style="color:#FFF;">Dashboard <b class="caret"></b></a>
<ul class="dropdown-menu">
<li><a href="sub.php"><img src="assets/custom/img/subject.png" width="50" height="30" />Subject Management</a></li>
<li><a href="testm.php"><img src="assets/custom/img/test1.png" width="50" height="30" style="margin-left:-40px;" />Test Management</a></li>
<li><a href="#"><img src="assets/custom/img/qtn1.jpg" width="50" height="30"  />Question Management</a></li>
<li><a href="#"><img src="assets/custom/img/user.png" width="50" height="30" style="margin-left:-30px;"  />User Management</a></li>
<!-- <li><a href="#"><img src="assets/custom/img/study.jpg" width="50" height="30"  style="margin-left:-40px;" />Study Material</a></li>-->
</ul>
</div>
<div class="pull-right" style="margin-right:20px;">
 <?php
    //navigation for Add option
    if (isset($_REQUEST['add'])) {
?>
<input type="submit" value="Save" name="savea"  onClick="validateform('usermng')" title="Save the Changes" class="btn btn-primary "/>
<input type="submit" value="Cancel" name="cancel"  title="Cancel" class="btn btn-primary "/>
<?php
    } else if (isset($_REQUEST['edit'])) { //navigation for Edit option
?>
<input type="submit" value="Save" name="savem"  onClick="validateform('usermng')" title="Save the changes" class="btn btn-primary "/> 
<input type="submit" value="Cancel" name="cancel"  title="Cancel" class="btn btn-primary "/>
<?php
    } else {  //navigation for Default
?>
<input type="submit" class="btn btn-primary " value="Add" name="add"  title="Add"/>
<input type="submit" value="Delete" name="delete"  title="Delete" class="btn btn-primary "/>
<?php
 }
 ?>
</div>
</div> 
<div class="row hidden-xs hidden-sm" style="margin-bottom:-30px;">
<nav class="navbar navbar" role="navigation" style="margin-top:-12px;">
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
<ul class="nav navbar-nav pull-left" style="margin-bottom:10px; margin-top:10px;">
<li class="dropdown mega-dropdown active" ></li>
<a href="#" class="dropdown-toggle btn btn-primary" data-toggle="dropdown" >Dashboard <span class="caret"></span></a>	
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
<!-- <li><a href="studymaterial.php"><img src="assets/custom/img/study.jpg" height="80" width="150"><span>Study Material</span></a></li>-->
</ul>
</div>
</div>
</div>
<!-- Nav tabs -->
</div>				
</li>
</ul>
<ul class="nav navbar-nav pull-right" style="margin-bottom:10px; margin-top:10px; margin-right:30px;">
<?php
    //navigation for Add option
    if (isset($_REQUEST['add'])) {
?>
<input type="submit" value="Save" name="savea" onClick="validateform('usermng')" title="Save the Changes" class="btn btn-primary "/>
<input type="submit" value="Cancel" name="cancel"  title="Cancel" class="btn btn-primary "/>
<?php
    } else if (isset($_REQUEST['edit'])) { //navigation for Edit option
?>
<input type="submit" value="Save" name="savem"  onClick="validateform('usermng')" title="Save the changes" class="btn btn-primary "/> 
<input type="submit" value="Cancel" name="cancel"  title="Cancel" class="btn btn-primary "/>
<?php
    } else {  //navigation for Default
?>
<input type="submit" class="btn btn-primary " value="Add" name="add"  title="Add"/>
<input type="submit" value="Delete" name="delete"  title="Delete" class="btn btn-primary "/>
<?php }
}
?>
</ul>
</div><!-- /.navbar-collapse -->
</div><!-- /.container-fluid -->
</nav>
</div>
</div>
</div>
<div class="container" style="margin-top:180px;"> 
 <?php
if ($_GLOBALS['message']) {
    echo "<div style=\"color:#C10000;font:'Times New Roman', Times, serif;font-size:20px;height:100px; \">" . $_GLOBALS['message'] . "</div>";
}
?>  
<?php
if (isset($_SESSION['admname'])) {
 ?> 
<?php
if (isset($_REQUEST['add'])) {
        /*         * ************************ Step 3 - Case 1 ************************ */
        //Form for the new user
		?>
<div class="panel panel-primary" style="margin-top:-60px;">
<div class="panel-heading panel-primary" ><center><p style="color:#fff; font-size:20px; color:#fff;">Add Student</center></div>
<div class="panel-body"> 
<!-- Login Form -->
<div class="col-md-4 col-md-offset-4">
<!-- Username Field -->
<div class="row">
<div class="form-group col-xs-12">
<div class="input-group">
<input class="form-control"  type="text" name="cname"   size="16" onKeyUp="isalphanum(this)"/ placeholder="Username"  />
<div class="input-group-addon">
<span class="glyphicon glyphicon-user" aria-hidden="true">
</div>
</div>
</div>
</div>       
<!-- Content Field -->
<div class="row">
<div class="form-group col-xs-12">
<div class="input-group">
<input class="form-control" id="password" type="text" name="password" placeholder="Password" onKeyUp="isalphanum(this)" />
<div class="input-group-addon">
<span class="glyphicon glyphicon-lock" aria-hidden="true">
</div>
</div>
</div>
</div>       
<div class="row">
<div class="form-group col-xs-12">
<div class="input-group">
<input class="form-control" id="email"  type="email" name="email" placeholder="Email" />
<div class="input-group-addon">
<span class="glyphicon glyphicon-envelope" aria-hidden="true">
</div>
</div>
</div>
</div>       
<div class="row">
<div class="form-group col-xs-12">
<div class="input-group">
<input class="form-control" id="contact" type="text" name="contactno"  placeholder="Contact" onKeyUp="isnum(this)" />
<div class="input-group-addon">
<span class="glyphicon glyphicon-earphone" aria-hidden="true">
</div>
</div>
</div>
</div>       
<div class="row">
<div class="form-group col-xs-12">
<div class="input-group">
<input class="form-control" autocomplete="off" id="" type="text" name="address"  placeholder="Address" />
<div class="input-group-addon">
<span class="glyphicon glyphicon-adjust" aria-hidden="true">
</div>
</div>
</div>
</div>
<div class="row">
<div class="form-group col-xs-12">
<div class="input-group">
<input class="form-control" autocomplete="off" id="" type="text" name="city" placeholder="City"   onkeyup="isalpha(this)" />
<div class="input-group-addon">
<span class="glyphicon glyphicon-map-marker" aria-hidden="true">
</div>
</div>
</div>
</div>          
<div class="row">
<div class="form-group col-xs-12">
<div class="input-group">
<input class="form-control" id="pin" type="text"   name="pin" placeholder="Pincode" onKeyUp="isnum(this)" autocomplete="off" />
<div class="input-group-addon">
<span class="glyphicon glyphicon-adjust" aria-hidden="true">
</div>
</div>
</div>
</div>
</div>
                </div>
				
				
				
																
				 <?php
	}


     else if (isset($_REQUEST['edit'])) {
		
$result = executeQuery("select stdid,stdname,DECODE(stdpassword,'oespass') as stdpass ,emailid,contactno,address,city,pincode from student where stdname='" . htmlspecialchars($_REQUEST['edit'], ENT_QUOTES) . "';");
        if (mysql_num_rows($result) == 0) {
            header('Location: register.php');
        } else if ($r = mysql_fetch_array($result)) {

           
?>
<div class="panel panel-primary" style="margin-top:-60px;" >
<div class="panel-heading panel-primary">
<center><p style="color:#fff; font-size:16px; color:#fff;">Edit Student Profile</center></div>
<div class="panel-body">   
<div class="col-md-4 col-md-offset-4">
<!-- Username Field -->
<div class="row">
<div class="form-group col-xs-12">
<div class="input-group">
<input class="form-control"  type="text" name="cname"  value="<?php echo htmlspecialchars_decode($r['stdname'], ENT_QUOTES); ?>" size="16" onKeyUp="isalphanum(this)"/ placeholder="Username"  readonly/>
<div class="input-group-addon">
<span class="glyphicon glyphicon-user" aria-hidden="true">
</div>
</div>
</div>
</div>       
<!-- Content Field -->
<div class="row">
<div class="form-group col-xs-12">
<div class="input-group">
<input class="form-control" id="password" value="<?php echo htmlspecialchars_decode($r['stdpass'], ENT_QUOTES); ?>"type="text" name="password" placeholder="Password" onKeyUp="isalphanum(this)" />
<div class="input-group-addon">
<span class="glyphicon glyphicon-lock" aria-hidden="true">
</div>
</div>
</div>
</div>       
<div class="row">
<div class="form-group col-xs-12">
<div class="input-group">
<input class="form-control" id="email" value="<?php echo htmlspecialchars_decode($r['emailid'], ENT_QUOTES); ?>" type="email" name="email" placeholder="Email" />
<div class="input-group-addon">
<span class="glyphicon glyphicon-envelope" aria-hidden="true">
</div>
</div>
</div>
</div>       
<div class="row">
<div class="form-group col-xs-12">
<div class="input-group">
<input class="form-control" id="contact" type="text" name="contactno" value="<?php echo htmlspecialchars_decode($r['contactno'], ENT_QUOTES); ?>" placeholder="Contact" onKeyUp="isnum(this)" />
<div class="input-group-addon">
<span class="glyphicon glyphicon-earphone" aria-hidden="true">
</div>
</div>
</div>
</div>       
<div class="row">
<div class="form-group col-xs-12">
<div class="input-group">
<input class="form-control" autocomplete="off" id="" type="text" name="address" value="<?php echo htmlspecialchars_decode($r['address'], ENT_QUOTES); ?>" placeholder="Address" />
<div class="input-group-addon">
<span class="glyphicon glyphicon-adjust" aria-hidden="true">
</div>
</div>
</div>
</div>
<div class="row">
<div class="form-group col-xs-12">
<div class="input-group">
<input class="form-control" autocomplete="off" id="" type="text" name="city" placeholder="City" value="<?php echo htmlspecialchars_decode($r['city'], ENT_QUOTES); ?>"  onkeyup="isalpha(this)" />
<div class="input-group-addon">
<span class="glyphicon glyphicon-map-marker" aria-hidden="true">
</div>
</div>
</div>
</div>          
<div class="row">
<div class="form-group col-xs-12">
<div class="input-group">
<input type="hidden" name="student" value="<?php echo htmlspecialchars_decode($r['stdid'], ENT_QUOTES); ?>"/>
<input class="form-control" id="pin" type="text"  value="<?php echo $r['pincode']; ?>" name="pin" placeholder="Pincode" onKeyUp="isnum(this)" />
<div class="input-group-addon">
<span class="glyphicon glyphicon-adjust" aria-hidden="true">
</div>
</div>
</div>
</div>
</div>
</div>
</div>
<!-- here editing ednds-->
<br>
<?php
closedb();
}
} else {
               /*                 * ************************ Step 3 - Case 3 ************************ */
                // Defualt Mode: Displays the Existing Users, If any.
$result = executeQuery("select * from student order by stdid;");
if (mysql_num_rows($result) == 0) {
                    echo "<h3 style=\"color:#0000cc;text-align:center;\">No Users Yet..!</h3>";
                } else {
                    $i = 0;
?>
<div class="panel panel-primary" style="margin-top:-60px;" >
<div class="panel-heading panel-primary"><center><p style="color:#fff; font-size:20px; color:#fff;">Student Management</center></div>
<div class="panel-body"> 
<table  class="pull-left table table-responsive-vertical"  style="margin-left:-12px;">
<thead>
<tr style="background-color:#C0C0C0">
<th>&nbsp;</th>
<th><p style="color:#000; font-size:16px;">User Name</th>
<th><p style="color:#000; font-size:16px;">Email-ID</th>
<th><p style="color:#000; font-size:16px;">Edit</th>
</tr>
</thead>
<tbody>
<?php
while ($r = mysql_fetch_array($result)) {
$i = $i + 1;
if ($i % 2 == 0)
echo "<tr >";
else
echo "<tr>";
echo "<td ><input type=\"checkbox\" name=\"d$i\" value=\"" . $r['stdid'] . "\" /></td><td>" . htmlspecialchars_decode($r['stdname'], ENT_QUOTES). "</td><td>" . htmlspecialchars_decode($r['emailid'], ENT_QUOTES) . "</td>"
. "<td ><a title=\"Edit " . htmlspecialchars_decode($r['stdname'], ENT_QUOTES) . "\"href=\"usr.php?edit=" . htmlspecialchars_decode($r['stdname'], ENT_QUOTES) . "\"><span class=\"glyphicon glyphicon-pencil\"></span> </a></td></tr>";
                    }
?>
</tbody>
</table>
</div>
</div>
</div>
<?php
}
closedb();
}
}
?>
</form>
</div>  
</div>
</div>  
</div>
</div>
<?php
if (isset($_SESSION['admname'])) {?>
<div class="container-fluid">  
<div class="panel panel-footer" style="background-color:#34495E;  margin-top:-20px;">
<center><b><p style="font-size:100%; color:#FFF;">Copy right 2018 © All rights are reserved and designed by Parrovphins</p></b></center></p>
</div>
</div>
</body>
<?php
}
?>
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
<script>
$(document).ready(function(){
    $('[data-toggle="popover"]').popover();   
});
</script>
<script type="text/javascript">
    jQuery(document).ready(function() {
      	App.init();
        App.initSliders();
        Index.initParallaxSlider();
    });
</script>
</html>