<?php


set_time_limit(0);
date_default_timezone_set('UTC');
require __DIR__.'/vendor/autoload.php';
use Symfony\Component\Process\Process;
require_once ("config.php");

/////// CONFIG ///////
$json_string = 'https://api.myip.com';
$jsondata = file_get_contents($json_string);
$json_array = json_decode($jsondata,true);
$ip=$json_array["ip"];
echo "IP address: $ip";
$task_id=1;
$insta_login="ricatino86";
$insta_password="S2HAtiEnnw";
$proxy="user3249:jV0m2DJq@185.220.35.7:33249";
$resourceAmount=100;
$searchType="hashtag";
$actionType="like";
$data="zara, rose, flower";
$message="";
$status="new";
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
/*$command =  'php exchange.php' . ' > NUL 2>&1 & echo $!; ';

$pid = exec($command, $output);

var_dump($pid);*/

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

/*function execInBackground($cmd) {
pclose(popen("start /B ". $cmd, "r"));
}
execInBackground('start cmd.exe @cmd /k "php exchange.php"');*/
//system("cmd /C  exchange.bat");
//system("cmd /C  exchange.bat");
?>