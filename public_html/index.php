<?php
session_start();
require_once 'functions.php';

/*if (($_SERVER['PHP_AUTH_USER'] != 'developers') ||
($_SERVER['PHP_AUTH_PW'] != 'team'))
{
header('WWW-Authenticate: Basic Realm="Secret Stash"');
header('HTTP/1.0 401 Unauthorized');
print('You must provide the proper credentials!');
exit;
}*/
require_once 'styles.php';

$result = getQuery("SELECT * FROM posts ORDER BY rating DESC");
mysqli_fetch_all($result,MYSQLI_ASSOC);
?>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Main</title>
		<style>
.text {
  border: 1px solid gray;
  padding: 8px;
  font-family: Arial, Helvetica, sans-serif;
  text-indent: 5px;
  text-align: justify;
  letter-spacing: 1px;
}
h1 {
  text-align: center;
  text-transform: uppercase;
  color: #333;
}
a {
  text-decoration: none;
  color: #008CBA;
}
</style>
      </head>

  <body>
	<div style="text-align:center">
    <div style="padding-left:16px">
  <h1>Blog - is an online publishing platform to post your articles and minds</h1>
    </div>

    <div style="padding-left:16px">
  <h2>Follow interesting authors </h2>
    </div>
    <div style="padding-left:16px">
      <h2>Create interesting content to be heard</h2><br>
    </div>
</div>

<?php
for ($i=0; $i < 3; $i++) {
	$title = $result['title'];
	$text = $result['text'];
	$out = "<div class='text'>
	  <h1>$title</h1>
	  <p>$text</p>
	</div>";
	echo $out;
	echo "Hello";
}
 ?>




</html>
