<?php
session_start();
require_once 'functions.php';
set_error_handler("reportError");

$username = "";
$email    = "";
$password = "";
$logs = array();



// connect to db
$connect = mysqli_connect('localhost', 'developers', 'team', 'developers');
if (!$connect) {
				die("Connection failed: " . mysqli_connect_error());
}

//big block "if", for registration
if (isset($_POST['register_user'])) {

  $username = mysqli_real_escape_string($connect, $_POST['username']);
  $username = preg_replace('/[^a-zA-Z0-9]/', '', $username);
  $email = mysqli_real_escape_string($connect, $_POST['email']);
  $email = filter_var($email, FILTER_SANITIZE_EMAIL);
  $password_1 = mysqli_real_escape_string($connect, $_POST['password_1']);
  $password_2 = mysqli_real_escape_string($connect, $_POST['password_2']);

	try {
  if(filter_var($email, FILTER_VALIDATE_EMAIL) === FALSE) {
       throw new reportException($email);
  }
}

catch (reportException $e) {
	array_push($logs, "Wrong Email in Login Page");
  	}

  if (empty($username))
  {
      array_push($logs, "Username is required");
  }
  if (empty($email))
  {
     array_push($logs, "Email is required");
  }
  if (empty($password_1))
  {
     array_push($logs, "Password is required");
  }
  if ($password_1 != $password_2)
  {
	   array_push($logs, "The two passwords do not match");
  }
	//чекаем если такой пользователь
	//здесь я использовал функцию из functios.php вместо старого подхода(joma)
	$user = db_query("SELECT * FROM users WHERE username='$username' OR email='$email' LIMIT 1");

  if ($user) {  //if user exists
  	if ($user['username'] === $username) {
  		array_push($logs, "Username already exists");
  	}

  	if ($user['email'] === $email) {
  		array_push($logs, "Mail already exists");
    	}
  }
	//logaction
 // $ip = $_SERVER["REMOTE_ADDR"];
  if(count($logs) > 0) {
	logAction($logs);
  }else {
	$hash_password = hash("sha256",$password_1);
  	db_query("INSERT INTO users (username, email, password) VALUES ('$username', '$email', '$hash_password')");
  	$_SESSION['username'] = $username;
	array_push($logs, "New user " . "$username" . " successfully registered!");
    	logAction($logs);
  	header('location: login.php');
  }


}




//big block "if", for login
if (isset($_POST['login'])) {
	$username = mysqli_real_escape_string($connect, $_POST['username']);
	$password = mysqli_real_escape_string($connect, $_POST['password']);

	// check for empty username and password
	if (strlen($username) != 0) {
		if (strlen($password) != 0) {
			$hash_password = hash("sha256",$password);
			$result = db_query("SELECT id FROM users WHERE  username = '$username' && password = '$hash_password'");
			if (count($result) == 1) {
				$_SESSION['username'] = $username;
				$_SESSION['id'] = $result['id'];
				array_push($logs, "$username" . " successfully logged in!");
	                       	echo "you are successfully logged in";
				header("location: index.php");
                	} else {
                       	array_push($logs, "Wrong password or username");
			}
		}else {
			array_push($logs, "Password is required");
		}
	}else{
		array_push($logs, "Username is required");
		if(strlen($password == 0)){
			 array_push($logs, "Password is required");
		}
	}

	if(count($logs)>0){
		logAction($logs);
	}
}


