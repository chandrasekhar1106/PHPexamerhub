<?php
error_reporting(0);
session_start();
include_once 'database/connect.php';
if(!isset($_SESSION['stdname'])) {
    header('Location: signin.php');
    //$_GLOBALS['message']="Session Timeout.Click here to <a href=\"index.php\">Re-LogIn</a>";
}
else if(isset($_REQUEST['logout'])) {
    //Log out and redirect login page
        unset($_SESSION['stdname']);
        header('Location: index.php');

    }
    else if(isset($_REQUEST['back'])) {
        //redirect to View Result
        header('Location: viewresult.php');
        }
        else if(isset($_REQUEST['dashboard'])) {
        //redirect to dashboard
        header('Location: dashboard.php');
        }
		else if(isset($_REQUEST['home'])){
			   header('Location:index.php');
		}

?>
<?php include_once 'shared/header.php';  ?>
	<div class="w3layouts-breadcrumbs">
		<div class="container">
			<span class="agile-breadcrumbs"><a href="index.php"><i class="fa fa-home home_1"></i></a> 
			<span>View Result/Test Summary</span></span>
		</div>
	</div>
	<!-- //header -->
	<!-- breadcrumbs -->
    <!-- //breadcrumbs -->
	<!-- Categories -->
	<!--Vertical Tab-->
