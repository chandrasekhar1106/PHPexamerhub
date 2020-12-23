<?php
error_reporting(0);
session_start();
include_once 'database/connect.php';
if(!isset($_SESSION['stdname'])) {
	header('Location: signin.php');
//$_GLOBALS['message']="Session Timeout.Click here to <a href=\"index.php\">Re-LogIn</a>";
}
else if(isset($_REQUEST['logout']))
{
    //Log out and redirect login page
       unset($_SESSION['stdname']);
       header('Location: index.php');

}
else if(isset($_REQUEST['dashboard'])){
    //redirect to dashboard
    //
     header('Location: dashboard.php');

    }
    else if(isset($_REQUEST['change']))
    {
        //redirect to testconducter
       
       $_SESSION['qn']=substr($_REQUEST['change'],7);
       header('Location: test.php');

    }
    else if(isset($_REQUEST['finalsubmit'])){
    //redirect to dashboard
    //
     header('Location: testack.php');

    }
     else if(isset($_REQUEST['fs'])){
    //redirect to dashboard
    //
     header('Location: testack.php');

    }

   
?>
<!DOCTYPE html>
<html lang="en">
<head>
<title>examerHub-Summary</title>
<link rel="stylesheet" href="css/bootstrap.min.css"><!-- bootstrap-CSS -->
<link rel="stylesheet" href="css/bootstrap-select.css"><!-- bootstrap-select-CSS -->
<link href="css/style.css" rel="stylesheet" type="text/css" media="all" /><!-- style.css -->
<link rel="stylesheet" href="css/font-awesome.min.css" /><!-- fontawesome-CSS -->
<link rel="stylesheet" href="css/menu_sideslide.css" type="text/css" media="all"><!-- Navigation-CSS -->
<!-- meta tags -->
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="keywords" content="Resale Responsive web template, Bootstrap Web Templates, Flat Web Templates, Android Compatible web template, 
Smartphone Compatible web template, free webdesigns for Nokia, Samsung, LG, Sony Ericsson, Motorola web design" />
<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
<!-- //meta tags -->
<!--fonts-->
<link href='//fonts.googleapis.com/css?family=Ubuntu+Condensed' rel='stylesheet' type='text/css'>
<link href='//fonts.googleapis.com/css?family=Open+Sans:400,300,300italic,400italic,600,600italic,700,700italic,800,800italic' rel='stylesheet' type='text/css'>
<!--//fonts-->	
<!-- js -->
<script type="text/javascript" src="js/jquery.min.js"></script>
<!-- js -->
<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="js/bootstrap.js"></script>
<script src="js/bootstrap-select.js"></script>

<!--Customer Css and js -->
<script type="text/javascript" src="js/cdtimer.js" ></script>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<link rel="shortcut icon" type="image/x-icon" href="images/hat.png">
<script type="text/javascript" src="js/changepass.js"></script>
<script type="text/javascript" src="js/menu.js"></script>

<script type = "text/javascript" >
function preventBack(){window.history.forward();}
setTimeout("preventBack()", 0);
window.onunload=function(){null};
</script>

<script type="text/javascript">
function check()
	{
		/*to check if both password and confirm password are same or not*/
		var s1=document.getElementById("newpass").value;
		var s2=document.getElementById("cpass").value;
		if(s1!=s2)
		{
		alert("new and confirm password doesnot match,enter again");
		/*if both password are not same then clear both textboxes and ask to enter again*/
		clearpass();
		}
	}
</script>
<script type="text/javascript" >
			<?php
                $elapsed=date("h:i:sa")-strtotime($_SESSION['starttime']);
                if(((int)$elapsed/60)<(int)$_SESSION['duration'])
                {
                    $result=executeQuery("select TIME_FORMAT(TIMEDIFF(endtime,CURRENT_TIMESTAMP),'%H') as hour,TIME_FORMAT(TIMEDIFF(endtime,CURRENT_TIMESTAMP),'%i') as min,TIME_FORMAT(TIMEDIFF(endtime,CURRENT_TIMESTAMP),'%s') as sec from studenttest where stdid=".$_SESSION['stdid']." and testid=".$_SESSION['testid'].";");
                    if($rslt=mysql_fetch_array($result))
                    {
                     echo "var hour=".$rslt['hour'].";";
                     echo "var min=".$rslt['min'].";";
                     echo "var sec=".$rslt['sec'].";";
                    }
                    else
                    {
                        $_GLOBALS['message']="Try Again";
                    }
                    closedb();
                }
                else
                {
                    echo "var sec=01;var min=00;var hour=00;";
                }
        ?>
    </script>