// posts
if(isset($_POST['post'])){
	$target_dir = "images/";
	$target_file = $target_dir . basename($_FILES["image"]["name"]);
	$uploadOk = false;
	$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

	$title = mysqli_real_escape_string($connect, $_POST['title']);
	$text = mysqli_real_escape_string($connect, $_POST['text']);
	$user_id = $_SESSION['id'];
	$date = date("Y-m-d H:i:s");
	$name = $_FILES["image"]["name"];
	if($_FILES["image"]["name"]){
    		$uploadOk = true;
    		$check = getimagesize($_FILES["image"]["tmp_name"]);
		if(!$check) {
			echo "File is not an image "."<br>";
			$uploadOk = false;
		}

        	if($imageFileType != "jpg" and $imageFileType != "png" and $imageFileType != "jpeg" and $imageFileType != "gif" ) {
			echo "not appropriate format";
			$uploadOk = false;
		}

    	}

	if($uploadOk){
		if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
				echo "The file ". basename( $_FILES["image"]["name"]). " has been uploaded.";
		$getId = db_query("select id from posts order by id desc limit 1");
		$post_id = $getId['id'];
		++$post_id;
	db_query("INSERT INTO images (post_id ,path , name, format)  VALUES ('$post_id', '$target_file', '$name' , '$imageFileType')");

		} else {
			echo "Sorry, there was an error uploading your file"."<br>";
		}
	}

	$result = db_query("INSERT INTO posts (text , title , date, user_id)  VALUES ('$text', '$title', '$date' , '$user_id')");
	$zapros_id = db_query("SELECT id from posts where title = '$title' and date = '$date'");
	$post_id = $zapros_id['id'];
	array_push($logs, "Article was submitted");
	if(count($logs)>0){
		logAction($logs);
	}
	
	header("location: post.php?id=$post_id");
}
if(isset($_POST['comment'])){
        $comment = mysqli_real_escape_string($connect, $_POST['testcom']);
        $user_id = $_SESSION['id'];
        $date = date("Y-m-d H:i:s");
        $post_id = mysqli_real_escape_string($connect, $_POST['post_id']);
        db_query("INSERT INTO testcom (text , userid , datetime, post_id)  VALUES ('$comment', '$user_id', '$date' , '$post_id')");
	array_push($logs, "Comment was submitted to post with id = ".$post_id);
        if(count($logs)>0){
                logAction($logs);
        }

        header("location: post.php?id=$post_id");

}
if(isset($_POST['up'])){
  $post_id = mysqli_real_escape_string($connect, $_POST['post_id']);
	$user_id = $_SESSION['id'];
	$post_type = "article";
	$vote = '+';

	$result = db_query("SELECT * from rating where user_id = '$user_id' and post_id = '$post_id'");
	if(!$result){
       		$up = getQuery("INSERT INTO rating (user_id , post_id, post_type, vote) VALUES ('$user_id', '$post_id', '$post_type' , '$vote')");
		if($up){
			db_query("UPDATE posts set rating = rating+1 where id = '$post_id'");
			array_push($logs, "Increased the rating of post with post_id = ".$post_id);
		}
	}
        if(count($logs)>0){
        	logAction($logs);
        }
	header("location: post.php?id=$post_id");

}

if(isset($_POST['down'])){
	$post_id = mysqli_real_escape_string($connect, $_POST['post_id']);
	$user_id = $_SESSION['id'];
	$post_type = "article";
	$vote = '-';

	$result = db_query("SELECT * from rating where user_id = '$user_id' and post_id = '$post_id'");
	if(!$result){
		$down = getQuery("INSERT INTO rating (user_id , post_id, post_type, vote)  VALUES ('$user_id', '$post_id', '$post_type' , '$vote')");
		if($down){
			db_query("UPDATE posts set rating = rating-1 where id = '$post_id'");
			array_push($logs, "Decreased the rating of post with post_id = ".$post_id);
		}
       }
        if(count($logs)>0){
                logAction($logs);
        }

	header("location: post.php?id=$post_id");

}
if(isset($_POST['reply'])){
    $text = mysqli_real_escape_string($connect, $_POST['testcom']);
    $user_id = $_SESSION['id'];
	$datetime = date("Y-m-d H:i:s");
	$post_id = mysqli_real_escape_string($connect, $_POST['post_id']);
	$parent_id = mysqli_real_escape_string($connect, $_POST['parent_id']);
        db_query("INSERT INTO testcom (text , userid , datetime, post_id, parent_id)  VALUES ('$text', '$user_id', '$datetime' , '$post_id', '$parent_id')");

	array_push($logs, "replied to comment with id = ".$parent_id. "in the post with id = ".$post_id);
        if(count($logs)>0){
                logAction($logs);
        }
	header("location: post.php?id=$post_id");

}
if(isset($_POST['change_password'])){
	$username = $_SESSION['username'];
//	$old_password = mysqli_real_escape_string($connect, $_POST['old_password']);
//	$new_password1 = mysqli_real_escape_string($connect, $_POST['new_pasword1']);
//	$new_password2 = mysqli_real_escape_string($connect, $_POST['new_password2']);
	$id = $_SESSION['id'];
	$old_password = $_POST['old_password'];
        $new_password1 = $_POST['new_password1'];
        $new_password2 = $_POST['new_password2'];

	$isValid = TRUE;

        if (strlen($old_password) == 0) {
		$isValid = FALSE;
		array_push($logs,"Old password is required");
	}
	if (strlen($new_password1) == 0) {
		$isValid = FALSE;
		array_push($logs,"New password is required");
	}
	if (strlen($new_password2) == 0) {
         	$isValid = FALSE;
		array_push($logs,"Confirm password is required");

	}
	if($new_password2 != $new_password1){
		$isValid = FALSE;
		array_push($logs, "Two passwords have to be the same");

	}
	if($isValid){
		$hash_old_password = hash("sha256",$old_password);
	        $result = db_query("SELECT password FROM users WHERE id = '$id'");
		if($result['password'] == $hash_old_password){
			$hash_new_password = hash("sha256",$new_password1);
			$update = db_query("UPDATE users set password = '$hash_new_password' where id = '$id' ");
			array_push($logs, "$username" . " successfully changed password!");
			logAction($logs);
			echo "Password is changed";
			unset($_SESSION['username']);
			session_destroy();
			header("Location: login.php");
			exit ("Password is changed");
		}else{
	                array_push($logs, "Old password is incorrect");
		}
	}

	if(count($logs)>0){
		logAction($logs);
	}
}


