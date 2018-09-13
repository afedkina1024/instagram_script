<?php
set_time_limit(0);
date_default_timezone_set('UTC');
require __DIR__.'/vendor/autoload.php';
require_once ("config.php");
use InstagramAPI\InstagramID;
use InstagramAPI\Exception\NetworkException;
class R extends \InstagramAPI\Response {
    public function isOk() {
        return true;
    }
}



$reps = new R();
$url_check = 'https://api.myip.com';
$debug = true;
$truncatedDebug = false;
$ig = new \InstagramAPI\Instagram($debug, $truncatedDebug);
$host = DB_HOST;
$dbName = DB_NAME; 
$login = DB_USERNAME; 
$pwd = DB_USERPWD;

$connect = mysqli_connect ($host, $login, $pwd, $dbName);

$sql="Select * from task_queue where status='new' order by task_id desc limit 1";
$result=mysqli_query($connect, $sql);

if ($result = mysqli_query($connect, $sql)){
        
  $row = mysqli_fetch_array ($result);
var_dump($row);
$task_id = $row['task_id'];
$instAccountId = $row['instAccountId'];
$username = $row['login'];
$password = $row['password'];
$proxy = $row['proxy'];
$limit = $row['resourceAmount'];
$searchType = $row['searchType'];
$actionType = $row['actionType'];
$data = $row['data'];
$message = $row['message'];
$dateUpdate = $row['dateUpdate'];
$status = $row['status'];         
mysqli_free_result ($result);
$sql = "Update task_queue Set status='in_progress' WHERE task_id='$task_id'";
$result=mysqli_query($connect, $sql);
echo "$sql $result\n";
}
$to_trim = array("[", "]", "\"");
$data=str_replace($to_trim, '', $data);
$data_r= explode (",", $data);
$data_1=trim($data_r[0]);
var_dump($data_1);



$users_visited=[];
$medias=[];
$instagram = new \InstagramScraper\Instagram();
$proxy_r = explode("@", $proxy);
$proxy_userpwd = explode(":", $proxy_r[0]);
$proxy_user=$proxy_userpwd[0];
$proxy_pass=$proxy_userpwd[1];
$proxy_ip_port = explode(":", $proxy_r[1]);
$proxy_ip=$proxy_ip_port[0];
$proxy_port=$proxy_ip_port[1];

//Настраиваем cURL
$url = "http://138.201.34.111:81/api/account/$task_id";
echo $url;
$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
curl_setopt($ch, CURLOPT_POST, true);

if (!empty($proxy)){
     var_dump('Connecting to proxy:' , $proxy);
      //$ig = new \InstagramAPI\Instagram($debug, $truncatedDebug);
      $ig->settings->setActiveUser($username);
      
      try{
      $ig->setProxy($proxy);
     $res = $ig->request($url_check)->setNeedsAuth(false)->getResponse($reps);
 
      }
      catch (NetworkException $e) {
      echo "Cannot connect to proxy $proxy: ".$e->getMessage()."\n";
      $array = [
          'status'=>'error',
          'message'=>"Cannot connect to proxy $proxy: ".$e->getMessage()
          ];
          curl_setopt($ch, CURLOPT_POSTFIELDS,http_build_query($array));
          $response = curl_exec($ch);
          var_dump ($response);
}
}
     





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
          $array = [
          'status'=>'error',
          'message'=>"Cannot login to the account $username: ".$e->getMessage()
          ];
          curl_setopt($ch, CURLOPT_POSTFIELDS,http_build_query($array));
          $response = curl_exec($ch);
}
*/
 

