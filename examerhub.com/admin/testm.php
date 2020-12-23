<!--here admin can add edit delete test for respected subject-->
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
} else if (isset($_REQUEST['delete'])) { /* * ************************ Step 2 - Case 3 ************************ */  
    //deleting the selected Tests
    unset($_REQUEST['delete']);
    $hasvar = false;
    foreach ($_REQUEST as $variable) {
        if (is_numeric($variable)) { //it is because, some session values are also passed with request
            $hasvar = true;

            if (!@executeQuery("delete from test where testid=$variable")) {
                if (mysql_errno () == 1451) //Children are dependent value
                    $_GLOBALS['message'] = "Too Prevent accidental deletions, system will not allow propagated deletions.<br/><b>Help:</b> If you still want to delete this test, then first delete the questions that are associated with it.";
                else
                    $_GLOBALS['message'] = mysql_errno();
            }
        }
    }
    if (!isset($_GLOBALS['message']) && $hasvar == true)
        $_GLOBALS['message'] = "Selected Tests are successfully Deleted";
    else if (!$hasvar) {
        $_GLOBALS['message'] = "First Select the Tests to be Deleted.";
    }
} else if (isset($_REQUEST['savem'])) {
    /*     * ************************ Step 2 - Case 4 ************************ */
    //updating the modified values
    $fromtime = $_REQUEST['testfrom'] . " " . date("H:i:s");
    $totime = $_REQUEST['testto'] . " 23:59:59";
    $_GLOBALS['message'] = strtotime($totime) . "  " . strtotime($fromtime) . "  " . time();
    if (strtotime($fromtime) > strtotime($totime) || strtotime($totime) < time())
        $_GLOBALS['message'] = "Start date of test is less than end date or last date of test is less than today's date.<br/>Therefore Nothing is Updated";
    else if (empty($_REQUEST['testname']) || empty($_REQUEST['testdesc']) || empty($_REQUEST['totalqn']) || empty($_REQUEST['duration'])|| empty($_REQUEST['testcode'])) {
        $_GLOBALS['message'] = "Some of the required Fields are Empty.Therefore Nothing is Updated";
    } else {
        $query = "update test set testname='" . htmlspecialchars($_REQUEST['testname'], ENT_QUOTES) . "',testdesc='" . htmlspecialchars($_REQUEST['testdesc'], ENT_QUOTES) . "',subid=" . htmlspecialchars($_REQUEST['subject'], ENT_QUOTES) . ",testfrom='" . $fromtime . "',testto='" . $totime . "',duration=" . htmlspecialchars($_REQUEST['duration'], ENT_QUOTES) . ",totalquestions=" . htmlspecialchars($_REQUEST['totalqn'], ENT_QUOTES) . ",testcode=ENCODE('" . htmlspecialchars($_REQUEST['testcode'], ENT_QUOTES) . "','oespass') where testid=" . $_REQUEST['testid'] . ";";
        if (!@executeQuery($query))
            $_GLOBALS['message'] = mysql_error();
        else
            $_GLOBALS['message'] = "Test Information is Successfully Updated.";
    }
    closedb();
}
else if (isset($_REQUEST['savea'])) {
    /*     * ************************ Step 2 - Case 5 ************************ */
    //Add the new Test information in the database
    $noerror = true;
    $fromtime = $_REQUEST['testfrom'] . " " . date("H:i:s");
    $totime = $_REQUEST['testto'] . " 23:59:59";
    if (strtotime($fromtime) > strtotime($totime) || strtotime($fromtime) < (time() - 3600)) {
        $noerror = false;
        $_GLOBALS['message'] = "Start date of test is either less than today's date or greater than last date of test.";
    } else if ((strtotime($totime) - strtotime($fromtime)) <= 3600 * 24) {
        $noerror = true;
        $_GLOBALS['message'] = "Note:<br/>The test is valid upto " . date(DATE_RFC850, strtotime($totime));
    }
    //$_GLOBALS['message']="time".date_format($first, DATE_ATOM)."<br/>time ".date_format($second, DATE_ATOM);
     $result = executeQuery("select max(testid) as tst from test");
    $r = mysql_fetch_array($result);
    if (is_null($r['tst']))
        $newstd = 1;
    else
        $newstd=$r['tst'] + 1;

    // $_GLOBALS['message']=$newstd;
    if (strcmp($_REQUEST['subject'], "<Choose the Subject>") == 0 || empty($_REQUEST['testname']) || empty($_REQUEST['testdesc']) || empty($_REQUEST['totalqn']) || empty($_REQUEST['duration']) || empty($_REQUEST['testfrom']) || empty($_REQUEST['testto']) || empty($_REQUEST['testcode'])) {
        $_GLOBALS['message'] = "Some of the required Fields are Empty";
    } else if ($noerror) {
        $query = "insert into test values($newstd,'" . htmlspecialchars($_REQUEST['usertype'], ENT_QUOTES) . "','" . htmlspecialchars($_REQUEST['testname'], ENT_QUOTES) . "','" . htmlspecialchars($_REQUEST['testdesc'], ENT_QUOTES) . "',(select curDate()),(select curTime())," . htmlspecialchars($_REQUEST['subject'], ENT_QUOTES) . ",'" . $fromtime . "','" . $totime . "'," . htmlspecialchars($_REQUEST['duration'], ENT_QUOTES) . "," . htmlspecialchars($_REQUEST['totalqn'], ENT_QUOTES) . ",0,ENCODE('" . htmlspecialchars($_REQUEST['testcode'], ENT_QUOTES) . "','oespass'),NULL)";
        if (!@executeQuery($query)) {
            if (mysql_errno () == 1062) //duplicate value
                $_GLOBALS['message'] = "Given Test Name voilates some constraints, please try with some other name.";
            else
                $_GLOBALS['message'] = mysql_error();
        }
        else
            $_GLOBALS['message'] = $_GLOBALS['message'] . "<br/>Successfully New Test is Created.";
    }
    closedb();
}
else if (isset($_REQUEST['manageqn'])) {
    /*     * ************************ Step 2 - Case 6 ************************ */
    //Store the Test identity in session varibles and redirect to prepare question section.
    //$tempa=explode(" ",$_REQUEST['testqn']);
    // $testname=substr($_REQUEST['manageqn'],0,-10);
    $testname = $_REQUEST['manageqn'];
    $result = executeQuery("select testid from test where testname='" . htmlspecialchars($testname, ENT_QUOTES) . "';");

    if ($r = mysql_fetch_array($result)) {
        $_SESSION['testname'] = $testname;
        $_SESSION['testqn'] = $r['testid'];
        //  $_GLOBALS['message']=$_SESSION['testname'];
        header('Location: pqtn.php');
    }
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Test Management System</title>
<script language=JavaScript>
<!--
function check_length(my_form)
{
maxLen = 50; // max number of characters allowed
if (my_form.testdesc.value.length >= maxLen) {
// Alert message if maximum limit is reached. 
// If required Alert can be removed. 
var msg = "You have reached your maximum limit of characters allowed";
alert(msg);
// Reached the Maximum length so trim the textarea
	my_form.testdesc.value = my_form.testdesc.value.substring(0, maxLen);
 }
else{ // Maximum length not reached so update the value of my_text counter
	my_form.text_num.value = maxLen - my_form.testdesc.value.length;
}
}
//-->
</script>
</head>
<link href="hrc.css" type="text/css" rel="stylesheet" />
<link href="assets/bootstrap/css/bootstrap.min.css" rel="stylesheet" />
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-y3tfxAZXuh4HwSYylfB+J125MxIs6mR5FOHamPBG064zB+AFeWH94NdvaCBm8qnd" crossorigin="anonymous">
<script type="text/javascript" src="../validate.js" ></script>
<link rel="icon" type="image/x-icon" href="assets/custom/img/hat.png">
<link href="menu.css" rel="stylesheet" />
<script src="menu.js"></script>
<script src="assets/bootstrap/js/bootstrap.min.js"></script>
<script src="assets/bootstrap/js/bootstrap-datepicker.js"></script>
<link rel="stylesheet" type="text/css" media="all" href="../calendar/jsDatePick.css" />
<script type="text/javascript" src="../calendar/jsDatePick.full.1.1.js"></script>
<link rel="icon" type="image/png" href="../images/hat.png" />
<link href="card.css" rel="stylesheet" type="text/css">
<link href="oes.css" rel="stylesheet" type="text/css" />
<link href="assets/bootstrap/css/datepicker.css" rel="stylesheet" />
<script src="assets/bootstrap/js/bootstrap-datepicker.js"></script>
<link href="assets/bootstrap/css/jquery-ui.css" rel="stylesheet" type="text/css" />
<script src="assets/bootstrap/js/jquery-ui.js"></script>
<link href="pop.css" rel="stylesheet" type="text/css" />
<script type="text/javascript">
            // When the document is ready
            $(document).ready(function () {
                
                $('#testfrom').datepicker({
                    format: "dd/mm/yyyy"
                });  
            
            });
        </script>
        <link rel="stylesheet" href="jquery-ui-themes-1.12.1/themes/base/jquery-ui.css">
		<script type="text/javascript">
            window.onload = function(){
                new JsDatePick({
                    useMode:2,
                    target:"testfrom"
                    //limitToToday:true <-- Add this should you want to limit the calendar until today.
                });

                new JsDatePick({
                    useMode:2,
                    target:"testto"
                    //limitToToday:true <-- Add this should you want to limit the calendar until today.
                });
            };
        </script>
<script type='text/javascript'>
$(window).load(function(){<!--from   ww w . j a va 2  s  .  c  o m-->
    $('#mytext').popover();
});
</script>
<script type="text/javascript" src="../validate.js" ></script>
<body>
<?php
if (isset($_SESSION['admname'])) {
    // Navigations
?>
   <form name="testmng" action="testm.php" method="post">
<div class="container-fluid navbar-fixed-top">
<div class="panel" style="background-color:#34495E; ">
<div class="row" >
<div class="col-lg-6">
<div class="pull-left">
<img src="assets/custom/img/logo.jpg" class="img-responsive"  />
</div>
</div>
<div class="col-lg-6">
<div class="pull-right" >
<input type="submit" value="LogOut" name="logout"  title="Log Out" class="btn btn-link " onclick="return confirm('Are you sure you want to Logout');"/>
<input type="submit" value="Home" name="home"  title="Home" class="btn btn-link " />
</div>
</div>
</div>
<div class="row hidden-lg hidden-md"  >
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
<?php
}
?>
<?php
if (isset($_SESSION['admname'])) {
    // Navigations
?>
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
                        
<?php }
 
?>
</div> <!--menu for mobile close here-->
</div><!--mobile menu row close here-->
<div class="row hidden-sm hidden-xs" style="margin-bottom:-30px;">
<nav class="navbar navbar" role="navigation"  style="margin-top:-12px;">
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
                              <!-- <li><a href="studymaterial.php"><img src="assets/custom/img/study.jpg" height="80" width="150"><span>Study Material</span></a></li>  -->  
                                
                            </ul>
                          </div>
                       </div>
                    </div>
                </div>				
			</li>
        </ul>
        <?php
}
?>
 <ul class="nav navbar-nav pull-right" style="margin-bottom:10px; margin-top:10px; margin-right:30px;">
 <?php
