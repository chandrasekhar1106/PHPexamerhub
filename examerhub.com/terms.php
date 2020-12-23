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
<?php include_once 'shared/header.php';      ?>
	<!-- //header -->
	<!-- breadcrumbs -->
	<div class="w3layouts-breadcrumbs">
		<div class="container">
			<span class="agile-breadcrumbs"><a href="index.php"><i class="fa fa-home home_1"></i></a> / <span>Terms</span></span>
		</div>
	</div>
	<!-- //breadcrumbs -->
	<!-- Terms of use -->
	<div class="terms main-grid-border">
		<div class="container">
			<h2 class="w3-head">Terms of Use</h2>
				<div class="panel-group" id="accordion">
				<!-- First Panel -->
					<div class="panel panel-default">
					<div class="panel-body">
				<span>1.</span>The Subscriber shall be provided a unique User id and password in case of online access and an activation code in case of offline products. Subscriber hereby acknowledges that in exercising the right to use his account, the Subscriber is entirely responsible for maintaining the confidentiality of the Subscriber's password and account. The Subscriber shall ensure that the Subscriber exits from the account at the end of each session by signing out.examerHub takes no responsibility and shall stand totally indemnified by the Subscriber for any or all consequences caused by any unauthorized use of the Subscriber's account by any third-party.
						
					</div>
					</div>
					<!-- Second Panel -->
					<div class="panel panel-default">
					<div class="panel-body">
								<span>2.</span>The Subscriber agrees to immediately notify examerHub of any unauthorized use of the Subscriber's password or account or any other breach of security, The Subscriber agrees to provide examerHub current, complete, and accurate registration information as prompted by The Site and to maintain and update this information at all times as required to keep it current, complete and accurate.
							
					</div>
					</div>
					<!-- Third Panel -->
					<div class="panel panel-default">
					<div class="panel-body">
								<span>3.</span> All the contents of the Service are only for general information or use. They do not constitute advice and should not be relied upon in making (or refraining from making) any decision. Any specific advice or replies to queries in any part of the Service is/are the personal opinion of such experts/consultants/persons and are not subscribed to by examerHub.
							</div>
					</div>
					<!-- Fourth Panel -->
					<div class="panel panel-default">
					<div class="panel-body">
								<span>4.</span>The subscription is for a fixed period and ends when the course ends. Moreover, whenever a Subscriber enrolls by agreeing to subscribe to the Service choosing payment through Credit Card/Bank Transfer as the mode of payment, Subscriber shall authorize examerHub to realize the full fee for the Service in advance. The Site will commence service only after due realization of payment. While every endeavor shall be made to start the Service to the Subscriber as early as possible upon realization of the full payment,examerHub shall not be liable for any damages should a delay inevitably occurs.
						</div>
					</div>
					<!-- Fifth Panel -->
					<div class="panel panel-default">
					<div class="panel-body">
								<span>5.</span>In addition to a normal Computer System and necessary hardware, Subscribers are required to have an installed working copy of Microsoft Internet Explorer version 6.0 or above or any other compatible web browser. The web pages are not guaranteed to display in any other format. Further, the Subscriber is advised to install such other software in the Subscriber's Computer software as demanded by the changing technologies, in order to be able to download the contents from the Site from time to time.
						</div>
					</div>
					<!-- Sixth Panel -->
					<div class="panel panel-default">
					<div class="panel-body">
								<span>6.</span> The violation of any of the terms and conditions by the Subscriber shall be adequate grounds for cancellation of the Service, and no liability shall befall OES to refund the fees already paid, either in full or in part. Once the payment has been realized no refund / cancellation will be made on any ground, including non-usage of the Service.
						</div>
					</div>
					
					</div>
					</div>
					</div>
					<!-- Seventh Panel -->
					
	<!-- // Terms of use -->
	<?php include_once 'shared/footer1.php';      ?>
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