$setProxy=$instagram->setProxy([
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

if($dateUpdate + CHECK_PARAMETRS_ACCOUNT < time() || empty($dateUpdate) )
{

  $account = $instagram->getAccount($username);
// Available fields
echo "Account info:\n";
echo "Id: {$account->getId()}\n";
echo "Username: {$account->getUsername()}\n";
echo "Full name: {$account->getFullName()}\n";
echo "Biography: {$account->getBiography()}\n";
echo "Profile picture url: {$account->getProfilePicUrl()}\n";
echo "External link: {$account->getExternalUrl()}\n";
echo "Number of published posts: {$account->getMediaCount()}\n";
echo "Number of followings: {$account->getFollowsCount()}\n";
echo "Number of followers: {$account->getFollowedByCount()}\n";
echo "Is private: {$account->isPrivate()}\n";
echo "Is verified: {$account->isVerified()}\n";

$array = [
  "followings"=>$account->getFollowsCount(), 
  "followers"=>$account->getFollowedByCount(),
  "post"=>$account->getMediaCount(),

    ];
var_dump($array);

$url_account = "http://138.201.34.111:81/api/account/statment/$instAccountId";
echo $url_account;
$ch_account = curl_init($url_account);
curl_setopt($ch_account, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch_account, CURLOPT_FOLLOWLOCATION, true);
curl_setopt($ch_account, CURLOPT_POST, true);
curl_setopt($ch_account, CURLOPT_POSTFIELDS,http_build_query($array));
  $response = curl_exec($ch_account);
var_dump ($response);
curl_close($ch_account);
}

//$instagram = $instagram->withCredentials($username, $password, 'cache_folder/'.$username);
//$instagram->login();
//$medias = $instagram->getMediasByTag('youneverknow', 2);
//echo sizeof($medias);
//$media = $medias[0];
///echo "\nMedia info:\n";
//echo "Id: {$media->getId()}\n";
	
//$data_r = explode(" ", $data);
//$limit_each = floor($limit / sizeof($data_r));
//$limit_mod = $limit%sizeof($data_r);
//$limit=10;
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

//echo "Limit: $limit_each, extra:$limit_mod \n ";

echo ("$actionType $searchType $data_1");
if ($actionType=="like"){
  if ($searchType=="hashtag"){

// select posts by hashtag
$result = $instagram->getPaginateMediasByTag($data_1);
$medias = $result['medias'];
//$media = $medias[0];
//echo "Id: {$media->getId()}\n";
echo sizeof($medias)."\n";
if (sizeof($medias)==0)
{
$array = [
          'status'=>'error',
          'message'=>"Cannot find posts for hashtag: $data_1"
    ];
  curl_setopt($ch, CURLOPT_POSTFIELDS,http_build_query($array));
  curl_exec($ch);
}
else
{
do{
	echo sizeof($medias)."\n";
	if (sizeof($medias)>=$limit) break;
		$result = $instagram->getPaginateMediasByTag($data_1, $result['maxId']);
    $medias = array_merge($medias, $result['medias']);
	echo "Id: {$media->getId()}\n";

} while ($result['hasNextPage'] === true);
}

}
//Search posts by username

if ($searchType=="username"){


$userId = $data_1; 
$userId_response = $ig->people->getInfoById($userId);
var_dump ($userId_response);
if (!$userId_response)
	{	
    $array = [
					'status'=>'error',
					'message'=>"Invalid user ID: $userId"
    ];
  curl_setopt($ch, CURLOPT_POSTFIELDS,http_build_query($array));
          curl_exec($ch);
        }
else
{	
$user = $response->getUser()->getUsername();
$result = $instagram->getPaginateMedias($user);
$medias = $result['medias'];
$media_id_array=[];
do{
	echo sizeof($medias)."\n";
	if (sizeof($medias)==0){
	$array = [
					'status'=>'error',
					'message'=>"Cannot find posts for user ID: $userId - $user"
    ];
  curl_setopt($ch, CURLOPT_POSTFIELDS,http_build_query($array));
  $response = curl_exec($ch);
	}

	$result = $instagram->getPaginateMedias('instagram', $result['maxId']);
  $medias = array_merge($medias, $result['medias']);
	if (sizeof($medias)>=$limit) break;
sleep(15);
} while ($result['hasNextPage'] === true);
}

}
if ($searchType=="location"){
// select posts by location
//$location_id = "380503552017025";
$location_id = $data_1;

$medias = $instagram->getMediasByLocationId($location_id, 30);


$medias_count=sizeof($medias);
echo"Medias by location $medias_count";
$array = [
					'status'=>'error',
					'message'=>"Cannot find posts for location: $location_id"
    ];
  curl_setopt($ch, CURLOPT_POSTFIELDS,http_build_query($array));
  $response = curl_exec($ch);


}

for ($i=0; $i<$limit; $i++)
	{
		$media_id_array[]=$medias[$i]->getId();
echo "$i - Id: ".$media_id_array[$i]."\n";
	}

echo sizeof($media_id_array)."\n";
}

//Формируем JSON

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
          $array = [
          'status'=>'error',
          'message'=>"Cannot login to the account $username: ".$e->getMessage()
          ];
          curl_setopt($ch, CURLOPT_POSTFIELDS,http_build_query($array));
          $response = curl_exec($ch);
var_dump ($response);

}

try {
 $current_user=$ig->people->getSelfInfo();  
} catch (\Exception $e) {
   //continue
}*/
//if (!empty($current_user)){
          foreach ($media_id_array as $media){
          $array = [
					'status'=>'success',
					'message'=>"Like media id: $media"
          ];
          curl_setopt($ch, CURLOPT_POSTFIELDS,http_build_query($array));
          $response = curl_exec($ch);
          var_dump ($response);
          sleep(100);
        }
          
          if (sizeof($media_id_array)<$limit)
          {
                      $array = [
          'status'=>'error',
          'message'=>"Cannot find more than ". sizeof($media_id_array)."posts for: $data_1"
          ];
          curl_setopt($ch, CURLOPT_POSTFIELDS,http_build_query($array));
          $response = curl_exec($ch);
          var_dump ($response);
          }
//          }
curl_close($ch);
$sql = "Update task_queue Set status='completed' WHERE task_id='$task_id'";
$result=mysqli_query($connect, $sql);
echo "$sql $result\n";
$connect -> close();
/*$ch = curl_init('http://sample.com/data.php');
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);*/

//Получаем данные
//$response = curl_exec($ch);
//$nonPrivateAccountMedias = $instagram->getMedias($user);