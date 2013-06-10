<?php
date_default_timezone_set('Asia/Kolkata');

$uri = $_SERVER['REQUEST_URI'];
$message = $uri;
$timestamp = date('Y/d/m H:i:s');
$log_file = '/var/log/my_script.log';
error_log('['.$timestamp.'] INFO: '.$message.PHP_EOL, 3, $log_file);

// Create connection
mysql_connect("198.100.45.191",root,ebffb4499fa6cd78);
@mysql_select_db(smartwifi) or die( "Unable to select database");

$query="SELECT * FROM voucher_list WHERE time_used IS NULL AND password='Citibank-Ambi-5'";
$result=mysql_query($query);
 
$receipientno= $_GET['msisdn'];
$username= mysql_result($result,0,"username");
$password= mysql_result($result,0,"password");

$insert="INSERT INTO login_data (mobileno, username, password, time) VALUES ('$receipientno', '$username', '$password', '$timestamp')";
$result1=mysql_query($insert);

echo "Get for free WiFi access. Your SmartWiFi Password: $username";
 
 
?>