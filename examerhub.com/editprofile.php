<?php
error_reporting(0);
session_start();
include_once 'database/connect.php';
if(!isset($_SESSION['stdname'])) {
	header('Location:index.php');
   // $_GLOBALS['message']="Session Timeout.Click here to <a href=\"index.php\">Re-LogIn</a>";
}
else if(isset($_REQUEST['logout']))
{
   unset($_SESSION['stdname']);
   header('Location: index.php');
}
else if(isset($_REQUEST['dashboard'])){
    header('Location: index.php');
}
	 else if(isset($_REQUEST['home'])){
			   header('Location:index.php');
		  }
	else if(isset($_REQUEST['savem']))
{
if(empty ($_REQUEST['email'])||empty ($_REQUEST['contactno'])||empty ($_REQUEST['pin'])||empty ($_REQUEST['address'])||empty ($_REQUEST['city']))
    {
         $_GLOBALS['message']="Some of the required Fields are Empty.Therefore Nothing is Updated";
    }
    else
    {
     $query="update student set stdname='".htmlspecialchars($_REQUEST['cname'],ENT_QUOTES)."',name='".htmlspecialchars($_REQUEST['name'],ENT_QUOTES)."', stdpassword=ENCODE('".htmlspecialchars($_REQUEST['password'],ENT_QUOTES)."','oespass'),emailid='".htmlspecialchars($_REQUEST['email'],ENT_QUOTES)."',contactno='".htmlspecialchars($_REQUEST['contactno'],ENT_QUOTES)."',address='".htmlspecialchars($_REQUEST['address'],ENT_QUOTES)."',city='".htmlspecialchars($_REQUEST['city'],ENT_QUOTES)."',pincode='".htmlspecialchars($_REQUEST['pin'],ENT_QUOTES)."' where stdid='".$_REQUEST['student']."';";
     if(!@executeQuery($query))
        $_GLOBALS['message']=mysql_error();
     else
        $_GLOBALS['message']="Your Profile is Successfully Updated.";
    }
    closedb();
}
?>
<?php include_once 'shared/header.php';   ?>
	<!-- //header -->
	<!-- breadcrumbs -->
	<div class="w3layouts-breadcrumbs text-center">
		<div class="container">
			<span class="agile-breadcrumbs" style="margin-right:1000px;"><a href="index.php"><i class="fa fa-home home_1"></i></a> /
			<span>Edit Profile</span></span>
		</div>
	</div>
	<!-- //breadcrumbs -->
	<!-- Categories -->
	<!--Vertical Tab-->
	<br>
	<div class="agileinfo_signin">
		<form id="editprofile" action="editprofile.php" method="post">
		<?php
			if($_GLOBALS['message']) {
			
			echo "<div class=\"alert alert-success\"> <strong>Info!</strong> ".$_GLOBALS['message']."</div>";
        	
        	}
    	?>
    	<?php
			if(isset($_SESSION['stdname'])) {
   		?>
		<?php if(isset($_SESSION['stdname'])) {
                         // Navigations
    	?>  
    	<?php if(isset($_SESSION['stdname'])){ ?>
 		<?php } ?>  
		<?php
			$result=executeQuery("select stdid,stdname,name,DECODE(stdpassword,'oespass') as stdpass ,emailid,contactno,address,city,pincode from student where stdname='".$_SESSION['stdname']."';");
        	if(mysql_num_rows($result)==0) {
        	header('Location: index.php');
        	}
        	else if($r=mysql_fetch_array($result))
        	{
		?>
			<input type="text" name="cname" placeholder="Username" readonly value="<?php echo htmlspecialchars_decode($r['stdname'],ENT_QUOTES); ?>" onkeyup="isalphanum(this)" required=""/>
			<input type="text" name="name"  placeholder="Name" readonly value="<?php echo htmlspecialchars_decode($r['name'],ENT_QUOTES); ?>" onkeyup="isalphanum(this)" required=""/>
			<input autocomplete="off" id="" type="text" name="email" placeholder="Email" value="<?php echo htmlspecialchars_decode($r['emailid'],ENT_QUOTES); ?>" required/>
			<input autocomplete="off" id="" type="text" name="contactno" placeholder="Contactno" value="<?php echo htmlspecialchars_decode($r['contactno'],ENT_QUOTES); ?>" onkeyup="isnum(this)" required/>
			<input autocomplete="off" id="" type="text" name="address" placeholder="Address" value="<?php echo htmlspecialchars_decode($r['address'],ENT_QUOTES); ?>" required/>
			<input autocomplete="off" id="" type="text" name="city" placeholder="City" value="<?php echo htmlspecialchars_decode($r['city'],ENT_QUOTES); ?>" onkeyup="isalpha(this)" required/>
			<input type="hidden" autocomplete="off" name="student" value="<?php echo $r['stdid'];?>"/>
			<input type="text" name="pin" placeholder="Pincode" value="<?php echo htmlspecialchars_decode($r['pincode'],ENT_QUOTES); ?>" onkeyup="isnum(this)" required/>
		<?php
		closedb();
		}
		}
		?>										
		<br>
		<!-- Login Button -->
		<!-- End of Login Form -->
		<center><button class="btn btn-primary"  type="submit"  name="savem" class="subbtn" onclick="validateform('editprofile')" title="Save the changes">Save</button></center>
		</br>
		</form>
	</div>
	<?php
	}
	?>
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
<?php include_once 'shared/footer.php'; ?>
			<!-- start-smoth-scrolling -->
		<!-- //here ends scrolling icon -->
</body>
</html>