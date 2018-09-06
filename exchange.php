<?php
set_time_limit(0);
date_default_timezone_set('UTC');
require __DIR__.'/vendor/autoload.php';
require_once ("config.php");
use InstagramAPI\InstagramID;

$host = DbHost;
$dbName = DbName; 
$login = DbUserName; 
$pwd = DbUserPwd;
$connect = mysqli_connect ($host, $login, $pwd, $dbName);
//var_dump($connect);
$sql="Select * from task_queue where status='new' order by task_id limit 1";
$result=mysqli_query($connect, $sql);

if ($result = mysqli_query($connect, $sql)){
        
            $row = mysqli_fetch_array ($result);
            var_dump($row);
$task_id = $row['task_id'];
$username = $row['login'];
$password = $row['password'];
$proxy = $row['proxy'];
$limit = $row['resourceAmount'];
$searchType = $row['searchType'];
$actionType = $row['actionType'];
$data = $row['data'];
$message = $row['message'];
$status = $row['status'];         
            mysqli_free_result ($result);
        }


$connect -> close();

$debug = true;
$truncatedDebug = false;
$users_visited=[];
$medias=[];
$instagram = new \InstagramScraper\Instagram();
$ig = new \InstagramAPI\Instagram($debug, $truncatedDebug);
$ig->setProxy($proxy);

$proxy_r = explode("@", $proxy);

$proxy_userpwd = explode(":", $proxy_r[0]);
$proxy_user=$proxy_userpwd[0];
$proxy_pass=$proxy_userpwd[1];
$proxy_ip_port = explode(":", $proxy_r[1]);
$proxy_ip=$proxy_ip_port[0];
$proxy_port=$proxy_ip_port[1];
//Открытие сеанса пользователя
/*try {
    $loginResponse = $ig->login($username, $password);
    if ($loginResponse !== null && $loginResponse->isTwoFactorRequired()) {
        $twoFactorIdentifier = $loginResponse->getTwoFactorInfo()->getTwoFactorIdentifier();
        // The verification code will be sent by Instagram via SMS.
        $verificationCode = trim(fgets(STDIN));
        $ig->finishTwoFactorLogin($username, $password, $twoFactorIdentifier, $verificationCode);
    }
} catch (\Exception $e) {
    echo 'Something went wrong: '.$e->getMessage()."\n";
}
*/
$instagram->setProxy([
    'address' => $proxy_ip,
    'port'    => $proxy_port,
    'tunnel'  => true,
    'timeout' => 30,
    'auth' => [
                'user' => $proxy_user,
                'pass' => $proxy_pass,
                'method' => CURLAUTH_BASIC
            ],
              ]);
//$instagram = $instagram->withCredentials($username, $password, 'cache_folder/'.$username);
//$instagram->login();
//$medias = $instagram->getMediasByTag('youneverknow', 2);
//echo sizeof($medias);
//$media = $medias[0];
///echo "\nMedia info:\n";
//echo "Id: {$media->getId()}\n";
	
$data_r = explode(" ", $data);
$limit_each = floor($limit / sizeof($data_r));
$limit_mod = $limit%sizeof($data_r);
$limit=100;
/*try {
    // Get the UserPK ID for "natgeo" (National Geographic).
    $userId = $ig->people->getUserIdForName('natgeo');
    // Starting at "null" means starting at the first page.
    $maxId = null;
    do {
        // Request the page corresponding to maxId.
        $response = $ig->timeline->getUserFeed($userId, $maxId);
        // In this example we're simply printing the IDs of this page's items.
        foreach ($response->getItems() as $item) {
            printf("[%s] https://instagram.com/p/%s/\n", $item->getId(), $item->getCode());


        $medias[] = $item->getId();
        echo (sizeof($medias)." - medias by user\n");
        if (sizeof($medias)>=$limit) break;
        }
        // Now we must update the maxId variable to the "next page".
        // This will be a null value again when we've reached the last page!
        // And we will stop looping through pages as soon as maxId becomes null.
        $maxId = $response->getNextMaxId();
        // Sleep for 5 seconds before requesting the next page. This is just an
        // example of an okay sleep time. It is very important that your scripts
        // always pause between requests that may run very rapidly, otherwise
        // Instagram will throttle you temporarily for abusing their API!
        echo "Sleeping for 10 s...\n";
        sleep(10);
if (sizeof($medias)>=$limit) break;
    } while ($maxId !== null); // Must use "!==" for comparison instead of "!=".
} catch (\Exception $e) {
    echo 'Something went wrong: '.$e->getMessage()."\n";
}
*/

echo "Limit: $limit_each, extra:$limit_mod \n ";
// select posts by hashtag

/*$result = $instagram->getPaginateMediasByTag('zara');
$medias = $result['medias'];
$media = $medias[0];
echo "Id: {$media->getId()}\n";

echo sizeof($medias)."\n";
do{
	echo sizeof($medias)."\n";
	if (sizeof($medias)>$limit) break;
		//$result = $instagram->getPaginateMediasByTag('zara', $result['maxId']);
    //$medias = array_merge($medias, $result['medias']);
	echo "Id: {$media->getId()}\n";

} while ($result['hasNextPage'] === true);

*/

$result = $instagram->getPaginateMedias('instagram');
$medias = $result['medias'];
//$media = $medias[0];
//echo "Id: {$media->getId()}\n";
$media_id_array=[];
do{
	echo sizeof($medias)."\n";
	
		$result = $instagram->getPaginateMedias('instagram', $result['maxId']);
    $medias = array_merge($medias, $result['medias']);
	if (sizeof($medias)>=$limit) break;
sleep(15);
} while ($result['hasNextPage'] === true);
for ($i=0; $i<$limit; $i++)
	{
		$media_id_array[]=$medias[$i]->getId();
echo "$i - Id: ".$media_id_array[$i]."\n";
	}

echo sizeof($media_id_array)."\n";

// select posts by location
/*$location_id = "380503552017025";
$medias = $instagram->getMediasByLocationId($location_id, 30);
$medias_count=sizeof($medias);
echo"Medias by location $medias_count";*/
//Формируем JSON
$request_data = array('type' => 'reqColor', 'value' => '#aa00cc');
$json = json_encode($request_data);

//Настраиваем cURL
$ch = curl_init('http://sample.com/data.php');
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

//Получаем данные
//$response = curl_exec($ch);
//$nonPrivateAccountMedias = $instagram->getMedias($user);