if(isset($_POST['change_username'])){
	$id = $_SESSION['id'];
	$username = $_SESSION['username'];
	$new_username = mysqli_real_escape_string($connect, $_POST['new_username']);
 	$isValid = TRUE;
	if (strlen($new_username) == 0) {
    	$isValid = FALSE;
    	array_push($logs, "New username is required");
	}
	if ($new_username === $username) {
		$isValid = FALSE;
		array_push($logs, "You typed the same username");
		echo "You typed the same username" . "<br>";
	}
	$result = db_query("SELECT id from users where username = '$new_username'");
	if(count($result)>0){
		$isValid = FALSE;
		array_push($logs, "this username already exist");
		echo "this username already exist"."<br>";
	}
    if($isValid) {
	$update = db_query("UPDATE users set username = '$new_username' where id = '$id' ");
	array_push($logs, "$username" . " Successfully changed username to " . "$new_username");
	logAction($logs);
	unset($_SESSION['username']);
	session_destroy();
	header("Location: login.php");
	exit ("Username is changed");
}

if(count($logs)>0){
  logAction($logs);
}

}

if(isset($_POST['follow'])){
        $user_id = mysqli_real_escape_string($connect, $_POST['user_id']);
        $follower_id = mysqli_real_escape_string($connect, $_POST['follower_id']);


        db_query("INSERT INTO follows (user_id,follower_id) VALUES ('$user_id','$follower_id')");
        array_push($logs," started following to ".$user_id);
        if(count($logs)>0){
                logAction($logs);
        }
        header("location: profile.php?id=$follower_id");

}
//trying to reset pass

if(isset($_POST['reset'])){

	$username = mysqli_real_escape_string($connect, $_POST['username']);
	$email = mysqli_real_escape_string($connect, $_POST['email']);
  $email = filter_var($email, FILTER_SANITIZE_EMAIL);

    	$result = db_query("SELECT username FROM users WHERE email = '$email'");

     	if($result['username'] === $username){

	$simv = array ("92", "83", "7", "66", "45", "4", "36", "22", "1", "0",
                   "k", "l", "m", "n", "o", "p", "q", "1r", "3s", "a", "b", "c", "d", "5e", "f", "g", "h", "i", "j6", "t", "u", "v9", "w", "x5", "6y", "z5");
      	for ($k = 0; $k < 8; $k++)
        {
          shuffle ($simv);
          $string = $string.$simv[1];

        }

	$newpass = hash("sha256", $string);
	$zapros = db_query("UPDATE users SET password='$newpass' WHERE username ='$username'");
	array_push($logs, " Password was successfully reset ".$string);
	if(count($logs)>0){
                logAction($logs);
        }


	// mail($email, "������ �� �������������� ������", "Hello, $username. Your new password: $string");

 	echo "Your new password is - ";
	echo $string;
}
else{
array_push($logs, " Incorrect username or E-mail ".$username);
	if(count($logs)>0){
                logAction($logs);
        }
}

}
?>
