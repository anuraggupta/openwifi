<?php
date_default_timezone_set('Asia/Kolkata');

// Create connection
mysql_connect("198.100.45.191",root,ebffb4499fa6cd78);
@mysql_select_db(citi_data) or die( "Unable to select database");


$name = $_POST['uName'];
$phone =$_POST['uPhone'];

$timestamp = date('Y/m/d H:i:s');

$insert="INSERT INTO apply_card (name, phone, time) VALUES ('$name', '$phone', '$timestamp')";
$result1=mysql_query($insert);

echo $timestamp;

?>