<div class="container" >
    <form id="summary" action="viewresult.php" method="post">
    <?php
    if($_GLOBALS['message']) {
        echo "<div class=\"message\">".$_GLOBALS['message']."</div>";
        }
        ?>
        <?php
            if(isset($_SESSION['stdname'])) {
        ?>
        <?php if(isset($_SESSION['stdname'])) {
            if(isset($_REQUEST['details'])) {
        ?>
        <?php
            }
            else
            {
        ?>
        <?php
            }
        ?>
        <?php
            if(isset($_REQUEST['details'])) {
            $result=executeQuery("select s.stdname,t.testname,sub.subname,DATE_FORMAT(st.starttime,'%d %M %Y %H:%i:%s') as stime,TIMEDIFF(st.endtime,st.starttime) as dur,(select sum(marks) from question where testid=".$_REQUEST['details'].") as tm,IFNULL((select sum(q.marks) from studentquestion as sq, question as q where sq.testid=q.testid and sq.qnid=q.qnid and sq.answered='answered' and sq.stdanswer=q.correctanswer and sq.stdid=".$_SESSION['stdid']." and sq.testid=".$_REQUEST['details']."),0) as om from student as s,test as t, subject as sub,studenttest as st where s.stdid=st.stdid and st.testid=t.testid and t.subid=sub.subid and st.stdid=".$_SESSION['stdid']." and st.testid=".$_REQUEST['details'].";") ;
            if(mysql_num_rows($result)!=0) {
            $r=mysql_fetch_array($result);
        ?>
        &nbsp;&nbsp;&nbsp;
        <div class="container">
            <div class="panel panel-default">
                <div class="panel-heading"><h4 style="color:#0000cc;text-align:center;">Test Information in Detail</h4></div>
                    <div class="panel-body" align="center">
                    <table style="margin-top:-5px;" class="table table-responsive">
                        <tr>
                            <td>Student Name</td>
                            <td>:</td>
                            <td><?php echo htmlspecialchars_decode($r['stdname'],ENT_QUOTES); ?></td>
                        </tr>
                        <tr>
                            <td>Test</td>
                            <td>:</td>
                            <td><?php echo htmlspecialchars_decode($r['testname'],ENT_QUOTES); ?></td>
                        </tr>
                        <tr>
                            <td>Subject</td>
                            <td>:</td>
                            <td><?php echo htmlspecialchars_decode($r['subname'],ENT_QUOTES); ?></td>
                        </tr>
                        <tr>
                            <td>Date and Time</td>
                            <td>:</td>
                            <td><?php echo $r['stime']; ?></td>
                        </tr>
                        <tr>
                            <td>Test Duration</td>
                            <td>:</td>
                            <td><?php echo $r['dur']; ?></td>
                        </tr>
                        <tr>
                            <td>Max. Marks</td>
                            <td>:</td>
                            <td><?php echo $r['tm']; ?></td>
                        </tr>
                        <tr>
                            <td>Obtained Marks</td>
                            <td>:</td>
                            <td><?php echo $r['om']; ?></td>
                        </tr>
                        <tr>
                            <td>Percentage</td>
                            <td>:</td>
                            <td><?php echo (round(($r['om']/$r['tm'])*100,2))." %"; ?></td>
                        </tr>
                       
                    </table>
					<br>
                    <?php
                        $result1=executeQuery("select q.qnid as questionid,q.question as quest,q.correctanswer as ca,sq.answered as status,sq.stdanswer as sa from studentquestion as sq,question as q where q.qnid=sq.qnid and sq.testid=q.testid and sq.testid=".$_REQUEST['details']." and sq.stdid=".$_SESSION['stdid']." order by q.qnid;" );
                        if(mysql_num_rows($result1)==0) {
                        echo"<h3 style=\"color:#0000cc;text-align:center;\">1.Sorry because of some problems Individual questions Cannot be displayed.</h3>";
                        }
                        else {
                        ?>
                        <table class="table table-bordered table-responsive">
                            <tr style="background-color:#C0C0C0">
                                <th style="color:#000000">Q. No</th>
                                <th style="color:#000000">Question</th>
                                <th style="color:#000000">Correct Answer</th>
                                <th style="color:#000000">Your Answer</th>
                                <th style="color:#000000">Score</th>
                                <th>&nbsp;</th>
                            </tr>
                            <?php
                                while($r1=mysql_fetch_array($result1)) {
                                if(is_null($r1['sa']))
                                $r1['sa']="question"; //any valid field of question
                                $result2=executeQuery("select ".$r1['ca']." as corans,IF('".$r1['status']."'='answered',(select ".$r1['sa']." from question where qnid=".$r1['questionid']." and testid=".$_REQUEST['details']."),'unanswered') as stdans, IF('".$r1['status']."'='answered',IFNULL((select q.marks from question as q, studentquestion as sq where q.qnid=sq.qnid and q.testid=sq.testid and q.correctanswer=sq.stdanswer and sq.stdid=".$_SESSION['stdid']." and q.qnid=".$r1['questionid']." and q.testid=".$_REQUEST['details']."),0),0) as stdmarks from question where qnid=".$r1['questionid']." and testid=".$_REQUEST['details'].";");
                                if($r2=mysql_fetch_array($result2)) {
                            ?>
                            <tr>

                                <td style="color:#000000"><?php echo $r1['questionid']; ?></td>
                                <td style="color:#000000"><?php echo htmlspecialchars_decode($r1['quest'],ENT_QUOTES); ?></td>
                                <td style="color:#000000"><?php echo htmlspecialchars_decode($r2['corans'],ENT_QUOTES); ?></td>
                                <td style="color:#000000"><?php echo htmlspecialchars_decode($r2['stdans'],ENT_QUOTES); ?></td>
                                <td style="color:#000000"><?php echo $r2['stdmarks']; ?></td>
                                <?php
                                    if($r2['stdmarks']==0) {
                                     echo"<td style=\"color:#FF0000;\"><div class=\"glyphicon glyphicon-remove\"></div></td>";
                                    }
                                    else {
                                        echo"<td style=\"color:#008000;\"><div class=\"glyphicon glyphicon-ok\"></div></td>";
                                    }
                                ?>
                            </tr>
                            <?php
                            }
                            else {
                                echo"<h3 style=\"color:#0000cc;text-align:center;\">Sorry because of some problems Individual questions Cannot be displayed.</h3>".mysql_error();
                                }
                                }
                                }
                                }
                                else {
                                    echo"<h3 style=\"color:#0000cc;text-align:center;\">Something went wrong. Please logout and Try again.</h3>".mysql_error();
                                }
                                ?>
                        </table>
						
                    </div>
                </div>
            </div>      
            <?php
                }
            else {
            $result=executeQuery("select st.*,t.testname,t.testdesc,DATE_FORMAT(st.starttime,'%d %M %Y %H:%i:%s') as startt from studenttest as st,test as t where t.testid=st.testid and st.stdid=".$_SESSION['stdid']." and st.status='over' order by st.testid desc;");
            if(mysql_num_rows($result)==0) {
            echo"<h3 style=\"color:#000;text-align:center;\">I Think You Haven't Attempted Any Exams Yet..! Please Try Again After Your Attempt.</h3>";
            }
            else {
            ?>
            <br>
            <table class="table table-responsive">
                <thead>
                    <tr style="background-color: #848B8B">
                        <th style="color:#000000">Test Id</th>
                        <th style="color:#000000">Test Name</th>
                        <th style="color:#000000">Date & Time</th>
                        <th style="color:#000000">Total Marks</th>
                        <th style="color:#000000">Obtained Marks</th>
                        <th style="color:#000000">Percentage</th>
                        <th style="color:#000000">Details</th>
                    </tr>
                </thead>
                <tbody>
	            <tr>
                    <?php
                        while($r=mysql_fetch_array($result)) {
                        $i=$i+1;
                        $om=0;
                        $tm=0;
                        $result1=executeQuery("select sum(q.marks) as om from studentquestion as sq, question as q where sq.testid=q.testid and sq.qnid=q.qnid and sq.answered='answered' and sq.stdanswer=q.correctanswer and sq.stdid=".$_SESSION['stdid']." and sq.testid=".$r['testid']." order by sq.testid;");
                        $r1=mysql_fetch_array($result1);
                        $result2=executeQuery("select sum(marks) as tm from question where testid=".$r['testid'].";");
                        $r2=mysql_fetch_array($result2);
                    ?>
                    <?php
                        if ($i % 2 == 0){
                            echo "<tr class=\"alt\">";
                        }
                        else { echo "<tr class=\"info\">";}
                        
                        echo"<td style=\"color:#000000\"> " . htmlspecialchars_decode($r['testid'], ENT_QUOTES)."</td>";
                        echo"<td style=\"color:#000000\">" .htmlspecialchars_decode($r['testname'],ENT_QUOTES)."</td>";
                        echo"<td style=\"color:#000000\">".$r['startt']."</td>";
                        if(is_null($r2['tm'])) {
                        $tm=0;
                        echo "<td style=\"color:#000000\">$tm</td>";
                        }
                        else {
                        $tm=$r2['tm'];
                        echo "<td style=\"color:#000000\">$tm</td>";
                        }
                        if(is_null($r1['om'])) {
                        $om=0;
                        echo "<td style=\"color:#000000\">$om</td>";
                        }
                        else {
                        $om=$r1['om'];
                        echo "<td style=\"color:#000000\">$om</td>";
                        }
                        if($tm==0) {
                        echo "<td style=\"color:#000000\">0</td>";
                        }
                        else {
                        echo "<td style=\"color:#000000\">".round(($om/$tm)*100,2)." %</td>";
                        }
                        echo"<td style=\"color:#000000\"><a  href=\"viewresult.php?details=".$r['testid']."\"><input type=\"button\" value=\"Details\" class=\"btn\" style=\"background-color:#0099e5;color:white;padding:5px 5px;\"  title=\"Details\"></a></td>";
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
    </form>
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
<!--footer section start-->		
<?php include_once 'shared/footer.php';    ?>
			<!-- start-smoth-scrolling -->
		<!-- //here ends scrolling icon -->
</body>
</html>