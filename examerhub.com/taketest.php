<?php
error_reporting(0);
session_start();
unset($_SESSION['starttime']);
unset($_SESSION['endtime']);
unset($_SESSION['tqn']);
unset($_SESSION['qn']);
unset($_SESSION['duration']);
include_once 'database/connect.php';
if (!isset($_SESSION['stdname'])) {
	header('Location: signin.php');
    //$_GLOBALS['message'] = "Session Timeout.Click here to <a href=\"index.php\">Re-LogIn</a>";
} else if (isset($_SESSION['starttime'])) {
    header('Location: testconducter.php');
} else if (isset($_REQUEST['logout'])) {
    //Log out and redirect login page
    unset($_SESSION['stdname']);
    header('Location: index.php');
} else if (isset($_REQUEST['dashboard'])) {
    //redirect to dashboard
header('Location: dashboard.php');
}
else if(isset($_REQUEST['home'])){
			   header('Location:dashboard.php');
		  }
 else if (isset($_REQUEST['starttest'])) {
    //Prepare the parameters needed for Test Conducter and redirect to test conducter
    if (!empty($_REQUEST['tc'])) {
        $result = executeQuery("select DECODE(testcode,'oespass') as tcode from test where testid=" . $_SESSION['testid'] . ";");

        if ($r = mysql_fetch_array($result)) {
            if (strcmp(htmlspecialchars_decode($r['tcode'], ENT_QUOTES), htmlspecialchars($_REQUEST['tc'], ENT_QUOTES)) != 0) {
                $display = true;
				
				?>
          <script>
			alert("You have entered an Invalid Test Code.Try again.");
			</script>
			
            <?php
               // $_GLOBALS['message'] = "You have entered an Invalid Test Code.Try again.";
            } else {
                //now prepare parameters for Test Conducter and redirect to it.
                //first step: InsSert the questions into table

                $result = executeQuery("select * from question where testid=" . $_SESSION['testid'] . " order by qnid;");
                if (mysql_num_rows($result) == 0) {
                    $_GLOBALS['message'] = "Tests questions cannot be selected.Please Try after some time!";
                } else {
                  //  executeQuery("COMMIT");
                    $error = false;
                    if (!executeQuery("insert into studenttest values(" . $_SESSION['stdid'] . "," . $_SESSION['testid'] . ",(select CURRENT_TIMESTAMP),date_add((select CURRENT_TIMESTAMP),INTERVAL (select duration from test where testid=" . $_SESSION['testid'] . ") MINUTE),0,'inprogress')"))
                        $_GLOBALS['message'] = "error" . mysql_error();
                    else {
                        while ($r = mysql_fetch_array($result)) {
                            if (!executeQuery("insert into studentquestion values(" . $_SESSION['stdid'] . "," . $_SESSION['testid'] . "," . $r['qnid'] . ",'unanswered',NULL)")) {
                                $_GLOBALS['message'] = "Failure while preparing questions for you.Try again";
                                $error = true;
                            }
							
                        }
                        if ($error == true) {
                      // executeQuery("rollback;");
                        } else {
                            $result = executeQuery("select totalquestions,duration from test where testid=" . $_SESSION['testid'] . ";");
                            $r = mysql_fetch_array($result);
                            $_SESSION['tqn'] = htmlspecialchars_decode($r['totalquestions'], ENT_QUOTES);
                            $_SESSION['duration'] = htmlspecialchars_decode($r['duration'], ENT_QUOTES);
                            $result = executeQuery("select DATE_FORMAT(starttime,'%Y-%m-%d %H:%i:%s') as startt,DATE_FORMAT(endtime,'%Y-%m-%d %H:%i:%s') as endt from studenttest where testid=" . $_SESSION['testid'] . " and stdid=" . $_SESSION['stdid'] . ";");
                            $r = mysql_fetch_array($result);
                            $_SESSION['starttime'] = $r['startt'];
                            $_SESSION['endtime'] = $r['endt'];
                            $_SESSION['qn'] = 1;
                            header('Location: test.php');
                        }
                    }
                }
            }
        } else {
            $display = true;
			?>
		
            <script>
			alert("You have entered an Invalid Test Code.Try again.");
			</script>
            <?php
           // $_GLOBALS['message'] = "You have entered an Invalid Test Code.Try again.";
        }
    } else {
        $display = true;
       // $_GLOBALS['message'] = "Enter the Test Code First!";
    }
} else if (isset($_REQUEST['testcode'])) {
    //test code preparation
    if ($r = mysql_fetch_array($result = executeQuery("select testid,userid from test where testname='" . htmlspecialchars($_REQUEST['testcode'], ENT_QUOTES) . "';"))) {
        $_SESSION['testname'] = $_REQUEST['testcode'];
        $_SESSION['testid'] = $r['testid'];
		$_SESSION['userid']=$r['userid'];
    }
} else if (isset($_REQUEST['savem'])) {
    //updating the modified values
    if (empty($_REQUEST['cname']) || empty($_REQUEST['password']) || empty($_REQUEST['email'])) {
        $_GLOBALS['message'] = "Some of the required Fields are Empty.Therefore Nothing is Updated";
    } else {
        $query = "update student set stdname='" . htmlspecialchars($_REQUEST['cname'], ENT_QUOTES) . "', stdpassword=ENCODE('" . htmlspecialchars($_REQUEST['password'], ENT_QUOTES) . "','oespass'),emailid='" . htmlspecialchars($_REQUEST['email'], ENT_QUOTES) . "',contactno='" . htmlspecialchars($_REQUEST['contactno'], ENT_QUOTES) . "',address='" . htmlspecialchars($_REQUEST['address'], ENT_QUOTES) . "',city='" . htmlspecialchars($_REQUEST['city'], ENT_QUOTES) . "',pincode='" . htmlspecialchars($_REQUEST['pin'], ENT_QUOTES) . "' where stdid='" . $_REQUEST['student'] . "';";
        if (!@executeQuery($query))
            $_GLOBALS['message'] = mysql_error();
        else
            $_GLOBALS['message'] = "Your Profile is Successfully Updated.";
    }
    closedb();
}
?>
<?php include_once 'shared/header.php'; ?>
<!-- //header -->
<!-- breadcrumbs -->
<div class="w3layouts-breadcrumbs" style="height:50px;">
	<div class="container" >
		<div class="row">
			<div class="col-md-4" style="margin-top:5px";>
				<span class="agile-breadcrumbs"><a href="index.php"><i class="fa fa-home home_1"></i></a> /
				<span>Test Offer</span></span>
			</div>
			<div class="col-md-4" id="myDIV">
				<div class="form-group">
					<div class="input-group">
						<input onkeypress="searchTest()" type="text" class="form-control" id="user_type_subject" placeholder="Test name"/>
						<span class="input-group-addon">
							<i class="fa fa-search"></i>
						</span>	
					</div>
				</div>
			</div>
			<div class="col-md-4" id="newpost">
				<select id='select_subject' name="subject" class="form-control"  onchange="searchSubject()">
				 
                    <option selected  value="<Choose the Subject>" disabled>Choose the Subject</option>
					<option  value="All" id="select_all" onClick="document.location.reload(true)">All</option>
					<?php
                        $result = executeQuery("select subid,subname from subject;");
                        while ($r = mysql_fetch_array($result)) {
						echo "<option   value=\""  . $r['subid'] . "\">" . htmlspecialchars_decode($r['subname'], ENT_QUOTES) . "</option>";
        			}
        			closedb();
					?>
     			</select>
			</div>
			

				<!-- <select  name="subject" class="form-control" onchange="jsFunction();">
                    <option selected   value="<Choose the Subject>" disabled>Choose the Subject</option>
                   
     			</select> -->
		
			
		</div>
	</div>
