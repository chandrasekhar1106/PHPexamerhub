<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>examerHub</title>

    <!-- Bootstrap core CSS -->
    <link href="assets/bootstrap/css/bootstrap.min.css" rel="stylesheet">
		<link rel="icon" type="img/png" href="assets/custom/img/hat.png">

    <!-- Just for debugging purposes. Don't actually copy this line! -->
    <!--[if lt IE 9]><script src="themes/assets/js/ie8-responsive-file-warning.js"></script><![endif]-->

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

	<!-- CSS Implementing Plugins -->
  

    <!-- Custom styles for this template -->
	
    <link href="assets/custom/css/business-plate.css" rel="stylesheet">


    <link rel="shortcut icon" href="assets/custom/ico/favicon.ico">
  </head>
<!-- NAVBAR
================================================== -->
  <body>
	<div class="container" style="margin-top: 5%; ">
    <div class="col-md-4 col-md-offset-4">
        <div class="panel panel-primary">
            <div class="panel-heading panel-primary" ><center>Login</center></div>
            <div class="panel-body">
            
            <!-- Login Form -->
            <form id="indexform" action="index.php" method="post">
              
               <?php


      error_reporting(0);
      session_start();
      include_once '../database/connect.php';

      /***************************** Step 2 ****************************/
      if(isset($_REQUEST['admsubmit']))
      {
          
          $result=executeQuery("select * from adminlogin where admname='".htmlspecialchars($_REQUEST['name'],ENT_QUOTES)."' and admpassword='".md5(htmlspecialchars($_REQUEST['password'],ENT_QUOTES))."'");
      
         // $result=mysql_query("select * from adminlogin where admname='".htmlspecialchars($_REQUEST['name'])."' and admpassword='".md5(htmlspecialchars($_REQUEST['password']))."'");
          if(mysql_num_rows($result)>0)
          {
             
              $r=mysql_fetch_array($result);
			   
              if($r>0)
              { 
                  $_SESSION['admname']=htmlspecialchars_decode($r['admname'],ENT_QUOTES);
                  unset($_GLOBALS['message']);
                  header('Location: dashboard.php');
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
      
        if(isset($_GLOBALS['message']))
        {
         echo "<div class=\"text-danger\">".$_GLOBALS['message']."</div>";
        }
      ?>
<center><img src="assets/custom/img/hat.png" width="150" height="150"></center>

            <!-- Username Field -->
                <div class="row">
                    <div class="form-group col-xs-12"style="margin-bottom:10px;">
                    <label for="username"><span class="text-danger" style="margin-right:5px;"></span></label>
                        <div class="input-group">
                        <input type="text" name="name" value="" size="16" class="form-control" id="username" placeholder="Username" autocomplete="off" required  />
                           
                            <span class="input-group-btn">
                                <label class="btn btn-primary"><span class="glyphicon glyphicon-user" aria-hidden="true"></label>
                            </span>
                            </span>
                        </div>
                    </div>
                </div>
                
                <!-- Content Field -->
                <div class="row">
                    <div class="form-group col-xs-12" style="margin-bottom:10px;">
                        <label for="password"><span class="text-danger" style="margin-right:5px;"></span></label>
                        <div class="input-group">
                        <input type="password" name="password" value=""  autocomplete="off" id="password" size="16" class="form-control" placeholder="Password" required />
                           
                            <span class="input-group-btn">
                                <label class="btn btn-primary"><span class="glyphicon glyphicon-lock" aria-hidden="true"></label>
                            </span>
                            </span>
                        </div>
                    </div>
                </div>
                <br>
                <!-- Login Button -->
                
                <div class="row">
                    <div class="form-group col-xs-12" style="margin-bottom:10px;">
                    <input type="submit" value="Log In" name="admsubmit" class=" btn btn-primary pull-right" />
                      
                    </div>
					 
                </div>
                
            </form>
            <!-- End of Login Form -->
            
        </div>
    </div>
</div>
<!-- JS Global Compulsory -->			
<script type="text/javascript" src="assets/custom/js/bootstrap.min.js"></script>
<script type="text/javascript" src="assets/custom/js/modernizr.custom.js"></script>		
<script type="text/javascript" src="assets/bootstrap/js/bootstrap.min.js"></script>	
	
	<!-- JS Implementing Plugins -->           
<script type="text/javascript" src="assets/custom/js/jquery.flexslider-min.js"></script>
<script type="text/javascript" src="assets/custom/js/modernizr.js"></script>
<script type="text/javascript" src="assets/custom/js/jquery.cslider.js"></script> 
<script type="text/javascript" src="assets/custom/js/back-to-top.js"></script>
<script type="text/javascript" src="assets/custom/js/jquery.sticky.js"></script>

<!-- JS Page Level -->           
<script type="text/javascript" src="assets/custom/js/app.js"></script>
<script type="text/javascript" src="assets/custom/js/index.js"></script>


<script type="text/javascript">
    jQuery(document).ready(function() {
      	App.init();
        App.initSliders();
        Index.initParallaxSlider();
    });
</script>


	</body>
</html>