<?php

require "functions.php";

$content = $_REQUEST['content'] . "";
$obj = json_decode($content, false);

$login = $obj->login . "";
$password = $obj->password . "";

if(isUserInDB($login) == true)
{
	write("NO");
}
else
{
	addUserToDB($login,$password);
	write("YES");
}

?>