<script>
  $(document).ready(function () {
    var mySelect = $('#first-disabled2');

    $('#special').on('click', function () {
      mySelect.find('option:selected').prop('disabled', true);
      mySelect.selectpicker('refresh');
    });

    $('#special2').on('click', function () {
      mySelect.find('option:disabled').prop('disabled', false);
      mySelect.selectpicker('refresh');
    });

    $('#basic2').selectpicker({
      liveSearch: true,
      maxOptions: 1
    });
  });
</script>
<!-- language-select -->
<script type="text/javascript" src="js/jquery.leanModal.min.js"></script>
<link href="css/jquery.uls.css" rel="stylesheet"/>
<link href="css/jquery.uls.grid.css" rel="stylesheet"/>
<link href="css/jquery.uls.lcd.css" rel="stylesheet"/>
<!-- Source -->
<script src="js/jquery.uls.data.js"></script>
<script src="js/jquery.uls.data.utils.js"></script>
<script src="js/jquery.uls.lcd.js"></script>
<script src="js/jquery.uls.languagefilter.js"></script>
<script src="js/jquery.uls.regionfilter.js"></script>
<script src="js/jquery.uls.core.js"></script>
<script>
			$( document ).ready( function() {
				$( '.uls-trigger' ).uls( {
					onSelect : function( language ) {
						var languageName = $.uls.data.getAutonym( language );
						$( '.uls-trigger' ).text( languageName );
					},
					quickList: ['en', 'hi', 'he', 'ml', 'ta', 'fr'] //FIXME
				} );
			} );
		</script>
<!-- //language-select -->
<!-- responsive tabs -->
	<link rel="stylesheet" type="text/css" href="css/easy-responsive-tabs.css " />
    <script src="js/easyResponsiveTabs.js"></script>
<!-- /responsive tabs -->
</head>
<body>
	<!-- Navigation -->
	<div class="agiletopbar">
		<div class="wthreenavigation">
			<div class="menu-wrap">
				<nav class="menu">
					<div class="icon-list">
						<a href="practice_test.php" style="text-decoration:none";><i class="glyphicon glyphicon-book"></i><span>Practice Test</span></a>
						<a href="taketest.php" style="text-decoration:none";><i class="glyphicon glyphicon-pencil"></i><span>Take Test</span></a>
						<a href="viewresult.php" style="text-decoration:none";><i class="glyphicon glyphicon-list-alt"></i><span>View Result</span></a>
						<a href="#" style="text-decoration:none";><i class="glyphicon glyphicon-question-sign"></i><span>Request to Exam</span></a>
						<a href="#" style="text-decoration:none";><i class="glyphicon glyphicon-user"></i><span>Conduct Test</span></a>
						<a href="#" style="text-decoration:none";><i class="glyphicon glyphicon-search"></i><span>Search Tutor</span></a>
						<a href="#" style="text-decoration:none";><i class="fa fa-fw fa-book"></i><span>Sample Questions</span></a>
						<a href="#" style="text-decoration:none";><i class="fa fa-fw fa-asterisk"></i><span>Tutorials</span></a>
						<a href="editprofile.php" style="text-decoration:none";><i class="glyphicon glyphicon-user"></i><span>View Profile</span></a>
						<a href="#" data-toggle="modal" data-target="#myModal" style="text-decoration:none";><i class="glyphicon glyphicon-lock"></i><span>Change Password</span></a>
						<a href="logout.php" style="text-decoration:none";><i class="glyphicon glyphicon-off"></i><span>Logout</span></a>
					</div>
				</nav>
				<button class="close-button" id="close-button">Close Menu</button>
			</div>
			<button class="menu-button" id="open-button"> </button>
		</div>
		<div class="clearfix"></div>
	</div>
	<!-- //Navigation -->
	<!-- header -->
	<header>
		<div class="w3ls-header" style="height:40px;"><!--header-one--> 
			<div class="w3ls-header-left">
				<p><a href="#"><i class="fa fa-download" aria-hidden="true"></i>Download Mobile App </a></p>
			</div>
			<div class="w3ls-header-right">
				<ul>
					<li class="dropdown head-dpdn">
						<?php if(isset($_SESSION['stdname'])){ ?>
						<a href="#" class="dropdown-toggle" data-toggle="dropdown"  style="text-decoration:none; color:#FFF;" ><i class="fa fa-user" aria-hidden="true"></i> <?php echo $_SESSION['stdname']; ?></a>
    					<ul class="dropdown-menu">
							<!-- <li><a href="editprofile.php" style="color:#000">Edit Profile</a></li>
							<li><a href="#" style="color:#000" data-toggle="modal" data-target="#myModal">Change Password</a></li>
							<li><a href="logout.php" style="color:#000">Logout</a></li> -->
						</ul>
					</li>
					<?php } 
               			else
                        {
                    ?>
					<!-- <li class="dropdown head-dpdn">
						<a href="signin.php" aria-expanded="false"><i class="fa fa-user" aria-hidden="true"></i> Sign In</a>
					</li>-->
					<?php
						 }
						 ?>
					<li class="dropdown head-dpdn">
						<a href="#"><i class="glyphicon glyphicon-envelope" aria-hidden="true"></i>info@examerhub.com</a>
					</li>
					
					<li class="dropdown head-dpdn">
						<a href="#"><i class="glyphicon glyphicon-earphone" aria-hidden="true"></i> 9481611667</a>
					</li>
					<li class="dropdown head-dpdn">
						<a href="contact.php">Contact Us</a>
					</li> 
					<li class="dropdown head-dpdn">
						<div class="header-right">			
							<!-- Large modal -->
						</div>
					</li>
				</ul>
			</div>
			<div class="clearfix"> </div> 
		</div>
		<div class="container">
			<div class="agile-its-header">
				<div class="logo" style="margin-top:-25px;">
					<h1><a href="index.php" style="text-decoration:none"><span>Examer</span>Hub</a></h1>
				</div>
				<div class="clearfix"></div>
			</div>
		</div>
	</header>
	<!-- //header -->
	<!-- breadcrumbs -->
	<div class="w3layouts-breadcrumbs">
		<div class="container">
			<span class="agile-breadcrumbs" style="margin-right:1000px;"><span>Summary</span></span>
		</div>
	</div>
	<!-- //breadcrumbs -->
	<!-- Categories -->
	<!--Vertical Tab-->
