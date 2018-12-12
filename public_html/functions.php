<?php
//крч тут будут функции
function filterInput($input){
        $cinput = preg_replace('/\'/','',$input);
        $cinput = preg_replace('/\"/','',$cinput);
        $cinput = preg_replace('/\</','',$cinput);
        $cinput = preg_replace('/\>/','',$cinput);
        $cinput = preg_replace('/script/','',$cinput);
        $cinput = preg_replace('/javascript/','',$cinput);

	$cinput = mysql_real_escape_string($cinput);

        return $cinput;
}

function getRealIpAddr()
{
    if (!empty($_SERVER['HTTP_CLIENT_IP']))   //check ip from share internet
    {
      $ip=$_SERVER['HTTP_CLIENT_IP'];
    }
    elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))   //to check ip is pass from proxy
    {
      $ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
    }
    else
    {
      $ip=$_SERVER['REMOTE_ADDR'];
    }
    return $ip;
}

function getQuery($sql_code){
	$connect = mysqli_connect('localhost', 'developers', 'team', 'developers');
        $result = mysqli_query($connect, $sql_code);
	return $result;
}

function db_query($sql_code){
	$connect = mysqli_connect('localhost', 'developers', 'team', 'developers');
	$result = mysqli_query($connect, $sql_code);
	$array = mysqli_fetch_assoc($result);
	return $array;
}

function logAction($errors){
	$ip = getRealIpAddr();
	$date = date("Y-m-d H:i:s");
	$str_error = implode(" ",$errors);
	$username = $_SESSION['username'];
	if($username === NULL) {
		db_query("INSERT INTO logs (ip, errors, date1) VALUES ('$ip', '$str_error', '$date')");
	}
	else {
		db_query("INSERT INTO logs (username, ip, errors, date1) VALUES ('$username', '$ip', '$str_error', '$date')");
	}
}

function reportError($errno, $errstr) {
  $error = "Error: [". $errno. "] ".$errstr. "<br>";
  $date = date("l jS \of F Y h:i:s A") . "<br>";
  $ip = getRealIpAddr();
  db_query("INSERT INTO errors (error, date, ip)  VALUES ('$error', '$date', '$ip')");
  //echo "<b>Error:</b> [$errno] $errstr <br>";
}

//class Exception
class reportException extends Exception {
  public function errorMessage() {
    //error message
    $errorMsg = 'Error on line '.$this->getLine().' in '.$this->getFile()
    .': <b>'.$this->getMessage().'</b> is not a valid E-Mail address';
    return $errorMsg;
  }
}
$email = "developers@gmail.com";
try {
  //check if
  if(filter_var($email, FILTER_VALIDATE_EMAIL) === FALSE) {
    //throw exception if email is not valid
    throw new reportException($email);
  }
}

catch (reportException $e) {  
  echo $e->errorMessage();
}




?>
