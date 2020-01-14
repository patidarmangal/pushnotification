<?php
include ('config.php');
define('SERVERKEY', 'AIzaSyA5-MQK_76clDWKl7hcOeP6Uvn59UOXCoc');
$sql = "SELECT device_token FROM fcm_token_storage";
$result = mysqli_query($conn, $sql);
while($row = mysqli_fetch_array($result) ){
	$token[] = $row['device_token'];
}

//$token = ['cCSNNDBCJ5CDASgvjMbuLT:APA91bEpaez8Jsl7kXz3kaK1vc30ISLOcbHJRlFQz4VmB4JNnbhzNvMD8NJmO6XzzAXiRD2qn3p27R2y-rOES5FOqRFf4f9xGcbnrCI87lgpepJh5RrLFC4zBJXGQKE1hGJLv51CLnNN'];

$header = [
	'Authorization: key='.SERVERKEY,
	'Content-Type: application/json'
];

$msg = [
	'title' => 'First msg',
	'body' => 'I got finally first msg',
	'icon' => 'icon.png',
	'image' => 'http://localhost/myprojects/TGN-NOTIFICATION/icon.png',
	'click_action' => 'http://localhost/myprojects'
];

$payload = [
	'registration_ids' => $token,
	'data' => $msg
];

$url = "https://fcm.googleapis.com/fcm/send";
$curl = curl_init();
curl_setopt($curl, CURLOPT_URL, $url);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($curl, CURLOPT_POST, true);
curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($payload) );
curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
$response = curl_exec($curl);
$err = curl_error($curl);
curl_close($curl);
if($err){
	echo "curl error".$err;
}else{
	echo $response;
}
?>