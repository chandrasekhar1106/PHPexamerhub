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
			   header('Location:index.php');
		  }
?>
<?php include_once 'shared/header.php'; ?>
<!-- //header -->
	<div class="slider">
		<ul class="rslides" id="slider">
			<li>
				<div class="w3ls-slide-text">
					<h3>Take Practice test now.</h3>
					<a href="practice_test.php" class="w3layouts-explore-all">Practice Test</a>
				</div>
			</li>
			<li>
				<div class="w3ls-slide-text">
					<h3>Self-registration</h3>
					<?php if(isset($_SESSION['stdname'])){ ?>
					
					<?php }  else { ?>
					<a href="signup.php" class="w3layouts-explore-all">Sign Up</a>
					<?php } ?>
				</div>
			</li>
			<li>
				<div class="w3ls-slide-text">
					<h3>Studying on your own speed gets the best results.</h3>
					<!--<a href="#" class="w3layouts-explore">Explore</a>-->
				</div>
			</li>
			<li>
				<div class="w3ls-slide-text">
					<h3>a Gateway to Completion of Exams. </h3>
					<!--<a href="#" class="w3layouts-explore">Explore</a>-->
				</div>
			</li>
			<li>
				<div class="w3ls-slide-text">
					<h3>examerHub is also available in android app</h3>
					<a href="#" class="w3layouts-explore-all">Download App</a>
				</div>
			</li>
		</ul>
	</div>
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
		<!-- //Slider -->
		<script>
$(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip(); 
});
</script>
		<div class="main-content">
			<div class="w3-categories">
				<h3>Exam Categories</h3>
				<div class="container">
					<div class="col-md-3">
						<div class="focus-grid w3layouts-boder1">
							<a class="btn-8" href="practice_test.php">
								<div class="focus-border">
									<div class="focus-layout">
										<div class="focus-image"><i class="glyphicon glyphicon-book"></i></div>
										<h4 class="clrchg">Practice Test </h4>
									</div>
								</div>
							</a>
						</div>
					</div>
					<div class="col-md-3">
						<div class="focus-grid w3layouts-boder2">	
						<a class="btn-8" href="taketest.php">
							<div class="focus-border">
								<div class="focus-layout">
									<div class="focus-image"><i class="glyphicon glyphicon-pencil"></i></div>
									<h4 class="clrchg">Take Test</h4>
								</div>
							</div>
						</a>
					</div>
					</div>
					<div class="col-md-3">
					<div class="focus-grid w3layouts-boder3">
						<a class="btn-8" href="viewresult.php">
							<div class="focus-border">
								<div class="focus-layout">
									<div class="focus-image"><i class="glyphicon glyphicon-list-alt"></i></div>
									<h4 class="clrchg">View Result</h4>
								</div>
							</div>
						</a>
					</div>	
					</div>
					
					<div class="col-md-3">
					<div class="focus-grid w3layouts-boder7">
						<a class="btn-8" href="#" >
							<div class="focus-border">
								<div class="focus-layout">
									<div class="focus-image"><i class="glyphicon glyphicon-book"></i></div>
									<h4 class="clrchg">Sample Questions</h4>
									<b>Coming Soon..</b>
								</div>
							</div>
						</a>
					</div>	
					</div>
					
					
					
					
					<div class="col-md-3">
					<div class="focus-grid w3layouts-boder5">
						<a class="btn-8" href="#" >
							<div class="focus-border">
								<div class="focus-layout">
									<div class="focus-image"><i class="glyphicon glyphicon-user"></i></div>
									<h4 class="clrchg">Conduct Test</h4>
									<b>Coming Soon..</b>
								</div>
							</div>
						</a>
					</div>
					</div>
					<div class="col-md-3">
					<div class="focus-grid w3layouts-boder6">
						<a class="btn-8" href="#" >
							<div class="focus-border">
								<div class="focus-layout">
									<div class="focus-image"><i class="glyphicon glyphicon-search"></i></div>
									<h4 class="clrchg">Search Tutor</h4>
									<b>Coming Soon..</b>
								</div>
							</div>
						</a>
					</div>	
					</div>
					
					
					<div class="col-md-3">
					<div class="focus-grid w3layouts-boder4">
						<a class="btn-8" href="#">
							<div class="focus-border">
								<div class="focus-layout">
									<div class="focus-image"><i class="glyphicon glyphicon-question-sign"></i></div>
									<h4 class="clrchg">Request To Test</h4>
									<b>Coming Soon..</b>
								</div>
							</div>
						</a>
					</div>	
					</div>
					
					
					
					
					<div class="col-md-3">
					<div class="focus-grid w3layouts-boder8">
						<a class="btn-8" href="#" data-toggle="modal" data-target="#myModal1">
							<div class="focus-border">
								<div class="focus-layout">
									<div class="focus-image"><i class="glyphicon glyphicon-asterisk"></i></div>
									<h4 class="clrchg">Tutorial</h4>
									<b>Coming Soon..</b>
								</div>
							</div>
						</a>
					</div>	
					</div>
					<div class="clearfix"></div>
				</div>
			</div>				
		<!--partners-->
			<div class="w3layouts-partners">
				<h3>Our Clients</h3>
					<div class="container">
						<div class="row">
							<marquee><p style="font-family: Impact; font-size: 18pt">Mahatma Gandhi Memorial College, Kunjibettu,Udupi | Sharada Residential College, Kunjibettu,Udupi.</p></marquee>
 						</div>
					</div>
			</div>	
		<!--//partners-->
		<!-- mobile app -->
			<!-- mobile app -->
			<div class="agile-info-mobile-app">
				<div class="container">
					<div class="col-md-5 w3-app-left">
						<a href="mobileapp.html"><img src="images/app.png" alt=""></a>
					</div>
					<div class="col-md-7 w3-app-right">
						<h3>Exams are your <span>opportunity</span> at providing your worth to everyone around you.
Grab it and do your best,don't let it pass through</h3>
					  <!--	<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam auctor Sed bibendum varius euismod. Integer eget turpis sit amet lorem rutrum ullamcorper sed sed dui. vestibulum odio at elementum. Suspendisse et condimentum nibh.</p>-->
						<div class="agileits-dwld-app">
							<h6>Download The App : 
								<!--<a href="#"><i class="fa fa-apple"></i></a>
								<a href="#"><i class="fa fa-windows"></i></a>-->
								<a href="#"><i class="fa fa-android"></i></a>
							</h6>
						</div>
					</div>
					<div class="clearfix"></div>
				</div>
			</div>
			<!-- //mobile app -->
	<!--footer section start-->		
	<?php include_once 'shared/footer1.php';    ?>
			<!-- start-smoth-scrolling -->
		<!-- //here ends scrolling icon -->
		 <!-- Modal -->
<div id="myModal1" class="modal fade" role="dialog">
	<div class="modal-dialog">
	<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title"><center><img class="img-responsive" src="images/coming.png" alt=""></center></h4>
			</div>
		</div>
	</div>
</div>
</body>		
</html>