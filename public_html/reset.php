<?php
session_start();

require_once 'library.php';
require_once 'styles.php';
//require_once 'functions.php';
if(count($logs)>0){
	foreach($logs as $error){
		echo $error."<br>";
	}
}
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Reset</title>
    <style media="screen">
    body  {
      font-family: "Times New Roman", Times, serif;
      background-color: #dcdcdc
          }

    </style>

  </head>
  <body>
<form action="reset.php" method="POST">
                Username
		<input type="username"  name = "username" required><br>
                E-mail
		<input type="email"  name = "email" required><br>
		<input type="submit" value="reset" name = "reset" />
                </form>
  </body>
</html>