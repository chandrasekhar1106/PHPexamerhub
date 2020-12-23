<!--Here admin can add edit delete the question paper for respected test and subject-->
<?php

error_reporting(0);
session_start();
include_once '../database/connect.php';

if (!isset($_SESSION['admname']) || !isset($_SESSION['testqn'])) {
    $_GLOBALS['message'] = "Session Timeout.Click here to <a href=\"index.php\">Re-LogIn</a>";
} else if (isset($_REQUEST['logout'])) {
   
    //Log out and redirect login page
    unset($_SESSION['admname']);
    header('Location: index.php');
} else if (isset($_REQUEST['home'])) {
    /*     * ************************ Step 2 - Case 2 ************************ */
    //redirect to dashboard
    header('Location: dashboard.php');
}
 else if (isset($_REQUEST['managetests'])) {
  
    //redirect to Manage Tests Section

    header('Location: testm.php');
} else if (isset($_REQUEST['delete'])) {
   
    //deleting the selected Questions
    unset($_REQUEST['delete']);
    $hasvar = false;
    $count = 1;
    foreach ($_REQUEST as $variable) {
        if (is_numeric($variable)) { //it is because, some session values are also passed with request
            $hasvar = true;

            if (!@executeQuery("delete from question where testid=" . $_SESSION['testqn'] . " and qnid=" . htmlspecialchars($variable)))
                $_GLOBALS['message'] = mysql_error();
        }
    }
    //reordering questions

    $result = executeQuery("select qnid from question where testid=" . $_SESSION['testqn'] . " order by qnid;");
    while ($r = mysql_fetch_array($result))
        if (!@executeQuery("update question set qnid=" . ($count++) . " where testid=" . $_SESSION['testqn'] . " and qnid=" . $r['qnid'] . ";"))
            $_GLOBALS['message'] = mysql_error();

    //
    if (!isset($_GLOBALS['message']) && $hasvar == true)
        $_GLOBALS['message'] = "Selected Questions are successfully Deleted";
    else if (!$hasvar) {
        $_GLOBALS['message'] = "First Select the Questions to be Deleted.";
    }
} else if (isset($_REQUEST['savem'])) {
    
    if (strcmp($_REQUEST['correctans'], "<Choose the Correct Answer>") == 0 || empty($_REQUEST['question']) || empty($_REQUEST['optiona']) || empty($_REQUEST['optionb']) || empty($_REQUEST['optionc']) || empty($_REQUEST['optiond']) || empty($_REQUEST['marks'])) {
        $_GLOBALS['message'] = "Some of the required Fields are Empty";
    } else if (strcasecmp($_REQUEST['optiona'], $_REQUEST['optionb']) == 0 || strcasecmp($_REQUEST['optiona'], $_REQUEST['optionc']) == 0 || strcasecmp($_REQUEST['optiona'], $_REQUEST['optiond']) == 0 || strcasecmp($_REQUEST['optionb'], $_REQUEST['optionc']) == 0 || strcasecmp($_REQUEST['optionb'], $_REQUEST['optiond']) == 0 || strcasecmp($_REQUEST['optionc'], $_REQUEST['optiond']) == 0) {
        $_GLOBALS['message'] = "Two or more options are representing same answers.Verify Once again";
    } else {
        $query = "update question set question='" . htmlspecialchars($_REQUEST['question'],ENT_QUOTES) . "',optiona='" . htmlspecialchars($_REQUEST['optiona'],ENT_QUOTES) . "',optionb='" . htmlspecialchars($_REQUEST['optionb'],ENT_QUOTES) . "',optionc='" . htmlspecialchars($_REQUEST['optionc'],ENT_QUOTES) . "',optiond='" . htmlspecialchars($_REQUEST['optiond'],ENT_QUOTES) . "',correctanswer='" . htmlspecialchars($_REQUEST['correctans'],ENT_QUOTES) . "',marks=" . htmlspecialchars($_REQUEST['marks'],ENT_QUOTES) . " where testid=" . $_SESSION['testqn'] . " and qnid=" . $_REQUEST['qnid'] . " ;";
        if (!@executeQuery($query))
            $_GLOBALS['message'] = mysql_error();
        else
            $_GLOBALS['message'] = "Question is updated Successfully.";
    }
    closedb();
}
else if (isset($_REQUEST['savea'])) {
   
    $cancel = false;
    $result = executeQuery("select max(qnid) as qn from question where testid=" . $_SESSION['testqn'] . ";");
    $r = mysql_fetch_array($result);
    if (is_null($r['qn']))
        $newstd = 1;
    else
        $newstd=$r['qn'] + 1;

    $result = executeQuery("select count(*) as q from question where testid=" . $_SESSION['testqn'] . ";");
    $r2 = mysql_fetch_array($result);

    $result = executeQuery("select totalquestions from test where testid=" . $_SESSION['testqn'] . ";");
    $r1 = mysql_fetch_array($result);

    if (!is_null($r2['q']) && (int) htmlspecialchars_decode($r1['totalquestions'],ENT_QUOTES) == (int) $r2['q']) {
        $cancel = true;
        $_GLOBALS['message'] = "Already you have created all the Questions for this Test.<br /><b>Help:</b> If you still want to add some more questions then edit the test settings(option:Total Questions).";
    }
    else
        $cancel=false;

    $result = executeQuery("select * from question where testid=" . $_SESSION['testqn'] . " and question='" . htmlspecialchars($_REQUEST['question'],ENT_QUOTES) . "';");
    if (!$cancel && $r1 = mysql_fetch_array($result)) {
        $cancel = true;
        $_GLOBALS['message'] = "Sorry, You trying to enter same question for Same test";
    } else if (!$cancel)
        $cancel = false;
    //$_GLOBALS['message']=$newstd;
    if (strcmp($_REQUEST['correctans'], "<Choose the Correct Answer>") == 0 || empty($_REQUEST['question']) || empty($_REQUEST['optiona']) || empty($_REQUEST['optionb']) || empty($_REQUEST['optionc']) || empty($_REQUEST['optiond']) || empty($_REQUEST['marks'])) {
        $_GLOBALS['message'] = "Some of the required Fields are Empty";
    } else if (strcasecmp($_REQUEST['optiona'], $_REQUEST['optionb']) == 0 || strcasecmp($_REQUEST['optiona'], $_REQUEST['optionc']) == 0 || strcasecmp($_REQUEST['optiona'], $_REQUEST['optiond']) == 0 || strcasecmp($_REQUEST['optionb'], $_REQUEST['optionc']) == 0 || strcasecmp($_REQUEST['optionb'], $_REQUEST['optiond']) == 0 || strcasecmp($_REQUEST['optionc'], $_REQUEST['optiond']) == 0) {
        $_GLOBALS['message'] = "Two or more options are representing same answers.Verify Once again";
    } else if (!$cancel) {
        $query = "insert into question values(" . $_SESSION['testqn'] . ",$newstd,'" .$_REQUEST['question']. "','" . htmlspecialchars($_REQUEST['optiona'],ENT_QUOTES) . "','" . htmlspecialchars($_REQUEST['optionb'],ENT_QUOTES) . "','" . htmlspecialchars($_REQUEST['optionc'],ENT_QUOTES) . "','" . htmlspecialchars($_REQUEST['optiond'],ENT_QUOTES) . "','" . htmlspecialchars($_REQUEST['correctans'],ENT_QUOTES) . "'," . htmlspecialchars($_REQUEST['marks'],ENT_QUOTES) . ")";
        if (!@executeQuery($query))
            $_GLOBALS['message'] = mysql_error();
        else
            $_GLOBALS['message'] = "Successfully New Question is Created.";
    }
    closedb();
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Prepare Question Paper</title>
</head>
<link href="assets/bootstrap/css/bootstrap.min.css" rel="stylesheet" />
<script type="text/javascript" src="ckeditor/ckeditor.js"></script>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-y3tfxAZXuh4HwSYylfB+J125MxIs6mR5FOHamPBG064zB+AFeWH94NdvaCBm8qnd" crossorigin="anonymous">
<script type="text/javascript" src="../validate.js" ></script>
<link rel="icon" type="image/x-icon" href="assets/custom/img/hat.png">
<link href="menu.css" rel="stylesheet" />
<script src="menu.js"></script>
<script src="assets/bootstrap/js/bootstrap.min.js"></script>
<link href="card.css" rel="stylesheet" />
<body>
<?php
if (isset($_SESSION['admname']))
{
?>
<form method="post" action="pqtn.php">
<div class="container-fluid navbar-fixed-top">
<div class="panel" style="background-color:#34495E; ">
<div class="row" >
<div class="col-lg-6">
<div class="pull-left">
<img src="assets/custom/img/logo.jpg" class="img-responsive"  />
</div>
</div>
<div class="col-lg-6">
<div class="pull-right">
<input type="submit" value="LogOut" name="logout"  title="Log Out" class="btn btn-link "  onclick="return confirm('Are you sure you want to Logout');" />
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
<li><a href="testm.php"><img src="assets/custom/img/qtn1.jpg" width="50" height="30"  />Question Management</a></li>
<li><a href="usr.php"><img src="assets/custom/img/user.png" width="50" height="30" style="margin-left:-30px;"  />User Management</a></li>
<!-- <li><a href="studymaterial.php"><img src="assets/custom/img/study.jpg" width="50" height="30"  style="margin-left:-40px;" />Study Material</a></li>-->
</ul>
</div>
</div>
<div class="row hidden-sm hidden-xs " style="margin-bottom:-30px;">
<nav class="navbar navbar  " role="navigation" style="margin-top:-12px;">
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
<li class="dropdown mega-dropdown active"></li>
<a href="#" class="dropdown-toggle btn btn-primary" data-toggle="dropdown">Dashboard <span class="caret"></span></a>	
<div class="dropdown-menu mega-dropdown-menu" style="margin-left:10px;">
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
<?php
}
?>
<ul class="nav navbar-nav pull-right" style="margin-bottom:10px; margin-top:10px; margin-right:40px;">
<?php
if (isset($_SESSION['admname']) && isset($_SESSION['testqn'])) {
    // Navigations
?>
<input type="submit" value="Manage Tests" name="managetests" class="btn btn-primary" title="Manage Tests"/>
<?php
        //navigation for Add option
        if (isset($_REQUEST['add'])) {
        ?>
<input type="submit" value="Save" name="savea" class="btn btn-primary" onClick="validateqnform('prepqn')" title="Save the Changes"/>
<input type="submit" value="Cancel" name="cancel" class="btn btn-primary" title="Cancel"/>
<?php
        } else if (isset($_REQUEST['edit'])) { //navigation for Edit option
?>
<input type="submit" value="Save" name="savem" class="btn btn-primary" onClick="validateqnform('prepqn')" title="Save the changes"/>
<input type="submit" value="Cancel" name="cancel" class="btn btn-primary" title="Cancel"/>
<?php
                    } else {  //navigation for Default
                        ?>
<input type="submit" value="Add" name="add" class="btn btn-primary" title="Add"/>
<input type="submit" value="Delete" name="delete" class="btn btn-primary" title="Delete"/>
                        <?php }
                } ?>
</ul>
</div><!-- /.navbar-collapse -->
</div><!-- /.container-fluid -->
</nav>
</div>
</div>
</div>
<div class="container" style="margin-top:160px;">
<?php
if ($_GLOBALS['message']) {
    echo "<div class=\"message\"><p style=\"color:#000; font-size:16px; color:#00F;\">" . $_GLOBALS['message'] . "</div>";
}
?>
 <?php
   if (isset($_SESSION['admname']) && isset($_SESSION['testqn'])) {
	    $result = executeQuery("select count(*) as q from question where testid=" . $_SESSION['testqn'] . ";");
        $r1 = mysql_fetch_array($result);
		$result = executeQuery("select totalquestions from test where testid=" . $_SESSION['testqn'] . ";");
        $r2 = mysql_fetch_array($result);
        if ((int) $r1['q'] == (int) htmlspecialchars_decode($r2['totalquestions'],ENT_QUOTES))
        echo "<div class=\"pmsg\"> <p style=\"color:#900; font-size:16px;\"> Test Name: " . $_SESSION['testname'] . "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Status: All the Questions are Created for this test.</div>";
        else
        echo "<div class=\"pmsg\"> Test Name: " . $_SESSION['testname'] . "Status: Still you need to create " . (htmlspecialchars_decode($r2['totalquestions'],ENT_QUOTES) - $r1['q']) . " Question/s. After that only, test will be available for candidates.</div>";
         ?>
         <?php
         if (isset($_REQUEST['add'])) {
         ?>
         <br />
<div class="panel panel-primary" >
<div class="panel-heading panel-primary"><center><p style="color:#FFF; font-size:20px; color:#FFF;">Add Question</center></div></div>
<br><div class="well" style="margin-top:-40px;" >
<div class="row">
<div class="col-md-12">
<div class="form-group col-xs-12">
<div class="input-group" >
<label style="margin-right:90px;">Question</label>
<textarea name="question" cols="40" rows="3" id="editor2"></textarea>
<script>
CKEDITOR.replace( 'editor2' );
</script>
</div>
</div>
</div>
</div>
<div class="row">
<div class="col-md-12">
<div class="form-group col-xs-12">
<div class="input-group" >
<label style="margin-right:90px;">Option A</label>
<input type="text" class="form-control" name="optiona" value=""   />
</div>
</div>
</div>
</div>
<div class="row">
<div class="col-md-12">
<div class="form-group col-xs-12">
<div class="input-group">
<label style="margin-right:90px;">Option B</label>
<input type="text" class="form-control" name="optionb" value=""  />
</div>
</div>
</div>
</div>
<div class="row">
<div class="col-md-12">
<div class="form-group col-xs-12">
<div class="input-group" >
<label style="margin-right:90px;">Option C</label>
<input type="text" class="form-control" name="optionc" value=""   />
</div>
</div>
</div>
</div>
<div class="row">
<div class="col-md-12">
<div class="form-group col-xs-12">
<div class="input-group">
<label style="margin-right:90px;">Option D</label>
<input type="text" class="form-control" name="optiond" value=""   />
</div>
</div>
</div>
</div>
<div class="row">
<div class="col-md-12">
<div class="form-group col-xs-12">
<div class="input-group" >
<label style="margin-right:45px;">Correct Answer</label>
<select name="correctans" class="form-control">
<option value="<Choose the Correct Answer>" selected>&lt;Choose the Correct Answer&gt;</option>
<option value="optiona">Option A</option>
<option value="optionb">Option B</option>
<option value="optionc">Option C</option>
<option value="optiond">Option D</option>
</select>
</div>
</div>
</div>
</div>
<div class="row">
<div class="col-md-12">
<div class="form-group col-xs-12">
<div class="input-group" >
<label style="margin-right:107px;">Marks</label>
<input type="text" class="form-control" name="marks" value="1"  onKeyUp="isnum(this)" />
</div>
</div>
</div>
</div>
</div>
<?php
                            } else if (isset($_REQUEST['edit'])) {
                               
                                $result = executeQuery("select * from question where testid=" . $_SESSION['testqn'] . " and qnid=" . $_REQUEST['edit'] . ";");
                                if (mysql_num_rows($result) == 0) {
                                    header('Location: prepqn.php');
                                } else if ($r = mysql_fetch_array($result)) {


                                    //editing components
?>
<div class="panel panel-primary" >
<div class="panel-heading panel-primary"><center><p style="color:#FFF;font-size:20px; color:#FFF;">Edit Question</center></div></div>
<div class="well" style="margin-top:-20px;">
<div class="row">
<div class="col-md-12">
<div class="form-group col-xs-12">
<div class="input-group" >
<label >Question</label>
<input type="hidden" class="form-control" name="qnid" value="<?php echo $r['qnid']; ?>" />
<textarea name="question"  id='editor2'>
<?php echo htmlspecialchars_decode($r['question'],ENT_QUOTES); ?></textarea>
<script>
CKEDITOR.replace( 'editor2' );
</script>
</div>
</div>
</div>
</div>          
<div class="row">
<div class="col-md-12">
<div class="form-group col-xs-12">
<div class="input-group" >
<label style="margin-right:90px;">Option A</label>
<input type="text" class="form-control" name="optiona" value="<?php echo htmlspecialchars_decode($r['optiona'],ENT_QUOTES); ?>"  />
</div>
</div>
</div>
</div>
<div class="row">
<div class="col-md-12">
<div class="form-group col-xs-12">
<div class="input-group" >
<label style="margin-right:90px;">Option B</label>
<input type="text" class="form-control" name="optionb" value="<?php echo htmlspecialchars_decode($r['optionb'],ENT_QUOTES); ?>"/>
</div>
</div>
</div>
</div>
<div class="row">
<div class="col-md-12">
<div class="form-group col-xs-12">
<div class="input-group" >
<label style="margin-right:90px;">Option C</label>
<input type="text" class="form-control" name="optionc" value="<?php echo htmlspecialchars_decode($r['optionc'],ENT_QUOTES); ?>"  />
</div>
</div>
</div>
</div>
<div class="row">
<div class="col-md-12">
<div class="form-group col-xs-12">
<div class="input-group" >
<label style="margin-right:90px;">Option D</label>
<input type="text" name="optiond" class="form-control" value="<?php echo htmlspecialchars_decode($r['optiond'],ENT_QUOTES); ?>"   />
</div>
</div>
</div>
</div>
<div class="row">
<div class="col-md-12">
<div class="form-group col-xs-12">
<div class="input-group">
<label style="margin-right:45px;">Correct Answer</label>
<select name="correctans" class="form-control">
<option value="optiona" <?php if (strcmp(htmlspecialchars_decode($r['correctanswer'],ENT_QUOTES), "optiona") == 0)
echo "selected"; ?>>Option A</option>
<option value="optionb" <?php if (strcmp(htmlspecialchars_decode($r['correctanswer'],ENT_QUOTES), "optionb") == 0)
echo "selected"; ?>>Option B</option>
<option value="optionc" <?php if (strcmp(htmlspecialchars_decode($r['correctanswer'],ENT_QUOTES), "optionc") == 0)
echo "selected"; ?>>Option C</option>
<option value="optiond" <?php if (strcmp(htmlspecialchars_decode($r['correctanswer'],ENT_QUOTES), "optiond") == 0)
echo "selected"; ?>>Option D</option>
</select>
</div>
</div>
</div>
</div>
<div class="row">
<div class="col-md-12">
<div class="form-group col-xs-12">
<div class="input-group" >
<label style="margin-right:110px;">Marks</label>
<input type="text" class="form-control" name="marks" value="<?php echo htmlspecialchars_decode($r['marks'],ENT_QUOTES); ?>"  onKeyUp="isnum(this)" />
</div>
</div>
</div>
</div>
</div>
<?php
closedb();
}
}
else {
	?>
<div class="panel panel-primary " >
<div class="panel-heading panel-warning" ><center><p style="color:#FFF; font-size:20px; color:#FFF;">Question Management System</center></div></div>
<?php
$result = executeQuery("select * from question where testid=" . $_SESSION['testqn'] . " order by qnid;");
if (mysql_num_rows($result) == 0) {
echo "<h3 style=\"color:#0000cc;text-align:center;\">No Questions Yet..!</h3>";
} else {
$i = 0;
?>
<?php
while ($r = mysql_fetch_array($result)) {
$i = $i + 1;
if ($i % 2 == 0)
echo'<div class="well" >';
else
echo'<div class="well"  >';
echo "<td  style=\"text-align:center;  bgcolor='#808080'\"><p style=\"color:#900;  \"><input  type=\"checkbox\" name=\"d$i\" value=\"" . $r['qnid'] . "\"  /></td>&nbsp;&nbsp;&nbsp;<td>Question No:</td><td> " . $i . "</p></td><hr style=\"border: 1px solid #fff;  \" / >";
echo"<td >" . htmlspecialchars_decode($r['question'],ENT_QUOTES) . "</td><hr style=\"border: 1px solid #fff;  \" />";
echo"<td id=\"test\"><strong>Correct Answer:</strong></td>&nbsp;&nbsp;&nbsp;<td>" . htmlspecialchars_decode($r[htmlspecialchars_decode($r['correctanswer'],ENT_QUOTES)],ENT_QUOTES) . "</td><hr style=\"border: 1px solid #fff;  \"/>
<td><strong>Marks:</strong></td>&nbsp;&nbsp;&nbsp;<td>" . htmlspecialchars_decode($r['marks'],ENT_QUOTES) . "</td><hr style=\"border: 1px solid #0000FF;  \" / >";
echo"<td bgcolor=\"#900\" ><a title=\"Edit " . $r['qnid'] . "\"href=\"pqtn.php?edit=" . $r['qnid'] . "\"><input type=\"button\" value=\"edit\" class=\"btn btn-primary\"></a>"
                                        . "</td><tr><br>";
										?>
                                       
</div>
<?php
}
?>
<?php		  
}
}
}
?>
</div>
</div>
</form>
<?php
if (isset($_SESSION['admname']))
{
?>
<div class="container-fluid">
<div class="panel panel-footer "  style="background-color:#34495E; ">
<center><b><p style="font-size:100%; color:#FFF;">Copy right 2018 © All rights are reserved and designed by Parrovphins</p></b></center></p>
</div>
</div>
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
<script type="text/javascript">
$(document).ready(function(){
    $("#myNav").affix({
        offset: { 
            top: $(".header").outerHeight(true)
        }
    });
});
</script>
<script type="text/javascript">
    jQuery(document).ready(function() {
      	App.init();
        App.initSliders();
        Index.initParallaxSlider();
    });
</script>
</body>
</html>