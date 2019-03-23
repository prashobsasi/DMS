<?php
/*$server_name="dms.vidyamca.in";
$user_name="dms_18";
$user_password="dms@123";
$db_name="dms_18";*/
$server_name="localhost";
$user_name="root";
$user_password="";
$db_name="dms";
$con=new mysqli($server_name,$user_name,$user_password,$db_name);
if($con->connect_error){
	die("Connection Failed: ".$con->connect_error);
}
?>