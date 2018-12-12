<?php
require_once 'library.php';
require_once 'styles.php';
set_error_handler("reportError");
?>
<!DOCTYPE html>
<html>
<head>
  <title>Registration</title>
<link rel="stylesheet" href="css/reglog.css">
<link rel="stylesheet" href="css/style.css">




</head>
<body>
  <div class = "container_log">
  	<h2>REGISTER</h2>
<div class="inp">


  <form method="post" action="signup.php">
    <?php  if (count($logs) > 0) : ?>
      <div>
      	<?php foreach ($logs as $error) : ?>
      	  <p><?php echo $error ?></p>
      	<?php endforeach ?>
      </div>
    <?php  endif ?>
  	<div>
  	  <label>Username:</label></div>
       <div><input type="text" name="username" value="" required placeholder="Only letters and numbers">
  	</div>
    	<div>
  	  <label>Email</label></div>

	<div> <input type="email" name="email" value="" required placeholder="example@gmail.com">
  	</div>
  	<div>
  	  <label>Password</label></div>

  	<div><input type="password" name="password_1"  required placeholder="Password">
  	</div>
  	<div>
  	  <label>Confirm password</label></div>
	<div><input type="password" name="password_2" required placeholder="Confirm password">
  	</div>
  	<div>
  	<button type="submit" name="register_user">Register</button>
  	</div>
  	<p>
  		Already a member?
      <a href="login.php"><button type="button" name="button">Login</button></a>
  	</p></div>
  </form>
  </div>
</body>
</html>
