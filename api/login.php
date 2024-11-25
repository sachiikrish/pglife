<?php
session_start();
require ("../includes/database_connect.php");

$email = $_POST['email'];
$password = $_POST['password'];
$password = sha1($password);
$sql = "SELECT * from users where email = '$email' AND password = '$password'";
$result = mysqli_query($conn, $sql);
if(!$result){
$response = array("success" => false, "message"=>"Something went wrong!");
echo json_encode($response);
return;
}
$rows_count = mysqli_num_rows($result);
if($rows_count==0){
echo json_encode(array("success"=> false, "message"=> "Login failed! Invalid Email or Password."));
return;
}
$data = mysqli_fetch_assoc($result);
$_SESSION['user_id'] = $data['id'];
$_SESSION['email'] = $data['email'];
$_SESSION['full_name'] = $data['full_name'];
header("location: ../index.php");
mysqli_close($conn);
?>