if (isset($_SESSION['admname'])) {
    // Navigations
?>
                       <?php
    //navigation for Add option
    if (isset($_REQUEST['add'])) {
?>
                        <input type="submit" value="Cancel" name="cancel" class="btn btn-primary" title="Cancel"/>
                        <input type="submit" value="Save" name="savea" class="btn btn-primary" onClick="validatetestform('testmng')" title="Save the Changes"/>

<?php
    } else if (isset($_REQUEST['edit'])) { //navigation for Edit option
?>
                        <input type="submit" value="Cancel" name="cancel" class="btn btn-primary" title="Cancel"/>
                        <input type="submit" value="Save" name="savem" class="btn btn-primary" onClick="validatetestform('testmng')" title="Save the changes"/>

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
    echo "<div class=\"message\"><p style=\"color:#000; font-size:20px; color:#00F;\">" . $_GLOBALS['message'] . "</div><br><br>";
}
?>
<?php
if (isset($_SESSION['admname'])) {
    // To display the Help Message
    if (isset($_REQUEST['forpq']))
        echo "<div class=\"pmsg\" style=\"text-align:center\"> Which test questions Do you want to Manage? <br/><b>Help:</b>Click on Questions button to manage the questions of respective tests</div>";
    if (isset($_REQUEST['add'])) {
        /*         * ************************ Step 3 - Case 1 ************************ */
        //Form for the new Test
?>
<div class="panel panel-primary" style="margin-top:-40px;">
   <div class="panel-heading panel-primary" ><center><p style="color:#FFF; font-size:20px; ">Add Test</center></div>
        <div class="panel-body"> 
           <div class="row">
                <div class="col-md-4 col-md-offset-4">
                     <div class="form-group col-md-12">
                           <div class="input-group" >
                        <label  style="margin-right:62px;">Usertype</label>
                      <select name="usertype" class="form-control">
                                    <option selected  value="<Choose the Usertype>" disabled>Choose the Usertype</option>
<?php
        $result = executeQuery("select userid,usertype from usertype;");
        while ($r = mysql_fetch_array($result)) {

            echo "<option value=\"" . $r['userid'] . "\">" . htmlspecialchars_decode($r['usertype'], ENT_QUOTES) . "</option>";
        }
        closedb();
?>
             </select>
           </div> 
        </div>
     </div>
    </div>
    <div class="row">
  <div class="col-md-4 col-md-offset-4">
      <div class="form-group col-md-12">
             <div class="input-group" >
                  <label  style="margin-right:62px;">Subject name</label>
                      <select name="subject" class="form-control">
                             <option selected  value="<Choose the Subject>" disabled>Choose the Subject</option>
                     <?php
                          $result = executeQuery("select subid,subname from subject;");
                         while ($r = mysql_fetch_array($result)) {

            echo "<option value=\"" . $r['subid'] . "\">" . htmlspecialchars_decode($r['subname'], ENT_QUOTES) . "</option>";
        }
        closedb();
?>
      </select>
      </div> 
     </div>
   </div>
  </div>
  <div class="row">
     <div class="col-md-4 col-md-offset-4">
        <div class="form-group col-xs-12">
            <div class="input-group" >
                <label style="margin-right:90px;">Test name</label>
                      <input type="text" name="testname" value=""  class="form-control" onKeyUp="isalphanum(this)" />
                         <span class="c"> <small><b><br>Test Name must be Unique in order to identify different tests on same subject.</b></small> </span>
                </div> 
             </div>
          </div>
       </div>
   <div class="row">
      <div class="col-md-4 col-md-offset-4">
          <div class="form-group col-xs-12">
              <div class="input-group" >
                 <label style="margin-right:48px;">Test Description</label>
                    <textarea  name="testdesc" rows=4 cols=30 name="testdesc"  class="form-control"></textarea>
    <br>                               
<!--<input size=1 value=50 name=text_num> -->
                   <!-- <textarea name="testdesc"  class="form-control" maxlength="50" id="textarea 1"></textarea><br />-->
                  <!--  <span class="co">  <small><b><br>Describe here:What the test is all about?</b></small> </span>-->
              </div> 
            </div>
         </div>
      </div>
<div class="row">
  <div class="col-md-4 col-md-offset-4">
     <div class="form-group col-xs-12">
          <div class="input-group" >
              <label style="margin-right:50px;">Total Questions</label>
                  <input type="text" name="totalqn" value=""  onKeyUp="isnum(this)" class="form-control" />
                      <!--    <span class="c"> <small><b><br>Test Name must be Unique in order to identify different tests on same subject.</b></small> </span>-->
                      </div> 
                   </div>
                 </div>
               </div>
              <div class="row">
                 <div class="col-md-4 col-md-offset-4">
                      <div class="form-group col-xs-12">
                          <div class="input-group">
                             <label style="margin-right:48px;">Duration(Mins)</label>
                              <input type="text" name="duration" value=""  onKeyUp="isnum(this)" class="form-control" />
                            </div> 
                          </div>
                       </div>
                    </div>
            <div class="row">
              <div class="col-md-4 col-md-offset-4 ">
                  <div class="form-group col-xs-12">
                     <div class="input-group" >
                         <label style="margin-right:90px;">Test From</label> 
                          <input type="text" name="testfrom" class="form-control" id="datepicker" placeholder="select date" >
                      </div>
                   </div>
              </div>
           </div>
       <div class="row">
         <div class="col-md-4 col-md-offset-4 ">
             <div class="form-group col-xs-12">
                <div class="input-group" >
                   <label style="margin-right:90px;">Test to</label> 
                      <input type="text" name="testto" class="form-control"    id="datepicker1" placeholder="select date" >
                </div> 
             </div>
         </div>
    </div>
<div class="row">
  <div class="col-md-4 col-md-offset-4">
  
                    <div class="form-group col-xs-12">
                   
                        <div class="input-group" >
                        <label style="margin-right:50px;">Test Secret Code</label>
                     <input type="text" name="testcode" value=""  onKeyUp="isalphanum(this)" class="form-control" />
                      <span class="c"> <small><b><br>Note:Candidates must enter this code in order to take the test </b></small> </span>
                      </div> 
        </div>
                    </div>
    </div>        

                      
                    </div>
                    </div>

 
<?php
    }
	else if (isset($_REQUEST['edit'])) {
 /*         * ************************ Step 3 - Case 2 ************************ */
        // To allow Editing Existing Test.
        $result = executeQuery("select t.totalquestions,t.duration,t.testid,t.testname,t.testdesc,t.subid,s.subname,DECODE(t.testcode,'oespass') as tcode,DATE_FORMAT(t.testfrom,'%Y-%m-%d') as testfrom,DATE_FORMAT(t.testto,'%Y-%m-%d') as testto from test as t,subject as s where t.subid=s.subid and t.testname='" . htmlspecialchars($_REQUEST['edit'], ENT_QUOTES) . "';");
	if (mysql_num_rows($result) == 0) {
            header('Location: testm.php');
        } else if ($r = mysql_fetch_array($result)) {//editing components
		
?>
<div class="panel panel-primary" style="margin-top:-40px;">
            <div class="panel-heading panel-primary" ><center><p style="color:#FFF; font-size:20px; ">Edit Testt</center></div>
               <div class="panel-body">  
                 <div class="row">
                    <div class="col-md-4 col-md-offset-4">
                       <div class="form-group col-md-12">
                          <div class="input-group" >
                             <label style="margin-right:62px;">Subject name</label>
                               <select class="form-control" class="selectpicker" name="subject" data-live-search="true" >
                                  <?php
                                     $result = executeQuery("select subid,subname from subject;");
									 while ($r1 = mysql_fetch_array($result)) {
                                     if (strcmp($r['subname'], $r1['subname']) == 0)
                                     echo "<option value=\"" . $r1['subid'] . "\" selected>" . htmlspecialchars_decode($r1['subname'], ENT_QUOTES) . "</option>";
                else
                 
		echo "<option value=\"" . $r1['subid'] . "\">" . htmlspecialchars_decode($r1['subname'], ENT_QUOTES) . "</option>";
  			}
            closedb();
?>
           </select>
           </div> 
        </div>
      </div>
   </div>
   <div class="row">
      <div class="col-md-4 col-md-offset-4">
            <div class="form-group col-xs-12">
               <div class="input-group" >
                   <label style="margin-right:90px;">Test name</label>
                      <input type="text" name="testname" value="<?php echo htmlspecialchars_decode($r['testname'], ENT_QUOTES); ?>"  class="form-control" onKeyUp="isalphanum(this)" />
                     
<span class="c"> <small><b><br>Test Name must be Unique in order to identify different tests on same subject.</b></small> </span>
           </div> 
        </div>
     </div>
  </div>
               
<div class="row">
  <div class="col-md-4 col-md-offset-4">
     <div class="form-group col-xs-12">
        <div class="input-group" >
           <label style="margin-right:48px;">Test Description</label>
             <textarea name="testdesc" rows=4 cols=30 name="testdesc"  class="form-control"><?php echo htmlspecialchars_decode($r['testdesc'], ENT_QUOTES); ?> </textarea>
                <!--   <textarea name="testdesc" maxlength="50" class="form-control" onkeypress="len();" onkeyup="len();" ><?php /*?><?php echo htmlspecialchars_decode($r['testdesc'], ENT_QUOTES); ?><?php */?></textarea>-->
                        <!--    <small><b><br>Describe here:What the test is all about?</b></small>-->
                </div> 
            </div>
        </div>
    </div>
<div class="row">
  <div class="col-md-4 col-md-offset-4">
    <div class="form-group col-xs-12">
       <div class="input-group" >
          <label style="margin-right:50px;">Total Questions</label>
             <input type="hidden" name="testid" value="<?php echo $r['testid']; ?>"/>
                <input type="text" name="totalqn" value="<?php echo htmlspecialchars_decode($r['totalquestions'], ENT_QUOTES); ?>" size="16" onKeyUp="isnum(this)" class="form-control" />
                 </div> 
              </div>
           </div>
       </div>
<div class="row">
  <div class="col-md-4 col-md-offset-4">
    <div class="form-group col-xs-12">
        <div class="input-group" >
             <label style="margin-right:52px;">Duration(Mins)</label>
                 <input type="text" name="duration" value="<?php echo htmlspecialchars_decode($r['duration'], ENT_QUOTES); ?>" size="16" onKeyUp="isnum(this)" class="form-control"/>
                </div> 
            </div>
          </div>
    </div>
              
              
                     <div class="row">
  
   <div class="col-md-4 col-md-offset-4">
  
                    <div class="form-group col-xs-12">
                   
                        <div class="input-group" >
                        <label style="margin-right:70px;">Test From</label>
                 
                   
                   <input type="text" name="testfrom"  value="<?php echo $r['testfrom']; ?>"  class="form-control" id="datepicker" placeholder="select date" required>

                          
                      </div> 
        </div>
                    </div>
    </div>
              
              
              
                       
                               <div class="row">
  
   <div class="col-md-4 col-md-offset-4">
  
                    <div class="form-group col-xs-12">
                   
                        <div class="input-group" >
                        <label style="margin-right:90px;">Test to</label>
                
                  
                    <input type="text" name="testto" class="form-control"  value="<?php echo $r['testto']; ?>"  id="datepicker1" placeholder="select date" >
                          
                      </div> 
        </div>
                    </div>
    </div>
              
              
              
              
              
                  <div class="row">
  
   <div class="col-md-4 col-md-offset-4">
  
                    <div class="form-group col-xs-12">
                   
                        <div class="input-group" >
                        <label style="margin-right:50px;">Test Secret Code</label>
                     <input type="text" name="testcode" value="<?php echo htmlspecialchars_decode($r['tcode'], ENT_QUOTES); ?>"   onKeyUp="isalphanum(this)" class="form-control" />
                      <span class="c"> <small><b><br>Note:Candidates must enter this code in order to take the test </b></small> </span>
                      </div> 
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
    
<div class="container-fluid">
   <div class="panel panel-primary" style="margin-top:-40px;">
             <div class="panel-heading panel-primary"><center><p style="color:#FFF; font-size:20px;">Test Management System</center>   </div>
  </div>  
</div>

<?php
                                /*                                 * ************************ Step 3 - Case 3 ************************ */
                                // Defualt Mode: Displays the Existing Test/s, If any.
                                $result = executeQuery("select t.testid,t.testname,t.testdesc,s.subname,DECODE(t.testcode,'oespass') as tcode,DATE_FORMAT(t.testfrom,'%d-%M-%Y') as testfrom,DATE_FORMAT(t.testto,'%d-%M-%Y %H:%i:%s %p') as testto from test as t,subject as s where t.subid=s.subid order by t.testid asc;");
                                if (mysql_num_rows($result) == 0) {
                                    echo "<h3 style=\"color:#0000cc;text-align:center;\">No Tests Yet..!</h3>";
                                } else {
                                    $i = 0;
?>




             
<?php
                                    while ($r = mysql_fetch_array($result)) {
                                        $i = $i + 1;


?>





           <div class="container">  
         
      <div class="row">
        
        <div class="col-xs-6 ">
			<div class="project project-default ">
				<div class="shape">
					<div class="shape-text">
						<?php
						
						
						echo"<td> " . htmlspecialchars_decode($r['testid'], ENT_QUOTES)."</td>";
						
						?>						
					</div>
				</div>
				<div class="project-content">
					<h4 class="lead">
                    <?php
					 
						 // echo "<td style=\"text-align:center;\"><input type=\"checkbox\" name=\"d$i\" value=\"" . $r['testid'] . "\" /></td><td> " . htmlspecialchars_decode($r['testname'], ENT_QUOTES)."</td><hr class=\"hr\" >";
						   echo "<input type=\"checkbox\" name=\"d$i\" value=\"" . $r['testid'] . "\" size\"15\" /> " . htmlspecialchars_decode($r['testname'], ENT_QUOTES)."<hr class=\"hr\" >";
                                       
										?>
					</h4>
					
                    <?php
						 if ($i % 2 == 0)
                                            echo "<tr class=\"alt\">";
                                        else
                                            echo "<tr>";
											
											
											
											$string= $r['testdesc'];
											$string = strip_tags($string);

if (strlen($string) >35) {

    // truncate string
    $stringCut = substr($string, 0, 35);

    // make sure it ends in a word so assassinate doesn't become ass...
    $string = substr($stringCut, 0, strrpos($stringCut, ' ')); 
}

											  echo "<td id=\"ex\" ><p style=\"color:#000; font-size:16px;\"\>Test Description:</td><td > $string...</td><hr>";
                                      echo"<td><p style=\"color:#000; font-size:16px;\">Subject Name:</td><td>" . htmlspecialchars_decode($r['subname'], ENT_QUOTES) . "</td><hr><td><p style=\"color:#000; font-size:16px;\">Secret Code:</td><td>" . htmlspecialchars_decode($r['tcode'], ENT_QUOTES) . "</td><hr><td><p style=\"color:#000; font-size:16px;\">Validity:</td><td>" . $r['testfrom'] . " To " . $r['testto'] . "</td><hr style=\"border: 1px solid #0000FF;  \" / >"
                                        . "<td ><a href=\"testm.php?edit=" . htmlspecialchars_decode($r['testname'], ENT_QUOTES) . "\"><input type=\"button\" value=\"Edit\" class=\"btn btn-primary\" style=\"margin-right:30px;\" title=\"Edit " . htmlspecialchars_decode($r['testname'], ENT_QUOTES) . "\"</a></td>"
                                        . "<td class=\"tddata\"><a  title=\"Manage Questions of " . htmlspecialchars_decode($r['testname'], ENT_QUOTES) . "\"href=\"testm.php?manageqn=" . htmlspecialchars_decode($r['testname'], ENT_QUOTES) . "\"><input type=\"button\" value=\"Manage Questions\" class=\"btn btn-primary\"></a></td></tr>";
										?>
					</p>
				</div>
			</div>
		</div>
            
        
                                <?php
                                    }

								
                          

                                }
                                closedb();
								
                                 
                            }
   
   
   
   
   
	 ?>
				 	   
                        <?php

    
                       }
					  
?>
</div>
  </div><!--/row-->
  
 <?php
if (isset($_SESSION['admname'])) {
    // Navigations
?>
<div class="container-fluid" style="width:1345px; margin-left:-100px;">

<div class="panel panel-footer" style="background-color:#34495E; ">



 <center><b><p style="font-size:100%; color:#FFF;">Copy right 2018 © All rights are reserved and designed by Parrovphins</p></b></center></p>
<?php
}
?>


</div>
</div>




</form>


<script>
$(document).ready(function(){
    $('[data-toggle="popover"]').popover();   
});
</script>

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


<link rel="stylesheet" href="jquery-ui-themes-1.12.1/themes/base/jquery-ui.css">

  <script src="js/jquery-1.12.4.js"></script>
  <script src="js/jquery-ui.js"></script>
 
		
  <script src="pikaday.js"></script>

  <script>

   $( function() {
 $('#datepicker').datepicker({ dateFormat: 'yy-mm-dd' }).val();
  } );
$(document).ready(function() {   
            var sideslider = $('[data-toggle=collapse-side]');
            var sel = sideslider.attr('data-target');
            var sel2 = sideslider.attr('data-target-2');
            sideslider.click(function(event){
                $(sel).toggleClass('in');
                $(sel2).toggleClass('out');
            });
        });
		

</script>




  <script>

   $( function() {
 $('#datepicker1').datepicker({ dateFormat: 'yy-mm-dd' }).val();
  } );
$(document).ready(function() {   
            var sideslider = $('[data-toggle=collapse-side]');
            var sel = sideslider.attr('data-target');
            var sel2 = sideslider.attr('data-target-2');
            sideslider.click(function(event){
                $(sel).toggleClass('in');
                $(sel2).toggleClass('out');
            });
        });
		

</script>


<!--<script>
function len(){
  t_v=textarea.value;
  if(t_v.length>50){
    long_post_container.innerHTML=long_post;
    post_button.className=post_button.className.replace('post_it_regular','post_it_disabled');
    post_button.disabled=true;
  }
  else{
    long_post_container.innerHTML="";
    post_button.className=post_button.className.replace('post_it_disabled','post_it_regular');
    post_button.disabled=false;
  }
  if(t_v.length>50){
        t_v=t_v.substring(0,50);
    }
}
textarea=document.getElementById('testdesc');</script>-->


<link rel="stylesheet" href="jquery-ui-themes-1.12.1/themes/base/jquery-ui.css">

  <script src="js/jquery-1.12.4.js"></script>
  <script src="js/jquery-ui.js"></script>
</body>

</html>