<?php
require("../includes/database_connect.php");
$name = $_POST['name'];
$email = $_POST['email'];
$phone_number = $_POST['phone_number'];
$college = $_POST['college'];
$password = $_POST['password'];
$password = sha1($password);
$gender = $_POST['gender'];
$sql = "SELECT * FROM users where email = '$email'";
$result = mysqli_query($conn, $sql);
if(!$result){
    $response = array("success" => false, "message" => "Something went wrong!");
    echo json_encode($response);
    return;
}
$row_count = mysqli_num_rows($result);
if($row_count!=0){
    $response = array("success" => false, "message" => "This email id is already registered with us!");
    echo json_encode($response);
    return;
}

$sql = "INSERT into users (email, password, full_name , phone, gender, college_name) values ('$email' , '$password' , '$name' , '$phone_number' , '$gender','$college')";
$result = mysqli_query($conn, $sql);
if(!$result){
    $response = array("success" => false, "message" => "Something went wrong!");
    echo json_encode($response);
    return;
}
$response = array("success" => true, "message" => "Your account has been created successfully!");
echo json_encode($response);
mysqli_close($conn);
?>