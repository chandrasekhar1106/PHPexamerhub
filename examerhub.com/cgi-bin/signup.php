<?php
error_reporting(0);
session_start();
$cap = 'notEq';
include_once 'database/connect.php';
/*if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if ($_POST['captcha'] == $_SESSION['cap_code']) {*/
if(isset($_REQUEST['stdsubmit']))
{
/*require_once('recaptchalib.php');
  $privatekey = "6LelHPkSAAAAAJ3reVMJVl6ljASyh__B0bgsFb4G";
  $resp = recaptcha_check_answer ($privatekey,
                                $_SERVER["REMOTE_ADDR"],
                                $_POST["recaptcha_challenge_field"],
                                $_POST["recaptcha_response_field"]);

  if (!$resp->is_valid) {
    // What happens when the CAPTCHA was entered incorrectly
    die ("The reCAPTCHA wasn't entered correctly. Go back and try it again." .
         "(reCAPTCHA said: " . $resp->error . ")");
  } else {
    // Your code here to handle a successful verification
  }*/
 


     $result=executeQuery("select max(stdid) as std from student");
     $r=mysql_fetch_array($result);
     if(is_null($r['std']))
     $newstd=1;
     else
     $newstd=$r['std']+1;

     $result=executeQuery("select stdname as std from student where stdname='".htmlspecialchars($_REQUEST['cname'],ENT_QUOTES)."';");

   
    if(empty($_REQUEST['cname'])||empty ($_REQUEST['password'])||empty ($_REQUEST['email']))
    {
         $_GLOBALS['message']="Some of the required Fields are Empty";
	}
	
	else if(mysql_num_rows($result)>0)
    {
        $_GLOBALS['message']="Sorry the User Name is Not Available Try with Some Other name.";
	}
	$db = mysql_connect('localhost', 'root', 'root', 'oesdb');
  $username = "";
  $email = "";
  if (isset($_POST['stdsubmit'])) {
  	$username = $_POST['cname'];
  	$email = $_POST['email'];
  
  	$sql_u = "SELECT * FROM student WHERE stdname='$username'";
  	$sql_e = "SELECT * FROM student WHERE emailid='$email'";
  	$res_u = mysql_query($db, $sql_u);
  	$res_e = mysql_query($db, $sql_e);

  	if (mysql_num_rows($res_u) > 0) {
  	  $name_error = "Sorry... username already taken"; 	
  	   }else if(mysql_num_rows($res_e) > 0){
  	  $email_error = "Sorry... email already taken"; 	
	  }
	  else{
		$query="insert into student values($newstd,'".htmlspecialchars($_REQUEST['usertype'],ENT_QUOTES)."','".htmlspecialchars($_REQUEST['cname'],ENT_QUOTES)."',ENCODE('".htmlspecialchars($_REQUEST['password'],ENT_QUOTES)."','oespass'),'".htmlspecialchars($_REQUEST['email'],ENT_QUOTES)."','".htmlspecialchars($_REQUEST['contactno'],ENT_QUOTES)."','".htmlspecialchars($_REQUEST['address'],ENT_QUOTES)."','".htmlspecialchars($_REQUEST['city'],ENT_QUOTES)."','".htmlspecialchars($_REQUEST['pin'],ENT_QUOTES)."')";
     if(!@executeQuery($query))
                $_GLOBALS['message']=mysql_error();
     else
     {
        $success=true;
        //$_GLOBALS['message']="Successfully Your Account is Created.Click <a href=\"index.php\">Here</a> to LogIn";
       // header('Location: index.php');
     }
    }
    closedb();
}
}
?>
<?php
if($_GLOBALS['message']) {
	echo "<div class=\"message\">".$_GLOBALS['message']."</div>";
}
?>
<?php
  if($success)
  {
	header('Location: signin.php');
  }
  else
  {
?>
<?php include_once 'shared/header.php'; ?>
	<!-- //header -->
	 <!-- sign up form -->
	<section>
		<div id="agileits-sign-in-page" class="sign-in-wrapper">
			<div class="agileinfo_signin">
			<h3>Sign Up</h3>
				<form action="signup.php" method="post"  onsubmit="return validateform('admloginform');">
				<select name="usertype" class="form-control">
                <option selected  value="<Usertype>" disabled>Select Usertype</option>
                <?php
                        $result = executeQuery("select userid,usertype from usertype;");
                        while ($r = mysql_fetch_array($result)) {
                        echo "<option value=\"" . $r['userid'] . "\">" . htmlspecialchars_decode($r['usertype'], ENT_QUOTES) . "</option>";
                     }
		
                    closedb();
                    ?>
					</select>
					<br>
					<input type="text" name="cname" placeholder="Username" onkeyup="isalphanum(this)" required=""> 
					<input type="password" name="password" onkeyup="isalphanum(this)" placeholder="Password" required="">
					<input type="password" name="repass" onkeyup="isalphanum(this)" placeholder="Retype Password" required="">
					<input type="text" name="email" placeholder="Email" required="">  
				    <input type="text" name="contactno" onkeyup="isnum(this)" placeholder="Contact" required=""> 
					<input type="text" name="address" placeholder="Address" required="">
					<input type="text" name="city" onkeyup="isalpha(this)" placeholder="City"  required="">
					<input type="text" name="pin" onkeyup="isnum(this)" placeholder="Pincode"  required="">
				    <div class="signin-rit">
						<span class="agree-checkbox">
							<label class="checkbox"><input type="checkbox" name="checkbox">I agree to your <a class="w3layouts-t" href="terms.php" target="_blank">Terms of Use</a> and <a class="w3layouts-t" href="privacy.html" target="_blank">Privacy Policy</a></label>
						</span>
					</div>
					<input type="submit" name="stdsubmit" value="Sign Up">
				</form>
				<?php } ?>
			</div>
		</div>
	</section>
	<!-- //sign up form -->
	<!--footer section start-->		
		
		<!--footer section start-->		
<?php include_once 'shared/footer.php';   ?>
			<!-- start-smoth-scrolling -->
		<!-- //here ends scrolling icon -->
		</body>
</html>