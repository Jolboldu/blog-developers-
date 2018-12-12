<?php
require_once 'functions.php';
for($i = 139; $i < 140; ++$i){
	  db_query("delete from posts where id = '$i'");

}

?>
