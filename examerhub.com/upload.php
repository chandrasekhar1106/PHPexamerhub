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
<html>
<head>

<title>Upload and Download Files</title>
		<link href="css/bootstrap.css" rel="stylesheet" type="text/css" media="screen">
        <link rel="stylesheet" type="text/css" href="css/DT_bootstrap.css">
</head>
	<script src="js/jquery.js" type="text/javascript"></script>
	<script src="js/bootstrap.js" type="text/javascript"></script>
	
	<script type="text/javascript" charset="utf-8" language="javascript" src="js/jquery.dataTables.js"></script>
	<script type="text/javascript" charset="utf-8" language="javascript" src="js/DT_bootstrap.js"></script>

<style>
</style>
<body>
	    <div class="row-fluid">
	        <div class="span12">
	            <div class="container">
		<br />
		<h1><p>Upload  And  Download Files</p></h1>	
		<br />
		<br />
			<form enctype="multipart/form-data" action="" name="form" method="post">
				Select File
					<input type="file" name="photo" id="photo" /></td>
					<input type="submit" name="submit" id="submit" value="Submit" />
			</form>
		<br />
		<br />
		
	</div>
	</div>
	</div>
</body>
</html>