<?php

$HostName = "localhost";
$DatabaseName = "rightbank_db_v4";
$HostUser = "root";
$HostPass = "";
$con = mysqli_connect($HostName, $HostUser, $HostPass, $DatabaseName);

$json = file_get_contents('php://input');

// Decoding the received JSON and store into $obj variable.
$obj = json_decode($json, true);

$account_type_id = $obj['account_type_id'];
$account_number = $obj['account_number'];

$loginQuery = "select * from account where account_id <0 ";
$Sql_Query = "INSERT INTO account  (
	 account_current_balance,
	 account_status,
     account_date_opened,
     account_branch_id,
     account_savings_interest_rates_id,
     account_type_id,
     account_number
) values (
	0,
	'Active',
	CURRENT_DATE,
	1,
     1,
     '$account_type_id',
     '$account_number'
	)";

// Executing SQL Query.
$check = mysqli_fetch_array(mysqli_query($con, $loginQuery));

if (isset($check)) {
    // If Email and Password did not Matched.
    $InvalidMSG = 'Account Number already exists';
    // Converting the message into JSON format.
    $InvalidMSGJSon = json_encode($InvalidMSG);

    echo $InvalidMSGJSon;

} else {

    if (mysqli_query($con, $Sql_Query)) {

        // If the record inserted successfully then show the message.
        $MSG = 0;
        $last_id = mysqli_insert_id($con);

        // Converting the message into JSON format.
        $json = json_encode($MSG);
        $ppl = json_encode($last_id);

        // Echo the message.
        echo $ppl;
    } else {
        $InvalidMSG = (mysqli_error($con));

        // Converting the message into JSON format.
        $InvalidMSGJSon = json_encode($InvalidMSG);

        // Echo the message.
        echo $InvalidMSGJSon;

    }
}

mysqli_close($con);
