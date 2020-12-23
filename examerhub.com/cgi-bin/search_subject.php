<?php 
session_start();
include 'database/connect.php';
$q = $_POST['reg'];

$result= executeQuery("select t.totalquestions,t.duration,t.testid,t.testname,t.testdesc,t.userid,t.subid,s.subname,u.usertype,
DECODE(t.testcode,'oespass') as tcode,s.subname,u.usertype from test as t, subject as s, usertype as u where
s.subid=t.subid and s.subname='$q' and u.userid=t.userid and CURRENT_TIMESTAMP<t.testto and t.totalquestions=(select count(*) from
question where testid=t.testid) and NOT EXISTS(select stdid,testid from studenttest where testid=t.testid 
and stdid=" . $_SESSION['stdid'] . ");");
if (mysql_num_rows($result) == 0) 
{
    echo"<h3 style=\"color:#000;text-align:center;\">Sorry...! For this moment, You have not Offered to take any tests.</h3>";
}   else {
	?>
	<br>
	<div class="container">
		<table class="table">
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
				    $i=0;
					while ($r = mysql_fetch_array($result)) {
        			$i = $i + 1;
	   		
					if ($i % 2 == 0)
					echo "<tr class=\"alt\">";
						else
					  echo "<tr class=\"info\" height=\"10\">";
					echo"<td style=\"color:#000000\"> " . htmlspecialchars_decode($r['testid'], ENT_QUOTES)."</td>
					<td style=\"color:#000000\"> " . htmlspecialchars_decode($r['testname'], ENT_QUOTES)."</td>
					<td style=\"color:#000000\">" . htmlspecialchars_decode($r['subname'], ENT_QUOTES) . "</td>
					<td style=\"color:#000000\">" . htmlspecialchars_decode($r['tcode'], ENT_QUOTES) . "</td>
					<td style=\"color:#000000\">" . htmlspecialchars_decode($r['totalquestions'], ENT_QUOTES) . "</td>
					<td style=\"color:#000000\">" . htmlspecialchars_decode($r['duration'], ENT_QUOTES) . "</td>"."
					<td style=\"color:#FFFFFF\"><a href=\"taketest.php?testcode=" . htmlspecialchars_decode($r['testname'], ENT_QUOTES) . "\"><input type=\"button\" value=\"Take Test\" class=\"btn\" style=\"background-color:#0099e5;color:white\" title=\"Start Test\"></a></td>";
				?>
				<?php
        			}
        			}
        			closedb();
	    			
				?>
				
				</tr>
      		</tbody>
  		</table>
          </div>
