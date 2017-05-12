<?php

require "functions.php";

$content = $_REQUEST['content'] . "";
$obj = json_decode($content, false);

$login = $obj->login . "";
$password = $obj->password . "";

$flag = correctLoginAndPassword($login,$password);

if($flag == true)
{
	write("YES");
}
else
{
	write("NO");
}

?>