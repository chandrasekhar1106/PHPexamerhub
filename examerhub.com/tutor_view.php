<?php
error_reporting(0);
session_start();
include_once 'database/connect.php';
if(!isset($_SESSION['stdname'])) {
	header('Location: signin.php');
    //$_GLOBALS['message']="Session Timeout.Click here to <a href=\"index.php\">Re-LogIn</a>";
}
else if(isset($_REQUEST['logout']))
{
    //Log out and redirect login page
    unset($_SESSION['stdname']);
    header('Location: index.php');
}
else if(isset($_REQUEST['dashboard'])){
    //redirect to dashboard
   header('Location: stdwelcome.php');
}
 else if(isset($_REQUEST['home'])){
			   header('dashboard.php');
		  }
if(isset($_SESSION['starttime']))
{
    unset($_SESSION['starttime']);
    unset($_SESSION['endtime']);
    unset($_SESSION['tqn']);
    unset($_SESSION['qn']);
    unset($_SESSION['duration']);
    executeQuery("update studenttest set status='over' where testid=".$_SESSION['testid']." and stdid=".$_SESSION['stdid'].";");
	}
	?>
 
<?php
$conn=new PDO('mysql:host=localhost; dbname=examerhub', 'root', '') or die(mysql_error());
if(isset($_POST['submit'])!=""){
  $name=$_FILES['photo']['name'];
  $size=$_FILES['photo']['size'];
  $type=$_FILES['photo']['type'];
  $temp=$_FILES['photo']['tmp_name'];
  $caption1=$_POST['caption'];
  $link=$_POST['link'];
  move_uploaded_file($temp,"files/".$name);
$query=$conn->query("insert into upload(name)values('$name')");
if($query){
header("location:index.php");
}
else{
die(mysql_error());
}
}
?>

<?php include_once 'shared/header.php'; ?>
	<!-- //header -->
	<!-- breadcrumbs -->
	<div class="w3layouts-breadcrumbs">
		<div class="container">
			<span class="agile-breadcrumbs"><a href="index.php"><i class="fa fa-home home_1"></i></a> /<span>Tutor Management</span></span>
		</div>
	</div>
	<!-- //breadcrumbs -->
	<!-- Categories -->
	<!--Vertical Tab-->
    <?php
		if($_GLOBALS['message']) {
            echo "<div class=\"message\">".$_GLOBALS['message']."</div>";
        }
    ?>
	
	<?php
		if(isset($_SESSION['stdname'])) {
   	?>
	<br><br>
 
<?php
$result = executeQuery("select * from tutor_add order by id;");
                if (mysql_num_rows($result) == 0) {
                    echo "<h3 style=\"color:#0000cc;text-align:center;\">No Tutor Yet..!</h3>";
                } else {
                    $i = 0;
?>

<div class="container">
	<div class="panel panel-primary">
		<div class="panel-heading panel-primary"><center><p style="color:#000; font-size:20px; color:#FFF;">Tutor Management</center></div>
			<div class="panel-body"> 
				<div class="table-responsive-vertical shadow-z-1 ">
				<!-- Table starts here -->
					<table id="table" class="table table-hover table-mc-light-blue">
					<thead>
						<tr style="background-color:#C0C0C0">
							<th>&nbsp;</th>
							<th><p style="color:#000; font-size:16px;">Tutor Name</th>
							<th><p style="color:#000; font-size:16px;">Expertice</th>
							<th><p style="color:#000; font-size:16px;">Experience</th>
							<th><p style="color:#000; font-size:16px;">Contact</th>
						</tr>
					</thead>
					<tbody>
				<?php
                    while ($r = mysql_fetch_array($result)) {
                        $i = $i + 1;
                        if ($i % 2 == 0) {
                            echo "<tr class=\"alt\">";
                        } else {
                            echo "<tr>";
                        }
                        echo " <td data-title=\"ID\" style=\"text-align:center;\"><input type=\"checkbox\" name=\"d$i\" value=\"" . $r['id'] . "\" /></td><td>" . htmlspecialchars_decode($r['t_name'], ENT_QUOTES)
                        . "</td><td>" . htmlspecialchars_decode($r['expertice'], ENT_QUOTES) . "</td><td>" . htmlspecialchars_decode($r['experience'], ENT_QUOTES) . "</td><td>" . htmlspecialchars_decode($r['contact'], ENT_QUOTES) . "</td></tr>";
                    }
?>

</tbody>
</table>
</div>
<?php
}
closedb();
?>
</div>
</div>
</div> <!--panel close-->
</div> <!--container close-->
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

<!--Close modal-->
<!--Plug-in Initialisation-->
	<script type="text/javascript">
    $(document).ready(function() {

        //Vertical Tab
        $('#parentVerticalTab').easyResponsiveTabs({
            type: 'vertical', //Types: default, vertical, accordion
            width: 'auto', //auto or any width like 600px
            fit: true, // 100% fit in a container
            closed: 'accordion', // Start closed if in accordion view
            tabidentify: 'hor_1', // The tab groups identifier
            activate: function(event) { // Callback function if tab is switched
                var $tab = $(this);
                var $info = $('#nested-tabInfo2');
                var $name = $('span', $info);
                $name.text($tab.text());
                $info.show();
            }
        });
    });
</script>

<!-- //Categories -->
<!--footer section start-->		
<br><br>

<?php include_once 'shared/footer.php'; ?>
			<!-- start-smoth-scrolling -->
		<!-- //here ends scrolling icon -->
</body>
</html>