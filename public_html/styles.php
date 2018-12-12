<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<style>
* {box-sizing: border-box;}

body {
  margin: 0;
  font-family: Arial, Helvetica, sans-serif;
}

.topnav {
  overflow: hidden;
  background-color: #333;
}

.topnav a {
  float: left;
  display: block;
  color: #f2f2f2;
  text-align: center;
  padding: 14px 16px;
  text-decoration: none;
  font-size: 17px;
}

.topnav a:hover {
  background-color: #ddd;
  color: black;
}

.topnav a.active {
  background-color: #5077BD;
  color: white;
}

.topnav .search-container {
  float: right;
}

.topnav input[type=text] {
  padding: 6px;
  margin-top: 8px;
  font-size: 17px;
  border: none;
}

.topnav .search-container button {
  float: right;
  padding: 6px 10px;
  margin-top: 8px;
  margin-right: 16px;
  background: #ddd;
  font-size: 17px;
  border: none;
  cursor: pointer;
}

.topnav .search-container button:hover {
  background: #ccc;
}

@media screen and (max-width: 600px) {
  .topnav .search-container {
    float: none;
  }
  .topnav a, .topnav input[type=text], .topnav .search-container button {
    float: none;
    display: block;
    text-align: left;
    width: 100%;
    margin: 0;
    padding: 14px;
  }
  .topnav input[type=text] {
    border: 1px solid #ccc;
  }
}
</style>
</head>
<body>

<div class="topnav">

  <a href="index.php" class="active">Home</a>
<?php if(!isset($_SESSION['username'])): ?>

  <a href="signup.php">Sign up</a>
  <a href="login.php">Login</a>
<?php endif?>

<a href="create.php">New post</a>
<a href="posts.php">Posts</a>
<?php  if (isset($_SESSION['username'])) :
$id = $_SESSION['id'];
?>
<a href="profile.php?id=<?=$id?>">Profile</a>


<a href="logout.php">Logout</a>
<?php endif ?>
  <div class="search-container">
    <form action="posts.php" method="post">
      <input type="text" placeholder="Search.." name="title">
      <button type="submit" name="search" value="Search"><i class="fa fa-search"></i></button>
    </form>
  </div>
</div>
</body>
</html>

