


<!--Here admin can view the result of student-->
<?php



error_reporting(0);
session_start();
include_once '../database/connect.php';
/************************** Step 1 *************************/
if(!isset($_SESSION['admname'])) {
    $_GLOBALS['message']="Session Timeout.Click here to <a href=\"index.php\">Re-LogIn</a>";
}
else if(isset($_REQUEST['logout'])) {
    /************************** Step 2 - Case 1 *************************/
    //Log out and redirect login page
        unset($_SESSION['admname']);
        header('Location: index.php');

    }
    else if(isset($_REQUEST['home'])) {
    /************************** Step 2 - Case 2 *************************/
        //redirect to dashboard
            header('Location: dashboard.php');

        }
        else if(isset($_REQUEST['back'])) {
    /************************** Step 2 - Case 3s *************************/
            //redirect to Result Management
                header('Location: res.php');

            }

?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Result Management System</title>
</head>
<link href="assets/bootstrap/css/bootstrap.min.css" rel="stylesheet" />
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-y3tfxAZXuh4HwSYylfB+J125MxIs6mR5FOHamPBG064zB+AFeWH94NdvaCBm8qnd" crossorigin="anonymous">
 <script type="text/javascript" src="../validate.js" ></script>
    
		<link rel="icon" type="image/x-icon" href="assets/custom/img/hat.png">
<link href="menu.css" rel="stylesheet" />
<script src="menu.js"></script>
<script src="assets/bootstrap/js/bootstrap.min.js"></script>
<body>

 

    <?php if(isset($_SESSION['admname'])) {
                        // Navigations

                            ?>
<form name="rsltmng" action="res.php" method="post">

<div class="container-fluid navbar navbar-fixed-top">

  <div class="panel " style="background-color:#34495E; " ><!-- panel starts-->      
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
</div>
</div>

<!--menu for sm and xm-->
<div class="row hidden-lg hidden-md" style="margin-bottom:20px;">

<div class="dropdown pull-left btn btn-primary" style="margin-left:20px; color:#FFF;">
        <a href="#" data-toggle="dropdown" class="dropdown-toggle" style="color:#FFF;">Dashboard <b class="caret"></b></a>
        <ul class="dropdown-menu">
            <li><a href="sub.php"><img src="assets/custom/img/subject.png" width="50" height="30" />Subject Management</a></li>
            <li><a href="testm.php"><img src="assets/custom/img/test1.png" width="50" height="30" style="margin-left:-40px;" />Test Management</a></li>
              <li><a href="#"><img src="assets/custom/img/qtn1.jpg" width="50" height="30"  />Question Management</a></li>
                <li><a href="#"><img src="assets/custom/img/user.png" width="50" height="30" style="margin-left:-30px;"  />User Management</a></li>
                  <!--<li><a href="#"><img src="assets/custom/img/study.jpg" width="50" height="30"  style="margin-left:-40px;" />Study Material</a></li>-->
                  
                  
                  
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
                        
<?php }
 
?>


</div> <!--menu for mobile close here-->

</div><!--mobile menu row close here-->




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
                               <!--<li><a href="studymaterial.php"><img src="assets/custom/img/study.jpg" height="80" width="150"><span>Study Material</span></a></li> -->  
                                  
                                
                            </ul>
                          </div>
                         
                         
                         
                         
                        </div>
                    </div>
                    
                    <!-- Nav tabs -->
                                       
							
			</li>
        </ul>
        <?php
	}
	?>
         <ul class="nav navbar-nav pull-right" style="margin-bottom:10px; margin-top:10px; margin-right:30px;">

    <?php if(isset($_SESSION['admname'])) {
                        // Navigations

                            ?>
                     
                            <?php  if(isset($_REQUEST['testid'])) { ?>
                       <input type="submit" value="Back" name="back" class=" btn btn-primary" title="Manage Results"/></li>
                            <?php }
				   }?>

</ul>
        
        
    </div><!-- /.navbar-collapse -->
   
    
  </div><!-- /.container-fluid -->
  
</nav>

</div>

</div>
</div>


   
      
    		
				  
