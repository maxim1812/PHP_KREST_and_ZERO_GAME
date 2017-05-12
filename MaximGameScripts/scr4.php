<?php

require "functions.php";

$content = $_REQUEST['content'] . "";
$obj = json_decode($content, false);

$login = $obj->login . "";
$answer = getInfoAboutUser($login);

write($answer);

?>