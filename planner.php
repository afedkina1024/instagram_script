<?php


set_time_limit(0);
date_default_timezone_set('UTC');
require __DIR__.'/vendor/autoload.php';
use Symfony\Component\Process\Process;
require_once ("config.php");

/////// CONFIG ///////
$json_string = 'http://instagram/public/api/task';
$jsondata = file_get_contents($json_string);
$json_array = json_decode($jsondata,true);
var_dump($json_array);
//$ip=$json_array["ip"];
//echo "IP address: $ip";
$task_id=$json_array["id"];
$insta_login=$json_array["instAccountLogin"];
$insta_password=$json_array["instAccountPassword"];
$proxy="user3249:jV0m2DJq@185.220.35.7:33249";
$resourceAmount=$json_array["resourceAmount"];
$searchType=$json_array["searchType"];
$actionType=$json_array["actionType"];
$data=$json_array["data"];
$message=$json_array["message"];
$status=$json_array["status"];
$host = DbHost;
$dbName = DbName; 
$login = DbUserName; 
$pwd = DbUserPwd;
$connect = mysqli_connect ($host, $login, $pwd, $dbName);
//var_dump($connect);
$sql="Insert into task_queue (task_id, login, password, proxy, resourceAmount, searchType, 	actionType, data, message, status) values ('$task_id', '$insta_login', '$insta_password', '$proxy', '$resourceAmount', '$searchType', '$actionType', '$data', '$message', '$status')";
$result=mysqli_query($connect, $sql);
echo "$sql $result";
//mysqli_free_result ($result);
$connect -> close();
//$command =  'php exchange.php' . ' > NUL 2>&1 & echo $!; ';

//$pid = exec($command, $output);

//var_dump($pid);

$process = new Process('php exchange.php');
$process->start();
var_dump($process->getPid());
while ($process->isRunning()) {
    // waiting for process to finish
}

var_dump ($process->getOutput());

$process2 = new Process('php exchange.php');
$process2->start();
var_dump($process2->getPid());
while ($process->isRunning()) {
    // waiting for process to finish
}

var_dump ($process->getOutput());
/*function execInBackground($cmd) {
pclose(popen("start /B ". $cmd, "r"));
}
execInBackground('start cmd.exe @cmd /k "php exchange.php"');*/
//system("cmd /C  exchange.bat");
//system("cmd /C  exchange.bat");
?>