<?php
if($_GLOBALS['message']) {
    echo "<div class=\"message\">".$_GLOBALS['message']."</div>";
}
?>
<?php if(isset($_SESSION['stdname'])) {?>
<div class="container">
    <form id="summary" action="summary.php" method="post">
        <?php if(isset($_SESSION['stdname'])) {
        ?>
    <div class="panel panel-default"  style="background-color:#FFC;">
        <div class="panel-body">
            <span id="timer" class="timerclass"></span>
        </div>
    </div>
</div>
<?php

    $result=executeQuery("select * from studentquestion where testid=".$_SESSION['testid']." and stdid=".$_SESSION['stdid']." order by qnid ;");
    if(mysql_num_rows($result)==0) {
    echo"<h3 style=\"color:#0000cc;text-align:center;\">Please Try Again.</h3>";
    }
    else
    {
?>
<div class="container">
    <div class="panel panel-default"  style="margin-top:-20px;">
        <div class="panel-body">
            <table class="table table-responsive-vertical">
                <tr style="background-color:#C0C0C0;">
                    <th style="color:#000000">Question No</th>
                    <th style="color:#000000">Question</th>
                    <th style="color:#000000">Status</th>
                    <th style="color:#000000">Change Your Answer</th>
                </tr>
                <?php
                    while($r=mysql_fetch_array($result)) {
                    $i=$i+1;
                    if($i%2==0)
                    {
                        echo "<tr class=\"alt\">";
                    }
                        else{ echo "<tr>";}
                        echo "<td align='center'>".$r['qnid']."</td>";
						$res=executeQuery("select question from question where qnid=".$r['qnid']." and testid=".$_SESSION['testid']."");
						if(mysql_num_rows($res)>0)
				        { 
							$r0 = mysql_fetch_array($res);
							echo "<td>".htmlspecialchars_decode($r0['question'],ENT_QUOTES)."</td>";
						}
						if(strcmp(htmlspecialchars_decode($r['answered'],ENT_QUOTES),"unanswered")==0 ||strcmp(htmlspecialchars_decode($r['answered'],ENT_QUOTES),"review")==0)
                        {
                            echo "<td style=\"color:#ff0000\">".htmlspecialchars_decode($r['answered'],ENT_QUOTES)."</td>";
                        }
                        else
                        {
                            echo "<td>".htmlspecialchars_decode($r['answered'],ENT_QUOTES)."</td>";
                        }
                            echo"<td><input type=\"submit\" value=\"Change ".$r['qnid']."\" name=\"change\" class=\"btn btn-link\" /></td></tr>";
                        }

                ?>
                <tr>
                    <td colspan="3" style="text-align:center;"><input type="submit" name="finalsubmit" value="Final Submit" class="btn btn-primary "/></td>
                </tr>
             </table>
        </div>
    </div>
</div>
<?php
}
closedb();
}
?>
</form>
</div>
 <?php }?>
