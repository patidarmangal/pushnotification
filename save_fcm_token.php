<?php
include ('config.php');
if(isset($_POST['token'])){
	$token = $_POST['token'];
	$sql = "INSERT INTO fcm_token_storage(device_token) VALUES ('".$token."')";
	$result = mysqli_query($conn, $sql);
	if($result){
		echo "Token inserted successfully";
	}else{
		echo "Unable to insert token";
	}
}
?>