</div>
<!-- //breadcrumbs -->
<!-- Products -->
<!-- Categories -->
<!--Vertical Tab-->


<form id="taketest" action="taketest.php" method="post">
<?php
    if($_GLOBALS['message']) {
        echo "<div class=\"message\">".$_GLOBALS['message']."</div>";
    }
        ?>
<?php
if(isset($_SESSION['stdname'])) {
    ?>
<?php
if (isset($_SESSION['stdname'])) {
?>

<?php
if (isset($_REQUEST['testcode']) ) {
?>

						


<center>

<div class="card">
 <br><br>
    <div  class="text-center">  Enter Test Code
            <br><br>
			<div class="inner-addon right-addon">
				<i class="glyphicon glyphicon-lock"></i>
				<input type="text" autocomplete="off" class="form-control"  tabindex="1" name="tc" value="" />
			</div>
			<br><br>
			<button class="btn" style="background-color:#0099e5"; type="submit" tabindex="3" name="starttest"  onclick="check()" >Start Test</button>
			                
		</div>

</div>
</center>
<br>
<script>
$(document).ready(function(){
    $('[data-toggle="popover"]').popover(); 
});
</script>
<?php
} 
else 
{?>
<div id="searchresult">
<?php
$result= executeQuery("select t.totalquestions,t.duration,t.testid,t.testname,t.testdesc,t.userid,t.subid,s.subname,u.usertype,
DECODE(t.testcode,'oespass') as tcode,s.subname,u.usertype from test as t, subject as s, usertype as u where
s.subid=t.subid and u.userid=t.userid and t.testid!=12 and CURRENT_TIMESTAMP<t.testto and t.totalquestions=(select count(*) from
question where testid=t.testid) and NOT EXISTS(select stdid,testid from studenttest where testid=t.testid 
and stdid=" . $_SESSION['stdid'] . ");");
if (mysql_num_rows($result) == 0) 
{
    echo"<h4 style=\"color:#000;text-align:center;\">Sorry...! For this moment, You have not Offered to take any tests.</h>";
}   else {
	?>
	<br>
	<div class="container">
		<table class="table table-responsive">
		   	<thead>
		   		<tr style="background-color: #848B8B">
					<th style="color:#000000;">Test Id</th>
					<th style="color:#000000">Test Name</th>
					<th style="color:#000000">Subject Name</th>
					<th style="color:#000000">Secret Code</th>
					<th style="color:#000000">Total Questions</th>
					<th style="color:#000000">Duration</th>
					<th style="color:#000000">Action</th>
				</tr>
		   	</thead>
		   	<tbody>
			 	<tr style="background-color:#F4F6F7">
				<?php
				
					while ($r = mysql_fetch_array($result)) {
        			$i = $i + 1;
	   			?>										
				<?php
					if ($i % 2 == 0)
					echo "<tr class=\"alt\">";
						else
					// echo "<tr style=\"background-color:#F9EBEA\">";
                    echo "<tr class=\"info\" height=\"10\">";
					echo"<td style=\"color:#000000\">" . htmlspecialchars_decode($r['testid'], ENT_QUOTES)."</td>
					<td style=\"color:#000000\">" . htmlspecialchars_decode($r['testname'], ENT_QUOTES)."</td>
					<td style=\"color:#000000\">" . htmlspecialchars_decode($r['subname'], ENT_QUOTES) . "</td>
					<td style=\"color:#000000\">" . htmlspecialchars_decode($r['tcode'], ENT_QUOTES) . "</td>
					<td style=\"color:#000000\">" . htmlspecialchars_decode($r['totalquestions'], ENT_QUOTES) . "</td>
					<td style=\"color:#000000\">" . htmlspecialchars_decode($r['duration'], ENT_QUOTES) . "</td>"."
					<td style=\"color:#FFFFFF\" ><a href=\"taketest.php?testcode=" . htmlspecialchars_decode($r['testname'], ENT_QUOTES) . "\">
					<input type=\"button\"  value=\"Take Test\" class=\"btn\" style=\"background-color:#0099e5;color:white;padding:5px 5px;\" title=\"Start Test\" onclick=\"showhide()\"></a></td>";
				?>
				<?php
        			}
        			}
        			closedb();
	    			}
				?>
				<?php
        			}
        		?>
				</tr>
      		</tbody>
  		</table>
	</div>
	</div>
</form>
<script type="text/javascript">
    function check()
        {
            if (!taketest.tc.value)
                {
                    alert ("Please Enter testcode");
                    return (false);
                }
                return (true);
        }

</script>
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
<?php include_once 'shared/footer.php'; ?>
        <!--footer section end-->
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
		<script type="text/javascript">
		function searchTest() {
			$.ajax({type: 'post', url: "search_testname.php",data: {reg: $("#user_type_subject").val()}, success: function(result)
{
            $("#searchresult").html(result);
			document.getElementById("txt1").value = "";
        }});
}
</script>
<!-- <script type="text/javascript">
		$(document).ready(function(){
    $("#search_button").click(function(){
		
        $.ajax({type: 'post', url: "search_subject.php",data: {reg: $("#user_type_subject").val()}, success: function(result)
{
            $("#searchresult").html(result);
document.getElementById("txt1").value = "";
        }});
    });
});
</script> -->
<script>
    function searchSubject(){
	var x = document.getElementById("select_subject").selectedIndex;
	var y = document.getElementById("select_subject").options;
	var subname=y[x].text;
	$.ajax({type: 'post', url: "search_subject.php",data: {reg: subname}, success: function(result)
	{
        $("#searchresult").html(result);
		document.getElementById("txt1").value = "";
        }});

    }
</script>
<script type="text/javascript">
$(document).ready(function(){
	$("#sub1").click(function(){
	{
		$.ajax({type: 'post', url: "search_subject.php",data: {reg: $("#subject").val()}, success: function(result)
		{ 
			$("#searchresult").html(result);
			document.getElementById("txt1").value = "";
        }});
	}
</script> 
<script>
    function showhide()
    {
        var div = document.getElementById("newpost");
		if (div.style.display !== "none") {
        div.style.display = "none";
		}
		else {
			div.style.display = "block";
		}
    }
</script>
<script type="text/javascript">
  document.getElementById('select_all').contentWindow.location.reload();
</script>
</body>
</html>