<br>				  
<div class="container" style="margin-top:160px;">

    <?php

        if($_GLOBALS['message']) {
            echo "<div class=\"message\">".$_GLOBALS['message']."</div>";
        }
        ?> 

  <?php
			  if (isset($_SESSION['admname'])) {
				  
				  ?>
   <div class="panel panel-primary" style="margin-top:-60px;" >
            <div class="panel-heading panel-primary" ><center><p style="color:#fff; font-size:20px; color:#FFF;">Result Management System</center></div></div>
<div class="panel panel-body panel-info" style="margin-top:-20px;">
<?php
				  
                        if(isset($_REQUEST['testid'])) {
 /************************** Step 3 - Case 1 *************************/
 // Defualt Mode: Displays the Detailed Test Results.
                            $result=executeQuery("select t.testname,DATE_FORMAT(t.testfrom,'%d %M %Y') as fromdate,DATE_FORMAT(t.testto,'%d %M %Y %H:%i:%S') as todate,sub.subname,IFNULL((select sum(marks) from question where testid=".$_REQUEST['testid']."),0) as maxmarks from test as t, subject as sub where sub.subid=t.subid and t.testid=".$_REQUEST['testid'].";") ;
                            if(mysql_num_rows($result)!=0) {

                                $r=mysql_fetch_array($result);
                                ?>
                                <div  align="center">
                   <br> <table>
                        <tr>
                            <td colspan="2"><h3 style="color:#0000cc;text-align:center;">Test Summary:</h3></td>
                        </tr>
                        <tr>
                            <td colspan="2" ><hr style="color:#ff0000;border-width:4px;"/></td>
                        </tr>  
                        <tr>
                            <td><p style="color:#000; font-size:18px;">Test Name</p></td>
                            <td>:</td>
                            <td><?php echo htmlspecialchars_decode($r['testname'],ENT_QUOTES); ?></td>
                        </tr>
                        <tr>
                            <td><p style="color:#000; font-size:18px;">Subject Name</p></td>
                            <td>:</td>
                            <td><?php echo htmlspecialchars_decode($r['subname'],ENT_QUOTES); ?></td>
                        </tr>
                       
                        <tr>
                            <td><p style="color:#000; font-size:18px;">Max. Marks</p></td>
                            <td>:</td>
                            <td><?php echo $r['maxmarks']; ?></td>
                        </tr>
                        <tr><td colspan="2"><hr style="color:#ff0000;border-width:2px;"/></td></tr>
                        <tr>
                            <td colspan="2"><h3 style="color:#0000cc;text-align:center;">Attempted Students</h3></td>
                        </tr>
                        <tr>
                            <td colspan="2" ><hr style="color:#ff0000;border-width:4px;"/></td>
                        </tr>
</table>
                  
    <?php

                               	 $result1=executeQuery("select s.stdname,s.emailid,IFNULL((select sum(q.marks) from studentquestion as sq, question as q where sq.testid=q.testid and sq.qnid=q.qnid and sq.answered='answered' and sq.stdanswer=q.correctanswer and sq.stdid=s.stdid and sq.testid=".$_REQUEST['testid']."),0) as om from student as s,test as t, subject as sub,studenttest as st where s.stdid=st.stdid and st.testid=t.testid and t.subid=sub.subid and st.stdid=s.stdid and st.testid=".$_REQUEST['testid'].";") ;
									
									

                                if(mysql_num_rows($result1)==0) {
                                    echo"<h3 style=\"color:#900;text-align:center;\">No Students Yet Attempted this Test!</h3>";
                                }
                                else {
                                    ?>
                    <table  class="table table-responsive-vertical">
                        <tr style="background-color:#C0C0C0">
                            <th><p style="color:#000; font-size:16px;">Student Name</p></th>
                           
                            <th><p style="color:#000; font-size:16px;">Obtained Marks</p></th>
                            <th><p style="color:#000; font-size:16px;">Result (%)</p></th>

                        </tr>
                                        <?php
                                        while($r1=mysql_fetch_array($result1)) {

                                            ?>
                        <tr>
                            <td><?php echo htmlspecialchars_decode($r1['stdname'],ENT_QUOTES); ?></td>
                          
                            <td><?php echo $r1['om']; ?></td>
                            <td><?php echo (round($r1['om']/$r['maxmarks']*100,2))." %"; ?></td>


                        </tr>
                                        <?php
                                        
                                        }

                                    }
                                }
                                else {
                                    echo"<h3 style=\"color:#0000cc;text-align:center;\">Something went wrong. Please logout and Try again.</h3>";
                                }
                                ?>
                    </table>


                        <?php

                        }
                        else {

                        /************************** Step 3 - Case 2 *************************/
                        // Defualt Mode: Displays the Test Results.
                            $result=executeQuery("select t.testid,t.testname,DATE_FORMAT(t.testfrom,'%d %M %Y') as fromdate,DATE_FORMAT(t.testto,'%d %M %Y %H:%i:%S') as todate,sub.subname,(select count(stdid) from studenttest where testid=t.testid) as attemptedstudents from test as t, subject as sub where sub.subid=t.subid;");
                            if(mysql_num_rows($result)==0) {
                                echo "<h3 style=\"color:#0000cc;text-align:center;\">No Tests Yet...!</h3>";
                            }
                            else {
                                $i=0;

                                ?>
                                
                                
                              
                                 
                                
                                  <table class="table table-responsive table-bordered ">
                        <tr style="background-color:#C0C0C0">
                            <th><p style="color:#000; font-size:14px;">Test Name</p></th>
                            <th><p style="color:#000; font-size:14px;">Validity</p></th>
                            <th><p style="color:#000; font-size:14px;">Subject Name</p></th>
                            <th><p style="color:#000; font-size:14px;">Attempted Students</p></th>
                            <th><p style="color:#000; font-size:14px;">Details</p></th>
                        </tr>
            <?php
                                    while($r=mysql_fetch_array($result)) {
                                        $i=$i+1;
                                        if($i%2==0) {
                                            echo "<tr >";
                                        }
                                        else { echo "<tr>";}
                                        echo "<td>".htmlspecialchars_decode($r['testname'],ENT_QUOTES)."</td><td>".$r['fromdate']." To ".$r['todate']." PM </td>"
                                            ."<td>".htmlspecialchars_decode($r['subname'],ENT_QUOTES)."</td><td>".$r['attemptedstudents']."</td>"
                                            ."<td class=\"tddata\"><a title=\"Details\" href=\"res.php?testid=".$r['testid']."\"><span style=\"font-size:24px; margin-left:20px;\" class=\"glyphicon glyphicon-book \" ></span></a></td></tr>";
                                    }
                                    ?>
                    </table>
                     
                   
        <?php
                            }
                        }
                        closedb();
			  }

                    ?>
                                
                                
                            
                     </div>
                     </div>
                     </div>         
                                
                                
                                
                  

              
     </form>
     
    <?php if(isset($_SESSION['admname'])) {
                        // Navigations

                            ?>    
      
  
 <div class="container-fluid">
  <div class="panel panel-footer"  style="background-color:#34495E; ">
 <center><b><p style="font-size:100%; color:#FFF;">Copy right © All rights are reserved </p></b></center></p>
</div>






<?php
}
?>
</div>







</body>


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
</html>