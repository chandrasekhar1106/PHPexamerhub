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
<?php include_once'shared/header.php';   ?>
	<!-- //header -->
	<!-- breadcrumbs -->
	<div class="w3layouts-breadcrumbs">
		<div class="container">
			<span class="agile-breadcrumbs"><a href="index.php"><i class="fa fa-home home_1"></i></a> / <span>Privacy Policy</span></span>
		</div>
	</div>
	<!-- //breadcrumbs -->
	<!-- Privacy -->
	<div class="privacy main-grid-border">
		<div class="container">
			<h2 class="w3-head">Privacy Policy</h2>

				<h5>PRIVACY PRINCIPLES:</h5>
				<p class="privacy-para">Your privacy is important to us we atexamerHub wish to emphasize these underlying principles: We won’t disclose your personal information to anybody, unless it’s for legal purposes, company and/or product development or to safeguard the rights of the company. We respect and keep private any personal information we may collect from you in the course of operating our website.</p>
				<h5>WEBSITE SIGNUP:</h5>
				<p class="privacy-para">You need be a registered user for participating in our website.We are committed to ensuring that your information is secure. We do not share any personally identifying information with outside third parties.</p>
				<h5>LINKS TO OTHER SITES:</h5>
				<p class="privacy-para">Our website contains links leading to other websites that are not owned or managed by us. Because we are not responsible for how these sites handle your privacy, we encourage you to check out the Privacy Policies of those other websites before giving out your personal information.</p>
				<h5>SECURITY:</h5>
				<p class="privacy-para">The security of your Personal Information is important to us, but remember that no method of transmission over the Internet, or method of electronic storage, is 100% secure.We are committed to ensuring that your information is secure. In order to prevent unauthorized access or disclosure we have put in place suitable physical, electronic and managerial procedures to safeguard and secure the information we collect online.</p>
					<h5>COOKIES:</h5>
				<p class="privacy-para">A Cookies disclosure should inform users that you may store cookies on your their computers when they visit the pages of your website.</p>
				
		</div>	
	</div>
	<!-- // Privacy -->
	<!--footer section start-->		
	<?php include_once'shared/footer1.php';  ?>
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