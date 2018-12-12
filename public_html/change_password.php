<?php
session_start();
if (!isset($_SESSION['username'])) {
   	header('location: login.php');
  }
require_once 'functions.php';
require_once 'library.php';
require_once 'styles.php';
if(count($logs)>0){
	foreach($logs as $error){
		echo $error."<br>";
	}
}


//$change_password = '';
//echo $change_password;




?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Change Password</title>
    <style media="screen">
    body  {
      font-family: "Times New Roman", Times, serif;
      background-color: #dcdcdc
          }
.content{
	margin:5px;
}

    </style>

  </head>
  <body>
<div class="content">
<form action="change_password.php" method="POST">
                Old password
		<input type="password"  name = "old_password" required><br>
                New password
		<input type="password"  name = "new_password1" required><br>
		Confirm password
		<input type="password"  name = "new_password2" required><br>
		<input type="submit" value="change password" name = "change_password" />
                </form>
</div>
  </body>
</html>

