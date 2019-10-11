<?php 
// echo "hi";
$response['message']='';
$response['status']='';
$response['data']=array();
// echo json_encode($response,true);
$email = isset($_REQUEST['email']) ? trim($_REQUEST['email']): "";
$old_password = isset($_REQUEST['old_password']) ? trim($_REQUEST['old_password']):"";
$new_password = isset($_REQUEST['new_password']) ? trim($_REQUEST['new_password']):"";
$conf_password = isset($_REQUEST['conf_password']) ? trim($_REQUEST['conf_password']):"";
if (empty($email)) {
	$response['message'] ='Email Required';
}elseif (empty($old_password)) {
	$response['message']='old Password is required';	 
}elseif (empty($new_password)) {
	$response['message']='Enter new pasword is required';	 
}elseif (empty($conf_password)) {
	$response['message']='confirm pasword is required';	 
}elseif($new_password == $conf_password){
    $mdpassword = md5($old_password);
    // echo $mdpassword;exit;
    $connection = mysqli_connect("localhost","root",'','akdb') OR die("NOt COnnect To Database!!!!!");
    $select = "SELECT password FROM apitest where email='$email'";
    $select_res = $connection->query($select);
    //mysqli_query($connection,$select);
    $current = $select_res->fetch_array();
    $current_password = $current['password'];
    // exit;
    if($current_password == $mdpassword){
        $updatePass = md5($conf_password);
        $upd ="UPDATE apitest SET password='$updatePass' WHERE email ='$email'";  
	    $result = mysqli_query($connection,$upd);
	    if($result){
		    $response['message']='Password Change Successfully';
		    $response['status']='true';
	    }else{
		    $response['message']='Intenal Server Error! Please Try again';
		    $response['status']='false';
        }
    }else{
    	$response['message']='Enter Correct Old pasword';	 
    }
}
else{
    $response['message'] ="Password Not Match";
}
echo json_encode($response);
?>