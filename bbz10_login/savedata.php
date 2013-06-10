<?php
date_default_timezone_set('Asia/Kolkata');

// Create connection
mysql_connect("198.100.45.191",root,ebffb4499fa6cd78);
@mysql_select_db(misc_data) or die( "Unable to select database");


$agent = $_POST['uAgent'];

$timestamp = date('Y/m/d H:i:s');

$insert="INSERT INTO bbz10_counter (agent, time) VALUES ('$agent', '$timestamp')";
$result1=mysql_query($insert);

echo $timestamp;

?>