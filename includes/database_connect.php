<?php
$db_hostname = "127.0.0.1";
$db_username = "root";
$db_name = "sample";
$db_password = "";

$conn = mysqli_connect($db_hostname, $db_username, $db_password, $db_name);
if(!$conn){
echo "something went wrong. Error : " . mysqli_connect_error();
exit;
}
?>