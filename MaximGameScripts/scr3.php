<?php

require "functions.php";

$content = $_REQUEST['content'] . "";
$obj = json_decode($content, false);

$login = $obj->login . "";
$tip = $obj->tip . "";

saveResult($login, $tip);
write("OK");

?>