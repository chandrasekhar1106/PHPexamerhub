<!DOCTYPE html>
<html lang="en">
<head>
<title>ExamerHub | Home</title>
<link href="css/style.css" rel="stylesheet" type="text/css" media="all" /><!-- style.css -->
<link rel="stylesheet" href="css/flexslider.css" type="text/css" media="screen" /><!-- flexslider-CSS -->
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
<!--Customer Css and js -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script src="js/menu.js"></script>
<link rel="stylesheet" href="css/card.css"> 
<script type="text/javascript" src="js/changepass.js"></script>
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
</head>
<body style="padding-right:0;overflow-y:scroll;">	
		
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
						<?php if(isset($_SESSION['stdname'])){ ?>
						<a href="editprofile.php" style="text-decoration:none";><i class="glyphicon glyphicon-user"></i><span>View Profile</span></a>
						<a href="#" data-toggle="modal" data-target="#myModal" style="text-decoration:none";><i class="glyphicon glyphicon-lock"></i><span>Change Password</span></a>
						<a href="logout.php" style="text-decoration:none";><i class="glyphicon glyphicon-off"></i><span>Logout</span></a>
						<!--	<a href="real-estate.html"><i class="fa fa-fw fa-home"></i><span>Real Estate</span></a>-->
						<?php
						}
						?>
					</div>
				</nav>
			
				<button class="close-button" id="close-button">Close Menu</button>
			</div>
			<button class="menu-button" id="open-button"> </button>
			</div>
			<div class="clearfix"></div>
		</div>
		<!-- //Navigation-->
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
      						<li><a href="editprofile.php" style="color:#000">Edit Profile</a></li>
     						<li><a href="#" style="color:#000" data-toggle="modal" data-target="#myModal">Change Password</a></li>
     						<li><a href="logout.php" style="color:#000">Logout</a></li>
    					</ul>
  					</li>
					<?php } 
					else
					{
                   	?>
					<li class="dropdown head-dpdn">
						<a href="signin.php" aria-expanded="false"><i class="fa fa-user" aria-hidden="true"></i> Sign In</a>
					</li>
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
						<a href="contact.php"></i>Contact Us</a>
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
				<div class="logo" style="margin-top:-25px";>
					<h1><a href="index.php" style="text-decoration:none"><span>Examer</span>Hub</a></h1>
				</div>
				<div class="agileits_search">
					<a class="post-w3layouts-ad" href="index.php"><i class="glyphicon glyphicon-home"></i> &nbsp;Home</a>
				</div> 
				<div class="clearfix"></div>
			</div>
		</div>
	</header>
	<!-- //header -->
	<!-- sign in form -->
	 <section>
		<div id="agileits-sign-in-page" class="sign-in-wrapper">
			<div class="agileinfo_signin">
		
				<form action="signin.php" method="post" autocomplete="off">
				<?php if(isset($_SESSION['stdname'])){
                          header('Location: index.php');}else{  
                         
                        ?>

                     
                        <?php 
						} 
						?>
                        <?php
	error_reporting(0);
    session_start();
	 include_once 'database/connect.php';
     
     if(isset($_REQUEST['stdsubmit']))
      {
		$result=executeQuery("select *,DECODE(stdpassword,'oespass') as std from student where stdname='".htmlspecialchars($_REQUEST['name'],ENT_QUOTES)."' and stdpassword=ENCODE('".htmlspecialchars($_REQUEST['password'],ENT_QUOTES)."','oespass')");
          if(mysql_num_rows($result)>0)
          {

              $r=mysql_fetch_array($result);
              if(strcmp(htmlspecialchars_decode($r['std'],ENT_QUOTES),(htmlspecialchars($_REQUEST['password'],ENT_QUOTES)))==0)
              {
                   $_SESSION['stdname']=htmlspecialchars_decode($r['stdname'],ENT_QUOTES);
				  
                   $_SESSION['stdid']=$r['stdid'];
				   $_SESSION['userid']=$r['userid'];
				   unset($_GLOBALS['message']);
				      echo "<script type='text/javascript'>window.location.href = 'index.php';</script>"
      
				?>
			

			<?php
               }else
               {?>
                 <div class="alert alert-danger">
 Check Your user name and Password.
</div><?php
               }
			}
            else
              {
               ?>
                 <div class="alert alert-danger">
 Check Your user name and Password.
</div><?php
              }
              closedb();
           }
       ?>
      <?php
        if($_GLOBALS['message'])
        {
		?>
        <div class="text-danger " style="font-size:13px;">
        <h5>
            <?php
             echo $_GLOBALS['message'];
        }
      		?>
	  	</h5>
			<h3>Sign In</h3>
	   	<input type="text" name="name"  placeholder="Username" required=""> 
		<input type="password" name="password" placeholder="Password" required=""> 
		<input type="submit" value="Sign In" name="stdsubmit">
		<div class="forgot-grid">
			
			<!-- Modal -->
			<div class="modal fade" id="myModal2" role="dialog">
				<div class="modal-dialog">
				<!-- Modal content-->
					<div class="modal-dialog modal-lg">
						<div class="modal-content">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal">&times;</button>
								<h3 class="w3ls-password">Get Password</h3>		
								<p class="get-pw">Enter your email address below and we'll send you an email with instructions.</p>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="clearfix"> </div>
			</div>
			</form>
				<h6> Not a Member Yet? <a href="signup.php">Sign Up Now</a> </h6>
			</div>
		</div>
	</section>
	<!-- //sign in form -->
	<!--footer section start-->		
	<!--footer section start-->		
<?php include_once 'shared/footer.php';   ?>
			<!-- start-smoth-scrolling -->
		<!-- //here ends scrolling icon -->
		</body>
</html>