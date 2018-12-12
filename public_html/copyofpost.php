<?php
session_start();
require_once 'functions.php';
require_once 'library.php';
set_error_handler("reportError");


$id = $_GET['id'];
$result = db_query("SELECT * FROM posts WHERE  id = '$id'") or trigger_error(mysql_error()." in ". $sql);

if ($result) {
	$user_id = $result['user_id'];
	$user = db_query("SELECT username FROM users WHERE  id = '$user_id'");
	echo $user['username'];
	echo "        (" . $result['date']. ") <br>";
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
		<input type = "hidden" value = '.$id .'  name = "post_id" />';
		echo $newcomment."<br>";

	}
	echo "<hr>comments </hr> <br>";

	$query = getQuery("SELECT * FROM testcom where '$id' = post_id ORDER BY commentid DESC");
	mysqli_fetch_all($query,MYSQLI_ASSOC);

	foreach($query as $x){
		$com_user_id = $x['userid'];
		$users = db_query("SELECT username from users where '$com_user_id' = id");
		echo $users['username']." :  ";
		echo $x['text']."<br>";
                echo $x['datetime']."<br>";
	}


} else {
	echo "0 Results";
}

?>
