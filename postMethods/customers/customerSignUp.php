<?php

$HostName = "localhost";
$DatabaseName = "rightbank_db_v4";
$HostUser = "root";
$HostPass = "";
$con = mysqli_connect($HostName, $HostUser, $HostPass, $DatabaseName);

$json = file_get_contents('php://input');

// Decoding the received JSON and store into $obj variable.
$obj = json_decode($json, true);

$customer_first_name = $obj['customer_first_name'];
$customer_last_name = $obj['customer_last_name'];
$customer_dob = $obj['customer_dob'];
$customer_street_address = $obj['customer_street_address'];
$customer_city = $obj['customer_city'];
$customer_national_id = $obj['customer_national_id'];
$customer_gender = $obj['customer_gender'];
$customer_email = $obj['customer_email'];
$customer_phone = $obj['customer_phone'];

$customer_title = $obj['customer_title'];
$customer_nationality = $obj['customer_nationality'];
$customer_profile_type = $obj['customer_profile_type'];

$loginQuery = "select * from customer where customer_national_id = '$customer_national_id' and customer_phone = '$customer_phone' ";
$Sql_Query = "INSERT INTO customer (
	 customer_first_name,
	 customer_last_name,
     customer_dob,
     customer_street_address,
     customer_suburb,
     customer_city,
     customer_national_id,
     customer_gender,
     customer_email,
     customer_phone,
     customer_created,
     customer_modified,
     number_of_dependents,
     customer_title,
     customer_nationality,
     customer_profile_type
) values (
	'$customer_first_name',
	'$customer_last_name',
	'$customer_dob',
	'$customer_street_address',
     NULL,
     '$customer_city',
     '$customer_national_id',
     '$customer_gender',
     '$customer_email',
     '$customer_phone',
      CURRENT_TIMESTAMP ,
      NULL,
      NULL,
      '$customer_title',
      '$customer_nationality',
      '$customer_profile_type'
	)";

// Executing SQL Query.
$check = mysqli_fetch_array(mysqli_query($con, $loginQuery));

if (isset($check)) {
    // If Email and Password did not Matched.
    $InvalidMSG = 'Phone number or national ID already exists';
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
