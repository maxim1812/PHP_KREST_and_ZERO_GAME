<?php

header('Access-Control-Allow-Origin: http://localhost:5000', false);
header('text/plain', false);
header('Access-Control-Allow-Methods: GET, POST, OPTIONS', false);
header('Access-Control-Allow-Headers: Content-Type', false);
header('Access-Control-Allow-Credentials: true', false);

$GLOBALS["localhost"] = 'localhost';
$GLOBALS["user"] = 'root';
$GLOBALS["password"] = '';
$GLOBALS["database"] = 'AAABBB';

function getLink()
{
	$link = mysqli_connect( $GLOBALS["localhost"], $GLOBALS["user"]); // $GLOBALS["password"]);  
	return $link;
}

function isUserInDB($loginUser)
{
	$loginUser = $loginUser . "";
	$link = getLink();
	mysqli_select_db($link,$GLOBALS["database"]);	
	$result = mysqli_query($link, " select login from users where login = '{$loginUser}'; ");
	$flag = false;
	while( $row = mysqli_fetch_row($result) ) $flag = true;
	mysqli_close($link);
	return $flag;
}

function addUserToDB($loginUser,$passwordUser)
{
	$loginUser = $loginUser . "";
	$passwordUser = $passwordUser . "";
	$link = getLink();
	mysqli_select_db($link,$GLOBALS["database"]);	
	$result = mysqli_query($link, " insert into users (login,password,wins,loses,nichia) values('{$loginUser}','{$passwordUser}',0,0,0); ");
	mysqli_close($link);
}

function correctLoginAndPassword($loginUser,$passwordUser)
{
	$loginUser = $loginUser . "";
	$passwordUser = $passwordUser . "";
	$link = getLink();
	mysqli_select_db($link,$GLOBALS["database"]);	
	$result = mysqli_query($link, " select login,password from users where login = '{$loginUser}' and password = '{$passwordUser}'; ");
	$flag = false;
	while( $row = mysqli_fetch_row($result) ) $flag = true;
	mysqli_close($link);
	return $flag;
}

function write($s)
{
	$s = $s . "";
	echo $s;
	exit();
}

function saveResult($loginUser, $tip)
{
	$loginUser = $loginUser . "";
	$tip = $tip + 0;
	$link = getLink();
	mysqli_select_db($link,$GLOBALS["database"]);	
	$query = "";
	if($tip == 1)
		$query = " update users set wins = wins + 1 where login = '{$loginUser}'; ";
	else
	if($tip == 2)
		$query = " update users set loses = loses + 1 where login = '{$loginUser}'; ";
	else
	if($tip == 3)
		$query = " update users set nichia = nichia + 1 where login = '{$loginUser}'; ";
	$result = mysqli_query($link,$query);
	mysqli_close($link);
}

function getInfoAboutUser($loginUser)
{
	$loginUser = $loginUser . "";
	$link = getLink();
	mysqli_select_db($link,$GLOBALS["database"]);
	$query = " select login,wins,loses,nichia from users where login = '{$loginUser}'; ";
	$result = mysqli_query($link,$query);
	$answer = "";
	while( $row = mysqli_fetch_row($result) )
	{
		$answer = $row[0] . "@" . $row[1] . "@" . $row[2] . "@" . $row[3]; 
	}
	mysqli_close($link);
	return $answer;
}

function getTopOfPlayers()
{
	$link = getLink();
	mysqli_select_db($link,$GLOBALS["database"]);
	$query = " select login, wins, loses, nichia, (wins-loses) from users order by (wins-loses)*(-1); ";
	$result = mysqli_query($link,$query);
	$i = 0;
	$answer = "<table border = '1px'><tr><td style = 'font-weight: bold; padding-top: 10px; padding-bottom: 10px; padding-left: 15px; padding-right: 15px'>Логин</td><td  style = 'font-weight: bold; padding-top: 10px; padding-bottom: 10px; padding-left: 15px; padding-right: 15px'>Победы</td><td  style = 'font-weight: bold; padding-top: 10px; padding-bottom: 10px; padding-left: 15px; padding-right: 15px'>Поражения</td><td  style = 'font-weight: bold; padding-top: 10px; padding-bottom: 10px; padding-left: 15px; padding-right: 15px'>Ничьи</td><td  style = 'font-weight: bold; padding-top: 10px; padding-bottom: 10px; padding-left: 15px; padding-right: 15px'>Разность побед и поражений</td></tr>";
	while( $row = mysqli_fetch_row($result) )
	{
		if($i < 3)
		{
			$answer = $answer . "<tr>";
			$answer = $answer . "<td  style = 'padding-top: 10px; padding-bottom: 10px; padding-left: 15px; padding-right: 15px'>" . $row[0] . "</td>";
			$answer = $answer . "<td  style = 'padding-top: 10px; padding-bottom: 10px; padding-left: 15px; padding-right: 15px'>" . $row[1] . "</td>";
			$answer = $answer . "<td  style = 'padding-top: 10px; padding-bottom: 10px; padding-left: 15px; padding-right: 15px'>" . $row[2] . "</td>";
			$answer = $answer . "<td  style = 'padding-top: 10px; padding-bottom: 10px; padding-left: 15px; padding-right: 15px'>" . $row[3] . "</td>";
			$answer = $answer . "<td  style = 'padding-top: 10px; padding-bottom: 10px; padding-left: 15px; padding-right: 15px'>" . $row[4] . "</td>";
			$answer = $answer . "</tr>";
		}
		$i++;
	}
	$answer = $answer . "</table>";
	mysqli_close($link);
	return $answer;
}


?>
