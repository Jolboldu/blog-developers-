<?php
session_start();
require_once 'functions.php';
require_once 'library.php';
require_once 'styles.php';
set_error_handler("reportError");

$id = $_GET['id'];
$result = db_query("SELECT * FROM posts WHERE  id = '$id'") or trigger_error(mysql_error()." in ". $sql);

if ($result) {
	$user_id = $result['user_id'];
	$user = db_query("SELECT username FROM users WHERE  id = '$user_id'");
?>
      <div style="margin:5px;"><a href="profile.php?id=<?=$user_id?>"><?=$user['username']?></a></h3>
<?php
	echo "      (" . $result['date']. ") <br>";
	echo $result['title']."<br>";
	echo $result['text'];
	if (isset($_SESSION['username'])) {

		$button_up = '<form action="post.php" method="POST">
		<input type = "submit" value = "up" name ="up"/>
	        <input type = "hidden" value = '.$id .'  name = "post_id" />
		</form>';
		$button_down = '<form action="post.php" method="POST">
                <input type = "submit" value ="down" name ="down"/>
                <input type = "hidden" value = '.$id .'  name = "post_id" />
                </form>';

		echo $button_up;
		echo $button_down;

		$newcomment = '<form action="post.php" method="POST">
        	<textarea name="testcom" rows="4" cols="50" placeholder = "comment" required></textarea>
        	<input type="submit" value="comment" name = "comment" />
		<input type = "hidden" value = '.$id .'  name = "post_id" />
		</form>';
		echo $newcomment."<br>";

	}
	echo "<h1>comments</h1>";
	$images = db_query("SELECT path from images where post_id = '$id'");
	if($images){
		$src = $images['path'];
		$src = '"'.$src.'"';
		echo '<div align = center><img src = '.$src.' width = 500 height = 500></div>';
	}

	$query = getQuery("SELECT * FROM testcom where '$id' = post_id ORDER BY commentid DESC");
	mysqli_fetch_all($query,MYSQLI_ASSOC);
	foreach($query as $x){
			$com_user_id = $x['userid'];
			$users = db_query("SELECT username from users where '$com_user_id' = id");
			echo $x['datetime']."<br>";
			echo $users['username']." :  ";
			echo $x['text']."<br>";
			echo "rating is ".$x['rating']."<br> <br>";
			$id_of_com = $x['commentid'];

			if($x['parent_id']>0){
				$parent_id = $x['parent_id'];
				$array_parent_id =db_query("SELECT userid FROM testcom where '$parent_id' = commentid");
				$userid = $array_parent_id['userid'];
				$array_username = db_query("SELECT username FROM users where '$userid' = id");
				echo "   reply to  ".$array_username['username'];
			}

		        if (isset($_SESSION['username'])) {

				$button_reply = '<form action="post.php" method="POST">
        	        	<textarea name="testcom" rows="4" cols="50" placeholder = "comment" required></textarea>
				<input type = "submit" value = "reply" name ="reply"/>
        	        	<input type = "hidden" value = '.$id.'  name = "post_id" />
        	        	<input type = "hidden" value = '.$id_of_com.'  name = "parent_id" />
				</form></div>';
				echo $button_reply;
				echo "<br>";

			}

	}


} else {
	echo "0 Results";
}

?>
</html>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Post</title>
 <style media="screen">
 	.content{
	 	margin: 5px;
 }
    body  {
      font-family: "Times New Roman", Times, serif;
      background-color: #dcdcdc
          }
    </style>

  </head>
  <body>

  </body>
</html>
