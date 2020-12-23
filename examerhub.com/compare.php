<?php 
include "database/connect.php"
$username=$_POST['name'];
$password=$_POST['password'];
$result=executeQuery("select *from student where stdname=$username and password=$password");

   
?>