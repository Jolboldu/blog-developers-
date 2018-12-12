<?php
session_start();
//if (!isset($_SESSION['username'])) {
// 	header('location: login.php');
//}
require_once 'functions.php';
require_once 'library.php';
require_once 'styles.php';
$id = $_SESSION['id'];
$isYourPage = true;
$username = $_SESSION['username'];

if($id != $_GET['id']){
	$isYourPage = false;
	$id = $_GET['id'];
}

if(!$isYourPage){
	$result = db_query("SELECT username from users where id = '$id'");
	$username = $result['username'];
}
echo"<h2>" . $username . "</h2>";

 //following list
  $following_query = getQuery("SELECT * from follows WHERE follower_id = '$id'");
  mysqli_fetch_all($following_query,MYSQLI_ASSOC);
  $following_block = "<button id='following_block'>Following</button>";
  echo $following_block;


//following list
  $follower_query = getQuery("SELECT * from follows WHERE user_id = '$id'");
  mysqli_fetch_all($follower_query,MYSQLI_ASSOC);
  $follower_block = "<button id='follower_block'>Followers</button>";
  echo $follower_block;




// follower is the current user

//if already following then do not show this
$follower_id = $_SESSION['id'];
$follow_check = db_query("SELECT * from follows where user_id = '$id' and follower_id = '$follower_id'");
if(!$isYourPage && !$follow_check && isset($_SESSION['id'])){

	$follow = '<form action="profile.php" method="POST">
	<input type = "submit" value = "follow" name ="follow"/>
        <input type = "hidden" value = '.$follower_id.'  name = "follower_id" />
        <input type = "hidden" value = '.$id.'  name = "user_id" />
        </form>';
        echo $follow."<br>";
}

	echo ($isYourPage)?"<h1>My profile <h1><br><hr>" :"<h1>Profile of ".$username."<h1><br><hr>";



	$result = getQuery("SELECT * FROM posts WHERE user_id = '$id'");
	mysqli_fetch_all($result,MYSQLI_ASSOC);

?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Profile </title>
<style media="screen">
    body  {
            background-color: #dcdcdc
          }

    </style>

  </head>
  <body>
    <br>
  <p id="following"></p>
<hr style="color:blue">
  <p id="follower"></p>

<h2>Articles </h2>
<?php foreach($result as $x): ?>
        <?php $id = $x['id']; ?>
	 <div>
                <p> <a href="post.php?id=<?=$id?>"><?=$x['title']?></a></p>
	 </div>
    <?php endforeach ?>
	<hr>
  <?php  if($isYourPage) {
    $settings = '
	<h2>My Settings</h2>
	<strong><p><a href = "change_password.php" style="color:red;">Change password </a> </p> </strong>
	<strong><p style = "color:blue;">Change Username</p></strong>
	<form action="profile.php" method="post">
	<input type="text" name="new_username" value="" placeholder="Write new Username" required>
        <input type="submit" name="change_username" value="Change Username">
  	</form>';

    echo $settings;

  }
?>


<script>

document.getElementById("following_block").addEventListener("click", function() {
    myFunction();
});
document.getElementById("follower_block").addEventListener("click", function() {
    myFunction2();
});

function myFunction() {
    var result = "<?php foreach ($following_query as $f) {
      $id = $f['user_id'];
      $result = db_query("SELECT * FROM users WHERE id = '$id'");
      $x = "<a href='profile.php?id=$id" . " '> " .  $result['username']  . " </a>";
      echo $x . "<br>";
    }?>";
    document.getElementById("following").innerHTML = result;
}

function myFunction2() {
    var result = "<?php foreach ($follower_query as $f) {
      $id = $f['follower_id'];
      $result = db_query("SELECT * FROM users WHERE id = '$id'");
      $x = "<a href='profile.php?id=$id" . " '> " .  $result['username']  . " </a>";
      echo $x . "<br>";
    }?>";
    document.getElementById("follower").innerHTML = result;
}</script>
  </body>
</html>
