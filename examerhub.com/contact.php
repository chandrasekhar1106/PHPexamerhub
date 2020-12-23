<?php
error_reporting(0);
session_start();
$cap = 'notEq';
 include_once 'database/connect.php';
?>
<?php include_once 'shared/header.php'; ?>
	<!-- //header -->
	<!-- breadcrumbs -->
	<div class="w3layouts-breadcrumbs">
		<div class="container">
			<span class="agile-breadcrumbs"><a href="index.php"><i class="fa fa-home home_1"></i></a> / <span>Contact Us</span></span>
		</div>
	</div>
	<!-- //breadcrumbs -->
	<!-- contact -->
	<div class="contact main-grid-border">
		<div class="container">
		<?php

error_reporting(0);
session_start();

if (isset($_REQUEST['send']))
{
 $query="insert into contact_us values(default,'".htmlspecialchars($_REQUEST['name'],ENT_QUOTES)."','".htmlspecialchars($_REQUEST['phone'],ENT_QUOTES)."','".htmlspecialchars($_REQUEST['email'],ENT_QUOTES)."','".htmlspecialchars($_REQUEST['comment'])."')";
     if(executeQuery($query))
	 { ?>
 <div class="alert alert-danger" style="width:600px;">
Sucessfully submitted we will contact you soon.
  </div>
    <?php
	 }
	 else if(isset($_REQUEST['send']) && !executeQuery($query)) 
	 { 
 
 ?>
 <div class="alert alert-danger">
Due to some Network issue your message is not submitted.
  </div>
    <?php
		
	 }
}?>
            
			<h2 class="w3-head text-center">Contact Us</h2>
			<section id="hire">    
				<form id="filldetails" action="contact.php" method="post" onsubmit="return validateform('admloginform');">
					  <div class="field name-box">
							<input type="text" name="name" placeholder="Who Are You?" onkeyup="isalpha(this)"  autocomplete="off" required/>
							<label>Name</label>
							<span class="ss-icon">check</span>
					  </div>
					  
					  <div class="field email-box">
							<input type="text" name="email" placeholder="example@email.com" autocomplete="off" required/>
							<label>Email</label>
							<span class="ss-icon">check</span>
					  </div>
					  
					  
					  <br>
					  <div class="field phonenum-box">
							<input type="text" name="phone" placeholder="Phone Number" onkeyup="isnum(this)"  autocomplete="off" required/>
							<label>Phone</label>
							<span class="ss-icon">check</span>
					  </div>

					  <div class="field msg-box">
							<textarea id="msg" rows="4" name="comment" placeholder="Your message goes here..." required></textarea>
							<label>Your Msg</label>
							<span class="ss-icon">check</span>
					  </div>

					<input class="btn btn-primary btn-md" type="submit" value="Send Us" name="send" />
		 
		
		</form>
		<!-- JavaScript Includes -->
		<script src="js/jquery.knob.js"></script>

		<!-- jQuery File Upload Dependencies -->
		<script src="js/jquery.ui.widget.js"></script>
		<script src="js/jquery.fileupload.js"></script>
		
		<!-- Our main JS file -->
		<script src="js/script.js"></script>
						</div>
			</section>
			<script>
				  $('textarea').blur(function () {
				$('#hire textarea').each(function () {
					$this = $(this);
					if (this.value != '') {
						$this.addClass('focused');
						$('textarea + label + span').css({ 'opacity': 1 });
					} else {
						$this.removeClass('focused');
						$('textarea + label + span').css({ 'opacity': 0 });
					}
				});
			});
			$('#hire .field:first-child input').blur(function () {
				$('#hire .field:first-child input').each(function () {
					$this = $(this);
					if (this.value != '') {
						$this.addClass('focused');
						$('.field:first-child input + label + span').css({ 'opacity': 1 });
					} else {
						$this.removeClass('focused');
						$('.field:first-child input + label + span').css({ 'opacity': 0 });
					}
				});
			});
			$('#hire .field:nth-child(2) input').blur(function () {
				$('#hire .field:nth-child(2) input').each(function () {
					$this = $(this);
					if (this.value != '') {
						$this.addClass('focused');
						$('.field:nth-child(2) input + label + span').css({ 'opacity': 1 });
					} else {
						$this.removeClass('focused');
						$('.field:nth-child(2) input + label + span').css({ 'opacity': 0 });
					}
				});
			});
			$('#hire .field:nth-child(3) input').blur(function () {
				$('#hire .field:nth-child(3) input').each(function () {
					$this = $(this);
					if (this.value != '') {
						$this.addClass('focused');
						$('.field:nth-child(3) input + label + span').css({ 'opacity': 1 });
					} else {
						$this.removeClass('focused');
						$('.field:nth-child(3) input + label + span').css({ 'opacity': 0 });
					}
				});
			});
			$('#hire .field:nth-child(4) input').blur(function () {
				$('#hire .field:nth-child(4) input').each(function () {
					$this = $(this);
					if (this.value != '') {
						$this.addClass('focused');
						$('.field:nth-child(4) input + label + span').css({ 'opacity': 1 });
					} else {
						$this.removeClass('focused');
						$('.field:nth-child(4) input + label + span').css({ 'opacity': 0 });
					}
				});
			});
		  //@ sourceURL=pen.js
		</script>    
		<script>
	  if (document.location.search.match(/type=embed/gi)) {
		window.parent.postMessage("resize", "*");
	  }
	</script>
		</div>	
		<!-- address -->
		<div class="container">
			<div class="agileits-get-us">
				<ul>
					<li><i class="fa fa-map-marker" aria-hidden="true"></i>Vaz Chembers Ground Floor, Kodialbail,Manglore-03</li>
					<li><i class="fa fa-phone" aria-hidden="true"></i>+91 9481611667<br/>+91 7795107025</li>
					<li><i class="fa fa-envelope" aria-hidden="true"></i><a href="mailto:info@example.com">info@examerhub.com support@examerhub.com</a></li>
				</ul>
			</div>
		</div>
		<!-- //address -->
		<div class="map-w3layouts">
			<h3>Location</h3>
			 <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3889.4639850577178!2d74.83769471472765!3d12.87785912041283!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3ba35a453a27e3a7%3A0x2cd01638b0daf387!2sParrovphins+Solutions!5e0!3m2!1sen!2sin!4v1523549562861"  class="hidden-xs hidden-sm map" width="1140" height="450" frameborder="0" style="border:0" allowfullscreen></iframe>
<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3889.4639850577178!2d74.83769471472765!3d12.87785912041283!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3ba35a453a27e3a7%3A0x2cd01638b0daf387!2sParrovphins+Solutions!5e0!3m2!1sen!2sin!4v1523549562861"  width="250" height="300" class="hidden-lg hidden-md" frameborder="0" style="border:0" allowfullscreen></iframe>
   
		</div>
	</div>

	<!-- // contact -->
	<!--footer section start-->		
		<?php include_once 'shared/footer1.php';   ?>
			<!-- start-smoth-scrolling -->
		<!-- //here ends scrolling icon -->
</body>
</html>