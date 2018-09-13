<?php
set_time_limit(0);
date_default_timezone_set('UTC');
require __DIR__.'/vendor/autoload.php';
use Symfony\Component\Process\Process;
require_once ("config.php");

/////// FUNCTION DECLARATION ///////
function getNewTask($json_string)
{
	$result = 0;
	$jsondata = file_get_contents($json_string);
	$json_array = json_decode($jsondata,true);
	var_dump($json_array);
	if (!empty($json_array))
	{
		$task_id = $json_array["id"];
		$instAccountId = $json_array["instAccountId"];
		$insta_login = $json_array["instAccountLogin"];
		$insta_password = $json_array["instAccountPassword"];
		$proxy = $json_array["proxyStr"];
		$resourceAmount = $json_array["resourceAmount"];
		$searchType = $json_array["searchType"];
		$actionType = $json_array["actionType"];
		$data = $json_array["data"];
		$message = $json_array["message"];
		$dateUpdate = $json_array["dateUpdateAccountParametrs"];
		$status = $json_array["status"];
		$host = DB_HOST;
		$dbName = DB_NAME; 
		$login = DB_USERNAME; 
		$pwd = DB_USERPWD;
		$connect = mysqli_connect ($host, $login, $pwd, $dbName);
		$sql = "Insert into task_queue (task_id, instAccountId, login, password, proxy, resourceAmount, searchType, 	actionType, data, message, dateUpdate, status) values ('$task_id', '$instAccountId', '$insta_login', '$insta_password', '$proxy', '$resourceAmount', '$searchType', '$actionType', '$data', '$message', '$dateUpdate', '$status')";
		$result = mysqli_query($connect, $sql);
		echo "$sql , Result: $result\n";
		$connect -> close();
	}
	return $result;
}
/////// MAIN SECTION ///////
while (1)
{
	$json_string = 'http://138.201.34.111:81/api/task';
	
	if (getNewTask($json_string)==1)
	{
		$process = new Process('php exchange.php');
		$process->start();
		var_dump($process->getPid());
	}
	sleep (60);
}

?>