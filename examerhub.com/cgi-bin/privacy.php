<?php
error_reporting(0);
session_start();
        if(!isset($_SESSION['stdname'])){
            $_GLOBALS['message']="Session Timeout.Click here to <a href=\"index.php\">Re-LogIn</a>";
        }
        else if(isset($_REQUEST['logout'])){
                unset($_SESSION['stdname']);
            $_GLOBALS['message']="You are Loggged Out Successfully.";
            header('Location: index.php');
        }
		else if(isset($_REQUEST['home'])){
			   header('Location:../index.php');
		  }
?>
<!DOCTYPE html>
<html lang="en">
<head>
<title>Resale_v2 a Classified ads Category Flat Bootstrap Responsive Website Template | Privacy-Policy :: w3layouts</title>
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
</head>
<body>
	<!-- Navigation -->
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
		<!-- //Navigation -->
	<!-- header -->
	<header>
			<div class="w3ls-header"><!--header-one--> 
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
						<a href="help.html"><i class="fa fa-question-circle" aria-hidden="true"></i> Help</a>
					</li>
					<li class="dropdown head-dpdn">
						<a href="#"><span class="active uls-trigger"><i class="fa fa-language" aria-hidden="true"></i>languages</span></a>
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
				<div class="logo" >
					<h1><a href="index.php" style="text-decoration:none"><span>Examer</span>Hub</a></h1>
				</div>
					
				<div class="clearfix"></div>
			</div>
		</div>
	</header>
	<!-- //header -->
	<!-- breadcrumbs -->
	<div class="w3layouts-breadcrumbs text-center">
		<div class="container">
			<span class="agile-breadcrumbs"><a href="index.php"><i class="fa fa-home home_1"></i></a> / <span>Privacy Policy</span></span>
		</div>
	</div>
	<!-- //breadcrumbs -->
	<!-- Privacy -->
	<div class="privacy main-grid-border">
		<div class="container">
			<h2 class="w3-head">Privacy Policy</h2>
				<p>On the other hand, we denounce with righteous indignation and dislike men who are so beguiled and demoralized by the charms of pleasure of the moment, so blinded by desire, that they cannot foresee the pain and trouble that are bound to ensue; and equal blame belongs to those who fail in their duty through weakness of will, which is the same as saying through shrinking from toil and pain. These cases are perfectly simple and easy to distinguish. In a free hour, when our power of choice is untrammelled and when nothing prevents our being able to do what we like best, every pleasure is to be welcomed and every pain avoided. But in certain circumstances and owing to the claims of duty or the obligations of business it will frequently occur.</p>
				<h4>Security:</h4>
				<p class="privacy-para">At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium voluptatum deleniti atque corrupti quos dolores et quas molestias excepturi sint occaecati cupiditate non provident, similique sunt in culpa qui officia deserunt mollitia animi, id est laborum et dolorum fuga. Et harum</p>
				<ol class="privacy-start">
					<li><a href="#">But I must explain to you how all this mistaken idea of denouncing pleasure and praising pain was born and I will give you a complete account of the system, and expound the actual teachings of the great explorer of the truth, the master-builder of human happiness. No one rejects, dislikes, or avoids .</a></li>
					<li><a href="#">Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed .</a></li>
					<li><a href="#">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse.</a></li>
					<li><a href="#">But I must explain to you how all this mistaken idea of denouncing pleasure and praising pain was born and I will give you a complete account of the system, and expound the actual teachings of the great explorer of the truth, the master-builder of human happiness. No one rejects, dislikes, or avoids .</a></li>
					<li><a href="#">Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed .</a></li>
					<li><a href="#">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse.</a></li>
				</ol>
				<h4 class="use-privay">Tips for safe transaction:</h4>
				<ul class="privacy-start">
					<li><a href="#">Contrary to popular belief, Lorem Ipsum is not simply random text.</a></li>
					<li><a href="#">There are many variations of passages of Lorem Ipsum available.</a></li>
					<li><a href="#">It is a long established fact that a reader will be distracted.</a></li>
					<li><a href="#">Lorem Ipsum is simply dummy text of the printing.</a></li>
					<li><a href="#">Sed ut perspiciatis unde omnis iste natus error sit voluptatem.</a></li>
					<li><a href="#">Contrary to popular belief, Lorem Ipsum is not simply random text.</a></li>
					<li><a href="#">There are many variations of passages of Lorem Ipsum available.</a></li>
					<li><a href="#">It is a long established fact that a reader will be distracted.</a></li>
					<li><a href="#">Lorem Ipsum is simply dummy text of the printing.</a></li>
					<li><a href="#">Sed ut perspiciatis unde omnis iste natus error sit voluptatem.</a></li>
					<li><a href="#">Contrary to popular belief, Lorem Ipsum is not simply random text.</a></li>
					<li><a href="#">There are many variations of passages of Lorem Ipsum available.</a></li>
					<li><a href="#">It is a long established fact that a reader will be distracted.</a></li>
					<li><a href="#">Lorem Ipsum is simply dummy text of the printing.</a></li>
					<li><a href="#">Sed ut perspiciatis unde omnis iste natus error sit voluptatem.</a></li>
				</ul>
		</div>	
	</div>
	<!-- // Privacy -->
	<!--footer section start-->		
	<footer>
		<div class="w3-agileits-footer-top">
			<div class="container">
				<div class="wthree-foo-grids">
					<div class="col-md-3 wthree-footer-grid">
						<h4 class="footer-head">Who We Are</h4>
						<p>We at Parrovphins have examerHub, a tool to conduct online exams. We have professional team to maintain and manage this tool. </p>
						<p>This tool is used by educational institutions to train their students to appear for competitive exams both for higher education and employment opportunities. </p>
					</div>
					<div class="col-md-3 wthree-footer-grid">
						<h4 class="footer-head">Help</h4>
						<ul>
							<li><a href="howitworks.html"><i class="fa fa-long-arrow-right" aria-hidden="true"></i>How it Works</a></li>
							<li><a href="sitemap.html"><i class="fa fa-long-arrow-right" aria-hidden="true"></i>Sitemap</a></li>
							<li><a href="faq.html"><i class="fa fa-long-arrow-right" aria-hidden="true"></i>Faq</a></li>
							<li><a href="feedback.html"><i class="fa fa-long-arrow-right" aria-hidden="true"></i>Feedback</a></li>
							<li><a href="contact.html"><i class="fa fa-long-arrow-right" aria-hidden="true"></i>Contact</a></li>
							<li><a href="typography.html"><i class="fa fa-long-arrow-right" aria-hidden="true"></i>Short codes</a></li>
							<li><a href="icons.html"><i class="fa fa-long-arrow-right" aria-hidden="true"></i>Icons Page</a></li>
						</ul>
					</div>
					<div class="col-md-3 wthree-footer-grid">
						<h4 class="footer-head">Information</h4>
						<ul>
							<li><a href="regions.html"><i class="fa fa-long-arrow-right" aria-hidden="true"></i>Locations Map</a></li>
							<li><a href="terms.php"><i class="fa fa-long-arrow-right" aria-hidden="true"></i>Terms of Use</a></li>
							<li><a href="popular-search.html"><i class="fa fa-long-arrow-right" aria-hidden="true"></i>Popular searches</a></li>
							<li><a href="privacy.php"><i class="fa fa-long-arrow-right" aria-hidden="true"></i>Privacy Policy</a></li>
						</ul>
					</div>
					<div class="col-md-3 wthree-footer-grid">
						<h4 class="footer-head">Contact Us</h4>
						<span class="hq">Parrovphins Solutions</span>
						<address>
							<ul class="location">
								<li><span class="glyphicon glyphicon-map-marker"></span></li>
								<li>Vaz chembers Ground floor Near besent college Kodialbail manglore</li>
							</ul> 
							<div class="clearfix"> </div>
							<ul class="location">
								<li><span class="glyphicon glyphicon-earphone"></span></li>
								<li>+0 561 111 235</li>
							</ul> 
							<div class="clearfix"> </div>
							<ul class="location">
								<li><span class="glyphicon glyphicon-envelope"></span></li>
								<li><a href="mailto:info@example.com">info@examerhub.com</a></li>
							</ul> 
						</address>
					</div>
					<div class="clearfix"></div>
				</div> 
			</div> 
		</div> 
		<div class="agileits-footer-bottom text-center">
			<div class="container">
				<div class="w3-footer-logo">
					<h1><a href="index.php"><span>Examer</span>Hub</a></h1>
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
</body>
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
</html>