<?php
require_once 'functions.php';
require_once 'library.php';
require_once 'styles.php';
set_error_handler("reportError");

$msg = $_REQUEST['msg'];

?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<title>Login</title>
    <link rel="stylesheet" href="css/reglog.css">

	</head>
	<body>
<div class="container_log inp">

		<h2>LOGIN</h2>
		<?php if (count($logs) > 0) : ?>
			<div>
				<?php foreach ($logs as $error) : ?>
					<p><?php echo $error ?></p>
				<?php endforeach ?>
			</div>
		<?php  endif ?>
		<form action="login.php" method="POST">
			Username:<br>
			<input type='text' name='username' required placeholder="Username">
			<br>
			Password:<br>
			<input type='password' name='password' required placeholder="Password" >
			<br> <br>
			<input type='submit' name = 'login'  value='login' style="background-color: #1e90ff">
			<br>
		<a href="reset.php">Forgot your password?</a>
		</form>

		</div>


</body>

</html>
