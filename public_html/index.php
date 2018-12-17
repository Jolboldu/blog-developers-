<?php
session_start();
require_once 'functions.php';
require_once 'styles.php';
/*if (($_SERVER['PHP_AUTH_USER'] != 'developers') ||
($_SERVER['PHP_AUTH_PW'] != 'team'))
{
header('WWW-Authenticate: Basic Realm="Secret Stash"');
header('HTTP/1.0 401 Unauthorized');
print('You must provide the proper credentials!');
exit;
}*/
$result = getQuery("SELECT * FROM posts ORDER BY rating DESC LIMIT 3");
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
    <h2>  <a href="http://5.59.11.66/~developers/create.php" style="color:#34495e">>>> Start Writing! <<<</a></h2><br>

    </div>
</div>




<?php foreach ($result as $x): ?>
	<div class="text">
	 <?php	 
	 $id = $x['id']; ?>
	 <h1><a href="post.php?id=<?=$id?>"><?=$x['title']?></a></h1>
	 <?php $text = $x['text'];
				 $text = substr($text,0,200); ?>
	 <p><?=$text?></p>
	 <?php $id = $x['id']; ?>
	</div>
<?php endforeach ?>








</html>
