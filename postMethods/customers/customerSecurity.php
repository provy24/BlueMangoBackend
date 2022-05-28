<?php

$HostName = "localhost";
$DatabaseName = "rightbank_db_v4";
$HostUser = "root";
$HostPass = "";

// Creating MySQL Connection.

$con = mysqli_connect($HostName, $HostUser, $HostPass, $DatabaseName);

$json = file_get_contents('php://input');

// Decoding the received JSON and store into $obj variable.
$obj = json_decode($json, true);

$username = $obj['username'];
$password = $obj['password'];
$security_question = $obj['security_question'];
$security_answer = $obj['security_answer'];
$customer_id = $obj['customer_id'];
$status = $obj['status'];
$currently_online = $obj['currently_online'];

$pass = password_hash($password, PASSWORD_DEFAULT);

//Applying User Login query with email and password.
$loginQuery = "select * from customer_security where username = '$username' and password = '$pass' ";
$Sql_Query = "INSERT INTO customer_security (
	 username,
	 password,
     security_question,
     security_answer,
     customer_id,
     status,
     currently_online,
     failed_attempts_tracker,
     lock_time

) values (
	'$username',
	'$pass',
    '$security_question',
    '$security_answer',
	'$customer_id',
    '$status',
    '$currently_online',
    '0',
    NULL
	)";

// Executing SQL Query.
$check = mysqli_fetch_array(mysqli_query($con, $loginQuery));

if (isset($check)) {

    // If Email and Password did not Matched.
    $InvalidMSG = 'Credentials Already Exists';

    // Converting the message into JSON format.
    $InvalidMSGJSon = json_encode($InvalidMSG);

    // Echo the message.
    echo $InvalidMSGJSon;

} else {

    if (mysqli_query($con, $Sql_Query)) {

        // If the record inserted successfully then show the message.
        $MSG = 'Success';

        // Converting the message into JSON format.
        $json = json_encode($MSG);

        // Echo the message.
        echo $json;

    } else {

        // If Email and Password did not Matched.
        $InvalidMSG = (mysqli_error($con));

        // Converting the message into JSON format.
        $InvalidMSGJSon = json_encode($InvalidMSG);

        // Echo the message.
        echo $InvalidMSGJSon;

    }
}
mysqli_close($con);
