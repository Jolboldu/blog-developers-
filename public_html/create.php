<?php
session_start();

if (!isset($_SESSION['username'])) {
   	header('location: login.php');
  }
require_once 'library.php';
require_once 'styles.php';
 ?>
<!DOCTYPE html>
<html>
<head>
<title>Create Post </title>
<style media="screen">
    body  {
      background-color: #dcdcdc
          }

    </style>
<script src="https://cdn.ckeditor.com/4.11.1/standard/ckeditor.js"></script>
</head>
<body>



   <form action="create.php" method="POST" enctype="multipart/form-data" style="margin:5px">  
   <textarea name="title" rows="1" cols="50" placeholder = "Title" required></textarea>
<br>
  <div><textarea name="text" id="text" rows="4" cols="50" placeholder = "Text" required></textarea></br>
</div>
<input type="file" name="image">
  <p>
   <div><input type="submit" value="post" name = "post" /></div>
   </form>
</body>
	<script>
	CKEDITOR.replace( 'text');
	CKEDITOR.config.width="70%";
    	CKEDITOR.config.height="250px"
	</script>
</html>

