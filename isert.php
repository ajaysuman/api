<?php 
$response['message']='';
$response['status']='';
$response['data']=array();
$newpassword = isset($_REQUEST['password']) ? trim($_REQUEST['password']):"";
$email = isset($_REQUEST['email']) ? trim($_REQUEST['email']): "";
$mdpassword = md5($newpassword);
if (empty($email)) {
	$response['message'] ='Email Required'; 
}elseif (empty($newpassword)) {
	$response['message']='pasword is required';	 
}else{
	$connection = mysqli_connect("localhost","root",'','akdb') OR die("NOt COnnect To Database!!!!!");
	$ins ="INSERT INTO apitest(email,password) VALUES ('$email','$mdpassword')";  
	$result = mysqli_query($connection,$ins);
	if($result){
		$response['message']='Insert Successfully';
		$response['status']='true';
	}else{
		$response['message']='Intenal Server Error! Please Try again';
		$response['status']='false';
	}
}
echo json_encode($response,true);
?>