<!---Change Password Modal-->
<div id="myModal" class="modal fade" role="dialog">
	<div class="modal-dialog">
	<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">Change Password</h4>
			</div>
			<div class="modal-body" style="margin-left:100px;">
			<form class="form-horizontal"  id="mmyform"  method="post" autocomplete="off" > 
				<div class="form-group">
					<div class="col-sm-8" >
						<input type="password" class="form-control" name="oldpass"  placeholder="Old password" id="oldpass" required/>
					</div>
				</div>
				<br>
				<div class="form-group">
					<div class="col-sm-8">
						<input type="password" class="form-control" name="newpass" id="newpass" placeholder="New password" onkeyup="isalphanum(this)"  required/>
					</div>
				</div>
				<br>
				<div class="form-group">
					<div class="col-sm-8">
						<input type="password" class="form-control" name="cpass" id="cpass" placeholder="Retype new Password" onchange="check()"  required/>
					</div>
				</div>
				<br>
				<div class="form-group">        
					<div class="col-sm-offset-2">
						<button type="submit" name="submit" class="btn btn-primary">Save</button>
						<button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
					</div>
				</div>
				<?php
				error_reporting(0);
				session_start();
				include_once 'database/connect.php';
				if(isset($_REQUEST['submit']))
				{
	  				$result=executeQuery("select DECODE(stdpassword,'oespass') as stdpass  from student where stdname='" . $_SESSION['stdname'] . "';");
					$n=mysql_num_rows( $result);
					$r = mysql_fetch_array($result);
					if($r['stdpass']!=$_POST['oldpass'])
					{ 
						echo" <script  type='text/javascript'>";
	 					echo"alert('Old password is wrong')";
						echo"</script>";       
					}
					else//if old password is correct
					{
						$q2="update student set stdpassword=ENCODE('" . htmlspecialchars($_REQUEST['newpass']) . "','oespass') where stdname='" . $_SESSION['stdname'] . "'";
						$r2=mysql_query($q2) or die ("update error");
						if($r2>0)
						{
							echo '<script  type="text/javascript">';
	 						echo 'alert("Password Changed");';
	 						echo '</script>';
        				}
					}
				}
				?>
			</form>
			</div>
		</div>
	</div>
</div>
<!--Close modal-->
<!--Plug-in Initialisation-->
	<script type="text/javascript">
    $(document).ready(function() {

        //Vertical Tab
        $('#parentVerticalTab').easyResponsiveTabs({
            type: 'vertical', //Types: default, vertical, accordion
            width: 'auto', //auto or any width like 600px
            fit: true, // 100% fit in a container
            closed: 'accordion', // Start closed if in accordion view
            tabidentify: 'hor_1', // The tab groups identifier
            activate: function(event) { // Callback function if tab is switched
                var $tab = $(this);
                var $info = $('#nested-tabInfo2');
                var $name = $('span', $info);
                $name.text($tab.text());
                $info.show();
            }
        });
    });
</script>
	<!-- //Categories -->
	<!--footer section start-->		
	<footer>
	<div class="agileits-footer-bottom text-center">
			<div class="container">
				<div class="w3-footer-logo">
					<h1><a href="index.php" style="text-decoration:none;"><span>Examer</span>Hub</a></h1>
				</div>
				<div class="w3-footer-social-icons">
					<ul>
						<li><a class="facebook" href="#"><i class="fa fa-facebook" aria-hidden="true"></i><span>Facebook</span></a></li>
						<li><a class="twitter" href="#"><i class="fa fa-twitter" aria-hidden="true"></i><span>Twitter</span></a></li>
						<li><a class="googleplus" href="#"><i class="fa fa-google-plus" aria-hidden="true"></i><span>Google+</span></a></li>
					</ul>
				</div>
				<div class="copyrights">
					<p> © 2018 ExamerHub. All Rights Reserved | Design by  <a href="http://parrovphins.com/"> ParrovPhins</a></p>
				</div>
				<div class="clearfix"></div>
			</div>
		</div>
	</footer>
        <!--footer section end-->
		<!-- Navigation-JavaScript -->
			<script src="js/classie.js"></script>
			<script src="js/main.js"></script>
		<!-- //Navigation-JavaScript -->
		<!-- here stars scrolling icon -->
			<script type="text/javascript">
				$(document).ready(function() {
					/*
						var defaults = {
						containerID: 'toTop', // fading element id
						containerHoverID: 'toTopHover', // fading element hover id
						scrollSpeed: 1200,
						easingType: 'linear' 
						};
					*/
										
					$().UItoTop({ easingType: 'easeOutQuart' });
										
					});
			</script>
			<!-- start-smoth-scrolling -->
			<script type="text/javascript" src="js/move-top.js"></script>
			<script type="text/javascript" src="js/easing.js"></script>
			<script type="text/javascript">
				jQuery(document).ready(function($) {
					$(".scroll").click(function(event){		
						event.preventDefault();
						$('html,body').animate({scrollTop:$(this.hash).offset().top},1000);
					});
				});
			</script>
			<!-- start-smoth-scrolling -->
		<!-- //here ends scrolling icon -->
</body>
</html>