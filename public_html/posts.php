<?php
session_start();
require_once 'functions.php';
require_once 'styles.php';
set_error_handler("reportError");


if(isset($_POST['search']) and strlen($_POST['title'])!= 0 ){
	$title = $_POST['title'];
	$result = getQuery("select * from posts where title like '$title%'");
}else if (isset($_POST['sort_rtn'])){

        $result = getQuery("SELECT * FROM posts ORDER BY rating DESC");

} else {
	$result = getQuery("SELECT * FROM posts ORDER BY id DESC");
}
mysqli_fetch_all($result,MYSQLI_ASSOC);

 ?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Posts</title>
  </head>
  <body>
    <div class="content">
    <form action="" method="POST">
      <input type="submit" value = "sort by rating" name = "sort_rtn"/>
    </form>
	<?php foreach($result as $x): ?>
        <?php $id = $x['id']; ?>
	 <div>
                <h3> <a href="post.php?id=<?=$id?>"><?=$x['title']?></a></h3>
                <p>   rating: <?=$x['rating']?> </p>
		<em> Date: <?=$x['date']?></em>
   		</form>

 </div>
    <?php endforeach ?>
    </div>
  </body>
</html>
