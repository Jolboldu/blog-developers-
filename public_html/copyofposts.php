<?php
session_start();
require_once 'functions.php';
set_error_handler("reportError");


$connect = mysqli_connect('localhost', 'developers', 'team', 'developers');
if (!$connect) {
				die("Connection failed: " . mysqli_connect_error());
}

   $query = "SELECT * FROM posts ORDER BY id DESC";
   $result = mysqli_query($connect, $query);
   if(!$result)
       die(mysqli_error($connect));

   $n = mysqli_num_rows($result);
	   $posts = array();
   for ($i = 0; $i < $n; $i++)
   {
       $row = mysqli_fetch_assoc($result);
       $posts[] = $row;
   }
 ?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Posts</title>
  </head>
  <body>
	<?php foreach($posts as $x): ?>
        <?php $id = $x['id']; ?>
	 <div>
                <h3> <a href="post.php?id=<?=$id?>"><?=$x['title']?></a></h3>
                <p>   rating: <?=$x['rating']?> </p>
		<em> Date: <?=$x['date']?></em>
		<p><?=$x['user_id']?></p>
   		</form>

 </div>
    <?php endforeach ?>
  </body>
</html>
