<footer>
		<div class="w3-agileits-footer-top">
			<div class="container">
				<div class="wthree-foo-grids">
					<div class="col-md-6 wthree-footer-grid">
						<h4 class="footer-head">Who We Are</h4>
						<p>We at Parrovphins have examerHub, a tool to conduct online exams. We have professional team to maintain and manage this tool. </p>
						<p>This tool is used by educational institutions to train their students to appear for competitive exams both for higher education and employment opportunities. </p>
					</div>
					<!-- <div class="col-md-3 wthree-footer-grid">
						<h4 class="footer-head">Help</h4>
						<ul>
							<li><a href="#"><i class="fa fa-long-arrow-right" aria-hidden="true"></i>How it Works</a></li>
							<li><a href="#"><i class="fa fa-long-arrow-right" aria-hidden="true"></i>Sitemap</a></li>
							<li><a href="#"><i class="fa fa-long-arrow-right" aria-hidden="true"></i>Faq</a></li>
							<li><a href="#"><i class="fa fa-long-arrow-right" aria-hidden="true"></i>Feedback</a></li>
							<li><a href="#"><i class="fa fa-long-arrow-right" aria-hidden="true"></i>Contact</a></li>
							<li><a href="#"><i class="fa fa-long-arrow-right" aria-hidden="true"></i>Short codes</a></li>
							<li><a href="#"><i class="fa fa-long-arrow-right" aria-hidden="true"></i>Icons Page</a></li>
						</ul>
					</div> -->
					<div class="col-md-3 wthree-footer-grid">
						<h4 class="footer-head">Information</h4>
						<ul>
							<!-- <li><a href="#"><i class="fa fa-long-arrow-right" aria-hidden="true"></i>Locations Map</a></li> -->
							<li><a href="terms.php"><i class="fa fa-long-arrow-right" aria-hidden="true"></i>Terms of Use</a></li>
							<!-- <li><a href="#"><i class="fa fa-long-arrow-right" aria-hidden="true"></i>Popular searches</a></li> -->
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
								<li>0824-2497884</li>
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
	<!-- Navigation-Js-->
	<script type="text/javascript" src="js/main.js"></script>
	<script type="text/javascript" src="js/classie.js"></script>
	<!-- //Navigation-Js-->
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
		<script type="text/javascript" src="js/jquery.flexisel.js"></script><!-- flexisel-js -->	
					<script type="text/javascript">
						 $(window).load(function() {
							$("#flexiselDemo3").flexisel({
								visibleItems:1,
								animationSpeed: 1000,
								autoPlay: true,
								autoPlaySpeed: 5000,    		
								pauseOnHover: true,
								enableResponsiveBreakpoints: true,
								responsiveBreakpoints: { 
									portrait: { 
										changePoint:480,
										visibleItems:1
									}, 
									landscape: { 
										changePoint:640,
										visibleItems:1
									},
									tablet: { 
										changePoint:768,
										visibleItems:1
									}
								}
							});
							
						});
					   </script>
		<!-- Slider-JavaScript -->
			<script src="js/responsiveslides.min.js"></script>	
			 <script>
			$(function () {	
			  $("#slider").responsiveSlides({
				auto: true,
				pager: false,
				nav: true,
				speed: 500,
				maxwidth: 800,
				namespace: "large-btns"
			  });

			});
		  </script>
		<!-- //Slider-JavaScript -->
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