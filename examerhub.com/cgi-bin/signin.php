<?php include_once 'shared/header.php'; ?>
	<!-- //header -->
	<!-- sign in form -->
	 <section>
		<div id="agileits-sign-in-page" class="sign-in-wrapper">
			<div class="agileinfo_signin">
			<h3>Sign In</h3>
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
				?>
<script>
  window.location.href = "http://examerhub.com/index.php";
</script>
			<?php
               }else
               {
                  $_GLOBALS['message']="Check Your user name and Password.";
               }
			}
            else
              {
                 $_GLOBALS['message']="Check Your user name and Password.";
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
	   	<input type="text" name="name"  placeholder="Username" required=""> 
		<input type="password" name="password" placeholder="Password" required=""> 
		<input type="submit" value="Sign In" name="stdsubmit">
		<div class="forgot-grid">
			<label class="checkbox"><input type="checkbox" name="checkbox">Remember me</label>
			<div class="forgot">
				<a href="#" data-toggle="modal" data-target="#myModal2">Forgot Password?</a>
			</div>
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